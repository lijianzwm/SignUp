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
        $phone = I("phone");
        $data['name'] = I("name");
        $data['phone'] = I("phone");
        $data['province'] = I("province");
        $data['city'] = I("city");
        $data['accommodation'] = I("accommodation");
        $members = M("members");
        if( $members->where("phone=$phone")->count() ){
            $json['error_code'] = 1;
            $json['msg'] = "该手机号码已经进行过报名！";
        }else if( $members->add($data)){
            $json['error_code'] = 0;
            $json['msg'] = "报名成功！";
        }else{
            $json['error_code'] = 1;
            $json['msg'] = "无法向数据库插入数据！";
        }
        echo json_encode($json);
    }

    public function sendVerifyCode(){
        $phone = I("phone");
        $code = I("code");
        $orgnization = "印心精舍";
        $activity = "元音老人思想研讨会";
        $result = MessageService::sendVerifyNum($phone, $code, $orgnization, $activity);
        $ret['status'] = 0;
        if( $result['alibaba_aliqin_fc_sms_num_send_response']['result']['err_code'] == 0 ){//error_code=0
            $ret['error_code'] = 0;
            $ret['msg'] = "验证码发送成功！";
        }else{
            $ret['error_code'] = 1;
            $ret['msg'] = "验证码发送失败！";
        }
        echo json_encode($ret);
    }

    public function loginVerifyCode(){
        $phone = I("phone");
        if( M("members")->where("phone=$phone")->count()){
            $code = I("code");
            $orgnization = "印心精舍";
            $activity = "元音老人思想研讨会";
            $result = MessageService::sendVerifyNum($phone, $code, $orgnization, $activity);
            if( $result['alibaba_aliqin_fc_sms_num_send_response']['result']['err_code'] == 0 ){//error_code=0
                $ret['error_code'] = 0;
                $ret['msg'] = "验证码发送成功！";
            }else{
                $ret['error_code'] = 1;
                $ret['msg'] = "验证码发送失败！";
            }
        }else{
            $ret['error_code'] = 1;
            $ret['msg'] = "此电话未报名！";
        }
        echo json_encode($ret);
    }

    public function modify(){
        if( I("code") != I("rightCode")){
            $this->error("验证码错误！");
        }
        $phone = I("phone");
        if( $phone)
        $data = M("members")->where("phone=$phone")->find();
        $province = $data['province'];
        $city = $data['city'];
        $data['provinceId'] = M("provincial")->where("name='$province'")->find()['id'];
        $data['cityId'] = M("city")->where("name='$city'")->find()['id'];
        $provinceList = M("provincial")->select();
        $this->assign("provinceList", $provinceList);
        $this->assign("data", $data);
        $this->display();
    }

    public function modifyHandler(){
        $data['id'] = I("id");
        $data['name'] = I("name");
        $data['phone'] = I("phone");
        $data['province'] = I("province");
        $data['city'] = I("city");
        $data['accommodation'] = I("accommodation");
        $members = M("members");
        if( $members->save($data)){
            $json['error_code'] = 0;
            $json['msg'] = "修改成功！";
        }else{
            $json['error_code'] = 1;
            $json['msg'] = "数据未被修改！";
        }
        echo json_encode($json);
    }

    public function login(){
        $this->display();
    }

}
