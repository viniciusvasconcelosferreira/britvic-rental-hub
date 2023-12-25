<template>
    <div class="container mt-5">
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
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Register</div>
                    <div class="card-body">
                        <form @submit.prevent="register">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" v-model="name" class="form-control" id="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" v-model="email" class="form-control" id="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" v-model="password" class="form-control" id="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="cpf" class="form-label">CPF</label>
                                <input type="text" v-model="cpf" class="form-control" id="cpf" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Register</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mt-3">
            <p>Already have an account?
                <router-link to="/login">Login here</router-link>
            </p>
        </div>
    </div>
</template>

<script>
import axios from '../../../utils/axios';

export default {
    data() {
        return {
            name: '',
            email: '',
            password: '',
            cpf: '',
            errors: {},
        }
    },
    methods: {
        async register() {
            try {
                const response = await axios.post('/auth/register', {
                    name: this.name,
                    email: this.email,
                    password: this.password,
                    cpf: this.cpf
                });

                if (response.data) {
                    const loginResponse = await axios.post('/auth/login', {
                        email: this.email,
                        password: this.password,
                    });

                    const token = loginResponse.data.authorization.token;
                    localStorage.setItem('token', token);
                    this.errors = {};
                    this.$router.push('/').then(() => {
                        window.location.reload();
                    });
                }
            } catch (error) {
                if (error.response && error.response.data && error.response.data.errors) {
                    this.errors = error.response.data.errors;
                }
                console.error('Error registering user:', error);
            }
        }
    }
}
</script>
