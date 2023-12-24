<template>
    <main>
        <navbar
            :authenticated="authenticated"
            :userName="userName"
            :userType="userType"
        ></navbar>
        <div class="container mt-5">
            <router-view></router-view>
        </div>
    </main>
</template>

<script>
import axios from '../utils/axios';
import Navbar from "./layout/Navbar.vue";

export default {
    components: {
        Navbar,
    },
    data() {
        return {
            authenticated: false,
            userName: '',
            userType: 'client'
        };
    },
    created() {
        this.checkAuthentication();
        // Ouvir o evento de login
        this.emitter.on('loginSuccess', this.fetchUserData);
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
            if (this.authenticated) {
                const token = localStorage.getItem('token');
                try {
                    const response = await axios.get('/user', {
                        headers: {Authorization: `Bearer ${token}`}
                    });
                    this.userName = response.data.name;
                    this.userType = response.data.groups;
                } catch (error) {
                    console.error('Erro ao buscar informações do usuário:', error);
                }
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
