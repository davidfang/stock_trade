<?php
namespace Home\Controller;

class IndexController extends BaseController {
    public function index(){
        if(session('user')['type']==0){
            $this->redirect('User/index');
        }elseif(session('user')['type']==1){
            $this->redirect('Agency/client');
        }elseif(session('user')['type']==2){
            $this->redirect('Admin/index');
        }
    }

}