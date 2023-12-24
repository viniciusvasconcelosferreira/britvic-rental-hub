<template>
    <div>
        <h1>New User</h1>
        <UserForm :isEditMode="false"/>
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
