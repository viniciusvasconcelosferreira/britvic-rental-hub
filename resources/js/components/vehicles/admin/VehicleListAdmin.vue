<template>
    <div>
        <div class="d-grid gap-2 d-md-flex justify-content-between">
            <h1>Vehicle List (Admin)</h1>
            <router-link class="btn btn-success" type="button" :to="{ name: 'admin-create-vehicle' }"
                         style="padding: 0.75rem 0.375rem;">Create
            </router-link>
        </div>
        <div v-if="loading" class="text-center my-4">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <div v-if="vehicles.data">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Brand</th>
                    <th scope="col">Model</th>
                    <th scope="col">Year</th>
                    <th scope="col">Number Plate</th>
                    <th scope="col">Added by</th>
                    <th scope="col">Created at</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="vehicle in vehicles.data" :key="vehicle.id">
                    <td>{{ vehicle.id }}</td>
                    <td>{{ vehicle.brand }}</td>
                    <td>{{ vehicle.model }}</td>
                    <td>{{ vehicle.year }}</td>
                    <td>{{ vehicle.number_plate }}</td>
                    <td v-if="vehicle.user">{{ vehicle.user.name }}</td>
                    <td v-else>--</td>
                    <td>{{ formatDate(vehicle.created_at) }}</td>
                    <td>
                        <div class="d-grid gap-2 d-md-flex">
                            <button @click="editVehicle(vehicle.id)" class="btn btn-primary" type="button">Edit</button>
                            <button @click="deleteVehicle(vehicle.id)" class="btn btn-danger" type="button">Delete
                            </button>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div v-else>
            <p>No record found.</p>
        </div>
        <div class="row py-3">
            <nav v-if="vehicles.meta" aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    <li class="page-item" :class="{ 'disabled': vehicles.meta.current_page === 1 }">
                        <a class="page-link" @click.prevent="fetchVehicleList(1)" href="#">First</a>
                    </li>
                    <li class="page-item" :class="{ 'disabled': !vehicles.links.prev }">
                        <a class="page-link" @click.prevent="fetchVehicleList(vehicles.meta.current_page - 1)"
                           href="#">Previous</a>
                    </li>
                    <li class="page-item disabled">
                            <span class="page-link">Page {{ vehicles.meta.current_page }} of {{
                                    vehicles.meta.last_page
                                }}</span>
                    </li>
                    <li class="page-item" :class="{ 'disabled': !vehicles.links.next }">
                        <a class="page-link" @click.prevent="fetchVehicleList(vehicles.meta.current_page + 1)"
                           href="#">Next</a>
                    </li>
                    <li class="page-item"
                        :class="{ 'disabled': vehicles.meta.current_page === vehicles.meta.last_page }">
                        <a class="page-link" @click.prevent="fetchVehicleList(vehicles.meta.last_page)"
                           href="#">Last</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</template>

<script>
import axios from '../../../utils/axios';
import {format} from "date-fns";

export default {
    data() {
        return {
            vehicles: [],
            loading: false,
        };
    },
    mounted() {
        this.fetchVehicleList();
    },
    methods: {
        getToken() {
            return localStorage.getItem('token');
        },
        async fetchVehicleList(page = 1) {
            try {
                this.loading = true;
                const response = await axios.get(`/vehicle?page=${page}`);
                this.vehicles = response.data;
            } catch (error) {
                console.error('Erro ao buscar veículos:', error);
            } finally {
                this.loading = false;
            }
        },
        formatDate(date) {
            return format(date, 'dd/MM/yyyy');
        },
        async editVehicle(vehicleId) {
            this.$router.push(`/admin/vehicles/${vehicleId}/edit`);
        },
        async deleteVehicle(vehicleId) {
            if (confirm('Are you sure you want to delete this vehicle?')) {
                try {
                    await axios.delete(`/admin/vehicle/${vehicleId}`, {
                        headers: {Authorization: `Bearer ${this.getToken()}`}
                    });
                    this.vehicles.data = this.vehicles.data.filter(vehicle => vehicle.id !== vehicleId);
                    console.log('Veículo excluído com sucesso!');
                } catch (error) {
                    console.error('Erro ao excluir veículo:', error);
                }
            }
        },
    },
};
</script>
