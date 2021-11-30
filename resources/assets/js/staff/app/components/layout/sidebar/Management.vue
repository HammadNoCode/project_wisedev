<template>
    <div v-if="manager">
        <li class="nav-main-item" :class="current_path.includes('/productivity/') ? 'open' : null">
            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                <i class="nav-main-link-icon fas fa-unlock"></i>
                <span class="nav-main-link-name">Management</span>
            </a>
            <ul class="nav-main-submenu pt-0">
                <li class="nav-main-item">
                    <router-link class="nav-main-link" active-class="active" :to="{ name: 'ManagerStaffAccounts' }">
                        <i class="nav-main-link-icon fa fa-user"></i>
                        <span class="nav-main-link-name">User</span>
                    </router-link>
                </li>
            </ul>
            <ul class="nav-main-submenu pt-0">
                <li class="nav-main-item">
                    <router-link class="nav-main-link" active-class="active" :to="{ name: 'Access' }">
                        <i class="nav-main-link-icon fa fa-user"></i>
                        <span class="nav-main-link-name">User IP Access</span>
                    </router-link>
                </li>
            </ul>
        </li>
    </div>
</template>
<script>
export default {
    computed: {
        manager: function() {
            return this.$store.state.user.manager == 1 ? true : false;
        },
        department: function() {
            return this.$store.state.user.department_array;
        },
        unread_messages: function() {
            return this.$store.state.inbox;
        },
        store_admin: function() {
            return this.$store.state.store_admin;
        },
        current_path: function() {
            return window.location.href;
        },
        production: function() {
            return window.location.href.includes("cavalrycare.co.uk") ? true : false;
        },
    },
};
</script>
