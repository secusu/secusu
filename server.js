'use strict';

var ENV = require('node-env-file')(__dirname + '/.env'),
    fs = require('fs'),
    express = require('express'),
    app = express(),
    server,
    bodyParser = require('body-parser'),
    sjclWrapper = require('./node_modules_local/sjcl-wrapper');

app.set('port', ENV.NODE_PORT || 3000);
app.set('ipaddr', ENV.NODE_IP || 'localhost');
app.use(bodyParser.json()); // support json encoded bodies
app.use(bodyParser.urlencoded({extended: true})); // support encoded bodies

if (ENV.NODE_SSL_KEY && ENV.NODE_SSL_CERT) {
    var sslOptions = {
        key: (ENV.NODE_SSL_KEY_FILE ? fs.readFileSync(ENV.NODE_SSL_KEY_FILE) : null),
        cert: (ENV.NODE_SSL_CERT_FILE ? fs.readFileSync(ENV.NODE_SSL_CERT_FILE) : null),
        ca: (ENV.NODE_SSL_CA_FILE ? [fs.readFileSync(ENV.NODE_SSL_CA_FILE1),
            fs.readFileSync(ENV.NODE_SSL_CA_FILE2)] : null)
    };
    server = require('https').createServer(sslOptions, app);
} else {
    server = require('http').createServer(app);
}

app.post('/encrypt', function (req, res) {
    if (!req.body.message || !req.body.password) {
        return res.send('Request malformed.');
    }

    var cipher = sjclWrapper.encrypt({
        password: req.body.password,
        message: req.body.message
    });

    return res.send(cipher);
});

app.post('/decrypt', function (req, res) {
    if (!req.body.message || !req.body.password) {
        return res.send('Request malformed.');
    }

    var text = sjclWrapper.decrypt({
        password: req.body.password,
        message: req.body.message
    });

    return res.send(text);
});

var io = require('socket.io')(server),
    IORedis = require('ioredis'),
    ioredis = new IORedis({
        db: ENV.REDIS_DATABASE || 0
    });

var ChatServer = require('./node_modules_local/chat-server/chat-server.js');
new ChatServer({io: io, ENV: ENV}).init();

ioredis.subscribe('secu-channel');
ioredis.on('message', function (channel, message) {
    message = JSON.parse(message);
    io.emit(channel + ':' + message.event, message.data);
});

server.listen(app.get('port'), function() {
    console.log('SECU node.js server started at ' + app.get('ipaddr') + ':' + app.get('port') + ' from ' + __dirname);
});
