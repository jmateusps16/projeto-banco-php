const RandomNumber = function (min, max) {
    return Math.floor(Math.random() * (max - min + 1) + min);
}

const Guid = function () {
    const parts = [
        [0,0,0,0].map(a => RandomNumber(0,255)).map(a => `000${a.toString('16')}`.slice(-2)),
        [0,0].map(a => RandomNumber(0,255)).map(a => `000${a.toString('16')}`.slice(-2)),
        [0,0].map(a => RandomNumber(0,255)).map(a => `000${a.toString('16')}`.slice(-2)),
        [0,0].map(a => RandomNumber(0,255)).map(a => `000${a.toString('16')}`.slice(-2)),
        [0,0,0,0,0,0].map(a => RandomNumber(0,255)).map(a => `000${a.toString('16')}`.slice(-2)),
    ];

    return parts.map(a => a.join('')).join('-');
}

const inputFloat = function (event = new InputEvent()) {
    const valor = event.target.value;
    const [decimal, ...float] = valor.replace(/\,/g, '.')
        .split('')
        .filter(a => /\d|\./g.test(a))
        .join('')
        .split('.');

    const decimalValue = parseInt(decimal) || 0;
    const floatValue = parseInt(float.join('')) || 0;

    event.target.value = float.length > 0 ? `${decimalValue}.${floatValue}`: `${decimalValue}`;
}

const inputInt = function (event = new InputEvent()) {
    event.target.value = event.target.value.split('').filter(a => /\d/.test(a)).join('');
}