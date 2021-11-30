<template>
    <div>
        <div v-if="show === 1">
            <dashboard />
        </div>
    </div>
</template>
<script>
import Dashboard from "./Overall";
export default {
    components: {
        Dashboard,
    },
    computed: {
        manager: function () {
            return this.$store.state.system.user.manager == 1 ? true : false;
        },
    },
    data: () => ({
        routePrefix: "/api/dashboard/",
        show: 1,
    }),
};
</script>
