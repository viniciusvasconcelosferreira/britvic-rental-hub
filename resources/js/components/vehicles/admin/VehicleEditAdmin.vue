<template>
    <div>
        <h1>Edit Vehicle</h1>
        <VehicleForm :isEditMode="true"/>
    </div>
</template>

<script>
import VehicleForm from './layout/VehicleFormAdmin';

export default {
    components: {
        VehicleForm,
    },
};
</script>
