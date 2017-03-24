// 服务器发送信息，必须全用io.sockets.emit 所有客户端将会收到
// socket.emit 将会给到相应的人，

var io = require('socket.io').listen(3003);

console.log('listen 3003 init');

io.sockets.on('connection', function (socket) {
    socket.on('start', function (data) {
	    io.sockets.emit('start_list',data);
    });

    socket.on('c_emit', function (data) {
        io.sockets.emit('s_listen',data);
    });
});
