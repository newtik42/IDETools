<?php
include_once './../vendor/autoload.php';

$file = '/media/newtik/Elements/stas/works/projects/OpenCart/my_modules/data_exchange/newtik_1c_sync/';

$ideT = new NewTik\IDETools\IDETools(\NewTik\IDETools\enumIDE::NetBeans, $file);


$ideT->getProjectSetting();

$ideT->addIncludePath('/media/newtik/Elements/stas/works/lib/php/OpenCart/OpenCartAutocomplete/');
$ideT->addIncludePath('/media/newtik/Elements/stas/works/lib/php/OpenCart/build_modules/');


echo '<pre>';
var_dump($ideT->getData());
echo '</pre>';


//$ideT->save();