<?php
include_once './../vendor/autoload.php';


$ideT = new \NewTik\IDETools\IDETools(\NewTik\IDETools\enumIDE::NetBeans, __DIR__ . "/data");


$setting = $ideT->getProjectSetting();

print_r($setting);

echo  PHP_EOL;

$ideT->addIncludePath('/media/newtik/Elements/stas/works/lib/php/OpenCart/OpenCartAutocomplete/');
$ideT->addIncludePath('/media/newtik/Elements/stas/works/lib/php/OpenCart/build_modules/');


echo '<pre>';
var_dump($ideT->getData());
echo '</pre>';


//$ideT->save();