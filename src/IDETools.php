<?php

/* * ******************************************************* */
/* 	@copyright	NewTik 2020-.					          */
/* 	@support	https://newtik-opencart.com/			  */
/* 	@license	LICENSE.txt								  */
/* * ******************************************************* */

namespace NewTik\IDETools;

use NewTik\IDETools\enumIDE;

use \NewTik\IDETools\InterfaceIDE;

class IDETools implements InterfaceIDE{
    
    private string $dir_sourse = '';
    
    private ?InterfaceIDE $adaptor = null;
    
    private bool $ckeckIDE = false;
    
    public function __construct(?string $adaptorName = null, string $dir_sourse = '') {
        
        if($dir_sourse == ''){
            $dir_sourse = dirname($_SERVER['SCRIPT_NAME']). '/';
        }
        
        $this->dir_sourse = $dir_sourse;
        
        $this->ckeckIDE = self::chekIDE($dir_sourse);
        
        if(!$this->ckeckIDE){
            return;
        }
        
        if($adaptorName == null){
            
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
            
            $class = 'NewTik\\IDETools\\ide\\' . $adaptorName;

            if (class_exists($class)) {
                $this->adaptor = new $class($dir_sourse);
                $this->adaptor::chekIDE();
            } else {
                throw new \Exception('Error: Could not load adaptor ' . $adaptorName . '!');
            }
        }
                
        
        
    }
    
    
    public function addConfiguration(string $name, $properties = []) {
        if($this->ckeckIDE){
            $this->adaptor->addConfiguration($name, $properties);
        }
        
    }

    public function addIncludePath($path) {
        if($this->ckeckIDE){
            return '';
        }
        $this->adaptor->addIncludePath($path);
    }

    public function clear() {
        if($this->ckeckIDE){
            $this->adaptor->clear();
        }        
    }

    public function delConfiguration($name) {
        if($this->ckeckIDE){
            
        }
    }

    public function delConfigurations() {
        if($this->ckeckIDE){
            
        }
    }

    public function delIncludePath($path) {
        if($this->ckeckIDE){
            
        }
    }

    public function getConfiguration($name): array {
        if($this->ckeckIDE){
            
        }
    }

    public function getConfigurations(): array {
        if($this->ckeckIDE){
            
        }
    }

    public function getData(): array {
        if($this->ckeckIDE){
            return [];
        }
        return $this->adaptor->getData();
    }

    public function getIncludePath(): array {
        if ($this->adaptor !== null) {
            return $this->adaptor->getIncludePath();
        }
        return [];
    }

    public function getProperties(): array {
        
    }

    public function setProperties($properties) {
        
    }

    public function getProjectSetting(): array {
        
        if($this->ckeckIDE){
            return $this->adaptor->getProjectSetting();
        }
        
        return [];
        
    }

    public function save() {
        if($this->ckeckIDE){
            $this->adaptor->save();
        }
        
    }
    
    public static function chekIDE(string $dir_sourse = ''): bool {
        
        $classNameSpace = 'NewTik\\IDETools\\ide\\';
        $ides = glob(__DIR__ . '/ide/*.php');
        
        foreach ($ides as $ide) {

            $ide = basename($ide, '.php');

            if (class_exists($classNameSpace.$ide)) {

                $class = $classNameSpace . $ide;
                
                $is = $class::chekIDE($dir_sourse);
                
                if($is){
                    return true;
                }
            }
        }
        
        return false;
        
    }
}
