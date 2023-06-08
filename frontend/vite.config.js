const path = require('path')

export default {
  root: path.resolve(__dirname, 'src'),
  build: {
    target: 'esnext',
    outDir: '../dist'
  },
  server: {
    port: 8080
  }
}
