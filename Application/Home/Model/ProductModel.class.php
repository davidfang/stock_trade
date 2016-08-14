<?php

namespace Home\Model;
use Think\Model;

class ProductModel extends Model
{
    /**
     * @return mixed
     * 获取产品
     */
    public function get_product(){
        $where['status'] = 0;
        $product = M('product')->where($where)->order('create_time desc')->select();
        return $product;
    }

    /**
     * @param $product
     * @return array
     * 添加或修改产品
     */
    public function add_save($product){
        $table = M('product');
        $find_where['name']=$product['name'];
        $find_where['status']=0;
        $find_res = $table->where($find_where)->find();
        if(empty($find_res)||$find_res['id']==$product['product']) {
            $data['name'] = $product['name'];
            $data['intro'] = $product['intro'];
            if (empty($product['product'])) {
                $data['create_time'] = $data['update_time'] = time();
                $res = $table->add($data);
                if (empty($res)) {
                    return array('code' => 1, 'msg' => '失败', 'data' => '添加失败！');
                } else {
                    return array('code' => 0, 'msg' => '成功', 'data' => '添加成功！');
                }
            } else {
                $data['update_time'] = time();
                $res = $table->where('id=' . $product['product'])->save($data);
                if (empty($res)) {
                    return array('code' => 1, 'msg' => '失败', 'data' => '修改失败！');
                } else {
                    return array('code' => 0, 'msg' => '成功', 'data' => '修改成功！');
                }
            }
        }else{
            return array('code' => 1,'msg' => '提示','data' => '产品已存在！');
        }
    }

    /**
     * 产品删除
     */
    public function del_product($obj_id){
        $res = M('prepaid')->where('product_id='.$obj_id)->select();
        if(empty($res)){
            $data['update_time']=time();
            $data['status']=1;
            $del_res = M('product')->where('id='.$obj_id)->save($data);
            if(empty($del_res)){
                return array('code' => 1,'msg' => '提示','data' => '删除失败！');
            }else{
                return array('code' => 0,'msg' => '成功','data' => '删除成功！');
            }
        }else{
            return array('code' => 1,'msg' => '提示','data' => '产品已被购买！');
        }
    }

}