<template>
	<div>
		<li class="nav-main-item open">
			<a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
				<i class="nav-main-link-icon fas fa-dollar-sign"></i>
				<span class="nav-main-link-name">Business</span>
			</a>
			<ul class="nav-main-submenu">
				<li class="nav-main-item">
					<router-link class="nav-main-link" active-class="active" :to="{ name: 'ClientsTable' }">
						<i class="nav-main-link-icon fas fa-home"></i>
						<span class="nav-main-link-name">Carehomes</span>
					</router-link>
					<!-- <router-link class="nav-main-link" active-class="active" :to="{ name: 'ClientForm' }">
						<i class="nav-main-link-icon fa fa-plus"></i>
						<span class="nav-main-link-name">Create</span>
					</router-link> -->
				</li>
				<!-- <li class="nav-main-item">
					<a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" href="#">
						<i class="nav-main-link-icon far fa-building"></i>
						<span class="nav-main-link-name">Organisations</span>
					</a>
					<ul class="nav-main-submenu">
						<li class="nav-main-item">
							<router-link class="nav-main-link" active-class="active" :to="{ name: 'OrganisationsTable' }">
								<i class="nav-main-link-icon fa fa-list"></i>
								<span class="nav-main-link-name">List</span>
							</router-link>
							<router-link class="nav-main-link" active-class="active" :to="{ name: 'OrganisationForm' }">
								<i class="nav-main-link-icon fa fa-plus"></i>
								<span class="nav-main-link-name">Create</span>
							</router-link>
						</li>
					</ul>
				</li> -->
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
