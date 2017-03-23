import {base} from "/Public/build/base.js";
export class socket extends base{
	constructor(){
		super();
		this._init();
		this._listen_bind();
	}
	// 初始化
	_init(){
		this._socket = io.connect('http://120.26.239.60:3003');
	}
	// 事件侦听
	_listen_bind(){
		var self = this;
		this._socket.on('s_listen',function(data){
			let dom = data.author + '-' + data.line;
			if(data.author != 'row-' + _config.userinfo.userid){
				if($('.content div[key='+ data.key+']').length > 0){
					let info = $('.content div[key='+ data.key+']');
					if(friend.indexOf(data.author) == -1){
						self.default(data.author,data.userinfo.color);
						friend.push(data.author);
					}
					info.addClass(data.author);
					info.attr('style',data.style);
					info.html('<img src="'+ data.userinfo.figureurl_qq_2+'" class="face"/>' + data.txt);
					_is_back = false;
				}else{
					_is_back = true;
					$('.content').append('<div class="'+ dom+' '+ data.author+'" key="'+ data.key +'">'+ data.txt +'</div>');
				}
			}
		}.bind(this))
	}
	default(author,color){
		// 动态设置用户颜色
		if(document.all){
	        window.style="."+ author +"{border-left:2px solid "+ color+";padding-left:10px;}"; 
	        document.createStyleSheet("javascript:style"); 
	    }else{
	        var style = document.createElement('style'); 
	        style.type = 'text/css'; 
	        style.innerHTML="."+ author +"{border-left:2px solid "+ color+";padding-left:10px;}"; 
	        document.getElementsByTagName('HEAD').item(0).appendChild(style); 
	    }
	}
	// 发送消息
	_emit(info){
		this._socket.emit('c_emit',info);
	}
}

window.socket = new socket();