<?php

namespace Home\Controller;
use Think\Controller;

class EmptyController extends Controller{
    function _empty(){
        $this->display("Public/404");
    }
}