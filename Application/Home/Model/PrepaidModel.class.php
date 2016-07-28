<?php

namespace Home\Model;
use Think\Model;

class PrepaidModel extends Model
{

    /**
     * @param $begin
     * @param $end
     * @param $phone
     * @param $name
     * @return array
     * 充值记录
     */
    public function get_recharge_list($begin,$end,$phone,$name){
        $where['p.status'] = 1;
        if(!empty($begin)&&!empty($end)){
            $where['p.update_time'] = array('BETWEEN',array($begin,$end));
        }
        if(!empty($phone)){
            $where['u.phone'] = $phone;
        }
        if(!empty($name)){
            $where['u.name'] = array('like',"%".$name."%");
        }
        $prepaid_table = M('prepaid as p');
        $total = $prepaid_table
            -> join('user as u on p.user_id=u.id')
            -> join('product as pr on p.product_id=pr.id')
            -> where($where)
            -> count();
        $per = C('PAGE_NUM');
        $Page = new  \Think\Page($total, $per);
        $Page->setConfig('last','尾页');//最后一页显示"尾页"
        $show = $Page->show();
        $recharge_info = $prepaid_table
            -> field('p.id,p.user_id,u.name,u.phone,pr.name as product,p.money,p.update_time')
            -> join('user as u on p.user_id=u.id')
            -> join('product as pr on p.product_id=pr.id')
            -> where($where)
            -> limit($Page->firstRow.','.$Page->listRows)
            -> order('p.update_time desc')
            -> select();
        return array($recharge_info, $show);
    }


    /**
     * 今日订单及充值信息
     */
    public function get_prepaid(){
        $begin = strtotime(date('Y-m-d',time()));
        $end = strtotime('+1 day',$begin);

        $where['create_time'] = array('BETWEEN',array($begin,$end));
        $indent = M('prepaid')
            ->field('count(id) as sum,sum(money) as indent_money')
            ->where($where)
            ->find();
        $where['update_time'] = array('BETWEEN',array($begin,$end));
        $where['status']=1;
        $finish = M('prepaid')
            ->field('count(id) as sum,sum(money) as finish_money')
            ->where($where)
            ->find();
        $data['indent'] = $indent['sum'];//订单数
        $data['indent_money'] = $indent['indent_money'];//订单金额
        $data['finish'] = $finish['sum'];//今日完成的订单数【订单为今日下的订单】
        $data['finish_money'] = $finish['finish_money'];//今日完成的订单金额
        $data['money_percentage'] = round($data['finish_money']/$data['indent_money']*100,2);//今日完成的订单金额百分比
        return $data;
    }


    /**
     * @param $product 产品id
     * @param $status 订单状态
     * @return array
     * 我的充值记录
     */
    public function get_prepaid_records($product,$status){
        if($status!=''){
            $where['p.status'] = $status;
        }
        $where['u.id'] = session('user')['id'];
        if(!empty($product)){
            $where['pr.id'] = $product;
        }
        $prepaid_table = M('prepaid as p');
        $total = $prepaid_table
            -> join('user as u on p.user_id=u.id')
            -> join('product as pr on p.product_id=pr.id')
            -> where($where)
            -> count();
        $per = C('PAGE_NUM');
        $Page = new  \Think\Page($total, $per);
        $Page->setConfig('last','尾页');//最后一页显示"尾页"
        $show = $Page->show();
        $recharge_info = $prepaid_table
            -> field('pr.name as product,p.money,p.update_time,p.remarks,p.status')
            -> join('user as u on p.user_id=u.id')
            -> join('product as pr on p.product_id=pr.id')
            -> where($where)
            -> limit($Page->firstRow.','.$Page->listRows)
            -> order('p.update_time desc')
            -> select();
        return array($recharge_info, $show);
    }


    /**
     * 充值操作
     */
    public function recharge($data){
        $data['create_time'] = $data['update_time'] = time();
        $data['user_id'] = session('user')['id'];
        $res = M('prepaid')->add($data);
        return $res;
    }

}