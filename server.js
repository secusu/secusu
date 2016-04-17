'use strict';

var fs = require('fs');
var env = require('node-env-file');
env(__dirname + '/.env');

var port = process.env.NODE_PORT || 3000;
var express = require('express');
var app = express();
var server;

if (process.env.NODE_SSL_KEY && process.env.NODE_SSL_CERT) {
    var httpsOptions = {
        key: fs.readFileSync(process.env.NODE_SSL_KEY),
        cert: fs.readFileSync(process.env.NODE_SSL_CERT)
        //ca: fs.readFileSync('ssl/certs/domain.com.cabundle')
    };
    server = require('https').createServer(httpsOptions, app);
} else {
    server = require('http').createServer(app);
}

var bodyParser = require('body-parser');
var sjclWrapper = require('./node_modules_local/sjcl-wrapper');
var io = require('socket.io')(server);
var Redis = require('ioredis');
var redis = new Redis();

app.use(bodyParser.json()); // support json encoded bodies
app.use(bodyParser.urlencoded({extended: true})); // support encoded bodies

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

redis.subscribe('secu-channel');
redis.on('message', function (channel, message) {
    message = JSON.parse(message);
    io.emit(channel + ':' + message.event, message.data);
});

server.listen(port);
console.log('SECU node.js server started at port: ' + port);
