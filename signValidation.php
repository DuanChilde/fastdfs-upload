<?php
/**
 * Created by IntelliJ IDEA.
 * User: duanwei
 * Date: 2017/10/23
 * Time: 下午6:17
 */


class SignValidation{

    /*
    *  生成签名,根据appid，appsecret，ip排序，然后拼接md5
    */
    public function generate($array){
        if(!$array['appId'] || !$array['appSecret'] || !$array['ip'])
        {
            throw new Exception("参数缺失");
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
    public function signVerify($ip,$array){
        $newarray=array();
        if(!$array['appId']){
            return false;
        }
        $authorizedKeys = include_once "authorizedKeys.php";
        if(!array_key_exists($array['appId'],$authorizedKeys)){
            return false;
        }
        $newarray["appSecret"]= $authorizedKeys[$array['appId']];
        $newarray['ip'] = $ip;
        reset($array);
        while(list($key,$val) = each($array)){
            if($key != "sign" ){
                $newarray[$key]=$val;
            }
        }
        $sign=$this->generate($newarray);
        if($sign == $array["sign"]){
            return true;
        }
        return false;
    }


}