import Ads from 'vue-google-adsense'

Vue.use(require('vue-script2'))
Vue.use(Ads.Adsense)

Vue.component('google-map', require('./components/GoogleMapComponent.vue'));

window.packageNameEvent = new Vue();