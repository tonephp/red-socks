const path = require('path');

module.exports = {
  entry: {
      app: ['./app/src/app.js'],
  },
  output: {
    filename: '[name].js',
    path: path.resolve(__dirname, 'public/dist'),
  },
  module: {
    rules: [
      {
        test: /\.s[ac]ss$/i,
        use: [
          {
            loader: 'file-loader',
            options: {
                outputPath: '../dist',
                name: '[name].css',
            },
          },
          "sass-loader",
        ],
      },
    ],
  }
};