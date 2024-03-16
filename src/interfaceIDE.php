<?php

/* * ******************************************************* */
/* 	@copyright	NewTik 2020-.					          */
/* 	@support	https://newtik-opencart.com/			  */
/* 	@license	LICENSE.txt								  */
/* * ******************************************************* */

namespace NewTik\IDETools;

interface interfaceIDE {
        
    public function getData() : array;
    
    public function getProjectSetting() : array;
    
    static function chekIDE(string $dir_sourse = '') : bool;
    
    
    public function getProperties() : array;
    public function setProperties($properties);
    
    public function clear();
    public function save();
    
    public function getConfigurations() : array;
    public function delConfigurations();
    
    public function getConfiguration(string $name) : array;
    public function addConfiguration(string $name, $properties = []);
    public function delConfiguration($name);
    
    public function getIncludePath(): array;
    public function addIncludePath(string $path);
    public function delIncludePath(string $path);
    
    
    
    
    
}
