const VehicleList = () => import('../components/vehicles/VehicleList.vue')

export const routes = [
    {
        name: 'home',
        path: '/',
        component: VehicleList
    },
]
