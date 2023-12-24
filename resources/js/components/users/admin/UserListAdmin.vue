<template>
    <div>
        <div class="d-grid gap-2 d-md-flex justify-content-between">
            <h1>User List (Admin)</h1>
            <router-link class="btn btn-success" type="button" :to="{ name: 'admin-create-user' }"
                         style="padding: 0.75rem 0.375rem;">Create
            </router-link>
        </div>
        <div v-if="loading" class="text-center my-4">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <div v-if="users.data">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">CPF</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Groups</th>
                    <th scope="col">Created at</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="user in users.data" :key="user.id">
                    <td>{{ user.id }}</td>
                    <td>{{ formatCpf(user.cpf) }}</td>
                    <td>{{ user.name }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ user.groups }}</td>
                    <td>{{ formatDate(user.created_at) }}</td>
                    <td>
                        <div class="d-grid gap-2 d-md-flex">
                            <button @click="editUser(user.id)" class="btn btn-primary" type="button">Edit</button>
                            <button @click="deleteUser(user.id)" class="btn btn-danger" type="button">Delete
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
            <nav v-if="users.meta" aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    <li class="page-item" :class="{ 'disabled': users.meta.current_page === 1 }">
                        <a class="page-link" @click.prevent="fetchUserList(1)" href="#">First</a>
                    </li>
                    <li class="page-item" :class="{ 'disabled': !users.links.prev }">
                        <a class="page-link" @click.prevent="fetchUserList(users.meta.current_page - 1)"
                           href="#">Previous</a>
                    </li>
                    <li class="page-item disabled">
                            <span class="page-link">Page {{ users.meta.current_page }} of {{
                                    users.meta.last_page
                                }}</span>
                    </li>
                    <li class="page-item" :class="{ 'disabled': !users.links.next }">
                        <a class="page-link" @click.prevent="fetchUserList(users.meta.current_page + 1)"
                           href="#">Next</a>
                    </li>
                    <li class="page-item"
                        :class="{ 'disabled': users.meta.current_page === users.meta.last_page }">
                        <a class="page-link" @click.prevent="fetchUserList(users.meta.last_page)"
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

export default {
    data() {
        return {
            users: [],
            loading: false,
        };
    },
    mounted() {
        this.fetchUserList();
    },
    methods: {
        getToken() {
            return localStorage.getItem('token');
        },
        async fetchUserList(page = 1) {
            try {
                this.loading = true;
                const response = await axios.get(`/admin/user?page=${page}`, {
                    headers: {Authorization: `Bearer ${this.getToken()}`}
                });
                this.users = response.data;
            } catch (error) {
                console.error('Erro ao buscar usuários:', error);
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
        async editUser(userId) {
            this.$router.push(`/admin/users/${userId}/edit`);
        },
        async deleteUser(userId) {
            if (confirm('Are you sure you want to delete this user?')) {
                try {
                    await axios.delete(`/admin/user/${userId}`, {
                        headers: {Authorization: `Bearer ${this.getToken()}`}
                    });
                    this.users.data = this.users.data.filter(user => user.id !== userId);
                    console.log('Usuário excluído com sucesso!');
                } catch (error) {
                    console.error('Erro ao excluir usuário:', error);
                }
            }
        },
    },
};
</script>
