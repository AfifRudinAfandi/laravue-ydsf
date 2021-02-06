<template>
	<div>
		<Hero />

		<Counter />

		<Program home="true" url="/api/campaigns/feed" />

		<SuccessStory />

		<CardJoin />

		<Footer home="true" />
	</div>
</template>

<script>
import $ from 'jquery'
import axios from 'axios'

import Hero from '~/components/Hero.vue'
import Program from '~/components/Program.vue'
import SuccessStory from '~/components/SuccessStory.vue'
import CardJoin from '~/components/CardJoin.vue'
import Footer from '~/components/Footer.vue'
import SkeletonBox from '~/components/SkeletonBox.vue'
import Counter from '~/components/Counter.vue'

export default {
	data: () => ({
		offset: null,
		isFixed: false,
	}),

	metaInfo() {
		return { title: 'Beranda' }
	},

	components: {
		Hero,
		Program,
		SuccessStory,
		CardJoin,
		Footer,
		SkeletonBox,
		Counter
	},

}
</script>

<style src="../../css/home.css">
</style>
<style scoped src="../../css/mobile.css">