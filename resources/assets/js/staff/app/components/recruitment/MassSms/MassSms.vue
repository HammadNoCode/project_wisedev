<template>
    <div class="content">
        <div class="row pt-3">
            <div class="col-12">
                <h3 class="mb-0">Mass SMS</h3>
            </div>
        </div>

        <div class="row py-3" style="display: flex">
            <div class="col-12 pt-3">
                <div
                    class="block block-rounded block-bordered"
                    style="height: 100%; width: 100%"
                >
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Data Filters</h3>
                    </div>
                    <div class="block-content p-0 py-2">
                        <filters />
                    </div>
                </div>
            </div>
        </div>

        <div class="row py-3">
            <div class="col-12">
                <datatable />
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <button class="btn btn-primary w-100 py-3" @click="sendSms">
                    <h4 class="text-white mb-0">
                        <i class="fas fa-paper-plane pr-2"></i>Send SMS
                    </h4>
                </button>
            </div>
        </div>
    </div>
</template>
<script>
import Filters from "./components/Filters.vue";
import Datatable from "./components/Datatables.vue";

export default {
    components: {
        Filters,
        Datatable,
    },
    computed: {
        format_number: function () {
            return this.$root.format_number;
        },
        filters: {
            get() {
                return this.$store.state.sms.filters;
            },
            set(newVal) {
                return (this.$store.state.sms.filters = newVal);
            },
        },
        datatable: {
            get() {
                return this.$store.state.sms.datatable;
            },
            set(newVal) {
                return (this.$store.state.sms.datatble = newVal);
            },
        },
        roles: function () {
            return this.$store.state.sms.roles;
        },
        loaded: {
            get() {
                return this.$store.state.sms.loaded;
            },
            set(newVal) {
                return (this.$store.state.sms.loaded = newVal);
            },
        },
        smsParams: {
            get() {
                return this.$store.state.sms.smsParams;
            },
            set(newVal) {
                return (this.$store.state.sms.smsParams = newVal);
            },
        },
    },
    watch: {
        filters: {
            deep: true,
            handler: function (val) {
                this.$store.dispatch("sms/getData", {
                    filters: this.filters,
                });
            },
        },
    },
    mounted() {
        this.getData();
    },
    methods: {
        async getData() {
            await this.$store
                .dispatch("sms/getData", {
                    filters: this.filters,
                })
                .then((res) => {
                    this.loaded = true;
                });
        },
        async sendSms() {
            await this.$store
                .dispatch("sms/sendSms", {
                    filters: this.filters,
                })
                .then((res) => {
                    const dt = this.$store.state.sms.res;

                    this.$root.notification(dt.data.message, "success");
                })
            .catch(error => {
                const dt_err = this.$store.state.sms.error.response;

                this.$root.notification(dt_err.data.message, "error");
            });

        },
    },
};
</script>
