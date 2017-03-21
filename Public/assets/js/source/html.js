import {base} from "Public/build/base.js";
export class html extends base{
	constructor(){
		super();
		this._event_init();
		//this.message('欢迎[ ' + _config.name + ' ]进入协同办公');
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
					let className = nodes.context.className;
					if(! className){
						nodes = $(nodes.context.parentNode);
						className = nodes.context.parentNode.className;
					}
					let rows = className.split('-');
					socket._emit({author:rows[0] + '-' + rows[1],line : rows[2] ,txt : nodes.html()});
					break;
			}
		});
		// 行内输入class绑定
		function addEvent(obj, type, fn) {
        if (obj) {
	            if (obj.attachEvent) {
	                obj['e' + type + fn] = fn;
	                obj[type + fn] = function () { obj['e' + type + fn](window.event); };
	                obj.attachEvent('on' + type, obj[type + fn]);
	            } else {
	                obj.addEventListener(type, fn, false);
	            }
	        }
	    };
	    function log(val){
	    	console.log(val);
	    }

        // addEvent(node, 'keypress', function (e) {
        //     log('keypress');
        // });

        // addEvent(node, 'input', function (e) {
        //     log('input');
        // });

        node.addEventListener('input',function (e) {
            var targetNode = getSelectionStart();
		    if(targetNode != undefined && targetNode.nodeType === 1 && targetNode.nodeName == 'DIV'){
		    	_is_back = false;
		     	var line = $('#edit-box div').size() + 1;
			    var info = $(targetNode);
			    socket._emit({author:'row-' + _config.userid,line : line,txt : info.html() , key : info.attr('key')});
		    }
        },false);
        node.addEventListener('DOMNodeInserted', function (e) {
        	if(! _is_back){
        		log('DOMNodeInserted');
	         	let info = $(e.target);
	            let line = $('#edit-box div').size() + 1;
	            let key = Math.round(Math.random() * 1000000);
	            info.attr('class','row-' + _config.userid + '-' + line).attr('key',key).addClass('row-' + _config.userid);
				//socket._emit({author:'row-' + _config.userid,line : line,txt : info.html() ,key : key});
        	}
        }, false);

		function getSelectionStart() {
		 var node = document.getSelection().anchorNode;
		 return (node.nodeType == 3 ? node.parentNode : node);
		}

		$('#edit-box').html('<div>Start</div>');
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