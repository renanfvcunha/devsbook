const path = require('path');

module.exports = [
  {
    entry: './src/js/main/main.js',
    output: {
        path: path.resolve(__dirname, 'public', 'assets', 'js'),
        filename: 'main.js'
    }
  },
  {
    entry: './src/js/signin/signin.js',
    output: {
        path: path.resolve(__dirname, 'public', 'assets', 'js'),
        filename: 'signin.js'
    }
  },
  {
    entry: './src/js/signup/signup.js',
    output: {
        path: path.resolve(__dirname, 'public', 'assets', 'js'),
        filename: 'signup.js'
    }
  }
];
