<?php
/**
 * Created by IntelliJ IDEA.
 * User: duanwei
 * Date: 2017/10/23
 * Time: 下午6:17
 */

class SignException extends Exception
{
    public function __construct($message, $code = 0) {
        parent::__construct($message, $code);
    }

    public function __toString() {
        return __CLASS__.':['.$this->code.']:'.$this->message.'\n';
    }

    public function customFunction() {
        //echo '自定义错误类型';
    }
}