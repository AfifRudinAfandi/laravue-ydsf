<template>
	<div id="app">
		<notifications group="all">
			<template slot="body" slot-scope="props">
				<div class="notification">
					<a class="title">{{props.item.title}}</a>
					<a class="close" @click="props.close"><i class="fa fa-fw fa-close"></i></a>
					<div class="body" v-html="props.item.text"></div>
				</div>
			</template>
		</notifications>
		
		<loading ref="loading" />

		<transition name="page" mode="out-in">
			<component :is="layout" v-if="layout" />
		</transition>
	</div>
</template>

<script>
import Loading from './Loading'

// Load layout components dynamically.
const requireContext = require.context('~/layouts', false, /.*\.vue$/)

const layouts = requireContext
	.keys()
	.map(file => [file.replace(/(^.\/)|(\.vue$)/g, ''), requireContext(file)])
	.reduce((components, [name, component]) => {
		components[name] = component.default || component
		return components
	}, {})

export default {
	el: '#app',

	components: {
		Loading
	},

	data: () => ({
		layout: null,
		defaultLayout: 'default'
	}),

	metaInfo() {
		const { appName } = window.config

		return {
			title: appName,
			titleTemplate: `%s · ${appName}`
		}
	},

	mounted() {
		this.$loading = this.$refs.loading
	},

	methods: {
		/**
		 * Set the application layout.
		 *
		 * @param {String} layout
		 */
		setLayout(layout) {
			if (!layout || !layouts[layout]) {
				layout = this.defaultLayout
			}

			this.layout = layouts[layout]
		}
	}
}
</script>

<style lang="scss" scoped>
.notification {
	background: #fff;
	padding: 10px 10px 10px 20px;
	margin: 10px;
	border-radius: 10px;
	box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.08);
	.title {
		font-weight: 700;
	}
	.body {
		margin-top: 10px;
	}
	&.warn {
		background: #ffb648;
		border-left-color: #f48a06;
	}

	&.error {
		background: #E54D42;
		border-left-color: #B82E24;
	}

	&.success {
		background: #68CD86;
		border-left-color: #42A85F;
	}
}
</style>