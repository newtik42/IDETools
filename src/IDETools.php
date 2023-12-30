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
    
    public function __construct($adaptor, string $dir_sourse = '') {
        
        if($dir_sourse == '')
            $dir_sourse = dirname($_SERVER['SCRIPT_NAME']). '/';
        
        $class = 'NewTik\\IDETools\\ide\\' . $adaptor;

		if (class_exists($class)) {
			$this->adaptor = new $class($dir_sourse);
		} else {
			throw new \Exception('Error: Could not load adaptor ' . $adaptor . '!');
		}
        
        $this->dir_sourse = $dir_sourse;
        
    }
    
    
    public function addConfiguration(string $name, $properties = []) {
        $this->adaptor->addConfiguration($name, $properties);
    }

    public function addIncludePath($path) {
        $this->adaptor->addIncludePath($path);
    }

    public function clear() {
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
        return $this->adaptor->getData();
    }

    public function getIncludePath(): array {
        
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

}
