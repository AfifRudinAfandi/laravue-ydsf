<template>
	<button class="form-button" :type="nativeType" :disabled="loading">
		<slot />
	</button>
</template>

<script>
export default {
	name: 'VButton',

	props: {
		type: {
			type: String,
			default: 'primary',
		},

		nativeType: {
			type: String,
			default: 'submit',
		},

		loading: {
			type: Boolean,
			default: false,
		},
	},
}
</script>

<style lang="scss" scoped>
.form-button {
	@apply w-full px-4 py-2 font-bold text-white bg-blue-500 rounded-full;
	&:hover {
		@apply bg-blue-700;
	}
	&:focus {
		@apply outline-none shadow-outline;
	}
}

.loader {
	animation: spin 2s linear infinite;
}

@keyframes spin {
	0% {
		transform: rotate(0deg);
	}
	100% {
		transform: rotate(360deg);
	}
}
</style>
