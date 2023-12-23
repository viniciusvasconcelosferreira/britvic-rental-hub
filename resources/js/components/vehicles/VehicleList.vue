<template>
    <div>
        <h1>Vehicle List</h1>
        <div class="container">
            <div v-if="loading" class="text-center my-4">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            <div v-else-if="vehicles.data && vehicles.data.length > 0" class="row row-cols-1 row-cols-md-4 g-4">
                <div v-for="vehicle in vehicles.data" class="col" :key="vehicle.id">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ vehicle.brand }} - {{ vehicle.model }}</h5>
                            <p class="card-text">Ano: {{ vehicle.year }}</p>
                            <p class="card-text">Placa: {{ vehicle.number_plate }}</p>
                            <a href="#" class="btn btn-primary">Reserve</a>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else class="row row-cols-1 row-cols-md-4 g-4">
                <div class="card w-100 text-center">
                    <div class="card-body">
                        <h5 class="card-title">No record found.</h5>
                    </div>
                </div>
            </div>
            <div class="row py-3">
                <nav v-if="vehicles.meta" aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        <li class="page-item" :class="{ 'disabled': vehicles.meta.current_page === 1 }">
                            <a class="page-link" @click.prevent="fetchVehicles(1)" href="#">First</a>
                        </li>
                        <li class="page-item" :class="{ 'disabled': !vehicles.links.prev }">
                            <a class="page-link" @click.prevent="fetchVehicles(vehicles.meta.current_page - 1)"
                               href="#">Previous</a>
                        </li>
                        <li class="page-item disabled">
                            <span class="page-link">Page {{ vehicles.meta.current_page }} of {{
                                    vehicles.meta.last_page
                                }}</span>
                        </li>
                        <li class="page-item" :class="{ 'disabled': !vehicles.links.next }">
                            <a class="page-link" @click.prevent="fetchVehicles(vehicles.meta.current_page + 1)"
                               href="#">Next</a>
                        </li>
                        <li class="page-item"
                            :class="{ 'disabled': vehicles.meta.current_page === vehicles.meta.last_page }">
                            <a class="page-link" @click.prevent="fetchVehicles(vehicles.meta.last_page)"
                               href="#">Last</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</template>

<script>
import axios from '../../utils/axios';

export default {
    data() {
        return {
            vehicles: [],
            loading: false, // Adicionado indicador de carregamento
        };
    },
    mounted() {
        this.fetchVehicles();
    },
    methods: {
        async fetchVehicles(page = 1) {
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
    },
};
</script>
