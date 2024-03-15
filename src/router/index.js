import { createRouter, createWebHistory } from '@ionic/vue-router';
import Dashboard from '../views/Dashboard.vue'
import AddForm from '../views/AddForm.vue'

const routes = [
  {
    path: '/dashboard',
    name: 'dashboard',
    component: Dashboard,
    children: [
      {
        path: '/addForm', 
        name: 'addForm',
        component: AddForm,
      },
    ]
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
}); 

export default router
