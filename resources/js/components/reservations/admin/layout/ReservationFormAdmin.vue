<template>
    <div v-if="loading" class="text-center my-4">
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <div v-if="Object.keys(errors).length > 0">
        <ul>
            <li v-for="(errorMessages, field) in errors" :key="field">
                <strong>{{ field }}</strong>
                <ul>
                    <li v-for="message in errorMessages" :key="message">{{ message }}</li>
                </ul>
            </li>
        </ul>
    </div>
    <form @submit.prevent="submitForm">

        <div class="mb-3">
            <label for="date" class="form-label">Select a Date</label>
            <input type="date" v-model="formData.date" class="form-control" id="date" name="datepicker">
        </div>

        <div class="mb-3">
            <label for="user" class="form-label">Select a User</label>
            <select
                class="form-select"
                aria-label="User"
                id="user"
                v-model="formData.user"
                multiple
            >
                <option v-for="user in users" :key="user['id']" :value="user['id']"
                        :selected="formData.user['id'] === user['id']">
                    {{ user['name'] }}
                </option>
            </select>
        </div>

        <div class="mb-3">
            <label for="vehicle" class="form-label">Select a Vehicle</label>
            <select
                class="form-select"
                aria-label="Vehicle"
                id="vehicle"
                v-model="formData.vehicle"
                multiple
            >
                <option v-for="(vehicle,value) in cars" :key="Object.keys(cars)[value-1]"
                        :value="Object.keys(cars)[value-1]"
                        :selected="isContained(vehicleData,vehicle)">
                    {{ vehicle }}
                </option>
            </select>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Select a Status</label>
            <select
                class="form-select"
                aria-label="Status"
                id="status"
                v-model="formData.status"
            >
                <option v-for="(status, value) in statusOptions" :key="value" :value="value"
                        :selected="formData.status.includes(value)">
                    {{ status }}
                </option>
            </select>
        </div>

        <div class="mb-3">
            <label for="additional_information" class="form-label">Additional Information</label>
            <input type="text" name="additional_information" id="additional_information"
                   v-model="formData.additional_information" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</template>

<script>
import axios from '../../../../utils/axios';
import ReservationStatus from "../../../../enums/ReservationStatus";
import {transformData} from "../../../../utils/helpers";

export default {
    computed: {
        ReservationStatus() {
            return ReservationStatus
        }
    },
    props: {
        isEditMode: Boolean,
    },
    data() {
        return {
            formData: {
                date: '',
                user: '',
                vehicle: '',
                status: '',
                additional_information: ''
            },
            loading: false,
            errors: {},
            statusOptions: {
                pending: 'Pendente',
                confirmed: 'Confirmada',
                in_progress: 'Em progresso',
                completed: 'Completa',
                cancelled: 'Cancelada',
            },
            cars: [],
            vehicleData: [],
            users: []
        };
    },
    created() {
        if (this.isEditMode) {
            const reservationId = this.$route.params.id;
            this.fetchReservationData(reservationId);
        }
        this.fetchUsers();
        this.fetchVehicles();
    },
    methods: {
        getToken() {
            return localStorage.getItem('token');
        },
        isContained(vehiclesData, cars) {
            return Object.values(vehiclesData) == cars;
        },
        async fetchReservationData(reservationId) {
            try {
                this.loading = true;
                const response = await axios.get(`/admin/reservation/${reservationId}`, {
                    headers: {Authorization: `Bearer ${this.getToken()}`}
                });
                this.formData = response.data.data;
            } catch (error) {
                console.error('Erro ao buscar dados da reserva para edição:', error);
            } finally {
                this.loading = false;
            }
        },
        async fetchVehicles() {
            try {
                const response = await axios.get(`/admin/vehicles/all`, {
                    headers: {Authorization: `Bearer ${this.getToken()}`}
                });
                this.cars = response.data.data.reduce((acc, item) => {
                    acc[item.id] = `${item.brand} - ${item.model} - ${item.number_plate}`;
                    return acc;
                }, {});
                this.vehicleData = transformData(this.formData.vehicle);
            } catch (error) {
                console.error('Erro ao buscar veiculos cadastrados:', error);
            }
        },
        async fetchUsers() {
            try {
                const response = await axios.get(`/admin/users/all`, {
                    headers: {Authorization: `Bearer ${this.getToken()}`}
                });
                this.users = response.data.data;
            } catch (error) {
                console.error('Erro ao buscar usuários cadastrados:', error);
            }
        },
        async submitForm() {
            try {
                const apiEndpoint = this.isEditMode
                    ? `/admin/reservation/${this.$route.params.id}`
                    : '/reservation';
                const response = await axios[this.isEditMode ? 'put' : 'post'](apiEndpoint, {
                    date: this.formData.date,
                    user_id: this.formData.user[0],
                    vehicle_id: this.formData.vehicle[0],
                    status: this.formData.status,
                    additional_information: this.formData.additional_information
                }, {
                    headers: {Authorization: `Bearer ${this.getToken()}`},
                });
                this.errors = {};
                this.$router.push('/admin/reservations');
            } catch (error) {
                if (error.response && error.response.data && error.response.data.errors) {
                    this.errors = error.response.data.errors;
                }
                console.error(`Erro ao ${this.isEditMode ? 'atualizar' : 'criar'} reserva:`, error);
            }
        },
    }
}
</script>
