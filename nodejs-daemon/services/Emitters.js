const {emitter} = require('./Globals')

const Kernel = require('./Kernel')

const GethWebsocketController = require('../controllers/GethWebsocketController')
const GethController = require('../controllers/GethController')

exports.emitter = emitter

exports.init = async function () {

  console.log('Emitters initialization')
  //ws
  emitter.on('initialization', GethWebsocketController.init)
  emitter.on('send_websocket_message', GethWebsocketController.send)
  //geth
  emitter.on('subscribe', GethController.subscribe)
  emitter.on('check_for_new_eth_transaction', GethController.checkForNewEthTransaction)
  //kernel
  emitter.on('ready_for_subscribe', Kernel.initSubscribing)
  emitter.on('process_incoming_eth_transaction', Kernel.processIncomingEthTransaction)

}