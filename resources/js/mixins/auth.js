export default {
	methods: {
		$can(permissionName) {
			const permission = this.$store.getters['auth/user'].permissions
			if (typeof permission != 'undefined') {
				return permission.indexOf(permissionName) !== -1
			}
		},
		$auth() {
			return this.$store.getters['auth/check']
		}
	}
}
