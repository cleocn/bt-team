define(["exports","Public/build/base.js"],function(t,e){"use strict";function n(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}function o(t,e){if(!t)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!e||"object"!=typeof e&&"function"!=typeof e?t:e}function i(t,e){if("function"!=typeof e&&null!==e)throw new TypeError("Super expression must either be null or a function, not "+typeof e);t.prototype=Object.create(e&&e.prototype,{constructor:{value:t,enumerable:!1,writable:!0,configurable:!0}}),e&&(Object.setPrototypeOf?Object.setPrototypeOf(t,e):t.__proto__=e)}Object.defineProperty(t,"__esModule",{value:!0}),t.socket=void 0;var r=function(){function t(t,e){for(var n=0;n<e.length;n++){var o=e[n];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(t,o.key,o)}}return function(e,n,o){return n&&t(e.prototype,n),o&&t(e,o),e}}(),c=t.socket=function(t){function e(){n(this,e);var t=o(this,(e.__proto__||Object.getPrototypeOf(e)).call(this));return t._init(),t._listen_bind(),t}return i(e,t),r(e,[{key:"_init",value:function(){this._socket=io.connect("http://120.26.239.60:3003"),this.log("socket init")}},{key:"_listen_bind",value:function(){this._socket.on("s_listen",function(t){var e=t.author+"-"+t.line;if(t.author!="row-"+_config.userid)if($(".content div").hasClass(e)){var n=$(".content div."+e);n.html(t.txt)}else $(".content").append('<div class="'+e+'">'+t.txt+"</div>");this.log(t)}.bind(this))}},{key:"_emit",value:function(t){this._socket.emit("c_emit",t)}}]),e}(e.base);window.socket=new c});