import { createRouter, createWebHistory } from '@ionic/vue-router';
import store from '../store/store';
import { IS_USER_AUTHENTICATE_GETTER, GET_USER_TOKEN_GETTER } from '../store/storeconstants';

const Login = () => import( /* webpackChunkName: "Login" */ '../views/Login.vue');
// const Signup = () => import('../views/Signup.vue');
const MainLayout = () => import('../views/MainLayout.vue');

//Admin
import AdminDash from '../views/AdminSide/AdminDashboard.vue'
import AddForm from '../views/AdminSide/forms/AddForm.vue';
import uploadForm from '../views/AdminSide/forms/UploadForm.vue'
import AddPolicy from '../views/AdminSide/policy/AddPolicy.vue';
import AddProcedures from '../views/AdminSide/procedures/AddProcedures.vue';
import AddWorkInstruction from '../views/AdminSide/instruction/AddWorkInstruction.vue';
import AddRecords from '../views/AdminSide/records/AddRecords.vue';
import AddDepartments from '../views/AdminSide/departments/AddDepartments.vue';
import Account from '../views/AdminSide/settin/AccountManagement.vue'
//UserClient
import UserDash from '../views/ClientSide/UserDashboard.vue'
import generalPolicy from '../views/ClientSide/policy/GeneralPolicy.vue'
import departmentPolicy from '../views/ClientSide/policy/DepartmentPolicy.vue'
import UserGenForm from '../views/ClientSide/form/GeneralForms.vue'
import UserDeptForm from '../views/ClientSide/form/DepartmentForms.vue'


const userSide = (props) => [
    {
        path: '',
        name: props + '.dashboard',
        meta: {
            auth: false,
            user: 'user',
            userType: 'user'
        },
        component: UserDash,
    },
    {
        path: 'dashboard',
        name: props + '.dashboard',
        meta: {
            auth: false,
            user: 'user',
            userType: 'user'
        },
        component: UserDash,
    },
    {
        path: 'generalPolicy',
        name: 'General Policy',
        component: generalPolicy,
        meta: {
            auth: false,
            userType: 'user'
        },
    },
    {
        path: 'departmentPolicy',
        name: 'Department Policy',
        component: departmentPolicy,
        meta: {
            auth: false,
            userType: 'user'
        },
    },
    {
        path: 'generalForms',
        name: 'User General Form',
        component: UserGenForm,
        meta: {
            auth: false,
            userType: 'user'
        },
    },
    {
        path: 'departmentForms',
        name: 'User Department Form',
        component: UserDeptForm,
        meta: {
            auth: false,
            userType: 'user'
        },
    },
]

const adminSide = (props) => [
    {
        path: '',
        name: props + '.dashboard',
        meta: {
            auth: false,
            user: 'admin',
            userType: 'admin'
        },
        component: AdminDash,
    },
    {
        path: 'dashboard',
        name: props + '.dashboard',
        meta: {
            auth: false,
            user: 'admin',
            userType: 'admin'
        },
        component: AdminDash
    },
    {
        path: 'addForm',
        name: 'Add Form',
        meta: {
            auth: false,
            user: 'admin',
            userType: 'admin'
        },
        component: AddForm
    },
    {
        path: 'addPolicy',
        name: 'Add Policy',
        meta: {
            auth: false,
            user: 'admin',
            userType: 'admin'
        },
        component: AddPolicy
    },
    {
        path: 'addProcedures',
        name: 'Add Procedures',
        meta: {
            auth: false,
            user: 'admin',
            userType: 'admin'
        },
        component: AddProcedures
    },
    {
        path: 'addWorkInstructions',
        name: 'Add Work Instructions',
        meta: {
            auth: false,
            user: 'admin',
            userType: 'admin'
        },
        component: AddWorkInstruction
    },
    {
        path: 'addRecords',
        name: 'Add Records',
        meta: {
            auth: false,
            user: 'admin',
            userType: 'admin'
        },
        component: AddRecords
    },
    {
        path: 'addDepartments',
        name: 'Add Departments',
        meta: {
            auth: false,
            user: 'admin',
            userType: 'admin'
        },
        component: AddDepartments
    },
    {
        path: 'uploadForm',
        name: 'uploadForm',
        meta: {
            auth: false,
            user: 'admin',
            userType: 'admin'
        },
        component: uploadForm
    },
    {
        path: 'accountManagement',
        name: 'accountManagement',
        meta: {
            auth: false,
            user: 'admin',
            userType: 'admin'
        },
        component: Account
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
// {
//     path: '/signup',
//     name: 'Sign Up',
//     component: Signup,
//     meta: {
//         auth: false,
//         user: 'guest'
//     }
// },
{
    path: '/user',
    component: MainLayout,
    redirect: '/user/dashboard/',
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
    const isToken = store.getters[`auth/${GET_USER_TOKEN_GETTER}`]
    console.log(isToken)
    console.log(isAuth)
    console.log(IS_USER_AUTHENTICATE_GETTER)

    if (to.meta.auth && !isAuth && !isToken) {
        // Redirect unauthenticated users to the login page
        next('/login');
    } else if (to.meta.auth && !isAuth && isToken) {
        // If token is present but not authenticated, attempt to authenticate
        // You may need to dispatch an action to authenticate the user here
    } else if (to.meta.auth && isAuth) {
        // Authenticated user, allow access to the route
        next();
    } else {
        // No authentication required, allow access
        next();
    }
});

export default router;