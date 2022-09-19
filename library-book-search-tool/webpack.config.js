const MiniCssExtractPlugin = require('mini-css-extract-plugin');
var path = require('path');

// change these variables to fit your project
const jsPath= './src/scripts';
const cssPath = './src/styles';
const gutenbergPath = './src/gutenberg';
const outputPath = 'dist';
const entryPoints = {
  // 'app' is the output name, people commonly use 'bundle'
  // you can have more than 1 entry point
  'bundle': jsPath + '/index.js',
  'gutenberg': gutenbergPath + '/index.js',
};

module.exports = {
  entry: entryPoints,
  output: {
    path: path.resolve(__dirname, `${outputPath}`),
    filename: 'scripts/[name].js',
  },
  plugins: [
    new MiniCssExtractPlugin({
      filename: 'styles/[name].css',
    }),
  ],
  resolve: {
    modules: [__dirname, "src", "node_modules"],
    extensions: ["*", ".js", ".jsx", ".tsx", ".ts", ".scss"],
  },
  module: {
    rules: [
      {
        test: /\.s?[c]ss$/i,
        use: [
          MiniCssExtractPlugin.loader,
          'css-loader',
          'sass-loader',
        ],
      },
      {
        test: /\.sass$/i,
        use: [
          MiniCssExtractPlugin.loader,
          'css-loader',
          {
            loader: 'sass-loader',
            options: {
              sassOptions: { indentedSyntax: true },
            },
          },
        ],
      },
      {
        test: /\.(jpg|jpeg|png|gif|woff|woff2|eot|ttf|svg)$/i,
        use: 'url-loader?limit=1024',
      },
      {
        test: /\.jsx?$/,
        exclude: /node_modules/,
        loader: require.resolve("babel-loader"),
      },
    ]
  },
};