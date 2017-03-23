import {base} from  "/Public/build/base.js";
export class html extends base{
	constructor(){
		super();
		this._event_init();
		//this.message('欢迎[ ' + _config.name + ' ]进入协同办公');
	}
	// 事件初始化
	_event_init(){
		this.event();
		this.editor_init();
		this.editor_node_init();
		this.title_init();
		this.login();
	}
	event(){
		$('.logout').click(()=>{
			QC.Login.signOut();
			location.href = _config.CONTROLLER_NAME;
		})
	}
	login(){
		var self = this;
		setTimeout(()=>{
			if(_config.userinfo == null){
				$('.banner-content').removeClass('hide');
				let _html = ` <header>BT文档</header><section><button>使用QQ帐号登陆<div id="login"></div></button></section>`;
				layer.open({type: 1,title: false,closeBtn: 0,shadeClose: false,skin: 'layer_login',content: ''});
				$('.layui-layer-page').remove();
				_config.userinfo = {userid : 1,color : '#000'};
				self.default(false);
				QC.Login({btnId:"login"});
			}
		},500)
		//用JS SDK调用OpenAPI
		QC.api("get_user_info", {}).success((s)=>{
			$('.navbar-nav').removeClass('hide');
			$('.banner-content').addClass('hide');
			$('.layui-layer-shade').remove();
			this.close();
			_config.userinfo = s.data;
			$('.user img').attr('src',_config.userinfo.figureurl_qq_2);
			let data = {url : _config.CONTROLLER_NAME + '/save',data : _config.userinfo };
			self.ajax(data,(result)=>{
				_config.userinfo.userid = result.userid;
				_config.userinfo.color = result.color;
				// 完成登陆初始后，进行默认设置
				this.default(true);
			})
		});

	}
	default(is_login){
		// 默认内容初始化
		let _html = '<div>BT文档是一款支持「多人实时协作」的文档设计工具，你可以和别人一起同时进行一个文档制作，你们能够互相看到对方的状态，以及每个人的每一步操作与结果。<br></div><div>BT文档只是仿业内“石墨”的一个非常非常初级的版本，意在本人探索和偿试新产品下的技术原理实现~</div><div><br><video class="embed-responsive-item" id="fullVideo" autoplay="autoplay" controls=""><source src="https://dn-site.oss.aliyuncs.com/videos%2F60s_go_to_work.mp4?response-content-type=video/mp4" type="video/mp4"></video></div>',
			_title = 'BT-文档 多人实时协作工具';
		if(is_login){
			_html = '<div>Hello World</div>';
			_title = '无标题';
		}
		$('#edit-box').html(_html);
		$('#title').val(_title);
		document.title = $('#title').val();
		$('.dropdown-menu li:first a').html(_config.userinfo.nickname);
		// 动态设置用户颜色
		if(document.all){
	        window.style=".row-"+ _config.userinfo.userid +"{border-left:2px solid "+ _config.userinfo.color+";padding-left:10px;}"; 
	        document.createStyleSheet("javascript:style"); 
	    }else{
	        var style = document.createElement('style'); 
	        style.type = 'text/css'; 
	        style.innerHTML=".row-"+ _config.userinfo.userid +"{ border-left:2px solid "+ _config.userinfo.color+";padding-left:10px;}"; 
	        document.getElementsByTagName('HEAD').item(0).appendChild(style); 
	    }
	}
	// 标题侦听
	title_init(){
		$('#title').keyup(function(){
			document.title = $(this).val() || '无标题';
		})
	}
	// html在线编辑器Node侦听
	editor_node_init(){
		var self = this;
		// 侦听键盘输入
        node.addEventListener('input',(e)=> {
        	// log('input');
        	if($('#edit-box div').size() == 0){
        		self.default();
        	}
        	_is_back = false;
            var targetNode = this.getSelectionStart();
		    if(targetNode != undefined && targetNode.nodeType === 1 && targetNode.nodeName == 'DIV'){
		    	_is_back = false;
		     	var line = $('#edit-box div').size() + 1;
			    var info = $(targetNode);
			    socket._emit({author:'row-' + _config.userinfo.userid,line : line,txt : info.html() , key : info.attr('key'),style : info.attr('style'),userinfo : _config.userinfo});
		    }
        },false);
        // 侦听新行的产生
        node.addEventListener('DOMNodeInserted', function (e) {
        	// log('DOMNodeInserted');
        	if(! _is_back){
        		// var targetNode = this.getSelectionStart();
        		// log(targetNode)
	         	let info = $(e.target);
	            let line = $('#edit-box div').size() + 1;
	            let key = Math.round(Math.random() * 1000000);
	            //log(info.context.nodeName)
	            // if(info.context.nodeName == '#text'){
	            // 	log(info.context);
	            // 	$('#edit-box').append('<div></div>');
	            // }
	            if(info.context.nodeName == 'DIV'){
	            	info.attr('class','row-' + _config.userinfo.userid + '-' + line).attr('key',key).addClass('row-' + _config.userinfo.userid);
					//socket._emit({author:'row-' + _config.userinfo.userid,line : line,txt : info.html() ,key : key});
	            }
        	}
        }, false);
	}
	// html在线编辑器事件绑定
	editor_init(){
		var self = this;
		$('.html .Controls a').click(function(e) {
			switch($(this).data('role')) {
				case 'h1':
				case 'h2':
				case 'p':
					document.execCommand('formatBlock', false, '<' + $(this).data('role') + '>');
					break;
				default:
					document.execCommand($(this).data('role'), false, null);
					let nodes = $(self.getSelected().baseNode.parentElement);
					let className = nodes.context.className;
					if(! className){
						nodes = $(nodes.context.parentNode);
						className = nodes.context.parentNode.className;
					}
					let rows = className.split('-');
					socket._emit({author:rows[0] + '-' + rows[1],line : rows[2] ,txt : nodes.html() ,key : nodes.attr('key')});
					break;
			}
		});
	}
	// Nodel内容区
	getSelected() {
		if (window.getSelection) {
			return window.getSelection();
		} else if (document.getSelection) {
			return document.getSelection();
		} else if (document.selection) {
			return document.selection.createRange();
		}else{
			return null;
		}
	}
	// Nodel内容区
	getSelectionStart() {
		var node = document.getSelection().anchorNode;
		return (node.nodeType == 3 ? node.parentNode : node);
	}
}

window.html = new html();