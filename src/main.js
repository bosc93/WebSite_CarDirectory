// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import App from './App'
import router from './router'
import * as VueGoogleMaps from 'vue2-google-maps'
import VueResource from 'vue-resource'
import VueCarousel from 'vue-carousel'

Vue.config.productionTip = false
Vue.use(BootstrapVue)
Vue.use(VueResource)
Vue.use(VueCarousel)

Vue.use(VueGoogleMaps, {
  load: {
    key: 'AIzaSyDHecluKDprEeKSbk3WkCLHjEUEa6CNXmg',
    libraries: 'places' // necessary for places input
  }
})

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  components: { App },
  template: '<App/>'
})
