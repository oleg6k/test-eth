const config = require('../config/daemonConfig')

const WebSocket = require('ws')
const {emitter} = require('../services/Globals')


let ws;

function init() {
  ws = new WebSocket(`ws://${config.GETH_OPTIONS.host}:${config.GETH_OPTIONS.port_ws}`);
  ws.on('open', function open() {
    console.log('Connected to geth by WS.')
    emitter.emit('ready_for_subscribe')
  })
  ws.on('message', function (data) {
    emitter.emit('check_for_new_eth_transaction', JSON.parse(data))
  })
  ws.on('error', function () {
    console.error('Cannot connect to GETH by WS. Reconnect in 10 seconds...')
    setTimeout(() => {
      init()
    }, 10000)
  })
}

const send = (message) => {
  console.log('sending message', message)
  ws.send(message)
}


module.exports = {
  init,
  send
}