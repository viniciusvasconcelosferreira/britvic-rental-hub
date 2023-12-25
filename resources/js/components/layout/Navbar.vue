<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <div class="collapse navbar-collapse">
                <div class="navbar-nav">
                    <router-link exact-active-class="active" :to="homeLink" class="nav-item nav-link">{{
                            homeText
                        }}
                    </router-link>
                    <template v-if="authenticated && userType === 'employee'">
                        <router-link exact-active-class="active" to="/admin/vehicles"
                                     class="nav-item nav-link">Vehicles
                        </router-link>
                        <router-link exact-active-class="active" to="/admin/users" class="nav-item nav-link">Users
                        </router-link>
                        <router-link exact-active-class="active" to="/admin/reservations" class="nav-item nav-link">
                            Reservation
                        </router-link>
                    </template>
                    <template v-if="authenticated && userType === 'client'">
                        <router-link exact-active-class="active" to="/reservations" class="nav-item nav-link">
                            My Reservations
                        </router-link>
                    </template>
                </div>
            </div>
            <div class="text-end">
                <template v-if="!authenticated">
                    <router-link v-if="loginLink" exact-active-class="active" :to="loginLink"
                                 class="btn btn-outline-light me-2">Login
                    </router-link>
                </template>
                <template v-else>
                    <span class="text-light me-2">{{ userName }}</span>
                    <button @click="logout" class="btn btn-outline-light">Logout</button>
                </template>
            </div>
        </div>
    </nav>
</template>

<script>
export default {
    props: {
        authenticated: Boolean,
        userName: String,
        userType: String,
    },
    computed: {
        homeLink() {
            return this.userType === 'employee' ? '/admin' : '/';
        },
        homeText() {
            return this.userType === 'employee' ? 'Admin Home' : 'Home';
        },
        loginLink() {
            return this.userType === 'client' ? '/login' : '/admin/login';
        },
    },
    methods: {
        logout() {
            localStorage.removeItem('token');

            this.$router.push('/');

            this.authenticated = false;
        },
    },
};
</script>
