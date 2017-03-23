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
				let _html = ` <header>BT文档</header><section><button>使用QQ帐号登陆<div id="login"></div></button></section>`;
				layer.open({type: 1,title: false,closeBtn: 0,shadeClose: false,skin: 'layer_login',content: _html});
				QC.Login({btnId:"login"});

				_config.userinfo = {userid : 1,color : '#000'};
				self.default(false);
			}
		},500)
		//用JS SDK调用OpenAPI
		QC.api("get_user_info", {}).success((s)=>{
			this.close();
			_config.userinfo = s.data;
			//log(_config.userinfo);
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
		let _html = '<div>品牌全案策划就是建立品牌、塑造品牌并完善品牌的一个过程，希望通过品牌全案策划的终极解决方案来完善企业品牌，使之成为行业内，市场中的一个知名 品牌，让这个品牌不仅有着极高的知名度，还具有不同凡响的美誉度，这才是做品牌全案策划的最终目的。</div><div class="row-1-4 row-1" key="873382"><br></div><div class="row-1-3 row-1" key="389376">那么接下来，先知品牌就来给大家简单的说一说2016 年终极品牌全案策划解决方案，希望能够给企业带来帮助。<br></div><div class="row-1-6 row-1" key="765449"><br></div><div class="row-1-5 row-1 content-undefined" key="999199"><b>1、前期调研</b><br>市场调研前期，我们一般分为三个步骤，第一，明确调研意图。第二，收集资料，分析问题。第三，确定市场调研主题。</div><div class="row-1-7 row-1" key="591420"><br><b>2、组织策划</b><br>先知品牌对品牌全案策划前期的组织策划提供以下思路：品牌整合策划、市场整合营销策划、企业视觉识别系统（VI）设计、产品包装设计与创意、销售终端生动 化创意与设计、影视广告的创意、平面设计广告的创意与策划、产品招商全程策划、企业销售管理体系、企业销售队伍培训等等。</div><div class="row-1-8 row-1" key="425025"><br><b>3、确立实施</b><br>品牌定位方案的确定、品牌全案设计的确定、品牌名称的确定、品牌商标的确定及注册、品牌营销方案的确定、品牌产品价格的确定、主推产品的确定、推广营销渠道的确定、品牌全案策划费用的确定、品牌推广营销的时间段的确定、品牌全案策划解决方案效果的评估预测等。<br></div><div></div><div style="text-align: right;"><img src="http://e.xianzhi.net/uploads/allimg/160616/47_160616135922_1.jpg"></div>',
			_title = 'BT-文档 可多人实时协作的云端工具';
		if(is_login){
			_html = '<div>Start</div>';
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