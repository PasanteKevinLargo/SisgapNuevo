import Vue from 'vue'
import Router from 'vue-router'
import Meta from 'vue-meta'
import NotFound from '@/components/NotFound'

import globals from '@/globals'

// Layouts
import Layout1 from '@/layout/Layout1'

Vue.use(Router)
Vue.use(Meta)

const router = new Router({
  base: '/',
  mode: 'history',
  routes: [{
    path: '/',
    component: Layout1,
    children: [{
      path: 'home',
      component: () => import('@/components/Home')
    }, {
      path: 'proyecto',
      component: () => import('@/components/01Proyecto')
    },{
      path: 'oficio',
      component: () => import('@/components/10Oficio')
    },{
      path: 'retenciones',
      component: () => import('@/components/Documentos/Retenciones')
    },{
      path: 'retencionespro',
      component: () => import('@/components/Documentos/RetencionesPro')
    },{
      path: 'notadebito',
      component: () => import('@/components/Documentos/Notadebito')
    },{
      path: 'notadebitopro',
      component: () => import('@/components/Documentos/NotadebitoPro')
    },{
      path: 'notacredito',
      component: () => import('@/components/Documentos/Notacredito')
    },{
      path: 'notacreditopro',
      component: () => import('@/components/Documentos/NotacreditoPro')
    },{
      path: 'guiasremision',
      component: () => import('@/components/Documentos/Guiasremision')
    },{
      path: 'guiasremisionpro',
      component: () => import('@/components/Documentos/GuiasremisionPro')
    },{
      path: 'liquidaciones',
      component: () => import('@/components/Documentos/Liquidaciones')
    },{
      path: 'liquidacionespro',
      component: () => import('@/components/Documentos/LiquidacionesPro')
    },{
      path: 'User',
      component: () => import('@/components/Documentos/User')
    },{
      path: 'contratos',
      component: () => import('@/components/Contratos')
    },{
      path: 'facturacion',
      component: () => import('@/components/Facturacion')
    },{
      path: 'usuariosweb',
      component: () => import('@/components/Usuarioweb')
    },{
      path: 'datos',
      component: () => import('@/components/DatosUsuario')
    }]
  }, {
    // 404 Not Found page
    path: '*',
    component: NotFound
  }, ]
})

router.afterEach(() => {
  // On small screens collapse sidenav
  if (window.layoutHelpers && window.layoutHelpers.isSmallScreen() && !window.layoutHelpers.isCollapsed()) {
    setTimeout(() => window.layoutHelpers.setCollapsed(true, true), 10)
  }

  // Scroll to top of the page
  globals().scrollTop(0, 0)
})

router.beforeEach((to, from, next) => {
  // Set loading state
  document.body.classList.add('app-loading')

  // Add tiny timeout to finish page transition
  setTimeout(() => next(), 10)
})

export default router
