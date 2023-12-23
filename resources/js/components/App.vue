<template>
    <main>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <div class="collapse navbar-collapse">
                    <div class="navbar-nav">
                        <router-link exact-active-class="active" to="/" class="nav-item nav-link">Home</router-link>
                    </div>
                </div>
                <div class="text-end">
                    <template v-if="!authenticated">
                        <router-link exact-active-class="active" to="/login" class="btn btn-outline-light me-2">Login
                        </router-link>
                    </template>
                    <template v-else>
                        <span class="text-light me-2">{{ userName }}</span>
                        <button @click="logout" class="btn btn-outline-light">Logout</button>
                    </template>
                </div>
            </div>
        </nav>
        <div class="container mt-5">
            <router-view></router-view>
        </div>
    </main>
</template>

<script>
import axios from '../utils/axios';

export default {
    data() {
        return {
            authenticated: false,
            userName: '',
        };
    },
    created() {
        this.checkAuthentication();
    },
    methods: {
        checkAuthentication() {
            const token = localStorage.getItem('token');

            if (token) {
                this.authenticated = true;

                this.fetchUserData();
            } else {
                this.authenticated = false;
            }
        },
        async fetchUserData() {
            try {
                const response = await axios.get('/user');
                this.userName = response.data.name;
            } catch (error) {
                console.error('Erro ao buscar informações do usuário:', error);
            }
        },
        logout() {
            localStorage.removeItem('token');

            this.$router.push('/');

            this.authenticated = false;
        },
    },
};
</script>
