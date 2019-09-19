module.exports = (sequelize, Sequelize) => {
  let Transaction = sequelize.define(
    'transactions',
    {
      id: {
        type: Sequelize.BIGINT,
        autoIncrement: true,
        primaryKey: true,
        unique: true
      },
      wallet_id: {
        type: Sequelize.INTEGER,
        allowNull: false
      },
      txid: {
        type: Sequelize.STRING,
        allowNull: false
      },
      amount: {
        type: Sequelize.FLOAT,
        allowNull: false
      },
      confirmations: {
        type: Sequelize.INTEGER,
        allowNull: true
      },
      created_at: {
        type: Sequelize.DATE,
        defaultValue: new Date()
      },
      updated_at: {
        type: Sequelize.DATE,
        defaultValue: new Date()
      },
    },
    {
      sequelize,
      underscored: true
    }
  )

  return Transaction
}
