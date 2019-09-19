const {emitter} = require('./Globals')
const WalletController = require('../controllers/WalletController')
const TransactionController = require('../controllers/TransactionController')


const processIncomingEthTransaction = async (ethTransaction) => {
  const wallet = await WalletController.getWalletByAddress(ethTransaction.address)
  if (wallet) {
    const transactionTemplate = {
      wallet_id: wallet.id,
      amount: ethTransaction.amount,
      txid: ethTransaction.txid,
      confirmations: ethTransaction.confirmations,
    }
    TransactionController.createTransaction(transactionTemplate)
  }
}

const initSubscribing = async () => {
  const addresses = await WalletController.getAllAddresses()
  addresses.forEach(address => {
    emitter.emit('subscribe', address)
  })
}

module.exports = {
  processIncomingEthTransaction,
  initSubscribing
}