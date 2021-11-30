<template>
    <div>
        <li class="nav-main-item" :class="current_path.includes('/compliance/') ? 'open' : null">
            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                <i class="nav-main-link-icon far fa-file-alt"></i>
                <span class="nav-main-link-name">Audits</span>
            </a>
            <ul class="nav-main-submenu pt-0">
                <li class="nav-main-item">
                    <router-link class="nav-main-link" active-class="active" :to="{ name: 'Dashboard' }">
                        <i class="nav-main-link-icon fas fa-th-large"></i>
                        <span class="nav-main-link-name">Dashboard</span>
                    </router-link>
                </li>
                <li class="nav-main-item">
                    <router-link class="nav-main-link" active-class="active" :to="{ name: 'Instruction' }">
                        <i class="nav-main-link-icon fas fa-info-circle"></i>
                        <span class="nav-main-link-name">Instructions</span>
                    </router-link>
                </li>
                <li class="nav-main-item">
                    <router-link class="nav-main-link" active-class="active" :to="{ name: 'Procedure' }">
                        <i class="nav-main-link-icon fas fa-clipboard-list"></i>
                        <span class="nav-main-link-name">Procedures</span>
                    </router-link>
                </li>
                <li class="nav-main-item">
                    <router-link class="nav-main-link" active-class="active" :to="{ name: 'Template' }">
                        <i class="nav-main-link-icon far fa-file"></i>
                        <span class="nav-main-link-name">Audit Management</span>
                    </router-link>
                </li>
                <li class="nav-main-item">
                    <router-link class="nav-main-link" active-class="active" :to="{ name: 'Upload' }">
                        <i class="nav-main-link-icon fas fa-file-upload"></i>
                        <span class="nav-main-link-name">Upload Audit</span>
                    </router-link>
                </li>
                <li class="nav-main-item">
                    <router-link class="nav-main-link" active-class="active" :to="{ name: 'UploadTable' }">
                        <i class="nav-main-link-icon fas fa-check"></i>
                        <span class="nav-main-link-name">Completed Audits</span>
                    </router-link>
                </li>
            </ul>
        </li>
    </div>
</template>
<script>
export default {
    computed: {
        manager: function () {
            return this.$store.state.user.manager == 1 ? true : false;
        },
        department: function () {
            return this.$store.state.user.department_array;
        },
        unread_messages: function () {
            return this.$store.state.inbox;
        },
        store_admin: function () {
            return this.$store.state.store_admin;
        },
        current_path: function () {
            return window.location.href;
        },
        production: function () {
            return window.location.href.includes("cavalrycare.co.uk") ? true : false;
        },
    },
};
</script>
