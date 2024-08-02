import { Centrifuge } from 'centrifuge';

const centrifugo = new Centrifuge('wss://centrifugo.whycat.space/connection/websocket', {
    debug: true,
});

centrifugo.on('connect', () => {
    console.log('Connected to Centrifugo');
});

centrifugo.on('disconnect', () => {
    console.log('Disconnected from Centrifugo');
});

centrifugo.on('error', (err) => {
    console.error('Centrifugo error:', err);
});

export default centrifugo;
