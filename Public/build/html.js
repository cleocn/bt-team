define(["exports","Public/build/base.js"],function(e,t){"use strict";function n(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}function o(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!=typeof t&&"function"!=typeof t?e:t}function r(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,enumerable:!1,writable:!0,configurable:!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}Object.defineProperty(e,"__esModule",{value:!0}),e.html=void 0;var i=function(){function e(e,t){for(var n=0;n<t.length;n++){var o=t[n];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(e,o.key,o)}}return function(t,n,o){return n&&e(t.prototype,n),o&&e(t,o),t}}(),c=e.html=function(e){function t(){n(this,t);var e=o(this,(t.__proto__||Object.getPrototypeOf(t)).call(this));return e._event_init(),e}return r(t,e),i(t,[{key:"_event_init",value:function(){var e=this;$(".html .Controls a").click(function(t){switch($(this).data("role")){case"h1":case"h2":case"p":document.execCommand("formatBlock",!1,"<"+$(this).data("role")+">");break;default:document.execCommand($(this).data("role"),!1,null);var n=$(e.getSelected().baseNode.parentElement),o=n.context.className;o||(n=$(n.context.parentNode),o=n.context.parentNode.className);var r=o.split("-");socket._emit({author:r[0]+"-"+r[1],line:r[2],txt:n.html()})}}),$("div").on("keyup","div",function(e){if(e.currentTarget.childElementCount>1){var t=$(e.currentTarget.children[1].lastElementChild),n=$(".content div").size()+1;t.attr("class","row-"+_config.userid+"-"+n),t.addClass("row-"+_config.userid),socket._emit({author:"row-"+_config.userid,line:n,txt:t.html()})}})}},{key:"getSelected",value:function(){return window.getSelection?window.getSelection():document.getSelection?document.getSelection():document.selection?document.selection.createRange():null}}]),t}(t.base);window.html=new c});