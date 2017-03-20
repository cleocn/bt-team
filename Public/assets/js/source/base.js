// 所有ES6 Class 基类
// Authur : 方清 Brandon Fang
// Date   : 2016/11/14
export class base{
	log(val){
		console.log(val);
	}
	// 基础提醒弹框
	msg(txt,closeBtn = 1,fn = null){
		layer.closeAll();
		layer.open({content: txt,btn: ['确定'],yes : fn,closeBtn: closeBtn});
	}
	message(txt,close = true){
		layer.closeAll();
		layer.msg(txt,{shadeClose:false,shade: [0.3, '#fff']});
	}
	// 基础loading...
	load(){
		var index = layer.load(2, {
			shade: [0.1,'#fff'] //0.1透明度的白色背景
		});
	}
	regex_null(obj){
		if (obj.replace(/\s/g,'') == '')
			return true;
		return false;
	};
	// 定义POST参数
	get query_param(){
		if(this._query == null){
			this._query = new Map();
		}
		return this._query;
	}
	// 关闭没有弹框
	close(){
		layer.closeAll();
	}
	// AJAX
	ajax(_args,_func){
		_args.data.__hash__ = $('[name="__hash__"]').attr('content');
		$.ajax({
			type: _args.type || "POST",
			url: _args.url,
			data: _args.data,
			success:
	        function(data){
	        	_func(eval('('+data+')'));
	        }
	    });
	}
	// 事件基础邦定
	events_bind(){
		setTimeout(()=>{
			$.each(this.events,(i,c)=>{
				$(i).click(()=>{
			    	this[c]();
			    })
			});
		},100)
	}
	// ajax翻页
	set_page($dom,pagecount,currentpage,fn){
		$dom.createPage({pageCount:pagecount,current:currentpage,backFn:fn});
	}
	// 过滤重复数据
	filter(args){
		var str1=[];
		for(var i=0;i<args.length;i++){
            if(str1.indexOf(args[i])<0 && args[i] != ''){
                str1.push(args[i])
            }
        }
        return str1;
	}
	// 将时间戳转换时间
	getLocalTime(nS){
		return new Date(parseInt(nS) * 1000).toLocaleString().replace(/年|月/g, "-").replace(/日/g, " ");
	}
	// 获取文件扩展名
	get_file_ext(filename){
		filename=filename.replace(/.*(\/|\\)/, ""); 
		let fileExt=(/[.]/.exec(filename)) ? /[^.]+$/.exec(filename.toLowerCase()) : ''; 
		return fileExt;
	}
	// 判断文件是否合法
	reg_up_file_ok(filename){
		let ext = this.get_file_ext(filename);
		if(ext == 'jpg' || ext == 'png' || ext == 'txt' || ext == 'doc' || ext == 'docx')
			return true;
		return false
	}
}