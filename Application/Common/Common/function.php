<?php

// 读取本地资源文件 通常用于静态文本
function LC($name){
    $resource = parse_ini_file(APP_PATH .'Common/Conf/resource.ini');
    return $resource[$name];
}

function random_color(){
    $color = array('#DC143C','#DB7093','#C71585','#8B008B','#9400D3','#4B0082','#483D8B','#191970','#1E90FF','#5F9EA0','#2F4F4F','#00FF7F','#32CD32','#008000','#ADFF2F','#6B8E23','#808000','#FFD700','#FFA500','#D2691E','#FF4500','#FF6347','#FF0000','#8B0000','#696969','#000000','#FA8072','#9932CC');
    return $color;
}

function objectToArray($obj){
    $arr = is_object($obj) ? get_object_vars($obj) : $obj;
    if(is_array($arr)){
        return array_map(__FUNCTION__, $arr);
    }else{
        return $arr;
    }
}

// 下载文件
function downfile($fileurl)
{
    // echo $fileurl;
    // exit;
    ob_start(); 
    $filename=$fileurl;
    $date=date("Ymd-H:i:m");
    header( "Content-type:  application/octet-stream "); 
    header( "Accept-Ranges:  bytes "); 
    header( "Content-Disposition:  attachment;  filename= $fileurl"); 
    $size=readfile($filename); 
    header( "Accept-Length: " .$size);
}

// 分页组件
function get_page_pagination($count,$pagesize){
    $page = new \Think\Page($count, $pagesize);
    $page->setConfig('prev', '上一页');
    $page->setConfig('next', '下一页');
    $page->setConfig('last', '末页');
    $page->setConfig('first', '首页');
    $page->setConfig('theme','%LINK_PAGE% %END%');
    return $page->show();
}

// 获取缩略图
function get_thumbnail($url){
    return $url;
    $file = pathinfo($url);
    return $file['dirname'] . '/' .$file['filename'] . '_thumbnail.' . $file['extension'];
}

function get_filename($url){
    $file = pathinfo($url);
    return $file['filename'] . '.' . $file['extension'];
}

// 取当前登陆信息
function get_manage_user_info(){
    $info = session("__MEMBER_ID__");
    return $info;
}

// 返回一个随机数
function get_rand(){
    return date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 15);
}

function get_no_data_html(){
    $str .= '<div class="no-data">';
    $str .= '<div class="nodata-ico"></div>';
    $str .= '<span>很抱歉，当前分类没有可操作的数据。<br />我们会尽快丰富资源库哦！</span>';
    $str .= '<a href="javascript:history.back();">返回</a>';
    $str .= '</div>';
    


    // $str .= '<div class="alert alert-warning" style="background-color: #eeeeee;color:#999;border-color:#eee">';
    // $str .= '<strong >提示！</strong>当前没有可以操作的数据。';
    // $str .= '</div>';
    return $str;
}
// 判断当前页面操作状态
function get_head_status_title($ID){
    if(!$ID){
        return '新增';
    }
    return "修改";
}

// 返回订单号
function build_order_no(){
        return date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
}

// 生成JS
function build_js_open($url){
    echo '<script>';
    echo 'window.open("'. $url .'");';
    echo '</script>';
}

// 发送短信内容
function send_sms($mobile,$text){
    $wcfURL = C('SMS_URL');
    $wcfClient = new \SoapClient ( $wcfURL );
    $args = array (
        'phoneNumber' => $mobile,
        'smsContent' => $text,
        'signature' => '【远播国际教育】',
        'username' =>'yuanbo',
        'password' => '123'
    );
    $rtnSoap = $wcfClient->SendMessage( $args );
    return $rtnSoap->SendMessageResult;
}

// 返回某个用户单个活动记录的当前状态
function get_activity_status($type){
    $array = array("4"=>"未支付","5"=>"支付完成","6"=>"完成报名","-1"=>"支付失败","-2"=>"报名已经取消","-3"=>"发起支付取消","-4"=>"支付取消审核通过","-5"=>"支付取消未通过","-6"=>"支付取消完成");
    return $array[$type];
}
// 返回时光轴类别
function get_media_type($type){
    $array = array(1 => '学生笔记',2 => '翼云测评',3 => '考试成绩',4 => '参与活动');
    return $array[$type];
}
// 返回时光轴图片
function get_media_type_image($type,$image){
    if($type == 2)
        return "data:" . $image;
    return C("ONLINE_URL") . $image;
}
// 返回用户头像
function get_user_photo($photo){
    if($photo){
        return C("ONLINE_URL") . $photo;
    }
    return '/Public/img/toux-d.png';
}
// 判断某个时间是否在一个时间段内
function is_time_section($start,$end,$current_time = null){
    $start = strtotime($start);
    $end = strtotime($end);
    if($current_time == null){
        $current_time = get_now();
    }
    $current_time = strtotime($current_time);
    return $current_time >= $start && $current_time <= $end;
}
// 将内容图片处理，加上完整的对外URL
function get_request_image_url($str){
    $pattern="/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg]))[\'|\"].*?[\/]?>/";
    return preg_replace($pattern,"<img src='".C('ONLINE_URL')."\${1}'/>",$str);
}
// 返回当前日期
function get_now(){
    return date('Y-m-d H:i:s',time());
}
/**
 * 根据配置类型解析配置
 * @param  string $type  配置类型
 * @param  string  $value 配置值
 */
function parse_attr($value, $type){
    switch ($type) {
        default: //解析"1:1\r\n2:3"格式字符串为数组
            $array = preg_split('/[,;\r\n]+/', trim($value, ",;\r\n"));
            if(strpos($value,':')){
                $value  = array();
                foreach ($array as $val) {
                    list($k, $v) = explode(':', $val);
                    $value[$k]   = $v;
                }
            }else{
                $value = $array;
            }
            break;
    }
    return $value;
}

/**
 * 字符串截取(中文按2个字符数计算)，支持中文和其他编码
 * @static
 * @access public
 * @param str $str 需要转换的字符串
 * @param str $start 开始位置
 * @param str $length 截取长度
 * @param str $charset 编码格式
 * @param str $suffix 截断显示字符
 * @return str
 */
function get_str($str, $start, $length, $charset='utf-8', $suffix=true) {
    $str = trim($str);
    $length = $length * 2;
    if($length){
        //截断字符
        $wordscut = '';
        if(strtolower($charset) == 'utf-8'){
            //utf8编码
            $n = 0;
            $tn = 0;
            $noc = 0;
            while($n < strlen($str)){
                $t = ord($str[$n]);
                if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)){
                    $tn = 1;
                    $n++;
                    $noc++;
                }elseif(194 <= $t && $t <= 223){
                    $tn = 2;
                    $n += 2;
                    $noc += 2;
                }elseif(224 <= $t && $t < 239){
                    $tn = 3;
                    $n += 3;
                    $noc += 2;
                }elseif(240 <= $t && $t <= 247){
                    $tn = 4;
                    $n += 4;
                    $noc += 2;
                }elseif(248 <= $t && $t <= 251){
                    $tn = 5;
                    $n += 5;
                    $noc += 2;
                }elseif($t == 252 || $t == 253){
                    $tn = 6;
                    $n += 6;
                    $noc += 2;
                }else{
                    $n++;
                }
                if ($noc >= $length){
                    break;
                }
            }
            if($noc > $length){
                $n -= $tn;
            }
            $wordscut = substr($str, 0, $n);
        }else{
            for($i = 0; $i < $length - 1; $i++){
                if(ord($str[$i]) > 127) {
                    $wordscut .= $str[$i].$str[$i + 1];
                    $i++;
                } else {
                    $wordscut .= $str[$i];
                }
            }
        }
        if($wordscut == $str){
            return $str;
        }
        return $suffix ? trim($wordscut).'...' : trim($wordscut);
    }else{
        return $str;
    }
}

/**
 * 过滤标签，输出纯文本
 * @param string $str 文本内容
 * @return string 处理后内容
 * @author jry <598821125@qq.com>
 */
function html2text($str){
    $str = preg_replace("/<sty(.*)\\/style>|<scr(.*)\\/script>|<!--(.*)-->/isU","",$str);
    $alltext = "";
    $start = 1;
    for($i=0;$i<strlen($str);$i++){
        if($start==0 && $str[$i]==">"){
            $start = 1;
        }
        else if($start==1){
            if($str[$i]=="<"){
                $start = 0;
                $alltext .= " ";
            }
            else if(ord($str[$i])>31){
                $alltext .= $str[$i];
            }
        }
    }
    $alltext = str_replace("　"," ",$alltext);
    $alltext = preg_replace("/&([^;&]*)(;|&)/","",$alltext);
    $alltext = preg_replace("/[ ]+/s"," ",$alltext);
    return $alltext;
}

/**
 * 敏感词过滤替换
 * @param  string $text 待检测内容
 * @param  array $sensitive 待过滤替换内容
 * @param  string $suffix 替换后内容
 * @return bool
 * @author jry <598821125@qq.com>
 */
function sensitive_filter($text, $sensitive = null, $suffix = '**'){
    if(!$sensitive){
        $sensitive = C('SENSITIVE_WORDS');
    }
    $sensitive_words = explode(',', $sensitive);
    $sensitive_words_replace = array_combine($sensitive_words,array_fill(0,count($sensitive_words), $suffix));
    return strtr($text, $sensitive_words_replace);
}

/**
 * 解析文档内容
 * @param string $str 待解析内容
 * @return string
 * @author jry <598821125@qq.com>
 */
function parse_content($str){
    return preg_replace('/(<img.*?)src=/i', "$1 class='lazy img-responsive' data-original=", $str);//将img标签的src改为data-original用户前台图片lazyload加载
}

/**
 * 友好的时间显示
 * @param int    $sTime 待显示的时间
 * @param string $type  类型. normal | mohu | full | ymd | other
 * @param string $alt   已失效
 * @return string
 * @author jry <598821125@qq.com>
 */
function friendly_date($sTime, $type = 'normal', $alt = 'false'){
    if (!$sTime)
        return '';
    //sTime=源时间，cTime=当前时间，dTime=时间差
    $cTime      =   time();
    $dTime      =   $cTime - $sTime;
    $dDay       =   intval(date("z",$cTime)) - intval(date("z",$sTime));
    //$dDay     =   intval($dTime/3600/24);
    $dYear      =   intval(date("Y",$cTime)) - intval(date("Y",$sTime));
    //normal：n秒前，n分钟前，n小时前，日期
    if($type=='normal'){
        if( $dTime < 60 ){
            if($dTime < 10){
                return '刚刚';
            }else{
                return intval(floor($dTime / 10) * 10)."秒前";
            }
        }elseif( $dTime < 3600 ){
            return intval($dTime/60)."分钟前";
            //今天的数据.年份相同.日期相同.
        }elseif( $dYear==0 && $dDay == 0  ){
            //return intval($dTime/3600)."小时前";
            return '今天'.date('H:i',$sTime);
        }elseif($dYear==0){
            return date("m月d日 H:i",$sTime);
        }else{
            return date("Y-m-d H:i",$sTime);
        }
    }elseif($type=='mohu'){
        if( $dTime < 60 ){
            return $dTime."秒前";
        }elseif( $dTime < 3600 ){
            return intval($dTime/60)."分钟前";
        }elseif( $dTime >= 3600 && $dDay == 0  ){
            return intval($dTime/3600)."小时前";
        }elseif( $dDay > 0 && $dDay<=7 ){
            return intval($dDay)."天前";
        }elseif( $dDay > 7 &&  $dDay <= 30 ){
            return intval($dDay/7) . '周前';
        }elseif( $dDay > 30 ){
            return intval($dDay/30) . '个月前';
        }
        //full: Y-m-d , H:i:s
    }elseif($type=='full'){
        return date("Y-m-d , H:i:s",$sTime);
    }elseif($type=='ymd'){
        return date("Y-m-d",$sTime);
    }else{
        if( $dTime < 60 ){
            return $dTime."秒前";
        }elseif( $dTime < 3600 ){
            return intval($dTime/60)."分钟前";
        }elseif( $dTime >= 3600 && $dDay == 0  ){
            return intval($dTime/3600)."小时前";
        }elseif($dYear==0){
            return date("Y-m-d H:i:s",$sTime);
        }else{
            return date("Y-m-d H:i:s",$sTime);
        }
    }
}

/**
 * 时间戳格式化
 * @param int $time
 * @return string 完整的时间显示
 * @author jry <598821125@qq.com>
 */
function time_format($time = NULL, $format='Y-m-d H:i'){
    $time = $time === NULL ? NOW_TIME : intval($time);
    return date($format, $time);
}

/**
 * 解析数据库语句函数
 * @param string $sql  sql语句   带默认前缀的
 * @param string $tablepre  自己的前缀
 * @return multitype:string 返回最终需要的sql语句
 */
function sql_split($sql, $tablepre){
    if($tablepre != "ct_"){
        $sql = str_replace("ct_", $tablepre, $sql);
    }
    $sql = preg_replace("/TYPE=(InnoDB|MyISAM|MEMORY)( DEFAULT CHARSET=[^; ]+)?/", "ENGINE=\\1 DEFAULT CHARSET=utf8", $sql);
    if($r_tablepre != $s_tablepre){
        $sql = str_replace($s_tablepre, $r_tablepre, $sql);
    }
    $sql = str_replace("\r", "\n", $sql);
    $ret = array();
    $num = 0;
    $queriesarray = explode(";\n", trim($sql));
    unset($sql);
    foreach($queriesarray as $query){
        $ret[$num] = '';
        $queries = explode("\n", trim($query));
        $queries = array_filter($queries);
        foreach($queries as $query){
            $str1 = substr($query, 0, 1);
            if($str1 != '#' && $str1 != '-'){
                $ret[$num] .= $query;
            }
        }
        $num++;
    }
    return $ret;
}

/**
 * 执行文件中SQL语句函数
 * @param string $file sql语句文件路径
 * @param string $tablepre  自己的前缀
 * @return multitype:string 返回最终需要的sql语句
 */
function execute_sql_from_file($file){
    $sql_data = file_get_contents($file);
    $sql_format = sql_split($sql_data, C('DB_PREFIX'));
    $counts = count($sql_format);
    for($i = 0; $i < $counts; $i++){
        $sql = trim($sql_format[$i]);
        D()->execute($sql);
    }
    return true;
}


/**
 * 系统非常规MD5加密方法
 * @param  string $str 要加密的字符串
 * @return string
 * @author jry <598821125@qq.com>
 */
function user_md5($str, $auth_key){
    if(!$auth_key){
        $auth_key = C('AUTH_KEY');
    }
    return '' === $str ? '' : md5(sha1($str) . $auth_key);
}

/**
 * 检测用户是否登录
 * @return integer 0-未登录，大于0-当前登录用户ID
 * @author jry <598821125@qq.com>
 */
function is_login(){
    return D('User')->isLogin();
}

/**
 * 根据用户ID获取用户信息
 * @param  integer $id 用户ID
 * @param  string $field
 * @return array  用户信息
 * @author jry <598821125@qq.com>
 */
function get_user_info($id, $field){
    $userinfo = D('User')->find($id);
    if($field){
        $userinfo[$field];
    }
    return $userinfo;
}

/**
 * 获取上传文件路径
 * @param  int $id 文件ID
 * @return string
 * @author jry <598821125@qq.com>
 */
function get_cover($id, $type){
    $upload_info = D('PublicUpload')->find($id);
    $url = $upload_info['real_path'];
    if(!$url){
        switch($type){
            case 'default' : //默认图片
                $url = C('TMPL_PARSE_STRING.__HOME_IMG__').'/logo/default.gif';
                break;
            case 'avatar' : //用户头像
                $url = C('TMPL_PARSE_STRING.__HOME_IMG__').'/avatar/avatar'.rand(1,7).'.png';
                break;
            default: //文档列表默认图片
                break;
        }
    }
    return $url;
}

/**
 * 获取上传文件信息
 * @param  int $id 文件ID
 * @return string
 * @author jry <598821125@qq.com>
 */
function get_upload_info($id, $field){
    $upload_info = D('PublicUpload')->where('status = 1')->find($id);
    if($field){
        if(!$upload_info[$field]){
            return $upload_info['id'];
        }else{
            return $upload_info[$field];
        }
    }
    return $upload_info;
}


/**
 * 获取所有数据并转换成一维数组
 * @author jry <598821125@qq.com>
 */
function select_list_as_tree($model, $map = null, $extra = null){
    //获取列表
    $con['status'] = array('eq', 1);
    if($map){
        $con = array_merge($con, $map);
    }
    $list = D($model)->where($con)->select();

    //转换成树状列表(非严格模式)
    $tree = new \Common\Util\Tree();
    $list = $tree->toFormatTree($list, 'title', 'id', 'pid', 0, false);

    if($extra){
        $result[0] = $extra;
    }

    //转换成一维数组
    foreach($list as $val){
        $result[$val['id']] = $val['title_show'];
    }
    return $result;
}

/**
 * 系统邮件发送函数
 * @param string $receiver 收件人
 * @param string $subject 邮件主题
 * @param string $body 邮件内容
 * @param string $attachment 附件列表
 * @return boolean
 * @author jry <598821125@qq.com>
 */
function send_mail($receiver, $subject, $body, $attachment){
    return R('Addons://Email/Email/sendMail', array($receiver, $subject, $body, $attachment));
}

/**
 * 短信发送函数
 * @param string $receiver 接收短信手机号码
 * @param string $body 短信内容
 * @return boolean
 * @author jry <598821125@qq.com>
 */
function send_mobile_message($receiver, $body){
    return false; //短信功能待开发
}


/**
 * 处理插件钩子
 * @param string $hook   钩子名称
 * @param mixed $params 传入参数
 * @return void
 * @author jry <598821125@qq.com>
 */
function hook($hook, $params = array()){
    \Think\Hook::listen($hook,$params);
}

/**
 * 获取插件类的类名
 * @param strng $name 插件名
 * @author jry <598821125@qq.com>
 */
function get_addon_class($name){
    $class = "Addons\\{$name}\\{$name}Addon";
    return $class;
}

/**
 * 插件显示内容里生成访问插件的url
 * @param string $url url
 * @param array $param 参数
 * @author jry <598821125@qq.com>
 */
function addons_url($url, $param = array()){
    return D('Addon')->getAddonUrl($url, $param);
}

//为未登录用户创建及时cookie
function make_cookie(){
    $userid = "LIKE_" . make_rand(10);
    cookie('userid',$userid,12*30*24*3600);
}

//生成n位的随机数
function make_rand($length){
    return rand(pow(10,($length-1)), pow(10,$length)-1);
}


//判断用户是否已经点评过了
function judge($data_like, $member_id, $id, $type, $action){
    if (!$data_like['list']) {
        //此项目一篇都没有点评过，数据库使用add，后面的条件都是update
        if ($action == "like") {
            $data['code'] = "100";
        } else {
            $data['code'] = "101";
        }
    } else {
        //点评过次模块，不一定点评过该项目内容
        $data_like_ids = explode(',', $data_like['list'][0]['like_object_ids']);
        $data_dislike_ids = explode(',', $data_like['list'][0]['dislike_object_ids']);
        if (in_array($id, $data_like_ids)) {
            //点评过喜欢
            $data['code'] = "110";
        } else if (in_array($id, $data_dislike_ids)){
            //点评过不喜欢
            $data['code'] = "111";
        } else {
            //该项目点评过，该内容没点评过
            if ($action == "like") {
                if ($data_like_ids[0]) {
                    //like字段添加,id
                    $data['code'] = "120";
                } else {
                    //like字段添加id
                    $data['code'] = "121";
                }
            } else {
                if ($data_dislike_ids[0]) {
                    //dislike字段添加,id
                    $data['code'] = "130";
                } else {
                    //dislike字段添加id
                    $data['code'] = "131";
                }
            }
        }
    }
    return $data;
}

//计算饼图比例
function cal_rate($data){
    $like_count = $data[0];
    $dislike_count = $data[1];

    $data['rate']['like_rate'] = 100 * sprintf("%.3f", $like_count/($like_count+$dislike_count));
    $data['rate']['dislike_rate'] = 100 * sprintf("%.3f", $dislike_count/($like_count+$dislike_count));
   
    return $data['rate'];
}

//判断是否收藏
function judge_sc($data_sc, $id){
    if (!$data_sc['list']) {
        //该类型没有收藏过，用add
        return $data['code'] = "200";
    } else if (!in_array($id, explode(',', $data_sc['list'][0]['sc_ids']))) {
        //没有收藏过该项
        return $data['code'] = "201";
    } else {
        //已经收藏过了
        return $data['code'] = "202";
    }
    
}


//判断单条是否收藏
function judge_ssc($data_sc, $id){
    if (!$data_sc['list']) {
        //没有收藏过，用add
        return $data['code'] = "200";
    } else {
        //已经收藏过了
        return $data['code'] = "202";
    }
}

/**
 * 对数组进行排序
 * @param $array        数据数组
 * @param $cond         条件（结构为：array(array(列名1, SORT_ASC/SORT_DESC, SORT_STRING/SORT_NUMERIC),
 *                                         array(列名1, SORT_ASC/SORT_DESC, SORT_STRING/SORT_NUMERIC)
 *                                    )，第三参数表示按照string还是数字进行排序，可不传，可为空，默认为类型不变进行排序）
 * -- by jianghao  2016-11-10
 */
function array_sort($array, $cond)
{
    if(!is_null($array) && count($array) > 0)
    {
        if(count($cond) == 0)
        {
            return $array;
        }
        else
        {
            //排序列表
            $sortList = array();
            //排序字段类型列表
            $typeList = array();
            foreach($cond as $sort)
            {
                $sortList[] = !empty($sort[1]) ? $sort[1] : SORT_DESC;
                $typeList[] = isset($sort[2]) ? $sort[2] : SORT_REGULAR;
            }
            
            //值列表
            $valueList = array();
            foreach($cond as $sort)
            {
                $columnName = $sort[0];
                $values = array();
                foreach($array as $index => $row)
                {
                    $values[] = $row[$columnName];
                }

                $valueList[] = $values;
            }
            
            $args = array();
            for($i = 0; $i < count($cond); $i++)
            {
                $args[] = &$valueList[$i];
                $args[] = &$sortList[$i];
                $args[] = &$typeList[$i];
            }
            $args[] = &$array;
            call_user_func_array('array_multisort', $args);
            
            return $array;
        }
    }
    else
    {
        return array();
    }
}

// 炒鸡打印方法   ----- by jianghao 2016-12-2
function p($array) {
    dump($array, 1, '<pre>', 0);
}

/**
 * 发送HTTP请求方法
 * @param  string $url    请求URL
 * @param  array  $data 请求参数
 * @param  string $method 请求方法GET/POST
 * @return array  $data   响应数据
 */
function curl($url,$data,$method = 'GET'){ // 模拟提交数据函数
    $curl = curl_init(); // 启动一个CURL会话
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0); // 从证书中检查SSL加密算法是否存在
    curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
    curl_setopt($curl, CURLOPT_REFERER,'https://www.baidu.com');// 设置Referer
    switch(strtoupper($method)){
        case 'GET':
            $url = $url . '?' . http_build_query($data);
            break;
        case 'POST':
            curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
            break;
        default:
            throw new Exception('不支持的请求方式！');
    }
    curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
    curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
    curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
    $tmpInfo = curl_exec($curl); // 执行操作
    if (curl_errno($curl)) {
       echo 'Errno'.curl_error($curl);//捕抓异常
    }
    curl_close($curl); // 关闭CURL会话
    return $tmpInfo; // 返回数据
}

/**
 * 处理文件流，存到指定的路径。规定为post方式
 * @param  string $url    存储URL
 * @param  string $data 文件流数据
 * @param  string $format 文件格式
 * @return array  $data   完整的文件路径
 */
function get_file_stream_url($url, $data, $format){
    switch ($format) {
        case 'jpg':
            $file_data = base64_decode(explode(",", $data)[1]);
            break;
        
        default:
            # code...
            break;
    }
    $name = get_rand();
    file_put_contents(BASE_PATH . '/Resource/' . $url . '/' . $name . '.' . $format, $file_data);
    return '/Resource/' . $url . '/' . $name . '.' . $format;
}

