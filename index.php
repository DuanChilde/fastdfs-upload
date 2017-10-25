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
$sendTime = $_REQUEST['time'];

try{
    //校验
    $signValidation = new SignValidation();
    $signValidation->signVerify($sendTime,['appId'=>$appId,'sign'=>$sign]);
    //上传
    $fileUpload = new FileUpload();
    $ret['data'] = $fileUpload->uploadAttach();
}catch(\Exception $e){
    $ret['code'] = $e->getCode();
    $ret['error'] = $e->getMessage();
}
echo json_encode($ret);
die;

