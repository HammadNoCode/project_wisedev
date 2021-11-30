<template>
    <div>
        <li
            class="nav-main-item open"
            :class="current_path.includes('/application/') ? 'open' : null"
        >
            <a
                class="nav-main-link nav-main-link-submenu"
                data-toggle="submenu"
                aria-haspopup="true"
                aria-expanded="true"
                href="#"
            >
                <i class="nav-main-link-icon far fa-file-alt"></i>
                <span class="nav-main-link-name">Settings</span>
            </a>
            <ul class="nav-main-submenu pt-0">
                <li class="nav-main-item">
                    <router-link
                        class="nav-main-link"
                        active-class="active"
                        :to="{ name: 'ContactSupport' }"
                    >
                        <i class="nav-main-link-icon fas fa-ticket-alt"></i>
                        <span class="nav-main-link-name">Create a Ticket</span>
                    </router-link>
                </li>
                <li class="nav-main-item">
                    <router-link
                        class="nav-main-link"
                        active-class="active"
                        :to="{ name: 'MassEmails' }"
                    >
                        <i class="nav-main-link-icon fas fa-envelope-open-text"></i>
                        <span class="nav-main-link-name">Mass Emails</span>
                        <span class="badge badge-primary">NEW!</span>
                    </router-link>
                    <router-link
                        class="nav-main-link"
                        active-class="active"
                        :to="{ name: 'MassSms' }"
                    >
                        <i class="nav-main-link-icon fas fa-sms"></i>
                        <span class="nav-main-link-name">Mass SMS</span>
                    </router-link>
                </li>
                <li class="nav-main-item">
                    <router-link
                        class="nav-main-link"
                        active-class="active"
                        :to="{ name: 'SmsTemplate' }"
                    >
                        <i class="nav-main-link-icon fas fa-file-alt"></i>
                        <span class="nav-main-link-name">SMS Templates</span>
                    </router-link>
                </li>
                <li class="nav-main-item">
                    <router-link
                        class="nav-main-link"
                        active-class="active"
                        :to="{ name: 'smslog' }"
                    >
                        <i class="nav-main-link-icon fas fa-file-contract"></i>
                        <span class="nav-main-link-name">SMS Log</span>
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
