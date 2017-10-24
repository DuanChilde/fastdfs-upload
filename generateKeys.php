<?php

if($argc <2){
    echo "请输入appId!\n";
    die;
}
$appId = $argv[1];
$authorizedKeys = include "authorizedKeys.php";
if(array_key_exists($appId,$authorizedKeys)){
    echo "appId重复!\n";
    die;
}
$authorizedKeys[$appId] = md5(uniqid());

$keyFile = fopen("authorizedKeys.php", "w") or die("Unable to open file!");
fwrite($keyFile,"<?php\n return ".var_export($authorizedKeys, true).";");
fclose($keyFile);

echo "success";


