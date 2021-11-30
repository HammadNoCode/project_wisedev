<template>
	<div class="content">
		<div class="row mb-4">
			<div class="col mt-1">
				<h2 class="h3 font-w500 mt-2 mb-0">Settings</h2>
			</div>
		</div>
		<div>
			<Details />
		</div>
		<div>
			<Password />
		</div>
	</div>
</template>
<script>
import Details from './components/Details'
import Password from './components/Password'
export default {
	components: {
		Details,
		Password,
	},
	data: function () {
		return {
			index: 1,
			routePrefix: '/api/user/settings/',
		}
	},
}
</script>
