const Emitters = require('./services/Emitters');

Emitters.init()
Emitters.emitter.emit('initialization')

console.log('Daemon started')