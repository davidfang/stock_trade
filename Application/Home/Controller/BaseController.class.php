<?php

namespace Home\Controller;
use Think\Controller;

class BaseController extends Controller
{
    /**
     * 未登录处理
     */
    public function _initialize(){
        if(!session('?user')){
            $this->redirect("Login/login");
        }
        if(!$this->cross_jurisdiction()){
            $this->display("Public/404");
            exit;
        }
        $this -> assign('user',session('user'));
        $this -> get_nav(session('user')['type']);
    }


    /**
     * @return bool
     * 判断是否越权
     */
    public function cross_jurisdiction(){
        if(CONTROLLER_NAME=='Personal'||ACTION_NAME=='push_details'){
            return true;
        }
        if(session('user')['type']==2&&CONTROLLER_NAME=='Admin'){
            return true;
        }elseif(session('user')['type']==1&&CONTROLLER_NAME=='Agency'){
            return true;
        }elseif(session('user')['type']==0&&CONTROLLER_NAME=='User'){
            return true;
        }
        return false;
    }

    /**
     * @param $type [0:普通用户，1：代理，2：管理员]
     */
    private function get_nav($type){
        if($type==0){
            $nav = [
                ['name'=>'首页','url'=>U('User/index'),'ico'=>'glyphicon glyphicon-home'],
                ['name'=>'充值管理','ico'=>'fa fa-plus-square', 'children' => [
                    ['name'=>'我要充值','url'=>U('User/recharge')],
                    ['name'=>'充值记录','url'=>U('User/prepaid_records')],
                ]],
                ['name'=>'出金管理','ico'=>'fa fa-minus-square', 'children' => [
                    ['name'=>'我要出金','url'=>U('User/refund')],
                    ['name'=>'出金记录','url'=>U('User/refund_apply_list')],
                ]],
                ['name'=>'个人信息管理','ico'=>'glyphicon glyphicon-user', 'children' => [
                    ['name'=>'个人信息','url'=>U('Personal/personal_info')],
                    ['name'=>'修改信息','url'=>U('Personal/edit_personal_info')],
                    ['name'=>'修改密码','url'=>U('Personal/edit_password')],
                ]],
            ];
        }elseif($type==1){
            $nav = [
                ['name'=>'我的客户','url'=>U('Agency/client'),'ico'=>'fa fa-users'],
                ['name'=>'提成信息','ico'=>'fa fa-align-left', 'children' => [
                    ['name'=>'我的提成','url'=>U('Agency/push')],
                    ['name'=>'子代理提成','url'=>U('Agency/son_agency_push')],
                ]],
                ['name'=>'个人信息管理','ico'=>'fa fa-gear', 'children' => [
                    ['name'=>'个人信息','url'=>U('Personal/personal_info')],
                    ['name'=>'修改信息','url'=>U('Personal/edit_personal_info')],
                    ['name'=>'修改密码','url'=>U('Personal/edit_password')],
                ]],
            ];
        }elseif($type==2){
            $nav = [
                ['name'=>'首页','url'=>U('Admin/index'),'ico'=>'menu-icon fa fa-home'],
                ['name'=>'用户管理','ico'=>'fa fa-user', 'children' => [
                    ['name'=>'用户信息','url'=>U('Admin/user')],
                    ['name'=>'添加用户','url'=>U('Admin/add_user')],
//                    ['name'=>'用户资产管理','url'=>U('Admin/assets_manage')],
                ]],
                ['name'=>'代理管理','ico'=>'fa fa-group', 'children' => [
                    ['name'=>'代理信息','url'=>U('Admin/agency_info')],
                    ['name'=>'分配代理','url'=>U('Admin/allot_agency')],
                    ['name'=>'子代理查询','url'=>U('Admin/son_agency')],
                ]],
                ['name'=>'充值记录','url'=>U('Admin/recharge'),'ico'=>'fa fa-plus'],
                ['name'=>'交易记录','url'=>U('Admin/trading_record'),'ico'=>'fa fa-list'],
                ['name'=>'提成记录','url'=>U('Admin/push_list'),'ico'=>'fa fa-align-left'],
                ['name'=>'手续费记录','url'=>U('Admin/poundage_list'),'ico'=>'fa fa-th'],
                ['name'=>'出金管理','ico'=>'fa fa-minus', 'children' => [
                    ['name'=>'出金申请','url'=>U('Admin/drawings_apply')],
                    ['name'=>'出金记录','url'=>U('Admin/drawings_list')],
                ]],
                ['name'=>'个人信息管理','ico'=>'fa fa-gear', 'children' => [
                    ['name'=>'个人信息','url'=>U('Personal/personal_info')],
                    ['name'=>'修改信息','url'=>U('Personal/edit_personal_info')],
                    ['name'=>'修改密码','url'=>U('Personal/edit_password')],
                ]],
                ['name'=>'品种管理','ico'=>'fa fa-columns', 'children' => [
                    ['name'=>'产品信息','url'=>U('Admin/product')],
                    ['name'=>'添加产品','url'=>U('Admin/add_save_product')],
                ]],
                ['name'=>'系统管理','ico'=>'fa fa-wrench', 'children' => [
                    ['name'=>'管理员列表','url'=>U('Admin/admin_list')],
                    ['name'=>'添加管理员','url'=>U('Admin/add_admin')],
                    ['name'=>'提成设置','url'=>U('Admin/push_info')],
                    ['name'=>'手续费设置','url'=>U('Admin/poundage')],
                    ['name'=>'汇率设置','url'=>U('Admin/conversion')],
                    ['name'=>'数据管理','url'=>U('Admin/data_manage')],
                ]],
            ];
        }
        $this -> assign('nav',$nav);
    }

    /**
     * json的统一返回形式
     * @param $data   code 错误码   msg 信息  data 数据
     */
    public function json_response($data){
        $this->ajaxReturn(array(
            'code' => empty($data['code']) ? 0 : $data['code'],
            'msg' => empty($data['msg']) ? "" : $data['msg'],
            'data' => empty($data['data']) ? "" : $data['data'],
        ));
    }

    /**
     * 空方法处理
     */
     function _empty(){
         $this->display("Public/404");
     }
}