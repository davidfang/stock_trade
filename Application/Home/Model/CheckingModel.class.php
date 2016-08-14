<?php

namespace Home\Model;

class CheckingModel
{
    /**
     * @param $phone
     * @param $verify
     * @return bool|string
     * 验证手机验证码
     */
    public function checking_check($phone,$verify,$session_name){
        if(!session('?'.$session_name)){
            return '您未获取验证码';
        }else{
            $find_verify = session($session_name);
            if($phone!=$find_verify[0]){
                return '您未获取验证码';
            }
            if($find_verify[2]>=time()){
                if($find_verify[1]!=$verify){
                    return '验证码有误！';
                }else{
                    session('verify',null);
                    return true;
                }
            }else{
                return '验证码已过期！';
            }
        }
    }

}