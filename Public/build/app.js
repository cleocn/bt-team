var config_path = _config.path +  "Public/build/",html,socket;
requirejs.config({
    paths: {
    	"lib": config_path + "lib",
    	"socket": config_path + "socket",
        "html": config_path + "html",
    }
});
require(['html', 'lib','socket'])