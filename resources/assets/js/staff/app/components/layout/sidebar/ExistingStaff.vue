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
                <span class="nav-main-link-name">Existing Staff</span>
            </a>
            <ul class="nav-main-submenu pt-0">

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
                        <span class="nav-main-link-name">Head Office</span>
                    </a>
                    <ul class="nav-main-submenu pt-0">
                        <li class="nav-main-item" :class="current_path.includes('/clinical/') ? 'open' : null">
                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
                                <i class="nav-main-link-icon fas fa-user-nurse"></i>
                                <span class="nav-main-link-name">Live Staff</span>
                            </a>
                            <ul class="nav-main-submenu pt-0">
                                <li class="nav-main-item">
                                    <router-link class="nav-main-link" active-class="active" :to="{ name: 'LiveStaffTable' }">
                                        <i class="nav-main-link-icon fas fa-users"></i>
                                        <span class="nav-main-link-name">Portal</span>
                                    </router-link>
                                </li>
                                <li class="nav-main-item">
                                    <router-link class="nav-main-link" active-class="active" :to="{ name: 'PulseRecords' }">
                                        <i class="nav-main-link-icon fas fa-users"></i>
                                        <span class="nav-main-link-name">Pulse</span>
                                    </router-link>
                                </li>
                                <li class="nav-main-item" v-if="!production">
                                    <router-link class="nav-main-link" active-class="active" :to="{ name: 'PDFGenerator' }">
                                        <i class="nav-main-link-icon far fa-file-pdf"></i>
                                        <span class="nav-main-link-name">PDF Generator</span>
                                        <span class="badge badge-primary">NEW!</span>
                                    </router-link>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-main-item" :class="current_path.includes('/booking/') ? 'open' : null">
                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                                <i class="nav-main-link-icon fas fa-calendar-alt"></i>
                                <span class="nav-main-link-name">Events</span>
                            </a>
                            <ul class="nav-main-submenu pt-0">
                                <li class="nav-main-item" :class="current_path.includes('/booking/') ? 'open' : null">
                                    <router-link class="nav-main-link" active-class="active" :to="{ name: 'InductionDashboard' }">
                                        <i class="nav-main-link-icon fas fa-calendar-alt"></i>
                                        <span class="nav-main-link-name">Induction</span>
                                    </router-link>
                                </li>
                                <li class="nav-main-item" :class="current_path.includes('/booking/') ? 'open' : null">
                                    <router-link class="nav-main-link" active-class="active" :to="{ name: 'TrainingDashboard' }">
                                        <i class="nav-main-link-icon fas fa-chalkboard-teacher"></i>
                                        <span class="nav-main-link-name">Training</span>
                                    </router-link>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
<!-- add from here -->
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
                        <span class="nav-main-link-name">DBS</span>
                    </a>
                    <ul class="nav-main-submenu pt-0">
</ul>
                </li>
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
                        <span class="nav-main-link-name">Nurse Check</span>
                    </a>
                    <ul class="nav-main-submenu pt-0">
                        <li class="nav-main-item open">
                            <router-link
                                class="nav-main-link"
                                active-class="active"
                                :to="{ name: 'VaccinationList' }"
                            >
                                <i class="nav-main-link-icon fas fa-syringe"></i>
                                <span class="nav-main-link-name">Vaccinations</span>
                            </router-link>
                        </li>
                        <li class="nav-main-item open">
                            <router-link
                                class="nav-main-link"
                                active-class="active"
                                :to="{ name: 'PortalResultsTable' }"
                            >
                                <i class="nav-main-link-icon fas fa-viruses"></i>
                                <span class="nav-main-link-name">Covid-19 Tests</span>
                            </router-link>
                        </li>
                    </ul>
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
