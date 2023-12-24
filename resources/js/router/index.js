const VehicleListCustomer = () => import('../components/vehicles/customer/VehicleListCustomer.vue');
const CustomerLogin = () => import('../components/authentication/customer/Login.vue');
const CustomerRegister = () => import('../components/authentication/customer/Register.vue');

const AdminLogin = () => import('../components/authentication/admin/Login.vue');
const AdminRegister = () => import('../components/authentication/admin/Register.vue');
const VehicleListAdmin = () => import('../components/vehicles/admin/VehicleListAdmin.vue');
const VehicleCreateAdmin = () => import('../components/vehicles/admin/VehicleCreateAdmin.vue');
const VehicleEditAdmin = () => import('../components/vehicles/admin/VehicleEditAdmin.vue');
const UserListAdmin = () => import('../components/users/admin/UserListAdmin.vue');
const UserCreateAdmin = () => import('../components/users/admin/UserCreateAdmin.vue');
const UserEditAdmin = () => import('../components/users/admin/UserEditAdmin.vue');
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
    },
    {
        name: 'admin-create-vehicle',
        path: '/admin/vehicles/create',
        component: VehicleCreateAdmin,
    },
    {
        name: 'admin-edit-vehicle',
        path: '/admin/vehicles/:id/edit',
        component: VehicleEditAdmin,
        props: true
    },
    {
        name: 'admin-users',
        path: '/admin/users',
        component: UserListAdmin
    },
    {
        name: 'admin-create-user',
        path: '/admin/users/create',
        component: UserCreateAdmin,
    },
    {
        name: 'admin-edit-user',
        path: '/admin/users/:id/edit',
        component: UserEditAdmin,
        props: true
    },
];
