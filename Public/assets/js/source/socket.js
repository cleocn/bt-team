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
					_is_back = false;
				}else{
					_is_back = true;
					$('.content').append('<div class="'+ dom+' '+ data.author+'" key="'+ data.key +'">'+ data.txt +'</div>');
				}
				//$('.content div:last').input();
			}
			//this.log(data);
		}.bind(this))
	}
	// 发送消息
	_emit(info){
		this._socket.emit('c_emit',info);
	}
}

window.socket = new socket();