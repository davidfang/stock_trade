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
}