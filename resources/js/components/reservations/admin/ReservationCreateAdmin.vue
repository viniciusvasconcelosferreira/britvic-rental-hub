<template>
    <div>
        <h1>New Reservation</h1>
        <ReservationForm :isEditMode="false"/>
    </div>
</template>

<script>
import ReservationForm from './layout/ReservationFormAdmin.vue';

export default {
    components: {
        ReservationForm,
    },
};
</script>
