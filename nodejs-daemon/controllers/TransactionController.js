const {Transaction} = require('../models/sequelize')

const createTransaction = (transactionTemplate) => {
	return Transaction.create(transactionTemplate)
}

module.exports = {
	createTransaction
}