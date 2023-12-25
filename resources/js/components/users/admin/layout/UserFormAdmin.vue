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
            <label for="name" class="form-label">Name</label>
            <input type="text" v-model="formData.name" class="form-control" id="name" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" v-model="formData.email" class="form-control" id="email" required>
        </div>

        <div class="mb-3" v-if="!isEditMode">
            <label for="password" class="form-label">Password</label>
            <input type="password" v-model="formData.password" class="form-control" id="password" required>
        </div>

        <div class="mb-3">
            <label for="cpf" class="form-label">CPF</label>
            <input type="text" v-model="formData.cpf" class="form-control" id="cpf" required>
        </div>

        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <select
                class="form-select"
                aria-label="Type"
                id="type"
                v-model="formData.type"
            >
                <option v-for="(type, value) in typeOptions" :key="value" :value="value"
                        :selected="formData.type.includes(value)">
                    {{ type }}
                </option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</template>

<script>
import axios from '../../../../utils/axios';
import UserType from "../../../../enums/UserType";

export default {
    computed: {
        UserType() {
            return UserType
        }
    },
    props: {
        isEditMode: Boolean,
    },
    data() {
        return {
            formData: {
                name: '',
                email: '',
                password: '',
                cpf: '',
                type: '',
            },
            loading: false,
            errors: {},
            typeOptions: {
                employee: 'Employee',
                client: 'Client',
            },
        };
    },
    created() {
        if (this.isEditMode) {
            const userId = this.$route.params.id;
            this.fetchUserData(userId);
        }
    },
    updated() {

    },
    methods: {
        getToken() {
            return localStorage.getItem('token');
        },
        async fetchUserData(userId) {
            try {
                this.loading = true;
                const response = await axios.get(`/admin/user/${userId}`, {
                    headers: {Authorization: `Bearer ${this.getToken()}`}
                });
                this.formData = response.data.data;
            } catch (error) {
                console.error('Erro ao buscar dados do usuário para edição:', error);
            } finally {
                this.loading = false;
            }
        },
        async submitForm() {
            try {
                const apiEndpoint = this.isEditMode
                    ? `/admin/user/${this.$route.params.id}`
                    : '/admin/user';
                this.formData.type = this.formData.type.toUpperCase();
                const response = await axios[this.isEditMode ? 'put' : 'post'](apiEndpoint, this.formData, {
                    headers: {Authorization: `Bearer ${this.getToken()}`},
                });
                this.errors = {};
                this.$router.push('/admin/users');
            } catch (error) {
                if (error.response && error.response.data && error.response.data.errors) {
                    this.errors = error.response.data.errors;
                }
                console.error(`Erro ao ${this.isEditMode ? 'atualizar' : 'criar'} usuário:`, error);
            }
        },
    },
};
</script>
