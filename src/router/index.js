import Vue from 'vue'
import Router from 'vue-router'
import Welcome from '@/components/Welcome'
import List from '@/components/List'
import Details from '@/components/Details'

Vue.use(Router)

export default new Router({
  mode: 'history', // Permet d'enlever le # en fin d'URL
  routes: [
    {
      path: '/',
      name: 'Welcome',
      component: Welcome
    },
    {
      path: '/list',
      name: 'List',
      component: List
    },
    {
      path: '/concession',
      name: 'Details',
      component: Details
    }
  ]
})
