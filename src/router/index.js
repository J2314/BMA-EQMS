import { createRouter, createWebHistory } from '@ionic/vue-router';
import MainLayout from '../views/MainLayout.vue';
import Dashboard from '../views/Dashboard.vue';

const routes = [
  {
    path: '/',
    redirect: '/dashboard',
    component: MainLayout,
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
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;
