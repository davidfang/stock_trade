<?php

namespace Home\Controller;
use Think\Controller;

class LoginController extends Controller
{

    /**
     * json的统一返回形式
     * @param $data   code 错误码   msg 信息  data 数据
     */
    private function json_response($data){
        $this->ajaxReturn(array(
            'code' => empty($data['code']) ? 0 : $data['code'],
            'msg' => empty($data['msg']) ? "" : $data['msg'],
            'data' => empty($data['data']) ? "" : $data['data'],
        ));
    }

    /**
     * 登陆
     */
    public function login(){
        $this->display();
    }

    /**
     * 忘记密码
     */
    public function forget_pwd(){
        $this->display();
    }

    /**
     * 验证用户，并发送验证码
     */
    public function verify_forget_pwd(){
        $verify = new \Think\Verify();
        if(!$verify->check(trim($_POST["verify"]))){
            $this->json_response(array('code' => 2,'msg' => '提示','data' => '验证码有误！'));
        }else{
            $phone = I('post.phone');
            $find_res = M('user')->where('status=0 and phone='.$phone)->find();
            if(empty($find_res)){
                $this->json_response(array('code' => 2,'msg' => '提示','data' => '用户不存在！'));
            }else{
                $this->get_verify($phone,'find_pwd',$phone);
            }
        }
    }

    /**
     * 忘记密码时验证验证码
     */
    public function verify_phone(){
        $data = I("post.");
        $check_res = D('checking')->checking_check($data['phone'],$data['verify_text'],'find_pwd');
        if($check_res!==true){
            $this->json_response(array('code' => 1,'msg' => '提示','data' => $check_res));
        }else{
            $this->json_response(array('code' => 0,'msg' => '','data' => $data['phone']));
        }
    }

    /**
     * 重置用户密码
     */
    public function save_pwd(){
        $data = I("post.");
        $save_data['password'] = md5($data['password']);
        $save_res = M('user')->where('phone='.$data['phone'])->save($save_data);
        if(empty($save_res)){
            $this->json_response(array('code' => 1,'msg' => '提示','data' => '修改失败，请重试！'));
        }else{
            $this->json_response(array('code' => 0,'msg' => '密码已重置','data' => '即将返回登录。'));
        }
    }

    /**
     * 登录验证
     */
    public function login_verify(){
        $account  = trim(I('account'));
        $password = trim(I('password'));
        $verify = new \Think\Verify();
        if(!$verify->check(trim($_POST["verify"]))){
            $this->json_response(array('code' => 2,'msg' => '提示','data' => '验证码有误！'));
        } else {
            if(empty($account) || empty($password)){
                $this->json_response(array('code' => 2,'msg' => '提示','data' => '无效数据！'));
            }
            $where['phone'] = $account;
            $login_res = M('user')->where($where)->find();
            if(empty($login_res)||$login_res['password']!=md5($password)){
                $this->json_response(array('code' => 2,'msg' => '提示','data' => '账号或密码有误！'));
            }else{
                session('user',$login_res);
                $this->json_response(array('code' => 0,'msg' => '成功','data' => '登陆成功'));
            }
        }
    }

    /**
     * 登陆后跳转页面
     */
    public function select_url(){
        if(session('user')['type']==0){
            $this->redirect('User/index');
        }elseif(session('user')['type']==1){
            $this->redirect('Agency/client');
        }elseif(session('user')['type']==2){
            $this->redirect('Admin/index');
        }else{
            $this->redirect('Index/index');
        }
    }

    /**
     * 登出并清空session
     */
    public function login_out(){
        session('user',null);
        $this->redirect("Login/login");
    }

    /**
     * 注册界面
     */
    public function register(){
        $this->display();
    }

    /**
     * 修改密码再次获取手机验证
     */
    public function again_get_verify(){
        $phone = I('post.phone');
        $this->get_verify($phone,'find_pwd',$phone);
    }

    /**
     * 注册时获取手机验证
     */
    public function get_phone_verify(){
        $phone = I('post.phone');
        $find_user = M('user')->where('phone='.$phone)->find();
        if(!empty($find_user)){
            $this->json_response(array('code' => 1,'msg' => '提示','data' => '账号已存在！'));
        }
        $this->get_verify($phone,'verify',$phone);
    }

    /**
     * @param $phone 发送手机号
     * @param $session_name 存储session名
     * @param string $return_data 发送成功返回消息
     * 获取验证码
     */
    public function get_verify($phone,$session_name,$return_data=''){
        $code = GetRandStr(4);
        $res = send_sms_code($phone,$code);
        if(empty($res)){
            $this->json_response(array('code' => 1,'msg' => '提示','data' => '获取失败，请刷新重试！'));
        }else{
            session($session_name,array($phone,$code,strtotime('+'.C('PAST_DUE_TIME').' minute',time())));
            $this->json_response(array('code' => 0,'msg' => '','data' => $return_data));
        }
    }

    /**
     * 注册验证
     */
    public function register_verify(){
        $data = I("post.");
        $check_res = D('checking')->checking_check($data['phone'],$data['verify_text'],'verify');
        if($check_res!==true){
            $this->json_response(array('code' => 2,'msg' => '提示','data' => $check_res));
        }
        $user_model = D('user');
        if(!$user_model->create($data)){
            $this->json_response(array('code' => 2,'msg' => '提示','data' => $user_model->getError()));
        }else{
            $find_phone = M('user')->where('status=0 and phone=' . $data['phone'])->find();
            if (!empty($find_phone)) {
                $this->json_response(array('code' => 1, 'msg' => '失败', 'data' => '账号已被占用！'));
            } else {
                $res = $user_model->add_user($data);
                if ($res == false) {
                    $this->json_response(array('code' => 1, 'msg' => '失败', 'data' => '注册失败！'));
                } else {
                    $this->json_response(array('code' => 0, 'msg' => '成功', 'data' => '注册成功！'));
                }
            }
        }
    }

    /**
     * 注册成功后引导页
     */
    public function lead(){
        $this->display();
    }

    /**
     * 验证码设置
     */
    function verify(){
        $config = array(
            'useImgBg' => false,    // 使用背景图片
            'fontSize' => 15,       // 验证码字体大小(px)
            'useCurve' => false,    // 是否画混淆曲线
            'useNoise' => false,    // 是否添加杂点
            'imageH'   => 30,       // 验证码图片高度
            'imageW'   => 130,      // 验证码图片宽度
            'length'   => C('VERIFY_NUM'), // 验证码位数
            //字体样式有1.ttf   2.ttf   3.ttf   4.ttf   5.ttf   6.ttf  共六种
            'fontttf'  => '',       // 验证码字体，不设置随机获取
            'bg'       => array(243, 251, 254), // 背景颜色
            'reset'    => true,     // 验证成功后是否重置
        );
        $Verify = new \Think\Verify($config);
        $Verify->entry();
    }

    /**
     * 空方法处理
     */
    function _empty(){
        $this->display("Public/404");
    }

}