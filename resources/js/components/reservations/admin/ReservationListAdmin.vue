<template>
    <div>
        <div class="d-grid gap-2 d-md-flex justify-content-between">
            <h1>Reservation List (Admin)</h1>
            <router-link class="btn btn-success" type="button" :to="{ name: 'admin-create-reservation' }"
                         style="padding: 0.75rem 0.375rem;">Create
            </router-link>
        </div>
        <div v-if="loading" class="text-center my-4">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <div v-if="reservations.data">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Date</th>
                    <th scope="col">Name</th>
                    <th scope="col">Number Plate</th>
                    <th scope="col">Status</th>
                    <th scope="col">Created at</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="reservation in reservations.data" :key="reservation.id">
                    <td>{{ reservation.id }}</td>
                    <td>{{ formatDate(reservation.date) }}</td>
                    <td>{{ reservation.user.name }}</td>
                    <td>{{ reservation.vehicle.number_plate }}</td>
                    <td>{{ reservation.status }}</td>
                    <td>{{ formatDate(reservation.created_at) }}</td>
                    <td>
                        <div class="d-grid gap-2 d-md-flex">
                            <button @click="editReservation(reservation.id)" class="btn btn-primary" type="button">
                                Edit
                            </button>
                            <button @click="deleteReservation(reservation.id)" class="btn btn-danger" type="button">
                                Delete
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
            <nav v-if="reservations.meta" aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    <li class="page-item" :class="{ 'disabled': reservations.meta.current_page === 1 }">
                        <a class="page-link" @click.prevent="fetchReservationList(1)" href="#">First</a>
                    </li>
                    <li class="page-item" :class="{ 'disabled': !reservations.links.prev }">
                        <a class="page-link" @click.prevent="fetchReservationList(reservations.meta.current_page - 1)"
                           href="#">Previous</a>
                    </li>
                    <li class="page-item disabled">
                            <span class="page-link">Page {{ reservations.meta.current_page }} of {{
                                    reservations.meta.last_page
                                }}</span>
                    </li>
                    <li class="page-item" :class="{ 'disabled': !reservations.links.next }">
                        <a class="page-link" @click.prevent="fetchReservationList(reservations.meta.current_page + 1)"
                           href="#">Next</a>
                    </li>
                    <li class="page-item"
                        :class="{ 'disabled': reservations.meta.current_page === reservations.meta.last_page }">
                        <a class="page-link" @click.prevent="fetchReservationList(reservations.meta.last_page)"
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
import {formatCPF} from '@brazilian-utils/brazilian-utils';
import ReservationStatus from "../../../enums/ReservationStatus";

export default {
    data() {
        return {
            reservations: [],
            loading: false,
        };
    },
    mounted() {
        this.fetchReservationList();
    },
    methods: {
        getToken() {
            return localStorage.getItem('token');
        },
        async fetchReservationList(page = 1) {
            try {
                this.loading = true;
                const response = await axios.get(`/admin/reservation?page=${page}`, {
                    headers: {Authorization: `Bearer ${this.getToken()}`}
                });
                // console.log(response.data);
                this.reservations = response.data;
            } catch (error) {
                console.error('Erro ao buscar reservas:', error);
            } finally {
                this.loading = false;
            }
        },
        formatDate(date) {
            return format(date, 'dd/MM/yyyy');
        },
        formatCpf(cpf) {
            return formatCPF(cpf, {pad: true})
        },
        async editReservation(reservationId) {
            this.$router.push(`/admin/reservations/${reservationId}/edit`);
        },
        async deleteReservation(reservationId) {
            if (confirm('Are you sure you want to delete this user?')) {
                try {
                    await axios.patch(`/admin/reservations/${reservationId}/update-status`, {
                        'status': ReservationStatus.CANCELLED
                    }, {
                        headers: {Authorization: `Bearer ${this.getToken()}`}
                    });
                    this.reservations.data = this.reservations.data.filter(reservation => reservation.id !== reservationId);
                    console.log('Reserva excluída com sucesso!');
                } catch (error) {
                    console.error('Erro ao excluir reserva:', error);
                }
            }
        },
    },
};
</script>
