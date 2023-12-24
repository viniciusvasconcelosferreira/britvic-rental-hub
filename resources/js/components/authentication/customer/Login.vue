<template>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Login</div>
                    <div class="card-body">
                        <form @submit.prevent="login">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" v-model="email" class="form-control" id="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" v-model="password" class="form-control" id="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mt-3">
            <p>Don't have an account?
                <router-link to="/register">Register here</router-link>
            </p>
        </div>
    </div>
</template>

<script>
import axios from '../../../utils/axios';

export default {
    data() {
        return {
            email: '',
            password: '',
        };
    },
    methods: {
        async login() {
            try {
                const response = await axios.post('/auth/login', {
                    email: this.email,
                    password: this.password,
                });

                const token = response.data.authorization.token;
                localStorage.setItem('token', token);

                // Emitir o evento de login
                this.emitter.emit('loginSuccess');

                this.$router.push('/');
            } catch (error) {
                console.error('Erro no login:', error);
            }
        },
    },
};
</script>
