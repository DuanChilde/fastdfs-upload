<?php

include "fileUpload.php";
include "signValidation.php";

if(!isset($_REQUEST['appId']) || !isset($_REQUEST['sign'])){
    echo "参数错误";
    die;
}
$appId = $_REQUEST['appId'];
$sign = $_REQUEST['sign'];
$ip = getonlineip();
//校验权限
$signValidation = new SignValidation();
$ret = $signValidation->signVerify($ip,['appId'=>$appId,'sign'=>$sign]);
if(!$ret){
    echo "签名不正确";
    die;
}
//上传
try{
    $fileUpload = new FileUpload();
    $fileUpload->uploadAttach();
}catch(UploadException $e){
    echo $e->getMessage();
    die;
}

function getonlineip(){//获取用户ip
    if($_SERVER['HTTP_CLIENT_IP'])
    {
        $onlineip=$_SERVER['HTTP_CLIENT_IP']; //用户IP
    }
    else if($_SERVER['HTTP_X_FORWARDED_FOR'])
    {
        $onlineip=$_SERVER['HTTP_X_FORWARDED_FOR']; //代理IP
    }
    else
    {
        $onlineip=$_SERVER['REMOTE_ADDR']; //服务器IP
    }
    return $onlineip;
}
