<?php
/**
 * Created by PhpStorm.
 * User: lijian
 * Date: 2016/3/28
 * Time: 10:50
 */


function sendMessage(){
    $c = new TopClient;
    $c->appkey = 23326224;
    $c->secretKey = '0df337e3b7ce0d790c32df6506c43f83';
    $req = new AlibabaAliqinFcSmsNumSendRequest;
    $req->setExtend("123456");
    $req->setSmsType("normal");
    $req->setSmsFreeSignName("阿里大鱼");
    $req->setSmsParam("");
    $req->setRecNum("15506008069");
    $req->setSmsTemplateCode("SMS_585014");
    $resp = $c->execute($req);
}