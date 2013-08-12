var io = require('socket.io').listen(9999);

io.sockets.on('connection', function (socket) {
  socket.on('message', function (message) {
  	socket.send(message);
  });
  socket.on('disconnect', function () { });
});