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
            <label for="model" class="form-label">Model</label>
            <input type="text" v-model="formData.model" class="form-control" id="model" required>
        </div>

        <div class="mb-3">
            <label for="brand" class="form-label">Brand</label>
            <input type="text" v-model="formData.brand" class="form-control" id="brand" required>
        </div>

        <div class="mb-3">
            <label for="year" class="form-label">Year</label>
            <input type="text" v-model="formData.year" class="form-control" id="year" required>
        </div>

        <div class="mb-3">
            <label for="number_plate" class="form-label">Number Plate</label>
            <input type="text" v-model="formData.number_plate" class="form-control" id="number_plate" required>
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</template>

<script>
import axios from '../../../../utils/axios';

export default {
    props: {
        isEditMode: Boolean,
    },
    data() {
        return {
            formData: {
                model: '',
                brand: '',
                year: '',
                number_plate: '',
            },
            loading: false,
            errors: {},
        };
    },
    created() {
        if (this.isEditMode) {
            const vehicleId = this.$route.params.id;
            this.fetchVehicleData(vehicleId);
        }
    },
    methods: {
        getToken() {
            return localStorage.getItem('token');
        },
        async fetchVehicleData(vehicleId) {
            try {
                this.loading = true;
                const response = await axios.get(`/admin/vehicle/${vehicleId}`, {
                    headers: {Authorization: `Bearer ${this.getToken()}`}
                });
                this.formData = response.data.data;
            } catch (error) {
                console.error('Erro ao buscar dados do veículo para edição:', error);
            } finally {
                this.loading = false;
            }
        },
        async submitForm() {
            try {
                const apiEndpoint = this.isEditMode
                    ? `/admin/vehicle/${this.$route.params.id}`
                    : '/admin/vehicle';

                const response = await axios[this.isEditMode ? 'put' : 'post'](apiEndpoint, this.formData, {
                    headers: {Authorization: `Bearer ${this.getToken()}`},
                });
                this.errors = {};
                this.$router.push('/admin/vehicles');
            } catch (error) {
                if (error.response && error.response.data && error.response.data.errors) {
                    this.errors = error.response.data.errors;
                }
                console.error(`Erro ao ${this.isEditMode ? 'atualizar' : 'criar'} veículo:`, error);
            }
        },
    },
};
</script>
