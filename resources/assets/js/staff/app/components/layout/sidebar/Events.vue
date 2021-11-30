<template>
	<div>
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
