<?php
include_once './../autoloader.php';

$ideT = new NewTik\IDETools\IDETools(\NewTik\IDETools\enumIDE::NetBeans,  __dir__.'/data/');





$ideT->addIncludePath('/media/newtik/Elements/stas/works/lib/php/OpenCart/OpenCartAutocomplete/');
$ideT->addIncludePath('/media/newtik/Elements/stas/works/lib/php/OpenCart/build_modules/');

$ideT->addConfiguration('build-1', 
        [
            'index.file' => 'build.php',
            'run.as' => 'SCRIPT',
            'script.arguments' => 'runtype=build'
        ]
);

$ideT->save();