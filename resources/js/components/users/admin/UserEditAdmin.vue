<template>
    <div>
        <h1>Edit User</h1>
        <UserForm :isEditMode="true"/>
    </div>
</template>

<script>
import UserForm from './layout/UserFormAdmin';

export default {
    components: {
        UserForm,
    },
};
</script>
