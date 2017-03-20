import {base} from "Public/build/base.js";
export class html extends base{
	constructor(){
		super();
		this._event_init();
	}
	// 事件初始化
	_event_init(){
		// html在线编辑器事件绑定
		$('.html .Controls a').click(function(e) {
			switch($(this).data('role')) {
				case 'h1':
				case 'h2':
				case 'p':
					document.execCommand('formatBlock', false, '<' + $(this).data('role') + '>');
					break;
				default:
					document.execCommand($(this).data('role'), false, null);
					break;
			}
		});
		// 行内输入class绑定
		$('div').on('keypress','div',function(e) {
			if(e.currentTarget.childElementCount > 1){
				var info = $(e.currentTarget.children[1].lastElementChild);
				info.attr('class','row-' + _config.userid + '-' + ($('.content div').size() + 1))
			};
		});
	}
}

new html();