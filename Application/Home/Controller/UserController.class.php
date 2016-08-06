<?php

namespace Home\Controller;
use Think\Controller;

class UserController extends BaseController
{

    /**
     * @param string $begin
     * @param string $end
     * @param string $product 产品id
     * 首页
     */
    public function index($begin='',$end='',$product=''){
        $user_info = M('user')->where('id='.session('user')['id'])->find();
        $product_sum = M('prepaid')->where('status=1 and user_id='.session('user')['id'])->group('product_id')->select();
        if(!empty($begin)&&!empty($end)){
            $return_begin = date('m/d/Y',$begin);
            $return_end = date('m/d/Y',$end);
            $time = $return_begin." - ".$return_end;
            $end = strtotime("+1 day",$end);
        }
        $trade_info = D('trade')->get_user_trade_info($begin,$end,$product,session('user')['id']);
        $this -> assign('title','首页');
        $this -> assign('route','首页');
        $this -> assign('header_title','首页');

        $this -> assign('user_info',$user_info);
        $this -> assign('product_sum',count($product_sum));
        $this -> assign('trade_info',$trade_info[0]);
        $this -> assign('show_page',$trade_info[1]);
        $product_list = D('product')->get_product();
        $this -> assign('product_list',$product_list);

        $this -> assign('time',$time);
        $this -> assign('product',$product);
        $this -> display();
    }


    /**
     * @param string $product 产品id
     * @param string $status 订单状态['':全部，0：未充值，1：已充值]
     * 我的充值记录
     */
    public function prepaid_records($product='',$status=''){
        $records = D('prepaid')->get_prepaid_records($product,$status);
        $this -> assign('title','充值记录');
        $this -> assign('route','充值管理 / 充值记录');
        $this -> assign('header_title','充值记录');
        $this -> assign('prepaid_records',$records[0]);
        $this -> assign('show_page',$records[1]);
        $this -> assign('product',$product);
        $this -> assign('status',$status);
        $product_list = D('product')->get_product();
        $this -> assign('product_list',$product_list);
        $this -> display();
    }


    /**
     * 我要充值页面
     */
    public function recharge(){
        $this -> assign('title','我要充值');
        $this -> assign('route','充值管理 / 我要充值');
        $this -> assign('header_title','我要充值');
        $product_list = D('product')->get_product();
        $this -> assign('product_list',$product_list);
        $this -> display();
    }

    /**
     * 用户充值操作
     */
    public function recharge_handle(){
        $data = I('post.');
        $res = D('prepaid')->recharge($data);
        if(empty($res)){
            $this -> json_response(array('code'=>2,'msg'=>'提示','data'=>'充值失败，请重试！'));
        }else{
            //调用支付宝接口

            $this -> json_response(array('code'=>0,'msg'=>'成功','data'=>'恭喜，已成功充值。'));
        }
    }

    /**
     * 我要退款
     */
    public function refund(){
        $this -> assign('title','我要退款');
        $this -> assign('route','退款管理 / 我要退款');
        $this -> assign('header_title','我要退款');
        $user_asset = D('asset')->get_user_asset(session('user')['id']);
        $this -> assign('user_asset',$user_asset[0]);
        $this -> assign('show_page',$user_asset[1]);
        $product_list = D('product')->get_product();
        $this -> assign('product_list',$product_list);
        $this -> display();
    }

    /**
     * 退款操作
     */
    public function refund_handle(){
        $data = I('post.');
        $user = session('user')['id'];
        $apply = D('refund')->refund_apply($data,$user);
        if(empty($apply)){
            $this -> json_response(array('code'=>1,'msg'=>'提示','data'=>'申请失败，请重试！'));
        }else{
            $this -> json_response(array('code'=>0,'msg'=>'成功','data'=>'申请已发出，请耐心等待。'));
        }
    }

    /**
     * @param int $status 退款状态【0：审核中的，1：已退款的，2：已拒绝的】
     * 我的退款记录
     */
    public function refund_apply_list($status=1){
        $this -> assign('title','退款记录');
        $this -> assign('route','退款管理 / 退款记录');
        $this -> assign('header_title','退款记录');
        $this -> assign('status',$status);
        $user = session('user')['id'];
        $apply_list = D('refund')->get_refund_apply_list($status,$user);
        $this -> assign('apply_list',$apply_list[0]);
        $this -> assign('show_page',$apply_list[1]);
        $this -> display();
    }

}