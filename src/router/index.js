import { createRouter, createWebHistory } from '@ionic/vue-router';
import MainLayout from '../views/MainLayout.vue';
import Dashboard from '../views/Dashboard.vue';
import Login from '../views/Login.vue';
import AddForm from '../views/forms/AddForm.vue';
import AddPolicy from '../views/policy/AddPolicy.vue';
import AddProcedures from '../views/procedures/AddProcedures.vue';
import AddWorkInstruction from '../views/instruction/AddWorkInstruction.vue';
import AddRecords from '../views/records/AddRecords.vue';
import AddDepartments from '../views/departments/AddDepartments.vue';

const routes = [
  {
    path: '/',
    redirect: '/login'
  },
  {
    path: '/login',
    name: 'Login',
    component: Login
  },
  {
    path: '/dashboard',
    component: MainLayout,
    children: [
      {
        path: '',
        name: 'Dashboard',
        component: Dashboard,
      },
      {
        path: '/addForm',
        name: 'Add Form',
        component: AddForm
      },
      {
        path: '/addPolicy',
        name: 'Add Policy',
        component: AddPolicy
      },
      {
        path: '/addProcedures',
        name: 'Add Procedures',
        component: AddProcedures
      },
      {
        path: '/addWorkInstructions',
        name: 'Add Work Instructions',
        component: AddWorkInstruction
      },
      {
        path: '/addRecords',
        name: 'Add Records',
        component: AddRecords
      },
      {
        path: '/addDepartments',
        name: 'Add Departments',
        component: AddDepartments
      }
    ]
  },
  {
    path: '/userdashboard',
    name: 'User Dashboard',
    component: () => import('@/views/ClientSide/UserDashboard.vue'),
    children: [
      {
        path: '/forms',
        name: 'Forms',
        component: () => import('@/views/ClientSide/Forms.vue'),
      },
    ]
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;
