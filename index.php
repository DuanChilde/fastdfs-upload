<?php

include "fileUpload.php";

//校验权限
echo 1;die;
//上传
try{
    $fileUpload = new FileUpload();
    $fileUpload->uploadAttach();
}catch(UploadException $e){
    var_dump($e->getMessage());die;
}


