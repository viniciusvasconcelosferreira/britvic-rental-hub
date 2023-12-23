const VehicleList = () => import('../components/vehicles/VehicleList.vue');
const Login = () => import('../components/authentication/Login.vue');
const Register = () => import('../components/authentication/Register.vue');

export const routes = [
    {
        name: 'home',
        path: '/',
        component: VehicleList
    },
    {
        name: 'login',
        path: '/login',
        component: Login
    },
    {
        name: 'register',
        path: '/register',
        component: Register
    }
]
