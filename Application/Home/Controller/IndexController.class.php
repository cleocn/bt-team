<?php
namespace Home\Controller;
use \Common\Controller;

class IndexController extends Controller\_Controller {
	function __construct(){
        parent::__construct();
        layout(true);
        $this->data['is_login'] = session('name');
        //var_dump($this->data['is_login']);
    }
    public function index($id = null){
        $this->assign('data',$this->data);
        $this->display();
    }
    // 初始用户登录
    public function save(){
        $data = I('post.');
        $userModel = M('user');
        $info = $userModel->where(array('nickname' => $data['nickname']))->find();
        if( $info ){
            $data['userid'] = $info['userid'];
            $data['color'] = $info['color'];
        }else{
            $data['userinfo'] = json_encode($data);
            $data['userid'] = get_rand();
            $data['nickname'] = $data['nickname'];
            $data['createtime'] = get_now();
            $data['color'] = random_color()[array_rand(random_color(),1)];
            $userModel->add($data);
        }
        session('name' , $data['nickname']);
        $this->ajaxReturn(json_encode($data));
        //echo json_encode($data);
    }
    // 退出登陆
    public function logout(){
        session(null);
        $this->redirect("/");
    }
}
