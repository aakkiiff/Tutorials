var http = require('http');
console.log('Server Listening on 8080');
http.createServer(function (req, res) {

  res.writeHead(200, {'Content-Type': 'text/plain'});
  res.end('Hello World!');
  
}).listen(8080);