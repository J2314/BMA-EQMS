import { createRouter, createWebHistory } from '@ionic/vue-router';
import Dashboard from '../views/Dashboard.vue'

const routes = [
  {
    path: '/',
    name: 'main-layout',
    component: () => import('@/views/MainLayout.vue'),
    children: [
      {
        path: '/dashboard',
        name: 'Dashboard',
        component: Dashboard,
      },
      {
        path: '/addForm',
        name: 'Add Form',
        component: () => import('@/views/forms/AddForm.vue')
      }
    ]
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router
