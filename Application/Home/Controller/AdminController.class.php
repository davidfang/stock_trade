<?php

namespace Home\Controller;
use Think\Controller;

class AdminController extends BaseController
{

    /**
     * 首页
     */
    public function index(){
        $this -> assign('title','首页');
        $this -> assign('route','首页');
        $this -> assign('header_title','首页');
        $user_distribute = D('user')->get_user_distribute();
        $this -> assign('user_distribute',$user_distribute);
        $yesterday_push = D('commission')->get_yesterday_push();
        $this -> assign('yesterday_push',$yesterday_push);
        $prepaid = D('prepaid')->get_prepaid();
        $this -> assign('prepaid',$prepaid);
        $this -> display();
    }


    /**
     * 用户信息
     */
    public function user($phone='all',$name='all'){
        $this -> assign('title','用户信息');
        $this -> assign('route','用户管理 / 用户信息');
        $this -> assign('header_title','用户信息');
        $this -> assign('phone',$phone=='all'?'':$phone);
        $this -> assign('name',$name=='all'?'':$name);
        $user_info = D('user')->get_all_user($phone,$name);
        $this->assign('user_info', $user_info[0]);
        $this->assign('show_page', $user_info[1]);
        $this -> display();
    }

    /**
     * 添加用户或代理
     */
    public function add_user(){
        $data = I("post.");
        if(empty($data)){
            $this -> assign('title','添加用户');
            $this -> assign('route','用户管理 / 添加用户');
            $this -> assign('header_title','添加用户');
            $this -> assign('type','user');
            $this->display();
        }else{
            $user_model = D('user');
            if(!$user_model->create($data)){
                $this->json_response(array('code' => 2,'msg' => '提示','data' => $user_model->getError()));
            }else{
                $find = M('user')->where('phone='.$data['phone'])->find();
                if(!empty($find)){
                    $this->json_response(array('code' => 1,'msg' => '失败','data' => '账号已被占用！'));
                }
//                $data['password'] = md5(substr($data['identity_card'],12));
                $data['password'] = md5($data['set_pwd']);
                $res = $user_model->add_user($data);
                if($res == false){
                    $this->json_response(array('code' => 1,'msg' => '失败','data' => '添加失败,请重试！'));
                }else{
                    $this->json_response(array('code' => 0,'msg' => '成功','data' => '添加成功！'));
                }
            }
        }
    }

    /**
     * @param $user
     * 修改用户信息
     */
    public function edit_info($user){
        $data = I("post.");
        if(empty($data)){
            $this -> assign('title','编辑用户信息');
            $this -> assign('route','用户管理 / 用户信息');
            $this -> assign('header_title','编辑用户信息');
            $this -> assign('type','user');
            $this -> assign('user_id',$user);
            $user_info = D('user')->get_Personal_info($user);
            $this -> assign('user_info',$user_info);
            $this -> display("Admin/add_user");
        }else{
            $this->edit($data);
        }
    }

    /**
     * 代理信息
     */
    public function agency_info(){
        $this -> assign('title','代理信息');
        $this -> assign('route','代理管理 / 代理信息');
        $this -> assign('header_title','代理管理');
        $user_info = D('user')->get_agency_info();
        $this->assign('user_info', $user_info[0]);
        $this->assign('show_page', $user_info[1]);
        $this -> display();
    }

    /**
     * @param int $type 代理等级
     * 添加代理
     */
    public function add_agency($type=3){
        $this -> assign('title','添加代理');
        $this -> assign('route','代理管理 / 代理信息');
        if($type==1){
            $this -> assign('header_title','添加一级代理');
        }elseif($type==2){
            $this -> assign('header_title','添加二级代理');
        }else{
            $this -> assign('header_title','添加三级代理');
            $type=3;
        }
        if($type!=1){
            $one_grade = M('user as u')
                -> field('u.name,u.id')
                -> join('grade as g on g.id=u.grade_id')
                -> where("u.status=0 and g.name='一级代理'")
                -> select();
            $this -> assign('one_grade',$one_grade);
        }
        $this -> assign('type',$type);
        $this -> display();
    }

    /**
     * 删除代理并将其下的用归系统
     */
    public function del_agency(){
        $user = I("post.user");
        $res = D('user')->del_agency($user);
        if($res===false){
            $this->json_response(array('code' => 1, 'msg' => '失败', 'data' => '删除失败，请重试'));
        }elseif($res===true){
            $this->json_response(array('code' => 0, 'msg' => '成功', 'data' => '已删除。'));
        }else{
            $this->json_response(array('code' => 2, 'msg' => '提示', 'data' => $res));
        }
    }

    /**
     * @param $user 代理id
     * 获取某代理下的直接代理
     */
    public function get_son_grade($user){
        $son_grade = M('user')
            -> field('id,name')
            -> where('status=0 and superior='.$user)
            -> select();
        if(empty($son_grade)){
            $this->json_response(array('code' => 1, 'msg' => 'no', 'data' => null));
        }else{
            $this->json_response(array('code' => 0, 'msg' => 'yes', 'data' => $son_grade));
        }
    }

    /**
     * @param $user
     * 修改代理信息
     */
    public function edit_agency($user){
        $data = I("post.");
        if(empty($data)){
            $this -> assign('title','代理信息');
            $this -> assign('route','代理管理 / 代理信息');
            $this -> assign('header_title','编辑信息');
            $this -> assign('user_id',$user);
            $user_info = D('user')->get_Personal_info($user);
            $this -> assign('user_info',$user_info);
            $this -> display();
        }else{
            $this->edit($data);
        }
    }

    /**
     * 修改代理或用户信息操作
     */
    public function edit($data){
        $user_model = D('user');
        if(!$user_model->create($data)){
            $this->json_response(array('code' => 2,'msg' => '提示','data' => $user_model->getError()));
        }else {
            $find_phone = M('user')->where('phone=' . $data['phone'])->find();
            if (!empty($find_phone) && $find_phone['id'] != $data['user']) {
                $this->json_response(array('code' => 1, 'msg' => '失败', 'data' => '账号已被占用！'));
            } else {
                $data['update_time'] = time();
                $res = M('user')->where('id=' . $data['user'])->save($data);
                if ($res == false) {
                    $this->json_response(array('code' => 1, 'msg' => '失败', 'data' => '操作失败,请重试！'));
                } else {
                    $this->json_response(array('code' => 0, 'msg' => '成功', 'data' => '操作成功！'));
                }
            }
        }
    }

    /**
     * 重置密码
     */
    public function reset_password(){
        $data = I('post.');
        if($data['password']!=$data['verify_password']){
            $this->json_response(array('code' => 2,'msg' => '提示','data' => '前后密码不一致！'));
        }
        $save_data['password'] = md5($data['password']);
        $save_data['update_time'] = time();
        $save_res = M('user')->where('id='.$data['user'])->save($save_data);
        if(empty($save_res)){
            $this->json_response(array('code' => 1,'msg' => '失败','data' => '修改失败,请重试！'));
        }else{
            $this->json_response(array('code' => 0,'msg' => '成功','data' => '恭喜，密码已重置。'));
        }
    }

    /**
     * 分配代理
     */
    public function allot_agency($phone='all',$name='all'){
        $data = I('post.');
        if(empty($data)){
            $this -> assign('title','分配代理');
            $this -> assign('route','代理管理 / 分配代理');
            $this -> assign('header_title','分配代理');
            $this -> assign('phone',$phone=='all'?'':$phone);
            $this -> assign('name',$name=='all'?'':$name);
            $user_info = D('user')->get_all_user($phone,$name,'undistributed');
            $this->assign('user_info', $user_info[0]);
            $this->assign('show_page', $user_info[1]);
            //获取一级代理
            $one_grade = M('user as u')
                -> field('u.name,u.id')
                -> join('grade as g on g.id=u.grade_id')
                -> where("u.status=0 and g.name='一级代理'")
                -> select();
            $this -> assign('one_grade',$one_grade);
            $this -> display();
        }else{
            $allot_res = M("user")->where('id='.$data['user'])->save(array('superior'=>$data['superior']));
            if(empty($allot_res)){
                $this->json_response(array('code' => 1,'msg' => '失败','data' => '分配失败,请重试！'));
            }else{
                $this->json_response(array('code' => 0,'msg' => '成功','data' => '分配成功。'));
            }
        }
    }

    /**
     * @param int $grade_id 代理等级查询 【高级搜索】
     * @param string $phone 代理电话【高级搜索】
     * @param string $name 代理名字【高级搜索】
     * @param int $grade 代理等级【查看下级】
     * @param int $user 代理id【查看下级】
     * 子代理信息
     */
    public function son_agency($grade_id=0,$phone='all',$name='all',$grade=0,$user=0){
        $this -> assign('title','代理信息');
        $this -> assign('route','代理管理 / 子代理查询');
        $this -> assign('header_title','代理信息');
        $this -> assign('where',$grade_id);
        $this -> assign('phone',$phone=='all'?'':$phone);
        $this -> assign('name',$name=='all'?'':$name);
        if(!empty($grade)&&!empty($user)){//查看下级代理
            $user_info = D('user')->get_son_agency($grade,$user);
        }else{//代理信息搜索查看
            $user_info = D('user')->get_agency_info($grade_id,$phone,$name);
        }
        $this->assign('user_info', $user_info[0]);
        $this->assign('show_page', $user_info[1]);
        $this->assign('grade', $user);
        $this -> display();
    }

    /**
     * 产品信息
     */
    public function product(){
        $this -> assign('title','产品信息');
        $this -> assign('route','品种管理 / 产品信息');
        $this -> assign('header_title','产品信息');
        $product = D('product')->get_product();
        $this -> assign('product',$product);
        $this -> display();

    }

    /**
     * 添加产品
     */
    public function add_save_product($product_id=0){
        $data = I('post.');
        if(empty($data)){
            if(empty($product_id)){
                $this -> assign('title','添加信息');
                $this -> assign('route','品种管理 / 添加产品');
                $this -> assign('header_title','添加产品');
            }else{
                $this -> assign('title','修改产品');
                $this -> assign('route','品种管理 / 修改产品');
                $this -> assign('header_title','修改产品');
                $product_info = M('product')->where('status=0 and id='.$product_id)->find();
                if(empty($product_info)){
                    $this->redirect('Admin/product');
                }
                $this -> assign('product',$product_info);
            }
            $this -> display();
        }else{
            $add_save_res = D('product')->add_save($data);
            $this->json_response($add_save_res);
        }
    }

    /**
     * 产品删除
     */
    public function del_product(){
        $obj_id = I('post.obj_id');
        $del_res = D('product')->del_product($obj_id);
        $this->json_response($del_res);
    }

    /**
     * 提成设置
     */
    public function push_info(){
        $data = I('post.');
        if(empty($data)){
            $grade_rank = I('get.grade_rank');
            $product_id = I('get.product_id');
            $this -> assign('title','提成设置');
            $this -> assign('route','系统管理 / 提成设置');
            $this -> assign('header_title','提成设置');
            $push_info = D('setting')->get_push_info($grade_rank,$product_id);
            $this->assign('push_info', $push_info[0]);
            $this->assign('show_page', $push_info[1]);
            $product = D('product')->get_product();
            $this -> assign('product',$product);

            $this -> assign('grade_rank',$grade_rank);
            $this -> assign('product_id',$product_id);
            $this -> display();
        }else{
            if($data['type']=='look'){
                $fin_res = M('setting')->where('id='.$data['set_id'])->find();
                $this->json_response(array('code' => 0,'msg' => '','data' => $fin_res));
            }elseif($data['type']=='del'){
                $del_res = M('setting')->where('id='.$data['set_id'])->delete();
                if(empty($del_res)){
                    $this->json_response(array('code' => 1,'msg' => '失败','data' => '删除失败,请重试！'));
                }else{
                    $this->json_response(array('code' => 0,'msg' => '成功','data' => '删除成功。'));
                }
            }elseif(!empty($data['set_id'])){
                $save_res = D('setting')->save_push($data,$data['set_id']);
                if(empty($save_res)){
                    $this->json_response(array('code' => 1,'msg' => '失败','data' => '修改失败,请重试！'));
                }else{
                    $this->json_response(array('code' => 0,'msg' => '成功','data' => '修改成功。'));
                }
            }elseif(empty($data['set_id'])){
                $add_res = D('setting')->add_push($data);
                if(empty($add_res)){
                    $this->json_response(array('code' => 1,'msg' => '失败','data' => '设置失败,请重试！'));
                }else{
                    $this->json_response(array('code' => 0,'msg' => '成功','data' => '设置成功。'));
                }
            }
        }
    }


    /**
     * 手续费设置
     */
    public function poundage(){
        $data=I("post.money",-1);
        if($data<0){
            $this -> assign('title','手续费设置');
            $this -> assign('route','系统管理 / 手续费设置');
            $this -> assign('header_title','手续费设置');
            $poundage = M('poundage')->find();
            $this -> assign('poundage',$poundage);
            $this -> display();
        }else{
            if(is_numeric($data)){
                $save_data['money'] = $data;
                $save_data['update_time'] = time();
                $save_res = M('poundage')->where('id=1')->save($save_data);
                if(empty($save_res)){
                    $this->json_response(array('code' => 1,'msg' => '失败','data' => '修改失败！'));
                }else{
                    $this->json_response(array('code' => 0,'msg' => '成功','data' => '修改成功。'));
                }
            }else{
                $this->json_response(array('code' => 1,'msg' => '提示','data' => '输入不合法！'));
            }
        }
    }

    /**
     * 数据管理
     * 清除某时间前的提成数据
     */
    public function data_manage(){
        $data=I("post.time",-1);
        if($data==-1){
            $this -> assign('title','数据管理');
            $this -> assign('route','系统管理 / 数据管理');
            $this -> assign('header_title','数据管理');
            $this -> display();
        }else{
            $rule = '/^(\d{1,4})-(\d{1,2})-(\d{1,2})$/';
            if(preg_match($rule,$data)){
                $time = strtotime($data);
                if(empty($time)){
                    $this->json_response(array('code' => 1,'msg' => '提示','data' => '系统错误！'));
                }else{
                    $del_res = M("commission")->where("create_time<".$time)->delete();
                    if(empty($del_res)){
                        $this->json_response(array('code' => 1,'msg' => '失败','data' => '数据清除失败！'));
                    }else{
                        $this->json_response(array('code' => 0,'msg' => '成功','data' => '数据已清除。'));
                    }
                }
            }else{
                $this->json_response(array('code' => 1,'msg' => '提示','data' => '参数不合法！'));
            }
        }
    }

    /**
     * 退款申请记录
     */
    public function drawings_apply(){
        $apply_info = D("refund")->get_drawings_apply();
        $this -> assign('title','退款申请');
        $this -> assign('route','退款管理 / 退款申请');
        $this -> assign('header_title','退款申请');
        $this -> assign('apply_info',$apply_info[0]);
        $this -> assign('show_page',$apply_info[1]);
        $this -> display();
    }

    /**
     * 申请处理
     */
    public function apply_dispose(){
        $data = I("post.");
        if($data['status']=='pass'){
            $res = D('refund')->pass_apply($data['id']);
            if(empty($res)){
                $this->json_response(array('code' => 1,'msg' => '失败','data' => '操作失败,请重试！'));
            }else{
                if($res===true){
                    $this->json_response(array('code' => 0,'msg' => '成功','data' => '已同意。'));
                }else{
                    $this->json_response(array('code' => 1,'msg' => '失败','data' => '提示：'.$res));
                }
            }
        }elseif($data['status']=='refuse'){
            $res = D('refund')->refuse_apply($data['id'],$data['remarks']);
            if(empty($res)){
                $this->json_response(array('code' => 1,'msg' => '失败','data' => '操作失败,请重试！'));
            }else{
                $this->json_response(array('code' => 0,'msg' => '成功','data' => '已拒绝。'));
            }
        }
    }

    /**
     * @param string $status 退款状态
     * @param string $phone 用户手机号
     * @param string $name 用户名
     * 退款记录
     */
    public function drawings_list($status='',$phone='',$name=''){
        $drawings_list = D("refund")->get_drawings_list($status,$phone,$name);
        $this -> assign('title','退款记录');
        $this -> assign('route','退款管理 / 退款记录');
        $this -> assign('header_title','退款记录');
        $this -> assign('drawings_list',$drawings_list[0]);
        $this -> assign('show_page',$drawings_list[1]);
        $this -> assign('where',$status);
        $this -> assign('phone',$phone);
        $this -> assign('name',$name);
        $this -> display();
    }

    /**
     * 手续费记录
     */
    public function poundage_list($phone='',$name=''){
        $poundage_list = D("refund")->get_poundage_list($phone,$name);
        $this -> assign('title','手续费记录');
        $this -> assign('route','手续费记录');
        $this -> assign('header_title','手续费记录');
        $this -> assign('poundage_list',$poundage_list[0]);
        $this -> assign('show_page',$poundage_list[1]);
        $this -> assign('poundage_sum',$poundage_list[2]);
        $this -> assign('phone',$phone);
        $this -> assign('name',$name);
        $this -> display();
    }


    /**
     * @param string $begin
     * @param string $end
     * @param string $phone
     * @param string $name
     * 交易记录
     */
    public function trading_record($begin='',$end='',$phone='',$name=''){
        if(!empty($begin)&&!empty($end)){
            $return_begin = date('m/d/Y',$begin);
            $return_end = date('m/d/Y',$end);
            $time = $return_begin." - ".$return_end;
            $end = strtotime("+1 day",$end);
        }
        $trade_info = D('trade')->get_trade_info($begin,$end,$phone,$name);
        $this -> assign('title','交易记录');
        $this -> assign('route','交易记录');
        $this -> assign('header_title','交易记录');
        $this -> assign('poundage_list',$trade_info[0]);
        $this -> assign('show_page',$trade_info[1]);
        $this -> assign('time',$time?$time:'');
        $this -> assign('phone',$phone);
        $this -> assign('name',$name);
        $product = D('product')->get_product();
        $this -> assign('product',$product);
        $this -> display();
    }

    /**
     * @param $user 用户
     * @param $product 产品
     * @param $number 交易手数
     * @param bool|false $status 添加方式【true：批量添加】
     * @return bool
     * 添加交易记录
     */
    public function add_trading_record($user,$product,$number,$status=false){
        $add_res = $trade_info = D('trade')->add_record($user,$product,$number);
        if($add_res===false){
            if($status){
                return false;
            }else {
                $this->json_response(array('code' => 2, 'msg' => '失败', 'data' => '添加失败，请重试！'));
            }
        }elseif($add_res===true){
            if($status){
                return true;
            }else{
                $this->json_response(array('code' => 0,'msg' => '成功','data' => '添加成功'));
            }
        }else{
            if($status){
                return false;
            }else {
                $this->json_response(array('code' => 1, 'msg' => '提示', 'data' => $add_res));
            }
        }
    }

    /**
     * 下载 excel导入模板
     */
    public function download_template(){
        $filename = '交易记录导入模板';
        $header_list = ['手机号','产品名称','交易手数'];
        To_Exel($filename,$header_list);
    }


    /**
     * 导入交易记录
     */
    public function import_trading_record(){
        $info = $this->upload();
        $file = './Uploads/'.$info['savepath'].$info['savename'];
        $sheetData = From_Excel($file);
        $highestRow = count($sheetData);          //取得总行数
        $num=0;     //成功条数
        $fail = array();//导入失败的数据
        for($row=2;$row<=$highestRow;$row++){                        //从第二行开始读取数据
            $phone = $sheetData[$row]['A'];
            $product = $sheetData[$row]['B'];
            $number = $sheetData[$row]['C'];
            $res = $this->add_trading_record($phone,$product,$number,true);
            if($res){
                $num++;
            }else{
                array_push($fail,array('phone'=>$phone,'product'=>$product,'num'=>$number));
            }
        }
        unlink($file);
        if(!empty($fail)){
            foreach ($fail as $k => $info) {
                $list[$k]["phone"] = $info['phone'];
                $list[$k]["product"] = $info['product'];
                $list[$k]["num"] = $info['num'];
            }

            foreach ($list as $field => $v) {
                if ($field == 'phone') {
                    $headArr[] = '手机号';
                }

                if ($field == 'product') {
                    $headArr[] = '产品名称';
                }

                if ($field == 'num') {
                    $headArr[] = '交易手数';
                }
            }
            $filename = '';
            To_Exel($filename, $headArr, $list,false);
        }
        $this->json_response(['code'=>'0','msg'=>'导入完成','data'=>$num.'条数据成功导入']);
    }

    /**
     * 获取今天的导入失败的交易数据
     */
    public function get_fail_file(){
        $dir="Uploads/download_xlsx/";
        $file=scandir($dir);
        $return_data = array();
        $today = date('Y/m/d');
        foreach($file as $key=>$val){
            if(is_file($dir.$val)){
                $atime = fileatime($dir.$val);
                if($today == date("Y/m/d", $atime)){
                    array_push($return_data,array('file'=>$val,'create_time'=>date("Y/m/d H:i:s", $atime)));
                }
            }
        }
        $this->json_response(['code'=>'0','msg'=>'','data'=>$return_data]);
    }

    /**
     * 导入时 上传 Excel 文件
     * @return array|void  文件信息
     */
    public function upload(){
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('xlsx','xls');// 设置附件上传类型
        $upload->rootPath  =      './Uploads/'; // 设置附件上传根目录
        $upload->savePath  =      'import_lsx/'; // 设置附件上传（子）目录
        $upload->autoSub   =    false;
        // 上传文件
        $info   =   $upload->uploadOne($_FILES['import_file']);
        if(!$info) {// 上传错误提示错误信息
            return $this->json_response(array('code' => 1, 'msg' =>'提示','data'=>'导入失败！'));
        }

        return $info;
    }


    /**
     * @param string $begin
     * @param string $end
     * @param string $phone
     * @param string $name
     * 用户充值记录
     */
    public function recharge($begin='',$end='',$phone='',$name=''){
        if(!empty($begin)&&!empty($end)){
            $return_begin = date('m/d/Y',$begin);
            $return_end = date('m/d/Y',$end);
            $time = $return_begin." - ".$return_end;
            $end = strtotime("+1 day",$end);
        }
        $recharge_list = D('prepaid')->get_recharge_list($begin,$end,$phone,$name);
        $this -> assign('title','充值记录');
        $this -> assign('route','充值记录');
        $this -> assign('header_title','充值记录');
        $this -> assign('recharge_list',$recharge_list[0]);
        $this -> assign('show_page',$recharge_list[1]);
        $this -> assign('time',$time?$time:'');
        $this -> assign('phone',$phone);
        $this -> assign('name',$name);
        $this -> display();
    }


    /**
     * @param string $begin
     * @param string $end
     * @param string $grade 代理等级
     * @param string $phone 代理电话
     * @param string $name 代理名
     * @param string $grade_id 某代理下的直接代理【为空这代表全部】
     * 获取提成信息
     */
    public function push_list($begin='',$end='',$grade='',$phone='',$name='',$grade_id=''){
        if(!empty($begin)&&!empty($end)){
            $return_begin = date('m/d/Y',$begin);
            $return_end = date('m/d/Y',$end);
            $time = $return_begin." - ".$return_end;
            $end = strtotime("+1 day",$end);
        }
        $push_list = D('commission')->get_grade_push_list($begin,$end,$grade,$phone,$name,$grade_id);
        $this -> assign('title','提成记录');
        $this -> assign('route','提成记录');
        $this -> assign('header_title','提成记录');
        $this -> assign('push_list',$push_list[0]);
        $this -> assign('show_page',$push_list[1]);
        $this -> assign('push_sum',$push_list[2]);
        $this -> assign('time',$time?$time:'');
        $this -> assign('grade',$grade);
        $this -> assign('phone',$phone);
        $this -> assign('name',$name);
        $this -> assign('user_grade_id',$grade_id);
        $this -> display();
    }


    /**
     * @param $commission 某次提成id
     * @param $product
     * @param $phone
     * @param $name
     * 提成详情
     */

    public function push_details($commission,$product='',$phone='',$name=''){
        $push_details = D('commission')->get_push_details($commission,$product,$phone,$name);
        $this -> assign('title','提成详情');
        $this -> assign('route','提成详情');
        $this -> assign('header_title','提成详情');
        $this -> assign('push_details',$push_details[0]);
        $this -> assign('show_page',$push_details[1]);
        $this -> assign('product_list',$push_details[2]);
        $this -> assign('product',$product);
        $this -> assign('phone',$phone);
        $this -> assign('name',$name);
        $this -> display();
    }

    /**
     * @param string $phone 用户手机号
     * @param string $name 用户名
     * 资产管理
     */
    public function assets_manage($phone='',$name=''){
        $user_assets = D("asset")->get_assets($phone,$name);
        $this -> assign('title','资产管理');
        $this -> assign('route','用户管理 / 资产管理');
        $this -> assign('header_title','资产管理');
        $this -> assign('user_assets',$user_assets[0]);
        $this -> assign('show_page',$user_assets[1]);
        $this -> assign('phone',$phone);
        $this -> assign('name',$name);
        $this -> display();
    }

    /**
     * 修改用户资金信息
     */
    public function assets_save(){
        $id = I("post.id");
        $money = I("post.money");
        $asset_table = M('asset');
        $asset_old = $asset_table->where('id='.$id)->find();
        $poor = $asset_old['money']-$money;
        $data['money'] = $money;
        $data['usable'] = $asset_old['usable']-$poor;
        $asset_table->startTrans();
        $asset_save = $asset_table->where('id='.$id)->save($data);
        $save_user = M('user')->where('id='.$asset_old['user_id'])->setDec('current',$poor);
        if(empty($asset_save)||empty($save_user)){
            $asset_table->rollback();
            $this->json_response(array('code' => 1,'msg' => '失败','data' => '操作失败,请刷新重试！'));
        }else{
            $asset_table->commit();
            $this->json_response(array('code' => 0,'msg' => '成功','data' => '已成功修改。'));
        }
    }

    /**
     * 按id查询资金信息
     */
    public function get_asset_info(){
        $asset = I("post.id");
        $asset = M('asset')->where('id='.$asset)->find();
        if(empty($asset)){
            $this->json_response(array('code' => 1,'msg' => '失败','data' => '操作失败,请刷新重试！'));
        }else{
            $this->json_response(array('code' => 0,'msg' => '','data' => $asset));
        }
    }

    /**
     * 管理员列表
     */
    public function admin_list(){
        $this -> assign('title','管理员列表');
        $this -> assign('route','系统管理 / 管理员列表');
        $this -> assign('header_title','管理员列表');
        $admin_info = D('user')->get_admin();
        $this->assign('admin_info', $admin_info[0]);
        $this->assign('show_page', $admin_info[1]);
        $this -> display();
    }

    /**
     * 添加管理员
     */
    public function add_admin(){
        $data = I('post.');
        if(empty($data)){
            $this -> assign('title','添加管理员');
            $this -> assign('route','系统管理 / 添加管理员');
            $this -> assign('header_title','添加管理员');
            $this -> display();
        }else{
            $user_model = D('user');
            if(!$user_model->create($data)){
                $this->json_response(array('code' => 2,'msg' => '提示','data' => $user_model->getError()));
            }else{
                $find = M('user')->where('phone='.$data['phone'])->find();
                if(!empty($find)){
                    $this->json_response(array('code' => 1,'msg' => '失败','data' => '账号已被占用！'));
                }
//                $data['password'] = md5(substr($data['identity_card'],12));
                $data['password'] = md5($data['set_pwd']);
                $data['type'] = 2;
                $res = $user_model->add_user($data);
                if($res == false){
                    $this->json_response(array('code' => 1,'msg' => '失败','data' => '添加失败,请重试！'));
                }else{
                    $this->json_response(array('code' => 0,'msg' => '成功','data' => '添加成功！'));
                }
            }
        }
    }

}