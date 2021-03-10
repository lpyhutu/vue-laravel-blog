import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'

Vue.use(VueRouter)
const routerPush = VueRouter.prototype.push
VueRouter.prototype.push = function push(location) {
  return routerPush.call(this, location).catch(error => error)
}

const routes = [{
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/message',
    name: 'Message',
    component: () => import('@/views/Message.vue'),
    meta: {
      level: 1
    }
  },
  {
    path: '/link',
    name: 'Link',
    component: () => import('@/views/Link.vue'),
    meta: {
      level: 1
    }
  },
  {
    path: '/about',
    name: 'About',
    component: () => import('@/views/About.vue'),
    meta: {
      level: 1
    }
  },
  {
    path: '/detail/:id',
    name: 'Detail',
    component: () => import('@/views/Detail.vue'),
    meta: {
      level: 1
    }
  },
  {
    path: '/search/:title',
    name: 'Search',
    component: () => import('@/views/Search.vue'),
    meta: {
      level: 1
    }
  }, {
    path: '/experiment',
    name: 'Experiment',
    component: () => import('@/views/Experiment.vue'),
    meta: {
      level: 1
    },
  }, {
    path: '/discoloration',
    name: 'Discoloration',
    component: () => import('@/views/Discoloration.vue'),
    meta: {
      level: 2
    },
  }, {
    path: '/discoloration/ordinary',
    name: 'DiscolorationOrdinary',
    component: () => import('@/views/DiscolorationOrdinary.vue'),
    meta: {
      level: 2
    },
  }, {
    path: '/discoloration/advanced',
    name: 'DiscolorationAdvanced',
    component: () => import('@/views/DiscolorationAdvanced.vue'),
    meta: {
      level: 2
    },
  },

]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router