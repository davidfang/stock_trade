<?php

namespace Home\Model;
use Think\Model;

class CheckingModel extends Model
{
    /**
     * @param $phone
     * 添加验证码
     */
    public function add_checking($phone){

    }

    public function checking_check($phone,$verify){
        $table = M('checking');
        $where['phone'] = $phone;
        $find_verify = $table ->where($where) -> find();
        if(empty($find_verify)){
            return '您未获取验证码';
        }else{
            if($find_verify['due_time']>=time()){
                if($find_verify['verify']!=$verify){
                    return '验证码有误！';
                }else{
                    return true;
                }
            }else{
                return '验证码已过期！';
            }
        }
    }

}