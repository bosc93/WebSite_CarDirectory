import Vue from 'vue'
import Router from 'vue-router'
import Welcome from '@/components/Welcome'
import ConcessionsList from '@/components/ConcessionsList'
import ErrorNotFound from '@/components/NotFound'
import TemplateDetailsConcession from '@/components/DetailsConcession'

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
      path: '*',
      name: 'error',
      component: ErrorNotFound
    },
    {
      path: '/concessions',
      name: 'Concessions',
      component: ConcessionsList
    },
    {
      path: '/concessions/concessionDynamique', // renseigner la concession de manière dynamique
      name: 'Template',
      component: TemplateDetailsConcession
    }
  ]
})
