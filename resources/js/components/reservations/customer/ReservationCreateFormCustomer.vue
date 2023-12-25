<template>
    <div>
        <h1>Create Reservation</h1>
        <div class="alert alert-secondary" role="alert">
            <div class="row">
                <div class="col-4">
                    <strong>Brand: </strong><span>{{ car.brand }}</span>
                </div>
                <div class="col-4">
                    <strong>Model: </strong><span>{{ car.model }}</span>
                </div>
                <div class="col-4">
                    <strong>Year: </strong><span>{{ car.year }}</span>
                </div>
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
            <div class="row">
                <div class="mb-3 col-6">
                    <label for="date" class="form-label">Select a Date</label>
                    <input type="date" v-model="formData.date" class="form-control" id="date" name="datepicker"
                           @change="fetchReservations">
                </div>
                <div class="mb-3 col-6">
                    <label for="additional_information" class="form-label">Additional Information</label>
                    <input type="text" name="additional_information" id="additional_information"
                           v-model="formData.additional_information" class="form-control">
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
        <hr>
        <div v-if="loading" class="text-center my-4">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
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
import {formatDate} from "../../../utils/helpers";

export default {
    data() {
        return {
            formData: {
                additional_information: '',
                date: '',
                vehicle: this.$route.params.id,
            },
            car: [],
            reservations: [],
            loading: false,
            errors: {},
        }
    },
    created() {
        this.fetchVehicle(this.formData.vehicle);
    },
    methods: {
        formatDate,
        getToken() {
            return localStorage.getItem('token');
        },
        async fetchVehicle(vehicleId) {
            try {
                const response = await axios.get(`/vehicle/${vehicleId}`, {
                    headers: {Authorization: `Bearer ${this.getToken()}`}
                });
                this.car = response.data.data;
            } catch (e) {
                console.error('Erro ao buscar dados do veiculo:', e);
            }
        },
        async fetchReservations() {
            if (this.formData.date) {
                try {
                    this.loading = true;
                    const year = this.formData.date.split('-')[0];
                    const month = this.formData.date.split('-')[1];

                    const response = await axios.get(`/reservation/${this.formData.vehicle}/${month}/${year}`, {
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
        async submitForm() {
            try {
                const response = await axios.post(`/reservation`, {
                    vehicle_id: this.formData.vehicle,
                    date: this.formData.date,
                    additional_information: this.formData.additional_information ?? null,
                }, {
                    headers: {Authorization: `Bearer ${this.getToken()}`}
                });
                this.errors = {};
                this.$router.push('/reservations');
            } catch (error) {
                if (error.response && error.response.data && error.response.data.errors) {
                    this.errors = error.response.data.errors;
                }
                console.error(`Erro ao criar reserva:`, error);
            }
        }
    }
}
</script>
