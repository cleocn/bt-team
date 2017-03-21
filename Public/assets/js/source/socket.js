import {base} from "Public/build/base.js";
export class socket extends base{
	constructor(){
		super();
		this._init();
		this._listen_bind();
	}
	// 初始化
	_init(){
		this._socket = io.connect('http://120.26.239.60:3003');
		this.log("socket init");
	}
	// 事件侦听
	_listen_bind(){
		this._socket.on('s_listen',function(data){
			let dom = data.author + '-' + data.line;
			if(data.author != 'row-' + _config.userid){
				if($('.content div[key='+ data.key+']').length > 0){
					let info = $('.content div[key='+ data.key+']');
					info.addClass(data.author);
					info.html(data.txt);
				}else{
					_is_back = true;
					$('.content').append('<div class="'+ dom+' '+ data.author+'" key="'+ data.key +'">'+ data.txt +'</div>');
				}
			}
			//this.log(data);
		}.bind(this))
	}
	_remove_listen_bind(){
		node.removeEventListener("DOMNodeInserted", function () {
		    this.log('remove');
		}, false);
	}
	// 发送消息
	_emit(info){
		this._socket.emit('c_emit',info);
	}
}

window.socket = new socket();