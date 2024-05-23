import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'список постов',
      component: () => import('@/views/PostsView.vue')
    },
    {
      path: '/post/:id',
      name: 'пост',
      component: () => import('@/views/PostView.vue')
    },
    {
      path: '/create',
      name: 'публикация',
      component: () => import('@/views/CreateView.vue')
    },
    {
      path: '/edit/:id',
      name: 'редактировать пост',
      component: () => import('@/views/EditView.vue')
    },
  ]
})

export default router
