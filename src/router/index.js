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
      },
      {
        path: '/addPolicy',
        name: 'Add Policy',
        component: () => import('@/views/policy/AddPolicy.vue')
      },
      {
        path: '/addProcedures',
        name: 'Add Procedures',
        component: () => import('@/views/procedures/AddProcedures.vue')
      },
      {
        path: '/addWorkInstructions',
        name: 'Add Work Instructions',
        component: () => import('@/views/instruction/AddWorkInstruction.vue')
      },
      {
        path: '/addRecords',
        name: 'Add Records',
        component: () => import('@/views/records/AddRecords.vue')
      },
      {
        path: '/addDepartments',
        name: 'Add Departments',
        component: () => import('@/views/departments/AddDepartments.vue')
      }
    ]
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;
