<?php
/**
 * Created by IntelliJ IDEA.
 * User: duanwei
 * Date: 2017/10/23
 * Time: 下午6:17
 */

include "signException.php";

class SignValidation{

    /*
    *  生成签名,根据appid，appsecret，ip排序，然后拼接md5
    */
    public function generate($array){
        if(!$array['appId'] || !$array['appSecret'] || !$array['time'])
        {
            throw new Exception("参数不完整",10000);
        }
        ksort($array);
        $string="";
        while (list($key, $val) = each($array)){
            $string = $string . $val ;
        }
        return md5($string);
    }

    /**
     * 签名验证,通过签名验证的才能认为是合法的请求
     * @param $appSecret
     * @param $array
     * @return bool
     */
    public function signVerify($sendTime,$array){
        $newarray=array();
        if(!$array['appId']){
            throw new Exception("参数appId缺失",10001);
        }
        $authorizedKeys = include_once "authorizedKeys.php";
        if(!array_key_exists($array['appId'],$authorizedKeys)){
            throw new Exception("非法appId",10002);
        }
        $newarray["appSecret"]= $authorizedKeys[$array['appId']];
        $newarray['time'] = $sendTime;
        reset($array);
        while(list($key,$val) = each($array)){
            if($key != "sign" ){
                $newarray[$key]=$val;
            }
        }
        $sign=$this->generate($newarray);
        if($sign != $array["sign"]){
            throw new Exception("签名不正确",10003);
        }
        return true;
    }


}