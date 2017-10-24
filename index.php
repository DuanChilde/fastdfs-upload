<?php

include "fileUpload.php";
include "signValidation.php";

$ret = ['code'=>0,'data'=>[],'error'=>''];
if(!isset($_REQUEST['appId']) || !isset($_REQUEST['sign'])){
    $ret['code'] = 1;
    $ret['error'] = "参数错误";
    echo json_encode($ret);
    die;
}
$appId = $_REQUEST['appId'];
$sign = $_REQUEST['sign'];
$ip = getonlineip();

try{
    //校验
    $signValidation = new SignValidation();
    $signValidation->signVerify($ip,['appId'=>$appId,'sign'=>$sign]);
    //上传
    $fileUpload = new FileUpload();
    $ret['data'] = $fileUpload->uploadAttach();
}catch(\Exception $e){
    $ret['code'] = $e->getCode();
    $ret['error'] = $e->getMessage();
}
echo json_encode($ret);
die;

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
