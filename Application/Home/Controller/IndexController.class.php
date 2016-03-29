<?php
namespace Home\Controller;
use Think\Controller;
use Common\Service\MessageService;


class IndexController extends Controller {
    public function index(){
        $provinceList = M("provincial")->select();
        $this->assign("provinceList", $provinceList);
        $this->display();
    }

    public function getRegion(){
        $pid = I("pid");
        $cityList = M("city")->where("pid=$pid")->select();
        echo json_encode($cityList);
    }

    public function register(){
        $name = I("name");
        $phone = I("phone");
        $province = I("province");
        $city = I("city");

    }

    public function sendVerifyCode(){
        $phone = I("phone");
        $code = I("code");
        $orgnization = "印心精舍";
        $activity = "元音老人思想研讨会";
        $result = MessageService::sendVerifyNum($phone, $code, $orgnization, $activity);
        $ret['status'] = 0;
        if( $result['alibaba_aliqin_fc_sms_num_send_response']['result']['err_code'] == 0 ){//error_code=0
            $ret['status'] = 1;
        }
        dump($ret);
        return json_encode($ret);
    }

}
