import { createRouter, createWebHistory } from '@ionic/vue-router';
import store from '../store/store';
import { IS_USER_AUTHENTICATE_GETTER } from '../store/storeconstants';

const Login = () => import( /* webpackChunkName: "Login" */ '../views/Login.vue');
const Signup = () => import('../views/Signup.vue');
const MainLayout = () => import('../views/MainLayout.vue');
const Dashboard = () => import('../views/Dashboard.vue');
const AddForm = () => import('../views/forms/AddForm.vue');
import AddPolicy from '../views/policy/AddPolicy.vue';
import AddProcedures from '../views/procedures/AddProcedures.vue';
import AddWorkInstruction from '../views/instruction/AddWorkInstruction.vue';
import AddRecords from '../views/records/AddRecords.vue';
import AddDepartments from '../views/departments/AddDepartments.vue';
import UserDash from '../views/ClientSide/UserDashboard.vue'
import UserPolicy from '../views/ClientSide/policy/Policy.vue'
import UserGenForm from '../views/ClientSide/form/GeneralForms.vue'
import UserDeptForm from '../views/ClientSide/form/DepartmentForms.vue'

const userSide = (props) => [
    { 
        path: '', 
        name: props + '.dashboard',
        meta: {
            auth: true,
            user: 'user',
            userType: 'user'
        },
        component: UserDash,
    },
    {
        path: 'dashboard',
        name: props + '.dashboard',
        meta: {
            auth: true,
            user: 'user',
            userType: 'user'
        },
        component: UserDash,
    },
    {
        path: 'policy',
        name: 'User Policy',
        component: UserPolicy,
        meta: {
            auth: true,
            userType: 'user'
        },
    },
    {
        path: 'generalForms',
        name: 'User General Form',
        component: UserGenForm,
        meta: {
            auth: true,
            userType: 'user'
        },
    },
    {
        path: 'departmentForms',
        name: 'User Department Form',
        component: UserDeptForm,
        meta: {
            auth: true,
            userType: 'user'
        },
    },
]

const adminSide = (props) => [
    {
        path: '',
        name: props + '.dashboard',
        meta: {
            auth: true,
            user: 'admin',
            userType: 'admin'
        },
        component: Dashboard,
    },
    {
        path: 'dashboard',
        name: props + '.dashboard',
        meta: {
            auth: true,
            user: 'admin',
            userType: 'admin'
        },
        component: Dashboard
    },
    {
        path: 'addForm',
        name: 'Add Form',
        meta: {
            auth: true,
            user: 'admin',
            userType: 'admin'
        },
        component: AddForm
    },
    {
        path: 'addPolicy',
        name: 'Add Policy',
        meta: {
            auth: true,
            user: 'admin',
            userType: 'admin'
        },
        component: AddPolicy
    },
    {
        path: 'addProcedures',
        name: 'Add Procedures',
        meta: {
            auth: true,
            user: 'admin',
            userType: 'admin'
        },
        component: AddProcedures
    },
    {
        path: 'addWorkInstructions',
        name: 'Add Work Instructions',
        meta: {
            auth: true,
            user: 'admin',
            userType: 'admin'
        },
        component: AddWorkInstruction
    },
    {
        path: 'addRecords',
        name: 'Add Records',
        meta: {
            auth: true,
            user: 'admin',
            userType: 'admin'
        },
        component: AddRecords
    },
    {
        path: 'addDepartments',
        name: 'Add Departments',
        meta: {
            auth: true,
            user: 'admin',
            userType: 'admin'
        },
        component: AddDepartments
    }
]

const routes = [{
        path: '',
        redirect: '/login'
    },
    {
        path: '/login',
        name: 'Login',
        component: Login,
        meta: {
            auth: false,
            user: 'guest'
        }
    },
    {
        path: '/signup',
        component: Signup,
        meta: {
            auth: false,
            user: 'guest'
        }
    },
    {
        path: '/user',
        component: MainLayout,
        redirect:'/user/dashboard/',
        children: userSide('user')
    },
    {
        path: '/admin',
        component: MainLayout,
        redirect: '/admin/dashboard',
        children: adminSide('admin')
    },
];

const router = createRouter({
    history: createWebHistory("/"),
    routes,
});
// Middleware
function userMiddleware(to, from, next) {
    // Admin user middleware logic
    // console.log('Applicant user middleware')
    if (to.meta.user !== 'admin') {
        next('/admin/dashboard')
    } else {
        next()
    }
}
// Middleware for client
function clientMiddleware(to, from, next) {
        // Admin user middleware logic
        // console.log('Applicant user middleware')
    if (to.meta.user !== 'user') {
        next('/user/dashboard')
    } else {
        next()
    }
}
router.beforeEach((to, from, next) => {

    // Check if the user is Autheticated
    const isAuth = store.getters[`auth/${IS_USER_AUTHENTICATE_GETTER}`]
    console.log(isAuth)
    console.log(IS_USER_AUTHENTICATE_GETTER)
    /* if (
        'auth' in to.meta &&
        to.meta.auth &&
        !store.getters[`auth/${IS_USER_AUTHENTICATE_GETTER}`]
    ) {
        next('/login');
    } else {
        next();
    } */
        if (isAuth) {
         if (to.meta.user == 'admin')
         {
            userMiddleware(to, from, next)
         }
     } else {
         if (to.meta.user !== 'guest') {
             next('/')
         } else {
             next()
         }
     } 
});

export default router;