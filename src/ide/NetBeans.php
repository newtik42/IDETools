<?php

namespace NewTik\IDETools\ide;

class NetBeans implements \NewTik\IDETools\interfaceIDE{
    
    const DIR = '/nbproject/';
    private $dir_sourese = '';
    
    private $properties = [];
    
    private $data = [];
    
    public function __construct(string $dir_sourse) {
        
        $this->dir_sourese = realpath($dir_sourse . self::DIR) . "/";
        $this->data['dir_name'] = basename($dir_sourse);
        $this->data['dir'] = realpath($dir_sourse) . "/";
    }

    
    

    public function addIncludePath($path) {
        $this->_setPropertie('private_private.properties', 'include.path.private', $path, false);
        
    }

    public function clear() {
        
        @unlink($this->dir_sourese . 'project.properties');
        @unlink($this->dir_sourese . 'config.properties');

        $files = glob($this->dir_sourese . 'configs/*');
        foreach ($files as $file) {
            @unlink($file);
        }
        @unlink($this->dir_sourese . 'configs');

        //private        
        @unlink($this->dir_sourese . 'private/project.properties');
        @unlink($this->dir_sourese . 'private/config.properties');
        $files = glob($this->dir_sourese . 'private/configs/*');
        foreach ($files as $file) {
            @unlink($file);
        }
        @unlink($this->dir_sourese . 'private/configs');
        @unlink($this->dir_sourese . 'private');
        
    }
    
    public function addConfiguration(string $name, $properties = []) {
        $this->properties['configs_' . $name . '.properties'] = [];
        $this->properties['private_configs_' . $name . '.properties'] = [];
        
        $file = 'private_configs_' . $name . '.properties';
        
        foreach ($properties as $key => $value) {
            $this->_setPropertie($file, $key, $value);
        }
        
    }

    public function delConfiguration($name) {
        if (isset($this->properties['configs_' . $name . '.properties']))
            unset($this->properties['configs_' . $name . '.properties']);

        if (isset($this->properties['private_configs_' . $name . '.properties']))
            unset($this->properties['private_configs_' . $name . '.properties']);
    }

    public function delConfigurations() {
        foreach ($this->properties as $key => $value) {
            if (!in_array($key, ['config.properties', 'project.properties', 'private_private.properties', 'private_config.properties']))
                unset($this->properties[$key]);
        }
    }

    public function delIncludePath($path) {
        
    }

    public function getConfiguration($name): array {
        
    }

    public function getConfigurations(): array {
        
    }

    public function getData(): array {
        return $this->data;
    }

    public function getIncludePath(): array {
        
        return $this->_getPropertie('private_private.properties', 'include.path.private');
        
    }

    
    //
    public function getProperties(): array {
        
    }

    public function setProperties($properties) {
        
        
        
        
    }
    
    private function _parsProperties($filename) {

        $params = [];

        if (!file_exists($filename))
            return $params;

        $content = file_get_contents($filename);

        if (empty($content))
            return $params;

        $content = preg_replace('~\r?\n~', "\n", $content);
        $lines = explode("\n", $content);

        foreach ($lines as $line) {

            $line = str_replace(['    ', ':\\'], '', $line);

            if (empty($line))
                continue;

            $nv = explode("=", $line, 2);

            if (count($nv) == 2) {

                $key = $nv[0];
                $params[$key] = [];

                $params[$key]['type'] = TypeValue::getTypeValue($key);

                if ($params[$key]['type'] != TypeValue::Value) {
                    $params[$key]['value'] = [];
                    if ($nv[1] != "\\")
                        $params[$key]['value'][] = $nv[1];
                } else {
                    $params[$key]['value'] = $nv[1];
                }
            } else {
                $params[$key]['value'][] = $line;
            }
        }

        return $params;
    }
    
    private function _getPropertie($file, $key) {
        return $this->properties[$file][$key] ?? null;
    }
    
    
    private function _setPropertie($file, $key, $value, $reset = false) {

        if (!isset($this->properties[$file])) {
            $this->properties[$file] = [];
        }

        if (!isset($this->properties[$file][$key])) {
            $this->properties[$file][$key] = [];
            $this->properties[$file][$key]['type'] = TypeValue::getTypeValue($key);
        }
        if ($reset)
            $this->properties[$file][$key]['value'] = $value;
        else {
            if ($this->properties[$file][$key]['type'] != TypeValue::Value) {
                $this->properties[$file][$key]['value'][] = $value;
                $this->properties[$file][$key]['value'] = array_unique($this->properties[$file][$key]['value']);
            } else {
                $this->properties[$file][$key]['value'] = $value;
            }
        }
    }
    
    private function _savePropertieFile($file, $properties) {

        $content = '';

        foreach ($properties as $key2 => $value2) {

            if ($value2['type'] == TypeValue::Value) {
                $content .= $key2 . "=" . $value2['value'] . PHP_EOL;
            } else {
                if ($value2['type'] == TypeValue::File || $value2['type'] == TypeValue::FileProjeck) {
                    $content .= $key2 . "=\\" . PHP_EOL;
                    $content .= "    " . implode(':\\' . PHP_EOL . '    ', $value2['value']) . PHP_EOL;

                } else
                    $content .= $key2 . "=" . implode('    ' . PHP_EOL, $value2['value']) . PHP_EOL;
            }
        }

        $pathinfo = pathinfo($this->dir_sourese . $file);

        if (!is_dir($pathinfo['dirname']))
            mkdir($pathinfo['dirname'], "0777", true);

        file_put_contents($this->dir_sourese . $file, $content);
    }

    public function getProjectSetting(): array {
        
        
        if (!file_exists($this->dir_sourese . 'project.xml'))
            return [];
        
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->preserveWhiteSpace = false;
        $dom->load($this->dir_sourese . 'project.xml');

        $this->project_name = $dom->getElementsByTagName('project')->item(0)
                        ->getElementsByTagName('configuration')->item(0)
                        ->getElementsByTagName('data')->item(0)
                        ->getElementsByTagName('name')->item(0)->textContent;
        
        $this->data['project_name'] = $this->project_name;
        
        $this->properties['project.properties'] = $this->_parsProperties($this->dir_sourese . '/project.properties');
        $this->properties['config.properties'] = $this->_parsProperties($this->dir_sourese . '/config.properties');
        $files = glob($this->dir_sourese . 'configs/*.*');
        foreach ($files as $file) {
            $this->properties['configs_' . basename($file)] = $this->_parsProperties($file);
        }

        $this->properties['private_private.properties'] = $this->_parsProperties($this->dir_sourese . '/private/private.properties');
        $this->properties['private_config.properties'] = $this->_parsProperties($this->dir_sourese . '/private/config.properties');

        $files = glob($this->dir_sourese . '/private/configs/*.*');
        foreach ($files as $file) {
            $this->properties['private_configs_' . basename($file)] = $this->_parsProperties($file);
        }
        
        return $this->getData();
    }

    public function save() {
        
        foreach ($this->properties as $key => $propertie) {
            $file = str_replace("_", '/', $key);
            $this->_savePropertieFile($file, $this->properties[$key]);
        }
    }

    static function chekIDE(string $dir_sourse = ''): bool {        
        return is_dir($dir_sourse . self::DIR);
    }
}

class TypeValue {

    const FileProjeck = 'file_project';
    const File = 'file';
    const Value = 'value';

    static function getTypeValue($key) {
        if ($key == "code.analysis.excludes" ||
                $key == "ignore.path" ||
                $key == "include.path") {
            return self::FileProjeck;
        } elseif ($key == "include.path.private") {
            return self::File;
        } else {
            return self::Value;
        }
    }

}
