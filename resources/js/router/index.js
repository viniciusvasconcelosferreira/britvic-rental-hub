const VehicleListCustomer = () => import('../components/vehicles/customer/VehicleListCustomer.vue');
const CustomerLogin = () => import('../components/authentication/customer/Login.vue');
const CustomerRegister = () => import('../components/authentication/customer/Register.vue');

const AdminLogin = () => import('../components/authentication/admin/Login.vue');
const AdminRegister = () => import('../components/authentication/admin/Register.vue');
const VehicleListAdmin = () => import('../components/vehicles/admin/VehicleListAdmin.vue');

export const routes = [
    {
        name: 'home',
        path: '/',
        component: VehicleListCustomer
    },
    {
        name: 'customer-login',
        path: '/login',
        component: CustomerLogin
    },
    {
        name: 'customer-register',
        path: '/register',
        component: CustomerRegister
    },
    {
        name: 'admin-login',
        path: '/admin/login',
        component: AdminLogin
    },
    {
        name: 'admin-register',
        path: '/admin/register',
        component: AdminRegister
    },
    {
        name: 'admin-vehicles',
        path: '/admin/vehicles',
        component: VehicleListAdmin
    }
];
