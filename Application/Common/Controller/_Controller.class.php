<?php
/*
	自定义父类，用于基础数据的校验和用户数据的便利提取	
*/

namespace Common\Controller;
use Think\Controller;

class _Controller extends Controller {
	var $data = array();
	function __construct(){
		parent::__construct();
	}

	// 基础日志方法
	public static function log($txt){
        if(is_object($txt) || is_array($txt)){
            $txt = print_r($txt,1);
        }
        \Think\Log::record($txt);
    }

    public function _error($data){
    	$this->assign('data',$this->data);
    	$this->display('Public/_result');
    }

    public function _success($data){
    	$this->assign('data',$this->data);
    	$this->display('Public/_result');
    }    
}