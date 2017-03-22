<?php
namespace Home\Controller;
use \Common\Controller;

class IndexController extends Controller\_Controller {
	function __construct(){
        parent::__construct();
        layout(true);
    }
    public function index($id = null){
    	$array = array(1=>'张三',2=>'李四');
    	$this->data['id'] = $id;
    	$this->data['name'] = $array[$id];
        $this->assign('data',$this->data);
        $this->display();
    }
    public function save(){
        // $data = I('post.');
        // print_r($data);
        echo json_encode(array('ddd'));
    }
}
