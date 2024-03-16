<?php

namespace NewTik\IDETools;

class enumIDE{
    const NetBeans = 'NetBeans';
    const phpStorm = 'phpStorm';
    
    static function get($ide) {
        
        switch ($ide) {
            case 'NetBeans':
                return self::NetBeans;

                break;
            
            case 'phpStorm':                
                return self::phpStorm;
                break;

            default:
                return self::NetBeans;
                break;
        }
    }
}