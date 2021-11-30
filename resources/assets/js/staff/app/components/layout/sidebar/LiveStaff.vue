<template>
	<div>
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
