<template>
    <div>
        <h1>Edit Reservation</h1>
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
                <input @change="fetchReservations" type="date" v-model="formData.date" class="form-control" id="date"
                       name="datepicker">
            </div>

            <div class="mb-3">
                <label for="vehicle" class="form-label">Select a Vehicle</label>
                <select
                    class="form-select"
                    aria-label="Vehicle"
                    id="vehicle"
                    v-model="formData.vehicle"
                    multiple
                    @change="fetchReservations"
                >
                    <option v-for="(vehicle,value) in cars" :key="Object.keys(cars)[value-1]"
                            :value="Object.keys(cars)[value-1]"
                            :selected="isContained(vehicleData,vehicle)">
                        {{ vehicle }}
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
        <hr>
        <table class="table table-striped">
            <thead>
            <tr>
                <th colspan="3" class="text-center">
                    Reservations for {{ this.formData.date.split('-')[1] }}/{{ this.formData.date.split('-')[0] }}
                </th>
            </tr>
            <tr>
                <th>Date</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="reservation in reservations" :key="reservation.id">
                <td>{{ formatDate(reservation.date) }}</td>
                <td>{{ reservation.status }}</td>
            </tr>
            <tr>
                <td><strong>Total Reservations:</strong></td>
                <td><strong>{{ reservations.length }}</strong></td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import axios from '../../../utils/axios';
import {formatDate, transformData} from "../../../utils/helpers";

export default {
    data() {
        return {
            formData: {
                date: '',
                user: '',
                vehicle: '',
                additional_information: ''
            },
            loading: false,
            errors: {},
            cars: [],
            vehicleData: [],
            reservations: [],
        };
    },
    created() {
        const reservationId = this.$route.params.id;
        this.fetchReservationData(reservationId);
        this.fetchVehicles();
    },
    methods: {
        formatDate,
        getToken() {
            return localStorage.getItem('token');
        },
        isContained(vehiclesData, cars) {
            return Object.values(vehiclesData) == cars;
        },
        async fetchReservationData(reservationId) {
            try {
                this.loading = true;
                const response = await axios.get(`/reservation/${reservationId}`, {
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
        async submitForm() {
            try {
                const response = await axios.put(`/reservation/${this.$route.params.id}`, {
                    date: this.formData.date,
                    vehicle_id: this.formData.vehicle['id'] != null && this.formData.vehicle['id'] !== ' ' ? this.formData.vehicle['id'].join('') : this.formData.vehicle.join(''),
                    additional_information: this.formData.additional_information
                }, {
                    headers: {Authorization: `Bearer ${this.getToken()}`},
                });
                this.errors = {};
                this.$router.push('/reservations');
            } catch (error) {
                if (error.response && error.response.data && error.response.data.errors) {
                    this.errors = error.response.data.errors;
                }
                console.error(`Erro ao atualizar reserva: `, error);
            }
        },
        async fetchReservations() {
            if (this.formData.date) {
                try {
                    this.loading = true;
                    const year = this.formData.date.split('-')[0];
                    const month = this.formData.date.split('-')[1];

                    const response = await axios.get(`/reservation/${this.formData.vehicle['id'] != null && this.formData.vehicle['id'] != ' ' ? this.formData.vehicle['id'].join('') : this.formData.vehicle.join('')}/${month}/${year}`, {
                        headers: {Authorization: `Bearer ${this.getToken()}`}
                    });
                    this.reservations = response.data;
                } catch (error) {
                    console.error('Erro ao buscar reservas:', error);
                } finally {
                    this.loading = false;
                }
            }
        },
    }
}
</script>
