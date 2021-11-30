<template>
    <div class="content">
        <div class="row">
            <div class="col-lg-12 col-xl mb-4">
                <div class="block block-rounded block-fx-pop mt-3 mb-0 h-100">
                    <div class="block-content bg-primary h-100">
                        <div class="py-4 px-5">
                            <div class="h2 text-center font-weight-bolder text-white text-uppercase my-1">Cavalry HealthCare - Welcome</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12">
                <div role="group" aria-label="1" class="btn-group btn-block">
                    <router-link class="btn btn-light" :to="{ path: '/compliance/main' }" :class="{ active: currentTab === 'home' }">Dashboard</router-link>
                    <router-link class="btn btn-light" :to="{ path: '/compliance/main/how-to-use' }" :class="{ active: currentTab === 'how-to-use' }">Instructions (How-to)</router-link>
                    <router-link class="btn btn-light" :to="{ path: '/compliance/main/procedures' }" :class="{ active: currentTab === 'procedures' }">Procedures</router-link>
                    <router-link class="btn btn-light" :to="{ path: '/compliance/main/templates' }" :class="{ active: currentTab === 'templates' }">Document Templates</router-link>
                    <router-link class="btn btn-light" :to="{ path: '/compliance/main/checkout' }" :class="{ active: currentTab === 'checkout' }">Upload Files</router-link>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12">
                <div v-if="currentTab === 'home'">
                    <dashboard/>
                </div>
                <div v-if="currentTab === 'how-to-use'">
                    <usage/>
                </div>
                <div v-if="currentTab === 'procedures'">
                    <procedures/>
                </div>
                <div v-if="currentTab === 'templates'">
                    <templates/>
                </div>
                <div v-if="currentTab === 'checkout'">
                    <checkout/>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Dashboard from "./Dashboard/Main.vue";
import Usage from "./HowTo/Main.vue";
import Procedures from "./Procedures/Main.vue";
import Templates from "./Templates/Main.vue";
import Checkout from "./Checkout/Main.vue";

export default {
    computed: {
		currentTab() {
			return this.$route.params.tab || 'home';
		},
    },
    data: function () {
        return {
            routePrefix: "/api/recruitment/applications/",
            tabs: {
                live: ['dashboard', 'how-to-use', 'procedures', 'templates', 'checkout'],
            },
            edit: false,
            disabled: false,
        };
    },
        components: {
            Dashboard,
            Usage,
            Procedures,
            Templates,
            Checkout
    } 
};
</script>