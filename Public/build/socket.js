define(["exports","Public/build/base.js"],function(e,t){"use strict";function n(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}function o(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!=typeof t&&"function"!=typeof t?e:t}function i(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,enumerable:!1,writable:!0,configurable:!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}Object.defineProperty(e,"__esModule",{value:!0}),e.socket=void 0;var r=function(){function e(e,t){for(var n=0;n<t.length;n++){var o=t[n];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(e,o.key,o)}}return function(t,n,o){return n&&e(t.prototype,n),o&&e(t,o),t}}(),c=e.socket=function(e){function t(){n(this,t);var e=o(this,(t.__proto__||Object.getPrototypeOf(t)).call(this));return e._init(),e._listen_bind(),e}return i(t,e),r(t,[{key:"_init",value:function(){this._socket=io.connect("http://120.26.239.60:3003")}},{key:"_listen_bind",value:function(){this._socket.on("s_listen",function(e){var t=e.author+"-"+e.line;if(e.author!="row-"+_config.userid)if($(".content div[key="+e.key+"]").length>0){var n=$(".content div[key="+e.key+"]");n.addClass(e.author),n.html(e.txt),_is_back=!1}else _is_back=!0,$(".content").append('<div class="'+t+" "+e.author+'" key="'+e.key+'">'+e.txt+"</div>")}.bind(this))}},{key:"_emit",value:function(e){this._socket.emit("c_emit",e)}}]),t}(t.base);window.socket=new c});