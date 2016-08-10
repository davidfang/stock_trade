<?php

namespace Home\Model;
use Think\Model;

class UserModel extends Model
{
    /**
     * @var array
     * 注册验证
     */
    protected $_validate = array(
        array('name','require','姓名为必填项！'),
        array('phone','','帐号已经存在！',0,'unique',1), // 在新增的时候验证name字段是否唯一
        array('phone','require','手机号为必填项！'),
        array('phone','/^1[3|4|5|7|8]\d{9}$/','电话未填写或填写有误！'),
//        array('email','/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/','邮箱填写有误！'),
        array('identity_card','/^\d{17}([0-9]|X|x)$/','身份证号填写有误！'),
        array('address','require','地址为必填项！'),
        array('password','require','密码不能为空！'),
        array('verify_password','require','确认密码不能为空！'),
        array('verify_password','password','确认密码不正确',0,'confirm'), // 验证确认密码是否和密码一致
    );

    /**
     * @param $data
     * @return bool
     * 添加用户
     */
    public function add_user($data){
        $data['create_time'] = $data['update_time'] = time();
        $data['password'] = md5($data['password']);
        $table = M('user');
        $res = $table -> add($data);
        if(empty($res)){
            return false;
        }else{
            return true;
        }
    }

    /**
     * @param $user_id 用户id
     * @return mixed
     * 个人信息(代理 or 用户)
     */
    public function get_Personal_info($user_id){
        $table = M('user as u');
        $where['u.id']=$user_id;
        $where['u.status']=0;
        $info = $table
            ->field('u.name,u.phone,u.email,u.address,u.identity_card,g.name as grade_name,u.stock,u.stock_psd')
            ->join('left join grade as g on g.id=u.grade_id')
            ->where($where)
            ->find();
        return $info;
    }

    /**
     * 获得全部用户
     */
    public function get_all_user($phone,$name,$other){
        if($phone!='all'){
            $where['u.phone'] = $phone;
        }
        if($name!='all'){
            $where['u.name'] = array('like',"%".$name."%");
        }
        if($other=='undistributed'){
            $where['u.superior'] = 0;
        }
        $where['u.type'] = 0;
        $where['u.status'] = 0;
        $user_table = M('user as u');
        $total = $user_table->where($where)->count();
        $per = C('PAGE_NUM');
        $Page = new  \Think\Page($total, $per);
        $Page->setConfig('last','尾页');//最后一页显示"尾页"
        $show = $Page->show();
        $info = $user_table
            -> field('u.id,u.name,u.phone,u.email,u.address,u.identity_card,u1.name as there,u2.name as two,u3.name as one')
            -> where($where)
            -> join('left join user as u1 on u.superior=u1.id')
            -> join('left join user as u2 on u1.superior=u2.id')
            -> join('left join user as u3 on u2.superior=u3.id')
            -> limit($Page->firstRow.','.$Page->listRows)
            -> order('u.create_time desc')
            -> select();
        return array($info, $show);
    }


    /**
     * @return array
     * 获取代理信息
     */
    public function get_agency_info($grade,$phone,$name){
        if(!empty($grade)){
            $where['u.grade_id'] = $grade;
        }
        if(!empty($phone)&&$phone!='all'){
            $where['u.phone'] = $phone;
        }
        if(!empty($name)&&$name!='all'){
            $where['u.name'] = array("like","%".$name."%");
        }
        $where['u.type'] = 1;
        $where['u.status'] = 0;
        $user_table = M('user as u');
        $total = $user_table->where($where)->count();
        $per = C('PAGE_NUM');
        $Page = new  \Think\Page($total, $per);
        $Page->setConfig('last','尾页');//最后一页显示"尾页"
        $show = $Page->show();
        $info = $user_table
            -> field('u.id,u.name,u.phone,u.email,u.address,u.identity_card,g.name as grade,u.grade_id')
            -> join('grade as g on u.grade_id=g.id')
            -> where($where)
            -> limit($Page->firstRow.','.$Page->listRows)
            -> order('u.create_time desc')
            -> select();
        return array($info, $show);
    }

    /**
     * @param $grade
     * @param $user
     * @return array
     * 获得子代理
     */
    public function get_son_agency($grade,$user){
        $where['u.type'] = 1;
        $where['u.status'] = 0;
        $where['u.superior'] = $user;
        $user_table = M('user as u');
        $total = $user_table->where($where)->count();
        $per = C('PAGE_NUM');
        $Page = new  \Think\Page($total, $per);
        $Page->setConfig('last','尾页');//最后一页显示"尾页"
        $show = $Page->show();
        $info = $user_table
            -> field('u.id,u.name,u.phone,u.email,u.address,u.identity_card,g.name as grade,u.grade_id')
            -> join('grade as g on u.grade_id=g.id')
            -> where($where)
            -> limit($Page->firstRow.','.$Page->listRows)
            -> order('u.create_time desc')
            -> select();
        return array($info, $show);
    }

    /**
     * 删除代理并将其下的用户归系统
     */
    public function del_agency($user){
        $where['status'] = 0;
        $where['type'] = 1;
        $where['superior'] = $user;
        $find_res = M('user')->where($where)->select();
        if(!empty($find_res)){
            return '有下级子代理！';
        }else{
            $grade_rank = M('user')->where('status=0 and type=1 and id='.$user)->find();
            if($grade_rank['grade_id']==3){
                $now=time();
                $user_table = M('user');
                $user_table->startTrans();
                $save_res = $user_table->where('type=0 and superior='.$user)->save(array('superior'=>0,'update_time'=>$now));
                if(!empty($save_res)){
                    $del_res = M('user')->where('id='.$user)->save(array('status'=>1,'update_time'=>$now));
                    if(!empty($del_res)){
                        $user_table->commit();
                        return true;
                    }
                }
                $user_table->rollback();
                return false;
            }
            return '代理不存在！';
        }
    }

    /**
     * @param $grade 代理id
     * @return mixed 用户id数组
     * 获取某代理下的所有用户
     */
    public function get_grade_user($grade){
        $sql = 'select
        case u1.grade_id
        when 1 then u4.id
        when 2 then u3.id
        when 3 then u2.id
        end as u_id
        from
        user as u1
        LEFT JOIN user as u2 on u2.superior=u1.id
        LEFT JOIN user as u3 on u3.superior=u2.id
        LEFT JOIN user as u4 on u4.superior=u3.id
        where u1.id='.$grade;
        $user_id = M()->query($sql);
        $user = array();
        foreach($user_id as $val){
            array_push($user,$val['u_id']);
        }
        return $user;
    }


    /**
     * @return mixed
     * 获取用户或代理的百分比数据
     */
    public function get_user_distribute(){
        $sql='SELECT
            grade_id,count(id) as user_num,ROUND(ROUND(count(id)/(select count(id) from user where status=0 and type!=2),4)*100,2) AS num_rate
            FROM user
            where status=0 and type!=2
            group by grade_id;';
        $distribute_info = M()->query($sql);
        return $distribute_info;
    }


    /**
     * @param $grade 用户[为空代表当前用户]
     * @param $type 类型['':全部,0:普通用户，1:一级代理，2：二级代理，3:三级代理]
     * @param $phone 代理或用户手机号
     * @param $name 代理或用户名字
     * @return mixed
     * 获取某代理下的所有代理及用户信息
     */
    public function get_user_all($grade,$type,$phone,$name){
        $sql = 'select * from (select * from user where superior='.$grade;
        if(session('user')['grade_id']==1){
            $sql .= ' union all
                select * from user where superior in(select id from user where superior='.$grade.')
                union all
                select * from user where superior in(select id from user where superior in(select id from user where superior='.$grade.'))';
        }elseif(session('user')['grade_id']==2){
            $sql .= ' union all
                select * from user where superior in(select id from user where superior='.$grade.')';
        }elseif(session('user')['grade_id']==3){
            $sql.=' ';
        }
        $sql .= ' ) as u where type!=2';
        if($type!=''){
            $sql .= ' and u.grade_id='.$type;
        }
        if(!empty($phone)){
            $sql.=' and phone='.$phone;
        }
        if(!empty($name)){
            $sql.=' and name like "%'.$name.'%"';
        }
        $total = count(M()->query($sql));
        $per = C('PAGE_NUM');
        $Page = new  \Think\Page($total, $per);
        $Page->setConfig('last','尾页');//最后一页显示"尾页"
        $show = $Page->show();
        $sql.=' limit '.$Page->firstRow.','.$Page->listRows;
        $res = M()->query($sql);
        return array($res,$show);
    }


    /**
     * @param $grade
     * @param string $grade_rank 代理等级
     * @param $begin
     * @param $end
     * @param $phone
     * @param $name
     * @return array
     */
    public function get_grade($grade,$grade_rank,$begin,$end,$phone,$name){
        $sql = 'select
                u.id as uid,c.id as commission_id,u.name,u.grade_id,c.create_time,c.money,u.phone
                from (select * from user where superior='.$grade;
        if(session('user')['grade_id']==1){
            $sql .= ' union all
                select * from user where superior in(select id from user where superior='.$grade.')';
        }elseif(session('user')['grade_id']==2){
            $sql .= ' ';
        }elseif(session('user')['grade_id']==3){
            $sql.=' ';
        }
        $sql .= ' ) as u,commission as c where u.id=c.agency_id and u.type=1';
        if(!empty($begin)&&!empty($end)){
            $sql.=' and c.create_time BETWEEN '.$begin.' and '.$end;
        }

        if(!empty($phone)){
            $sql.=' and u.phone='.$phone;
        }
        if(!empty($name)){
            $sql.=' and u.name like "%'.$name.'%"';
        }
        if(!empty($grade_rank)){
            $sql.=' and u.grade_id='.$grade_rank;
        }
        $total = count(M()->query($sql));
        $per = C('PAGE_NUM');
        $Page = new  \Think\Page($total, $per);
        $Page->setConfig('last','尾页');//最后一页显示"尾页"
        $show = $Page->show();
        $sql.=' limit '.$Page->firstRow.','.$Page->listRows;
        $res = M()->query($sql);
        return array($res,$show);
    }

    /**
     * @return array
     * 获取所有有效管理员
     */
    public function get_admin(){
        $where['type'] = 2;
        $where['status'] = 0;
        $user_table = M('user');
        $total = $user_table->where($where)->count();
        $per = C('PAGE_NUM');
        $Page = new  \Think\Page($total, $per);
        $Page->setConfig('last','尾页');//最后一页显示"尾页"
        $show = $Page->show();
        $info = $user_table
            -> where($where)
            -> limit($Page->firstRow.','.$Page->listRows)
            -> order('create_time desc')
            -> select();
        return array($info, $show);
    }

}