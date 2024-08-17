<?php

namespace NewTik\IDETools\ide;

class phpStorm implements \NewTik\IDETools\interfaceIDE {

    const DIR = '/.idea/';

    private $dir_sourese = '';
    private $properties = [];
    private $project_name = '';
    private $data = [
        'project_name' => '',
    ];
    private $includePaths = [];

    public function __construct($dir_sourse = '') {

        if ($dir_sourse == '')
            $dir_sourse = dirname($_SERVER['SCRIPT_NAME']) . '/';

        $this->dir_sourese = $dir_sourse . self::DIR;
        $this->dir_sourese = str_replace("//", "/", $this->dir_sourese);
    }
    
    private $onfiguration = [];

    public function addConfiguration(string $name, $options = []) {
        
        
        
    }

    public function addIncludePath($path) {
        $this->includePaths[] = $path;
        $this->includePaths = array_unique($this->includePaths);
    }

    public function clear() {
        
    }

    public function delConfiguration($name) {
        
    }

    public function delConfigurations() {
        
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
        
    }

    public function getProperties(): array {
        
    }

    public function setProperties($properties) {
        
    }

    public function getProjectSetting(): array {

        $this->data['project_name'] = @file_get_contents($this->dir_sourese . '.name');

        return $this->getData();
    }

    public function save() {

        if (!empty($this->includePaths)) {

            $data = '<?xml version="1.0" encoding="UTF-8"?>';
            $data .= '<project version="4">';

            $data .= '<component name="PhpIncludePathManager">';
            $data .= '<include_path>';
            foreach ($this->includePaths as $file) {
                $data .= '<path value="'.$file.'" />';            }
            
            $data .= '</include_path>';
            $data .= '</component>';
            $data .= '</project>';
            file_put_contents($this->dir_sourese . 'php.xml', $data);
        }
        
        
    }

    public function _getPhpWorkspaceProjectConfiguration() {
        
    }

    public function _savePhpWorkspaceProjectConfiguration() {
        
    }

    static function chekIDE(string $dir_sourse = ''): bool {        
        return is_dir($dir_sourse . self::DIR);
    }
}
