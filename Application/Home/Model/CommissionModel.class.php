<?php

namespace Home\Model;
use Think\Model;

class CommissionModel extends Model
{

    /**
     * @param $begin
     * @param $end
     * @param $grade 代理等级
     * @param $phone 用户手机号
     * @param $name 用户名
     * @param bool|false $user【具体某个人的提成，为空代表所有人】
     * @return array
     * 获取提成列表
     */
    public function get_push_list($begin,$end,$grade,$phone,$name,$user=false){
        if(!empty($begin)&&!empty($end)){
            $where['c.create_time'] = array('BETWEEN',array($begin,$end));
        }
        if(!empty($grade)){
            $where['u.grade_id'] = $grade;
        }
        if(!empty($phone)){
            $where['u.phone'] = $phone;
        }
        if(!empty($name)){
            $where['u.name'] = array('like',"%".$name."%");
        }
        if(!empty($user)){
            $where['c.agency_id'] = $user;
        }
        $refund_table = M('commission as c');
        $total = $refund_table
            -> join('user as u on c.agency_id=u.id')
            -> join('grade as g on u.grade_id=g.id')
            -> where($where)
            -> count();
        $per = C('PAGE_NUM');
        $Page = new  \Think\Page($total, $per);
        $Page->setConfig('last','尾页');//最后一页显示"尾页"
        $show = $Page->show();
        $push_list = $refund_table
            -> field('c.id,c.agency_id,u.name as grade,u.phone,u.grade_id,g.name as grade_rank,c.create_time,c.money')
            -> join('user as u on c.agency_id=u.id')
            -> join('grade as g on u.grade_id=g.id')
            -> where($where)
            -> limit($Page->firstRow.','.$Page->listRows)
            -> order('c.create_time desc')
            -> select();
        $push_sum = $refund_table
            -> join('user as u on c.agency_id=u.id')
            -> join('grade as g on u.grade_id=g.id')
            -> where($where)
            -> sum('money');
        return array($push_list, $show,$push_sum);
    }


    /**
     * @param $commission 某次提成
     * @param $product
     * @param $phone
     * @param $name
     * @return array
     * 获取某次提成详细信息
     */
    public function get_push_details($commission,$product,$phone,$name){
        $agency_id = M('commission')->field('agency_id,create_time')->where('id='.$commission)->find();
        $user = D('user')->get_grade_user($agency_id['agency_id']);
        $begin = strtotime(date('Y-m-d',$agency_id['create_time']));
        $end = strtotime('+1 day',$begin);

        $where['t.create_time'] = array('BETWEEN',array($begin,$end));
        $where['t.user_id'] = array('in',$user);

        $refund_table = M('trade as t');
        //产品列表
        $product_list = $refund_table
            -> field('p.id,p.name as product')
            -> join('user as u on t.user_id=u.id')
            -> join('user as u1 on u.superior=u1.id')
            -> join('product as p on t.product_id=p.id')
            -> where($where)
            -> group("p.name")
            -> select();

        if(!empty($phone)){
            $where['u.phone'] = $phone;
        }
        if(!empty($name)){
            $where['u.name'] = array('like',"%".$name."%");
        }
        if(!empty($product)){
            $where['t.product_id'] = $product;
        }

        $total = $refund_table
            -> join('user as u on t.user_id=u.id')
            -> join('user as u1 on u.superior=u1.id')
            -> join('product as p on t.product_id=p.id')
            -> where($where)
            -> count();
        $per = C('PAGE_NUM');
        $Page = new  \Think\Page($total, $per);
        $Page->setConfig('last','尾页');//最后一页显示"尾页"
        $show = $Page->show();
        $trade_info = $refund_table
            -> field('t.id,t.user_id,u.name,u1.name as grade,p.name as product,t.create_time,t.number')
            -> join('user as u on t.user_id=u.id')
            -> join('user as u1 on u.superior=u1.id')
            -> join('product as p on t.product_id=p.id')
            -> where($where)
            -> limit($Page->firstRow.','.$Page->listRows)
            -> order('t.create_time desc')
            -> select();
        return array($trade_info, $show,$product_list);

    }


    /**
     * 获取昨日提成信息
     */
    public function get_yesterday_push(){
        $end = strtotime(date('Y-m-d',time()));
        $begin = strtotime('-1 day',$end);

        $where['c.create_time'] = array('BETWEEN',array($begin,$end));
        $push_info = M('commission as c')
            ->field('u.grade_id,sum(c.money) as push_sum')
            ->join('user as u on u.id=c.agency_id')
            ->where($where)
            ->group('u.grade_id')
            ->select();
        return $push_info;
    }

}