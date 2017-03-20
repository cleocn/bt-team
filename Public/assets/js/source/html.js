import {base} from "Public/build/base.js";
export class html extends base{
	constructor(){
		super();
		this._event_init();
		//this.message('欢迎[' + _config.name + ']进入协同办公');
	}
	// 事件初始化
	_event_init(){
		let self = this;
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
					let nodes = $(self.getSelected().baseNode.parentElement);
					self.log(nodes.context.className)
					//socket._emit({author:nodes.context.className,txt : nodes.html()});
					break;
			}
		});
		// 行内输入class绑定
		$('div').on('keyup','div',(e)=> {
			if(e.currentTarget.childElementCount > 1){
				var info = $(e.currentTarget.children[1].lastElementChild);
				var line = ($('.content div').size() + 1);
				info.attr('class','row-' + _config.userid + '-' + line)
				info.attr('data-id',_config.userid);
				info.attr('data-row',line);
				socket._emit({author:'row-' + _config.userid,line : line,txt : info.html()});
			};
		});
	}
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
}

window.html = new html();