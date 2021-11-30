<template>
	<header id="page-header">
		<div class="content-header">
			<div class="d-xl-none">
				<button
					type="button"
					class="btn btn-dual mr-1"
					data-toggle="layout"
					data-action="sidebar_toggle"
				>
					<i class="fa fa-fw fa-bars"></i>
				</button>
			</div>
			<div class="col">
				<button
					class="btn btn-dual"
					data-toggle="layout"
					@click="$router.back()"
				>
					<i class="fa fa-fw fa-chevron-left"></i>
				</button>
				<button
					class="btn btn-dual"
					data-toggle="layout"
					@click="$router.forward()"
				>
					<i class="fa fa-fw fa-chevron-right"></i>
				</button>
			</div>
			<div>
				<!-- <create-call></create-call> -->
				<div class="dropdown d-inline-block">
					<b-dropdown class="btn" variant="primary">
						<template slot="button-content">
							<i class="fa fa-fw fa-user d-sm-none"></i>
							<span class="d-none d-sm-inline-block">{{
								profile_name
							}}</span>
						</template>
						<div
							class="bg-primary-darker rounded-top font-w600 text-white text-center p-3"
						>
							User Options
						</div>
						<div class="p-2">
							<b-dropdown-item>
								<router-link
									class="dropdown-item"
									:to="{ name: 'UserSettings' }"
								>
									<i class="far si si-settings mr-1"></i> Settings
								</router-link>
							</b-dropdown-item>
							<b-dropdown-item>
								<a class="dropdown-item" v-on:click="logout">
									<i
										class="far fa-fw fa-arrow-alt-circle-left mr-1"
									></i>
									Sign Out
								</a>
							</b-dropdown-item>
						</div>
					</b-dropdown>
				</div>
			</div>
		</div>
		<div id="page-header-search" class="overlay-header bg-primary">
			<div class="content-header">
				<form class="w-100" action="/dashboard" method="POST">
					<div class="input-group">
						<div class="input-group-prepend">
							<button
								type="button"
								class="btn btn-primary"
								data-toggle="layout"
								data-action="header_search_off"
							>
								<i class="fa fa-fw fa-times-circle"></i>
							</button>
						</div>
						<input
							type="text"
							class="form-control border-0"
							placeholder="Search or hit ESC.."
							id="page-header-search-input"
							name="page-header-search-input"
						/>
					</div>
				</form>
			</div>
		</div>
		<div id="page-header-loader" class="overlay-header bg-primary-darker">
			<div class="content-header">
				<div class="w-100 text-center">
					<i class="fa fa-fw fa-2x fa-sun fa-spin text-white"></i>
				</div>
			</div>
		</div>
	</header>
</template>
<script>
import CreateCall from '../calls/CreateCall';

export default {
	components: {
		CreateCall
	},
	data: function () {
		return {
			dropdown: {
				user: false,
			},
		}
	},
	computed: {
		profile_name: function () {
			return this.$store.state.user.name;
		}
	},
	methods: {
		logout() {
			axios.get('/api/logout')
				.then(response => {
					location.reload();
				})
				.catch(error => {
					this.$root.notification(error.response.data.message, 'error');
				})
		}
	}
}
</script>
<style scoped>
@media screen and (max-width:375px) {
	.content-header {
		padding-right: 0px !important;
	}
}
</style>
