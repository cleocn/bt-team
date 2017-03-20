<?php
namespace Home\Controller;
use \Common\Controller;

class IndexController extends Controller\_Controller {
	function __construct(){
        parent::__construct();
        layout(true);
    }
    public function index($id){
    	$this->data['id'] = $id;
        $this->assign('data',$this->data);
        $this->display();
    }
}
