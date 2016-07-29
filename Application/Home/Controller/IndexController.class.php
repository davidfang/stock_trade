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

}