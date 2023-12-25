<template>
    <div>
        <h1>Edit Reservation</h1>
        <ReservationForm :isEditMode="true"/>
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
