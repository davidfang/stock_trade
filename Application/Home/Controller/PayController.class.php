<?php
/**
 * Created by PhpStorm.
 * User: 杨亚东
 * Date: 2016/9/19
 * Time: 18:32
 */

namespace Home\Controller;

use Think\Controller;

class PayController extends Controller
{
    public function recharge_res(){
        //接收返回的参数
        $v_oid = $_REQUEST['v_oid'];//订单编号组
        $v_pmode = urldecode($_REQUEST['v_pmode']);//支付方式组
        $v_pstatus = $_REQUEST['v_pstatus'];//支付状态组
        $v_pstring = urldecode($_REQUEST['v_pstring']);//支付结果说明
        $v_amount = $_REQUEST['v_amount'];//订单支付金额
        $v_count = $_REQUEST['v_count'];//订单个数
        $v_moneytype = $_REQUEST['v_moneytype'];//订单支付币种
        $v_mac = $_REQUEST['v_mac'];//数字指纹（v_mac）
        $v_md5money = $_REQUEST['v_md5money'];//数字指纹（v_md5money）
        $v_sign = $_REQUEST['v_sign'];//验证商城数据签名（v_sign）
        //拆分参数
        $sp = '|_|';
        $a_oid = explode($sp, $v_oid);
        $a_pmode = explode($sp, $v_pmode);
        $a_pstatus = explode($sp, $v_pstatus);
        $a_pstring = explode($sp, $v_pstring);
        $a_amount = explode($sp, $v_amount);
        $a_moneytype = explode($sp, $v_moneytype);
        $key = C('SXY_KEY');//商户的密钥
        $data1=$v_oid.$v_pmode.$v_pstatus.$v_pstring.$v_count;
        $mac= $this->hmac($key, $data1);

        $data2=$v_amount.$v_moneytype;
        $md5money= $this->hmac($key, $data2);
        if($mac == $v_mac or $md5money == $v_md5money) {
            echo("sent");
            //更改数据库状态
            //通过for循环查看该笔通知有几笔订单,并对于更改数据库状态
            for($i=0;$i<$v_count;$i++){
                $where['order_number'] = $v_oid;
                if($a_pstatus[$i]=='1'){
//                    $where['user_id'] = session('user')['id'];
                    $find_id = M('prepaid')->where($where)->find();
                    D('prepaid')->finish($find_id['id']);
                }else if($a_pstatus[$i]=='3'){//支付失败
                    $data['status'] = 2;
                    $data['update_time'] = time();
                    M('prepaid')->where($where)->save($data);
                }else{//处理中
                    $data['status'] = 3;
                    $data['update_time'] = time();
                    M('prepaid')->where($where)->save($data);
                }
            }
        }else{
            echo("error");
            echo("<br>");
        }
    }

    function hmac($key, $data){
        // 创建 md5的HMAC
        $b = 64; // md5加密字节长度
        if (strlen($key) > $b) {
            $key = pack("H*", md5($key));
        }
        $key = str_pad($key, $b, chr(0x00));
        $ipad = str_pad('', $b, chr(0x36));
        $opad = str_pad('', $b, chr(0x5c));
        $k_ipad = $key ^ $ipad;
        $k_opad = $key ^ $opad;
        return md5($k_opad . pack("H*", md5($k_ipad . $data)));
    }
}