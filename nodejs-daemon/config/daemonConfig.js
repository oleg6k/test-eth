require('dotenv').config()

const DB_OPTIONS = {
  host: process.env.DB_HOST,
  port: process.env.DB_PORT,
  database: process.env.DB_DATABASE,
  user: process.env.DB_USERNAME,
  password: process.env.DB_PASSWORD,
  connection: process.env.DB_CONNECTION,
}

const SEQUELIZE_OPTIONS = {
  dialect: DB_OPTIONS.connection,
  host: DB_OPTIONS.host,
  port: DB_OPTIONS.port,
  logging: false,
  max: 4,
  min: 0,
  idle: 8000,
  define: {
    underscored: true,
    freezeTableName: false,
    charset: 'utf8',
    dialectOptions: {
      collate: 'utf8_general_ci'
    },
    timestamps: false
  },
}

const GETH_OPTIONS = {
  host: process.env.GETH_URL,
  port: process.env.GETH_PORT,
  port_ws: process.env.GETH_PORT_WS,
}

module.exports={
  DB_OPTIONS,
  SEQUELIZE_OPTIONS,
  GETH_OPTIONS
}