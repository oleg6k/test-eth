const {Wallet} = require('../models/sequelize')

const getAllAddresses = async () => {
  return Wallet.getAllAddresses()
}

const getWalletByAddress = async (address) => {
  return Wallet.getWalletByAddress(address)
}


module.exports = {
  getAllAddresses,
  getWalletByAddress
}