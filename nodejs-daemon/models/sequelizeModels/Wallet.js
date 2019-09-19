module.exports = (sequelize, Sequelize) => {
  let Wallet = sequelize.define(
    'wallets',
    {
      id: {
        type: Sequelize.BIGINT,
        autoIncrement: true,
        primaryKey: true,
        unique: true
      },
      address: {
        type: Sequelize.STRING,
        allowNull: false
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

  Wallet.getAllAddresses = ()=>{
      return Wallet.findAll({
        attributes: ['address']
      })
  }

  Wallet.getWalletByAddress = (address)=>{
      return Wallet.findOne({
        where: {
          address:address
        }
      })
  }

  return Wallet
}
