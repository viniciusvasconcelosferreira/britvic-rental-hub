<template>
    <div>
        <h1>New Vehicle</h1>
        <VehicleForm :isEditMode="false"/>
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
