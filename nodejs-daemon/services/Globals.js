const events = require('events');

const emitter = new events.EventEmitter();
emitter.defaultMaxListeners = 15;

module.exports = {
  emitter
}