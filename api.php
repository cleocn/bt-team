<?php
  $res = $_POST['aoData'];

  $sEcho = 0; // 当页页大小
  $iDisplayStart = 0; // 起始索引
  $iDisplayLength = 0;//分页长度
  $jsonarray= json_decode($res) ;
  $sSearch;

   foreach($jsonarray as $value){ 
	   if($value->name=="sEcho"){
	       $sEcho=$value->value;
	   }
	   if($value->name=="iDisplayStart"){
	       $iDisplayStart=$value->value;
	   }
	   if($value->name=="iDisplayLength"){
	       $iDisplayLength=$value->value;
	   }
	   if($value->name == 'sSearch')
	   		$sSearch = $value->value;
   } 

   // echo $sSearch;
   // exit;
    $Array = Array(); 
     //此处生成50条数据，模仿数据库数据
    for ($i = 1; $i< 51; $i++) {
        $d = array($i,'张' . $i);
        Array_push($Array, $d);
    }

    $json_data = array ('sEcho'=>
	$sEcho,'iTotalRecords'=>50,'iTotalDisplayRecords'=>50,'aaData'=>array_slice($Array,$iDisplayStart,$iDisplayLength));  //按照datatable的当前页和每页长度返回json数据
	echo json_encode($json_data);