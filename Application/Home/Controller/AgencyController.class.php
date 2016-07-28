<?php

namespace Home\Controller;
use Think\Controller;

class AgencyController extends BaseController
{

    /**
     * @param string $grade 用户[为空代表当前用户]
     * @param string $type 类型【'':全部，0：普通用户，1：一级代理，2：二级代理，3：三级代理】
     * @param string $phone
     * @param string $name
     */
    public function client($grade='',$type='',$phone='',$name=''){
        if(empty($grade)){
            $grade = session('user')['id'];
        }
        $user = D('user')->get_user_all($grade,$type,$phone,$name);
        $this -> assign('title','我的客户');
        $this -> assign('route','我的客户');
        $this -> assign('header_title','客户信息');

        $this -> assign('user_all',$user[0]);
        $this -> assign('show_page',$user[1]);
        $this -> assign('grade',$grade);
        $this -> assign('type',$type);
        $this -> assign('phone',$phone);
        $this -> assign('name',$name);
        $this -> display();
    }

    /**
     * @param string $begin
     * @param string $end
     * 我的提成
     */
    public function push($begin='',$end=''){
        if(!empty($begin)&&!empty($end)){
            $return_begin = date('m/d/Y',$begin);
            $return_end = date('m/d/Y',$end);
            $time = $return_begin." - ".$return_end;
            $end = strtotime("+1 day",$end);
        }
        $push_list = D('commission')->get_push_list($begin,$end,'','','',session('user')['id']);
        $this -> assign('title','我的提成');
        $this -> assign('route','提成信息 / 我的提成');
        $this -> assign('header_title','我的提成');
        $this -> assign('push_list',$push_list[0]);
        $this -> assign('show_page',$push_list[1]);
        $this -> assign('push_sum',$push_list[2]);
        $this -> assign('time',$time?$time:'');
        $this -> display();
    }

    /**
     * @param string $grade 代理[为空代表当前代理]
     * @param string $grade_rank 代理等级
     * @param string $begin
     * @param string $end
     * @param string $phone 代理电话
     * @param string $name 代理姓名
     * 子代理提成查询
     */
    public function son_agency_push($grade='',$grade_rank='',$begin='',$end='',$phone='',$name=''){
        if(empty($grade)){
            $grade = session('user')['id'];
        }
        if(!empty($begin)&&!empty($end)){
            $return_begin = date('m/d/Y',$begin);
            $return_end = date('m/d/Y',$end);
            $time = $return_begin." - ".$return_end;
            $end = strtotime("+1 day",$end);
        }
        $son_push_list = D('user')->get_grade($grade,$grade_rank,$begin,$end,$phone,$name);
        $this -> assign('title','子代理提成');
        $this -> assign('route','提成信息 / 子代理提成');
        $this -> assign('header_title','子代理提成');

        $this -> assign('son_push_list',$son_push_list[0]);
        $this -> assign('show_page',$son_push_list[1]);
        $this -> assign('grade',$grade);
        $this -> assign('time',$time);
        $this -> assign('phone',$phone);
        $this -> assign('name',$name);
        $this -> display();
    }

}