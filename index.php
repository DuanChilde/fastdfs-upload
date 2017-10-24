<?php

include "fileUpload.php";
include "signValidation.php";

var_dump(getonlineip());
var_dump($_REQUEST);die;
//校验权限
$signValidation = new SignValidation();
//$sign = $signValidation->generate(['appId'=>'duanwei','appSecret'=>'87220d3428db2ef3a594d6abe02e0ef6','ip'=>'127.0.0.1']);
$ret = $signValidation->signVerify('127.0.0.1',['appId'=>'duanwei','sign'=>'ed3d8eb792daf82734d5e53dcb713c54']);
//上传
try{
    $fileUpload = new FileUpload();
    $fileUpload->uploadAttach();
}catch(UploadException $e){
    var_dump($e->getMessage());die;
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
