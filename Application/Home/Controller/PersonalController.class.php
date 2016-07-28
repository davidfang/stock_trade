<?php

namespace Home\Controller;
use Think\Controller;

class PersonalController extends BaseController
{

    /**
     * 个人信息
     */
    public function personal_info(){
        $this -> assign('title','个人信息');
        $this -> assign('route','个人信息管理 / 个人信息');
        $this -> assign('header_title','个人信息');
        $user = D('user')->get_Personal_info(session('user')['id']);
        $this -> assign('user',$user);
        $this -> display();
    }

    /**
     * 修改个人信息
     */
    public function edit_personal_info(){
        $this -> assign('title','修改信息');
        $this -> assign('route','个人信息管理 / 修改信息');
        $this -> assign('header_title','修改信息');
        $user = D('user')->get_Personal_info(session('user')['id']);
        $this -> assign('user',$user);
        $this -> display();
    }

    /**
     * 修改个人信息
     */
    public function save_personal_info(){
        $data = I("post.");
        $user_model = D('user');
        if(!$user_model->create($data)){
            $this->json_response(array('code' => 2,'msg' => '提示','data' => $user_model->getError()));
        }else{
            $data['update_time'] = time();
            $res = M('user')->where('id='.session('user')['id'])->save($data);
            session('user',M('user')->where('id='.session('user')['id'])->find());
            if(empty($res)){
                $this->json_response(array('code' => 1,'msg' => '失败','data' => '修改失败！'));
            }else{
                $this->json_response(array('code' => 0,'msg' => '成功','data' => '修改成功！'));
            }
        }
    }

    /**
     * 修改密码
     */
    public function edit_password(){
        $data = I('post.');
        if(empty($data)){
            $this -> assign('title','修改密码');
            $this -> assign('route','个人信息管理 / 修改密码');
            $this -> assign('header_title','修改密码');
            $this -> display();
        }else{
            if($data['old_password']==$data['new_password']){
                $this->json_response(array('code' => 2,'msg' => '提示','data' => '新旧密码不能相同！'));
            }
            if($data['verify_password']!=$data['new_password']){
                $this->json_response(array('code' => 2,'msg' => '提示','data' => '前后密码不一致！'));
            }
            $where['id'] = session('user')['id'];
            $where['password'] = md5($data['old_password']);
            $find_res = M('user')->where($where)->find();
            if(empty($find_res)){
                $this->json_response(array('code' => 2,'msg' => '提示','data' => '旧密码有误！'));
            }else{
                $save_data['password'] = md5($data['new_password']);
                $save_data['update_time'] = time();
                $save_res = M('user')->where($where)->save($save_data);
                if(empty($save_res)){
                    $this->json_response(array('code' => 1,'msg' => '失败','data' => '修改失败！'));
                }else{
                    $this->json_response(array('code' => 0,'msg' => '成功','data' => '修改成功,即将返回登录。'));
                }
            }
        }
    }

}