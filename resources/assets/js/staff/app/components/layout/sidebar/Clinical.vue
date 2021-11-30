<template>
	<div>
		<li
			class="nav-main-item"
			:class="current_path.includes('/clinical/') ? 'open' : null"
		>
			<a
				class="nav-main-link nav-main-link-submenu"
				data-toggle="submenu"
				aria-haspopup="true"
				aria-expanded="false"
				href="#"
			>
				<i class="nav-main-link-icon fas fa-user-nurse"></i>
				<span class="nav-main-link-name">Clinical Staff</span>
			</a>
			<ul class="nav-main-submenu pt-0">
				<li class="nav-main-item">
					<router-link
						class="nav-main-link"
						active-class="active"
						:to="{ name: 'ClinicalStaffDashboard' }"
					>
						<i class="nav-main-link-icon fas fa-th-large"></i>
						<span class="nav-main-link-name">Dashboard</span>
					</router-link>
				</li>
				<li class="nav-main-item">
					<router-link
						class="nav-main-link"
						active-class="active"
						:to="{ name: 'ClinicalStaffTable' }"
					>
						<i class="nav-main-link-icon fas fa-users"></i>
						<span class="nav-main-link-name">Clinical Staff</span>
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
