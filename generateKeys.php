<?php

if($argc <3){
    echo "请输入appId和操作指令(add,del,get)!\n";
    die;
}
$appId = $argv[1];
$operation = $argv[2];

$path = "authorizer";
$filename = "authorizedKeys.php";
if (!is_dir($path)){
    mkdir($path,0777);
}
if(!file_exists($path."/".$filename)){
    $fp = fopen($path."/".$filename, "w");
    fwrite($fp,"<?php\n return array();");
    fclose($fp);
}
$authorizedKeys = include $path."/"."authorizedKeys.php";
if($operation == "add"){
    if(array_key_exists($appId,$authorizedKeys)){
        echo "appId重复!\n";
        die;
    }
    $authorizedKeys[$appId] = md5(uniqid());
    $keyFile = fopen($path."/".$filename, "w") or die("Unable to open file!");
    fwrite($keyFile,"<?php\n return ".var_export($authorizedKeys, true).";");
    fclose($keyFile);
    echo $authorizedKeys[$appId]."\n";
}elseif($operation == "del"){
    if(!array_key_exists($appId,$authorizedKeys)){
        echo "appId不存在!\n";
        die;
    }
    unset($authorizedKeys[$appId]);
    $keyFile = fopen($path."/".$filename, "w") or die("Unable to open file!");
    fwrite($keyFile,"<?php\n return ".var_export($authorizedKeys, true).";");
    fclose($keyFile);
    echo "del success\n";
}elseif($operation == "get"){
    if(!array_key_exists($appId,$authorizedKeys)){
        echo "appId不存在!\n";
        die;
    }
    echo $authorizedKeys[$appId]."\n";
}
die;




