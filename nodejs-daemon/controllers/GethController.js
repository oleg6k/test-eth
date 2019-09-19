const Web3 = require('web3');
const config = require('../config/daemonConfig')
const {emitter} = require('../services/Globals')

const initWeb3 = () => {
  try{
    return new Web3(`${config.GETH_OPTIONS.host}:${config.GETH_OPTIONS.port}`)
  }catch (e) {
    console.log('Cannot connect to GETH by RPC. Reconnect in 10 seconds...')
    setTimeout(initWeb3,10000)
  }
}

const web3 = initWeb3()

const subscribe = (address) => {
  let msg = {id: 1, method: 'eth_subscribe', params: ["logs", address]}
  console.log(JSON.stringify(msg))
  emitter.emit('send_websocket_message', JSON.stringify(msg))
}

const checkForNewEthTransaction = async (data) => {
  if (data.method === 'eth_subscription') {
    const address = data.params.result.address
    const txid = data.params.result.transactionHash
    const transaction = await getTransaction(txid)
    if (transaction.to === address) {
      const confirmations = await getConfirmations(transaction)
      const amount = await getAmount(transaction)
      emitter.emit('process_incoming_eth_transaction',
        {
          confirmations: confirmations,
          amount: amount,
          address: address,
          txid: txid
        })
    }
  }
}

const getTransaction = (txHash) => {
  return web3.eth.getTransaction(txHash)
}

const getConfirmations = async (transaction) => {
  try {
    const currentBlock = await web3.eth.getBlockNumber()
    return transaction.blockNumber === null ? 0 : currentBlock - transaction.blockNumber
  } catch (error) {
    console.log(error)
  }
}

const getAmount = (transaction) => {
  let wei = web3.utils.hexToNumber(transaction.value)
  return web3.utils.fromWei(wei, 'ether');
}

module.exports = {
  subscribe,
  checkForNewEthTransaction
}