<?php
/**
 * Created by PhpStorm.
 * User: lijian
 * Date: 2016/3/28
 * Time: 11:53
 */

namespace Common\Service;
use Alidayu\AlidayuClient as Client;
use Alidayu\Request\SmsNumSend;

class MessageService{

    /**
     * 验证码${code}，您正在参加$organization的$$activity活动，请确认系本人申请。
     * @param $phone
     * @param $code
     * @param $activity
     */
    public static function sendVerifyNum( $phone, $code, $organization, $activity ){
        $client  = new Client;
        $request = new SmsNumSend;

        // 短信内容参数
        $smsParams = [
            'code'    => "$code",
            'product' => "$organization",
            'item' => "$activity"
        ];

        // 设置请求参数
        $req = $request->setSmsTemplateCode('SMS_6000004')
            ->setRecNum($phone)
            ->setSmsParam(json_encode($smsParams))
            ->setSmsFreeSignName('活动验证')
            ->setSmsType('normal')
            ->setExtend('demo');

        return $client->execute($req);
    }

    public static function sendMessage(){

    }
}