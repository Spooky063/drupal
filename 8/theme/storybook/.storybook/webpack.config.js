const path = require('path')

module.exports = ({ config }) => {
  config.module.rules.push({
    test: /\.twig$/,
    use: [
      {
        loader: 'twig-loader',
      },
    ],
  })

  return config
}
