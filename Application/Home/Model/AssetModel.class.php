<?php

namespace Home\Model;
use Think\Model;

class AssetModel extends Model
{

    /**
     * @param $user
     * @return mixed
     * 获取某用户资产信息
     */
    public function get_user_asset($user){
        $asset_table = M('asset as a');
        $where['u.id'] = $user;
        $total = $asset_table
            ->join('user as u on u.id=a.user_id')
            ->join('product as p on p.id=a.product_id')
            ->where($where)
            ->count();
        $per = C('PAGE_NUM');
        $Page = new  \Think\Page($total, $per);
        $Page->setConfig('last','尾页');//最后一页显示"尾页"
        $show = $Page->show();
        $asset_info = $asset_table
            ->field('p.id,p.name as product,a.usable')
            ->join('user as u on u.id=a.user_id')
            ->join('product as p on p.id=a.product_id')
            ->where($where)
            ->select();
        return array($asset_info,$show);
    }


    /**
     * @param $phone 用户手机号
     * @param $name 用户名
     * @return array
     * 根据用户手机号获得用户资产信息
     */
    public function get_assets($phone,$name){
        $asset_table = M('asset as a');
        if(!empty($phone)){
            $where['u.phone'] = $phone;
        }
        if(!empty($name)){
            $where['u.name'] = array('like','%'.$name.'%');
        }
        $where['u.type'] = 0;
        $total = $asset_table
            ->join('user as u on u.id=a.user_id')
            ->join('product as p on p.id=a.product_id')
            ->where($where)
            ->count();
        $per = C('PAGE_NUM');
        $Page = new  \Think\Page($total, $per);
        $Page->setConfig('last','尾页');//最后一页显示"尾页"
        $show = $Page->show();
        $asset_info = $asset_table
            ->field('a.id,u.name,u.phone,u.identity_card,p.name as product,a.money,a.usable')
            ->join('user as u on u.id=a.user_id')
            ->join('product as p on p.id=a.product_id')
            ->where($where)
            ->select();
        return array($asset_info,$show);
    }

}