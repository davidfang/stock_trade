<?php

namespace Home\Model;
use Think\Model;

class SettingModel extends Model
{

    /**
     * @param $grade_rank 代理等级
     * @param $product_id 产品id
     * @return array
     * 分页获取全部提成信息
     */
    public function get_push_info($grade_rank,$product_id){
        $where['p.status']=0;
        if(!empty($grade_rank)){
            $where['s.grade_id']=$grade_rank;
        }
        if(!empty($product_id)){
            $where['s.product_id']=$product_id;
        }
        $table = M('setting as s');
        $total = $table
            -> join('product as p on s.product_id=p.id')
            -> where($where)
            -> count();
        $per = C('PAGE_NUM');
        $Page = new  \Think\Page($total, $per);
        $Page->setConfig('last','尾页');//最后一页显示"尾页"
        $show = $Page->show();
        $info = $table
            -> field('s.id,s.grade_id,s.money,s.begin,s.end,p.name')
            -> join('product as p on s.product_id=p.id')
            -> where($where)
            -> limit($Page->firstRow.','.$Page->listRows)
            -> order('s.create_time desc')
            -> select();
        return array($info, $show);
    }

    /**
     * 添加
     * @param $data
     * @return bool|mixed
     */
    public function add_push($data){
        if($this->check_push($data,0)){
            $data['create_time'] = $data['update_time'] = time();
            $add_res = M('setting')->add($data);
            return $add_res;
        }else{
            return false;
        }
    }

    /**
     * 根据id修改提成
     * @param $data
     * @param $id
     * @return bool
     */
    public function save_push($data,$id){
        if($this->check_push($data,$id)){
            $data['update_time'] = time();
            $save_res = M('setting')->where('id='.$id)->save($data);
            return $save_res;
        }else{
            return false;
        }
    }

    /*
     * 验证提成设定是否合法
     */
    public function check_push($data,$id){
        $check_res = M("setting")
            ->where('grade_id='.$data['grade_id'].
                ' and product_id='.$data['product_id'].
                ' and ((begin<='.$data['begin'].' and end>='.$data['begin'].')'.
                ' or (begin>'.$data['begin'].' and end<'.$data['end'].')'.
                ' or (begin<='.$data['end'].' and end>='.$data['end'].'))')
            ->select();
        if(empty($check_res)){
            return true;
        }else{
            if($id==0){
                return false;
            }else{
                foreach($check_res as $val){
                    if($val['id']!=$id){
                        return false;
                    }
                }
                return true;
            }
        }
    }

    /**
     * 获取全部提成设置
     */
    public function get_all_set(){
        $trade_set = M('setting')->select();
        return $trade_set;
    }

}