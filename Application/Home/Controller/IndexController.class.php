<?php
namespace Home\Controller;
use Think\Controller;

class IndexController extends Controller{
    /**
     * 欢迎页即官网首页
     */
    public function index(){
        $this -> display();
    }

    /**
     * 下载页
     */
    public function download(){
        $this -> display();
    }

    /**
     * 每日自动提成【不可随意执行】
     */
    public function everyday_push(){
        $time = time();
        $min = strtotime(date('Y-m-d').C('PUSH_BEGIN'));
        $max = strtotime(date('Y-m-d').C('PUSH_end'));
        if($time>=$min&&$time<=$max){
            D('trade')->today_trade();
            dump('ok');
        }else{
            $this->display("Public/404");
        }
    }

    /**
     * 空方法处理
     */
    function _empty(){
        $this->display("Public/404");
    }
}