<?php

$dir = Config::get('configApplication.root') . "\\" . Config::get('configApplication.app') . "\\app";
$dirStub = Config::get('configApplication.root') . "\\" . Config::get('configApplication.app') . "\\geradores\\Stubs\\configApplication.stub";
$dirConfig = Config::get('configApplication.root') . "\\" . Config::get('configApplication.app') . "\\config\\teste.php";

$files = scandir($dir, 1);

foreach ($files as $file) {
    $name = explode(".",$file);

    if (count($name) >= 3) {
        break;
    }

    if (count($name) == 2) {
        $models[] = "'" . $name[0] . "'";
    }
}

$stub = new \Prettus\Repository\Generators\Stub($dirStub, [
    'MODELS' => implode(",",$models),
]);

$fp = fopen($dirConfig, 'w+');
fwrite($fp, $stub->render());
fclose($fp);

die("terminou");