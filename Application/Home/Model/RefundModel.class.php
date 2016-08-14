<?php

namespace Home\Model;
use Think\Model;

class RefundModel extends Model
{

    /**
     * @return mixed
     * 获取所有未审核的出金申请
     */
    public function get_drawings_apply(){
        $where['r.status'] = 0;
        $refund_table = M('refund as r');
        $total = $refund_table->where($where)->count();
        $per = C('PAGE_NUM');
        $Page = new  \Think\Page($total, $per);
        $Page->setConfig('last','尾页');//最后一页显示"尾页"
        $show = $Page->show();
        $apply_info = $refund_table
            -> field('r.id,r.user_id,u.name,u.phone,p.name as product,r.money')
            -> join('user as u on r.user_id=u.id')
            -> join('product as p on r.product_id=p.id')
            -> where($where)
            -> limit($Page->firstRow.','.$Page->listRows)
            -> order('r.create_time desc')
            -> select();
        return array($apply_info, $show);
    }

    /**
     * @param $id
     * @return bool
     * 同意申请
     */
    public function pass_apply($id){
        $data['update_time'] = time();
        $data['status'] = 1;
        $trans = M("refund");
        $trans->startTrans();
        $data_old = $trans->where('id='.$id)->find();
        $poundage = M('poundage')->find();//获取提成百分比
        if(empty($data_old)||empty($poundage)){
            $trans->rollback();
            return false;
        }
//        if($data_old['money']<=$poundage['money']){
//            $trans->rollback();
//            return '出金金额小于手续费！';
//        }
        $data['poundage'] = round($data_old['money']*$poundage['money']/100,2);//手续费四舍五入（两位小数）
        $data['actual_refund'] = $data_old['money']-$data['poundage'];//实际出金金额
        $res = $trans->where('id='.$id)->save($data);
        $user_trans = M('user');
        $user_trans->startTrans();
        if(!empty($res)){
            $current = $user_trans->where('id='.$data_old['user_id'])->setDec('current',$data_old['money']);
            $where['user_id'] = $data_old['user_id'];
            $where['product_id'] = $data_old['product_id'];
            $money = M('asset')->where($where)->setDec('money',$data_old['money']);
            if(!empty($current)&&!empty($money)){
                $user_trans->commit();
                $trans->commit();
                return true;
            }
        }
        $user_trans->rollback();
        $trans->rollback();
        return false;
    }

    /**
     * @param $id
     * @param $remarks
     * @return bool
     * 拒绝申请
     */
    public function refuse_apply($id,$remarks){
        $data['remarks'] = $remarks;
        $data['update_time'] = time();
        $data['status'] = 2;

        $trans = M("refund");
        $trans->startTrans();
        $data_old = $trans->where('id='.$id)->find();
        if(empty($data_old)){
            $trans->rollback();
            return false;
        }
        $res = $trans->where('id='.$id)->save($data);
        if(!empty($res)){
            $where['user_id'] = $data_old['user_id'];
            $where['product_id'] = $data_old['product_id'];
            $current = M('asset')->where($where)->setInc('usable',$data_old['money']);
            if(!empty($current)){
                $trans->commit();
                return true;
            }
        }
        $trans->rollback();
        return false;
    }

    /**
     * @param $status
     * @param $phone
     * @param $name
     * @return array
     * 手续费列表
     */
    public function get_drawings_list($status,$phone,$name){
        $where['r.status'] = array('neq',0);
        if(!empty($status)){
            $where['r.status'] = $status;
        }
        if(!empty($phone)){
            $where['u.phone'] = $phone;
        }
        if(!empty($name)){
            $where['u.name'] = array('like',"%".$name."%");
        }
        $refund_table = M('refund as r');
        $total = $refund_table
            -> join('user as u on r.user_id=u.id')
            -> join('product as p on r.product_id=p.id')
            -> where($where)
            -> count();
        $per = C('PAGE_NUM');
        $Page = new  \Think\Page($total, $per);
        $Page->setConfig('last','尾页');//最后一页显示"尾页"
        $show = $Page->show();
        $apply_info = $refund_table
            -> field('r.id,r.user_id,u.name,u.phone,p.name as product,r.money,r.poundage,r.actual_refund,r.status,r.remarks')
            -> join('user as u on r.user_id=u.id')
            -> join('product as p on r.product_id=p.id')
            -> where($where)
            -> limit($Page->firstRow.','.$Page->listRows)
            -> order('r.update_time desc')
            -> select();
        return array($apply_info, $show);
    }

    /**
     * @param $phone
     * @param $name
     * @return array
     * 手续费查询
     */
    public function get_poundage_list($phone,$name){
        $where['r.status'] = 1;
        if(!empty($phone)){
            $where['u.phone'] = $phone;
        }
        if(!empty($name)){
            $where['u.name'] = array('like',"%".$name."%");
        }
        $refund_table = M('refund as r');
        $total = $refund_table
            -> join('user as u on r.user_id=u.id')
            -> join('product as p on r.product_id=p.id')
            ->where($where)
            ->count();
        $per = C('PAGE_NUM');
        $Page = new  \Think\Page($total, $per);
        $Page->setConfig('last','尾页');//最后一页显示"尾页"
        $show = $Page->show();
        $apply_info = $refund_table
            -> field('r.id,r.user_id,u.name,u.phone,p.name as product,r.money,r.poundage,r.actual_refund,r.status,r.remarks')
            -> join('user as u on r.user_id=u.id')
            -> join('product as p on r.product_id=p.id')
            -> where($where)
            -> limit($Page->firstRow.','.$Page->listRows)
            -> order('r.update_time desc')
            -> select();
        $poundage_sum = $refund_table
            -> join('user as u on r.user_id=u.id')
            -> join('product as p on r.product_id=p.id')
            -> where($where)
            -> sum('poundage');
        return array($apply_info, $show,$poundage_sum);
    }

    /**
     * @param $data 出金申请数据
     * @param $user 用户
     * @return bool
     * 出金申请
     */
    public function refund_apply($data,$user){
        $refund = M('refund');
        $refund->startTrans();
        $asset_where['user_id']=$user;
        $asset_where['product_id']=$data['product_id'];
        $save_res = M('asset')->where($asset_where)->setDec('usable',$data['money']);
        if(!empty($save_res)){
            $data['user_id'] = $user;
            $data['create_time'] = $data['update_time'] = time();
            $add_res = M('refund')->add($data);
            if(!empty($add_res)){
                $refund->commit();
                return true;
            }
        }
        $refund->rollback();
        return false;
    }

    /**
     * @param $status 出金状态【'':全部，0：审核中的，1：已出金的，2：已拒绝的】
     * @param $user
     * @return array
     * 按状态获取某个用户的出金申请记录
     */
    public function get_refund_apply_list($status,$user){
        if($status!=''){
            $where['r.status'] = $status;
        }
        $where['r.user_id'] = $user;
        $refund_table = M('refund as r');
        $total = $refund_table->join('product as p on r.product_id=p.id')->where($where)->count();
        $per = C('PAGE_NUM');
        $Page = new  \Think\Page($total, $per);
        $Page->setConfig('last','尾页');//最后一页显示"尾页"
        $show = $Page->show();
        $apply_info = $refund_table
            -> field('p.name as product,r.money,r.poundage,r.actual_refund,r.remarks,r.create_time,r.update_time,r.status')
            -> join('product as p on r.product_id=p.id')
            -> where($where)
            -> limit($Page->firstRow.','.$Page->listRows)
            -> order('r.create_time desc')
            -> select();
        return array($apply_info, $show);
    }

}