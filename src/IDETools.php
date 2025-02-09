<?php

/* * ******************************************************* */
/* 	@copyright	NewTik 2020-.					          */
/* 	@support	https://newtik-opencart.com/			  */
/* 	@license	LICENSE.txt								  */
/* * ******************************************************* */

namespace NewTik\IDETools;

use NewTik\IDETools\enumIDE;

class IDETools implements \NewTik\IDETools\interfaceIDE{
    
    private \NewTik\IDETools\interfaceIDE $adaptor;
    
    private bool $ckeckIDE = false;
    
    public function __construct($adaptor = null, string $dir_sourse = '') {
        
        if($dir_sourse == '')
            $dir_sourse = dirname($_SERVER['SCRIPT_NAME']). '/';
        
        $this->ckeckIDE = self::chekIDE($dir_sourse);
        
        if(!$this->ckeckIDE){
            return;
        }
        
        if($adaptor == null){
            
            $classNameSpace = 'NewTik\\IDETools\\ide\\';
            $ides = glob(__DIR__ . '/ide/*.php');

            foreach ($ides as $ide) {

                $ide = basename($ide, '.php');

                if (class_exists($classNameSpace.$ide)) {

                    $class = $classNameSpace . $ide;

                    if(($class)::chekIDE($dir_sourse)){

                        $this->adaptor = new $class($dir_sourse);                        

                        break;
                    }
                }
            } 
            
        }else{
            
            $class = 'NewTik\\IDETools\\ide\\' . $adaptor;

            if (class_exists($class)) {
                $this->adaptor = new $class($dir_sourse);
                $this->adaptor::chekIDE();
            } else {
                throw new \Exception('Error: Could not load adaptor ' . $adaptor . '!');
            }
        }
                
        $this->dir_sourse = $dir_sourse;
        
    }
    
    
    public function addConfiguration(string $name, $properties = []) {
        $this->adaptor->addConfiguration($name, $properties);
    }

    public function addIncludePath($path) {
        if(!$this->ckeckIDE){
            return '';
        }
        $this->adaptor->addIncludePath($path);
    }

    public function clear() {
        if(!$this->ckeckIDE){
            return;
        }
        $this->adaptor->clear();
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
        if(!$this->ckeckIDE){
            return [];
        }
        return $this->adaptor->getData();
    }

    public function getIncludePath(): array {
        return $this->adaptor->getIncludePath();
    }

    public function getProperties(): array {
        
    }

    public function setProperties($properties) {
        
    }

    public function getProjectSetting(): array {
        return $this->adaptor->getProjectSetting();
    }

    public function save() {
        
        $this->adaptor->save();
        
    }
    
    public static function chekIDE(string $dir_sourse = ''): bool {
        
        $classNameSpace = 'NewTik\\IDETools\\ide\\';
        $ides = glob(__DIR__ . '/ide/*.php');

        foreach ($ides as $ide) {

            $ide = basename($ide, '.php');

            if (class_exists($classNameSpace.$ide)) {

                $class = $classNameSpace . $ide;

                if(($class)::chekIDE($dir_sourse)){

                    return true;                        

                    break;
                }
            }
        }    
        
        return false;
        
    }
}
