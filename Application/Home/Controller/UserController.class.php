<?php

namespace Home\Controller;
use Think\Controller;

class UserController extends BaseController
{

    /**
     * @param string $begin
     * @param string $end
     * @param string $product 产品id
     * 首页
     */
    public function index($begin='',$end='',$product=''){
        $user_info = M('user')->where('id='.session('user')['id'])->find();
        $product_sum = M('prepaid')->where('status=1 and user_id='.session('user')['id'])->group('product_id')->select();
        if(!empty($begin)&&!empty($end)){
            $return_begin = date('m/d/Y',$begin);
            $return_end = date('m/d/Y',$end);
            $time = $return_begin." - ".$return_end;
            $end = strtotime("+1 day",$end);
        }
        $trade_info = D('trade')->get_user_trade_info($begin,$end,$product,session('user')['id']);
        $this -> assign('title','首页');
        $this -> assign('route','首页');
        $this -> assign('header_title','首页');

        $this -> assign('user_info',$user_info);
        $this -> assign('product_sum',count($product_sum));
        $this -> assign('trade_info',$trade_info[0]);
        $this -> assign('show_page',$trade_info[1]);
        $product_list = D('product')->get_product();
        $this -> assign('product_list',$product_list);

        $this -> assign('time',$time);
        $this -> assign('product',$product);
        $this -> display();
    }


    /**
     * @param string $product 产品id
     * @param string $status 订单状态['':全部，0：未充值，1：已充值]
     * 我的充值记录
     */
    public function prepaid_records($product='',$status=''){
        $records = D('prepaid')->get_prepaid_records($product,$status);
        $this -> assign('title','充值记录');
        $this -> assign('route','充值管理 / 充值记录');
        $this -> assign('header_title','充值记录');
        $this -> assign('prepaid_records',$records[0]);
        $this -> assign('show_page',$records[1]);
        $this -> assign('product',$product);
        $this -> assign('status',$status);
        $product_list = D('product')->get_product();
        $this -> assign('product_list',$product_list);
        $this -> display();
    }


    /**
     * 我要充值页面
     */
    public function recharge(){
        $this -> assign('title','我要充值');
        $this -> assign('route','充值管理 / 我要充值');
        $this -> assign('header_title','我要充值');
        $product_list = D('product')->get_product();
        $this -> assign('product_list',$product_list);
        $conversion = M('conversion')->find();
        $this -> assign('conversion',$conversion);
        $this -> display();
    }

    /**
     * 合作协议
     */
    public function agreement(){
        $this->display();
    }

    /**
     * 用户充值操作
     */
    public function recharge_handle(){
        $data = I('post.');
        if(empty($data['money'])||empty($data['product_id'])||(floor(floatval($data['money'])*100)/100)<=0){
            $this -> assign('title','系统错误');
            $this -> assign('sen_title','系统错误');
            $this -> assign('content','订单生产失败，请完善订单信息！');
            $this -> assign('status','false');
            $this -> display('recharge_res');
        }else{
            $res = D('prepaid')->recharge($data);
            if(empty($res)){
                $this -> assign('title','系统错误');
                $this -> assign('sen_title','系统错误');
                $this -> assign('content','订单生产失败，请联系管理员！');
                $this -> assign('status','false');
                $this -> display('recharge_res');
            }else{
                $this->finish_recharge($res);
            }
        }
    }

    /**
     * 订单已存在
     * 去完成充值
     */
    public function to_recharge(){
        $v_oid = I('get.v_oid');
        $where['user_id'] = session('user')['id'];
        $where['order_number'] = $v_oid;
        $where['status'] = 0;
        $indent = M('prepaid')->where($where)->find();
        if(empty($indent)){
            $this -> assign('title','订单有误');
            $this -> assign('sen_title','订单不存在');
            $this -> assign('content','订单不存在，请核对订单！');
            $this -> assign('status','false');
            $this -> display('recharge_res');
        }else{
            $data = [$v_oid,$indent['money']];
            $this->finish_recharge($data);
        }
    }

    /**
     * @param $indent 订单号
     * @return bool
     * 完成充值
     */
    public function finish_recharge($indent){
        $arr = explode("-",$indent[0]);
        $v_ymd=$arr[0]; //订单产生日期，要求订单日期格式yyyymmdd.
        $v_mid=$arr[1];    //商户编号，和首信签约后获得,测试的商户编号444
        $v_date=$arr[2];
        $v_oid=$v_ymd .'-' . $v_mid . '-' .$v_date; //订单编号。订单编号的格式是yyyymmdd-商户编号-流水号，流水号可以取系统当前时间，也可以取随机数，也可以商户自己定义的订单号，自己定义的订单号必须保证每?次提交，订单号是唯一的??

        //本系统内未必要配置
        $v_rcvname=$v_mid; //收货人姓名,建议用商户编号代替或者是英文数字。因为首信平台的编号是gb2312的
        $v_rcvaddr=$v_mid; //收货人地址，可用商户编号代替
        $v_rcvpost=$v_mid;  //收货人邮编【用商户编号代替】
        $v_ordername=$v_mid;  //订货人姓名与收货人一致【个人设置】
        //end
        $key = C('SXY_KEY');//商户的密钥
        $v_rcvtel=session('user')['phone'];   //收货人电话
        $v_amount=$indent[1]; //订单金额
        $v_orderstatus="1";//配货状态:0-未配齐，1-已配
        $v_moneytype="0";  //0为人民币，1为美元，2为欧元，3为英镑，4为日元，5为韩元，6为澳大利亚元，7为卢布(内卡商户币种只能为人民币)
        $v_url='http://'.$_SERVER['SERVER_NAME'].U('User/recharge_res'); //支付完成后的实时返回地址。支付完成后实时先向这个地址做返回?在此地囿下做接收银行返回的支付确认消息?详细的返回参数格式西(接口文档的第二部分或者代码示例的received1.php)
        $data = $v_moneytype.$v_ymd.$v_amount.$v_rcvname.$v_oid.$v_mid.$v_url;//七个参数的拼串
        $v_md5info=$this->hmac($key, $data);
        echo '<html>
            <head>
            <meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
            <title>send</title>
            </head>
            <body>
            <form action='.C("SXY_URL").' method="post" name="payease_form" target="_parent">
                  <input type="hidden"  name="v_mid"        value="'.$v_mid.'">
                  <input type="hidden"  name="v_oid"      value="'.$v_oid.'">
                  <input type="hidden"  name="v_rcvname"  value="'.$v_rcvname.'">
                  <input type="hidden"  name="v_rcvaddr"  value="'.$v_rcvaddr.'">
                  <input type="hidden"  name="v_rcvtel"   value="'.$v_rcvtel.'">
                  <input type="hidden"  name="v_rcvpost"  value="'.$v_rcvpost.'">
                  <input type="hidden"  name="v_amount"   value="'.$v_amount.'">
                  <input type="hidden"  name="v_ymd"      value="'.$v_ymd.'">
                  <input type="hidden"  name="v_orderstatus" value="'.$v_orderstatus.'">
                  <input type="hidden"  name="v_ordername" value="'.$v_ordername.'">
                  <input type="hidden"  name="v_moneytype" value="'.$v_moneytype.'">
                  <input type="hidden"  name="v_url" value="'.$v_url.'">
                  <input type="hidden"  name="v_md5info" value="'.$v_md5info.'">
            </form>
            <script language="javascript">payease_form.submit();</script>
            </body>
            </html>';
    }

    /**
     * v_md5info的计算
     * @param $key
     * @param $data
     * @return string
     */
    function hmac ($key, $data){
        // 创建 md5的HMAC
        $b = 64; // md5加密字节长度
        if (strlen($key) > $b) {
            $key = pack("H*",md5($key));
        }
        $key  = str_pad($key, $b, chr(0x00));
        $ipad = str_pad('', $b, chr(0x36));
        $opad = str_pad('', $b, chr(0x5c));
        $k_ipad = $key ^ $ipad;
        $k_opad = $key ^ $opad;
        return md5($k_opad  . pack("H*",md5($k_ipad . $data)));
    }

    /**
     * 支付返回信息处理
     */
    public function recharge_res(){
//        //接收返回的参数
        $v_oid = $_REQUEST['v_oid'];             //支付提交时的订单编号，此时返回
        $v_pstatus = $_REQUEST['v_pstatus'];     //1 待处理,20 支付成功,30 支付失败
        $v_pstring = urldecode($_REQUEST['v_pstring']);   //支付结果信息返回。当v_pstatus=1时-已提交。20-支付完成。30-支付失败
        $v_pmode = urldecode($_REQUEST['v_pmode']);       //支付方式。
        $v_amount = $_REQUEST['v_amount'];                //订单金额
        $v_moneytype = $_REQUEST['v_moneytype'];          //币种
        $v_md5info = $_REQUEST['v_md5info'];
        $v_md5money = $_REQUEST['v_md5money'];
        $v_sign = $_REQUEST['v_sign'];
        $key = C('SXY_KEY');//商户的密钥
        $data1=$v_oid.$v_pstatus.$v_pstring.$v_pmode;
        $md5info= $this->hmac($key, $data1);
        $data2=$v_amount.$v_moneytype;
        $md5money= $this->hmac($key, $data2);
        if($md5info == $v_md5info && $md5money == $v_md5money){
            if($v_pstatus=='20'){
                $where['user_id'] = session('user')['id'];
                $where['order_number'] = $v_oid;
                $find_id = M('prepaid')->where($where)->find();
                $res = D('prepaid')->finish($find_id['id']);
                if(empty($res)){
                    $title = '系统错误';
                    $sen_title = '系统出错了';
                    $content = '系统出错了，请联系管理员！';
                    $status = 'false';
                }else{
                    $title = '支付成功';
                    $sen_title = '支付成功';
                    $content = '您已成功付款。';
                    $status = 'true';
                }
            }else if($v_pstatus=='30'){//支付失败时返回的页面
                $title = '支付失败';
                $sen_title = '支付失败';
                $content = '付款失败，请重新支付！';
                $status = 'false';
            }else{//待处理时返回的页面
                $title = '订单处理中';
                $sen_title = '订单处理中';
                $content = '处理中，如有疑问请联系管理员！';
                $status = 'true';
            }
        }else{
            $title = '系统错误';
            $sen_title = '系统出错了';
            $content = '系统出错了，请联系管理员！';
            $status = 'false';
        }
        $this -> assign('title',$title);
        $this -> assign('sen_title',$sen_title);
        $this -> assign('content',$content);
        $this -> assign('status',$status);
        $this -> display();
    }

    /**
     * 我要出金
     */
    public function refund(){
        $this -> assign('title','我要出金');
        $this -> assign('route','出金管理 / 我要出金');
        $this -> assign('header_title','我要出金');
        $user_asset = D('asset')->get_user_asset(session('user')['id']);
        $this -> assign('user_asset',$user_asset[0]);
        $this -> assign('show_page',$user_asset[1]);
        $product_list = D('product')->get_product();
        $this -> assign('product_list',$product_list);
        $conversion = M('conversion')->find();
        $this -> assign('conversion',$conversion);
        $this -> display();
    }

    /**
     * 出金操作
     */
    public function refund_handle(){
        $data = I('post.');
        $user = session('user')['id'];
        $apply = D('refund')->refund_apply($data,$user);
        if(empty($apply)){
            $this -> json_response(array('code'=>1,'msg'=>'提示','data'=>'申请失败，请重试！'));
        }else{
            $this -> json_response(array('code'=>0,'msg'=>'成功','data'=>'申请已发出，请耐心等待。'));
        }
    }

    /**
     * @param string $status 出金状态【'':全部，0：审核中的，1：已出金的，2：已拒绝的】
     * 我的出金记录
     */
    public function refund_apply_list($status=''){
        $this -> assign('title','出金记录');
        $this -> assign('route','出金管理 / 出金记录');
        $this -> assign('header_title','出金记录');
        $this -> assign('status',$status);
        $user = session('user')['id'];
        $apply_list = D('refund')->get_refund_apply_list($status,$user);
        $this -> assign('apply_list',$apply_list[0]);
        $this -> assign('show_page',$apply_list[1]);
        $this -> display();
    }

}