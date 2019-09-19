const Sequelize = require('sequelize')

const configAPI = require('../config/daemonConfig')
const TransactionModel = require('./sequelizeModels/Transaction')
const WalletModel = require('./sequelizeModels/Wallet')


const createSequelize = () => {
	return new Sequelize(
		configAPI.DB_OPTIONS.database,
		configAPI.DB_OPTIONS.user,
		configAPI.DB_OPTIONS.password,
		configAPI.SEQUELIZE_OPTIONS
	)
}

const sequelize = createSequelize()

const Transaction = TransactionModel(sequelize, Sequelize)
const Wallet = WalletModel(sequelize, Sequelize)

const init = () => {
	return sequelize.sync()
}



module.exports = {
	init,
	Transaction,
	Wallet
}