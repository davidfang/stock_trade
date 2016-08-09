<?php
/**
 * Created by PhpStorm.
 * User: 杨亚东1
 * Date: 2016/7/24
 * Time: 10:14
 */

namespace Home\Model;
use Think\Model;

class TradeModel extends Model
{

    /**
     * @param $begin 开始时间
     * @param $end 结束时间
     * @param $phone 用户电话
     * @param $name 用户姓名
     * @return array
     * 获得提成信息
     */
    public function get_trade_info($begin,$end,$phone,$name){
        if(!empty($begin)&&!empty($end)){
            $where['t.create_time'] = array('BETWEEN',array($begin,$end));
        }
        if(!empty($phone)){
            $where['u.phone'] = $phone;
        }
        if(!empty($name)){
            $where['u.name'] = array('like',"%".$name."%");
        }
        $refund_table = M('trade as t');
        $total = $refund_table
            -> join('user as u on t.user_id=u.id')
            -> join('product as p on t.product_id=p.id')
            -> where($where)
            -> count();
        $per = C('PAGE_NUM');
        $Page = new  \Think\Page($total, $per);
        $Page->setConfig('last','尾页');//最后一页显示"尾页"
        $show = $Page->show();
        $trade_info = $refund_table
            -> field('t.id,t.user_id,u.name,u.phone,p.name as product,t.create_time,t.number')
            -> join('user as u on t.user_id=u.id')
            -> join('product as p on t.product_id=p.id')
            -> where($where)
            -> limit($Page->firstRow.','.$Page->listRows)
            -> order('t.create_time desc')
            -> select();
        return array($trade_info, $show);
    }

    /**
     * @param $user
     * @param $product
     * @param $number
     * @return bool|mixed|string
     * 添加交易记录
     */
    public function add_record($user,$product,$number){
        $number = intval($number);
        if($number<0){
            return '交易手数有误！';
        }
        $user_id = M('user')->where('type=0 and status=0 and phone='.$user)->find();
        if(empty($user_id)){
            return '用户不存在！';
        }
        $product_where['status']=0;
        $product_where['name']=$product;
        $product_id = M('product')->where($product_where)->find();
        if(empty($product_id)){
            return '产品不存在！';
        }
        $data['user_id'] = $user_id['id'];
        $data['number'] = $number;
        $data['product_id'] = $product_id['id'];
        $data['create_time'] = time();
        $add_res = M('trade')->add($data);
        if(empty($add_res)){
            return false;
        }else{
            return true;
        }
    }


    /**
     * @param $begin
     * @param $end
     * @param $product 产品id
     * @param $user 用户id
     * @return array
     * 获取某个用户的交易记录
     */
    public function get_user_trade_info($begin,$end,$product,$user){
        $where['t.user_id']=$user;
        if(!empty($begin)&&!empty($end)){
            $where['t.create_time'] = array('BETWEEN',array($begin,$end));
        }
        if(!empty($product)){
            $where['p.id'] = $product;
        }
        $refund_table = M('trade as t');
        $total = $refund_table
            -> join('product as p on t.product_id=p.id')
            -> where($where)
            -> count();
        $per = C('PAGE_NUM');
        $Page = new  \Think\Page($total, $per);
        $Page->setConfig('last','尾页');//最后一页显示"尾页"
        $show = $Page->show();
        $trade_info = $refund_table
            -> field('t.create_time,t.number,p.name as product')
            -> join('product as p on t.product_id=p.id')
            -> where($where)
            -> limit($Page->firstRow.','.$Page->listRows)
            -> order('t.create_time desc')
            -> select();
        return array($trade_info, $show);
    }

    /**
     * 获取今天的所有交易记录
     */
    public function today_trade(){
        $time = strtotime(date('Y-m-d'));
        $where['t.create_time'] = array('GT',$time);
        $today_trade_grade_1 = M('trade as t')
            ->field('u1.id,u1.grade_id,t.product_id,sum(t.number) as number')
            ->join('user as u on t.user_id=u.id')
            ->join('user as u3 on u.superior=u3.id')
            ->join('user as u2 on u3.superior=u2.id')
            ->join('user as u1 on u2.superior=u1.id')
            ->where($where)
            ->group('u1.id,t.product_id')
            ->select();
        $today_trade_grade_2 = M('trade as t')
            ->field('u2.id,u2.grade_id,t.product_id,sum(t.number) as number')
            ->join('user as u on t.user_id=u.id')
            ->join('user as u3 on u.superior=u3.id')
            ->join('user as u2 on u3.superior=u2.id')
            ->where($where)
            ->group('u2.id,t.product_id')
            ->select();
        $today_trade_grade_3 = M('trade as t')
            ->field('u3.id,u3.grade_id,t.product_id,sum(t.number) as number')
            ->join('user as u on t.user_id=u.id')
            ->join('user as u3 on u.superior=u3.id')
            ->where($where)
            ->group('u3.id,t.product_id')
            ->select();
        $trade_set = D('setting')->get_all_set();
        $data = array();
        foreach($trade_set as $set){
            foreach($today_trade_grade_1 as $grade){
                if($set['grade_id']==$grade['grade_id']&&$set['product_id']==$grade['product_id']&&$set['begin']<=$grade['number']&&$set['end']>=$grade['number']){
                    array_push($data,array('agency_id'=>$grade['id'],'money'=>$grade['number']*$set['money']));
                }
            }
            foreach($today_trade_grade_2 as $grade){
                if($set['grade_id']==$grade['grade_id']&&$set['product_id']==$grade['product_id']&&$set['begin']<=$grade['number']&&$set['end']>=$grade['number']){
                    array_push($data,array('agency_id'=>$grade['id'],'money'=>$grade['number']*$set['money']));
                }
            }
            foreach($today_trade_grade_3 as $grade){
                if($set['grade_id']==$grade['grade_id']&&$set['product_id']==$grade['product_id']&&$set['begin']<=$grade['number']&&$set['end']>=$grade['number']){
                    array_push($data,array('agency_id'=>$grade['id'],'money'=>$grade['number']*$set['money']));
                }
            }
        }
        $add_data = array();
        for($i=0;$i<count($data);$i++){
            $money = $data[$i]['money'];
            for($j=0;$j<count($data);$j++){
                if($i!=$j&&$data[$i]['agency_id']==$data[$j]['agency_id']){
                    $money+=$data[$j]['money'];
                }
            }
            for($m=0;$m<count($add_data);$m++){
                if($add_data[$m]['agency_id']==$data[$i]['agency_id']){
                    continue 2;
                }
            }
            array_push($add_data,array('agency_id'=>$data[$i]['agency_id'],'money'=>$money,'create_time'=>time()));
        }
        $add_res = M('commission')->addAll($add_data);
//        if(empty($add_res)){
//            $this->today_trade();
//        }else{
//
//        }
    }

}