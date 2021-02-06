<template>
	<section class="success-story">
		<div class="wrapp-success">
			<div class="container ct-story wow fadeInUp">
				<h5 class="title-success-story">
					Success
					<span>Stories</span>
				</h5>
				<p class="success-p">
					Every donation you have millions of benefits for others
				</p>
			</div>

			<carousel
				:perPageCustom="[
					[300, 1],
					[768, 4],
				]"
				class="rw-slider wow fadeInUp"
			>
			<template v-if="loading">
				<slide v-for="n in 4" :key="n" class="item">
					<div class="item">
						<div class="card card-success-story">
							<img
								width="100%"
								v-lazy=""
								class="card-img-top"
								alt="image"
							/>
							<div class="card-body">
								<skeleton-box/>
								<skeleton-box/>
								<skeleton-box/>
							</div>
						</div>
					</div>
				</slide>
			</template>

			<template v-else>
				<slide v-for="item in items" :key="item.id" class="item">
					<div class="item">
						<router-link
							class="wrapper-card"
							:to="{
								name: 'single-blog',
								params: { slug: item.slug },
							}"
						>
							<div class="card card-success-story">
								<img
									width="100%"
									v-lazy="item.image_url"
									class="card-img-top"
									alt="image"
								/>
								<div class="card-body">
									<h5 class="success-project">
										{{ item.title }}
									</h5>
									<p class="success-time">
										<i class="fa fa-hourglass-half"></i>
										<span class="ml-2">
											{{ item.created_at | formatDate }}
											| {{ item.author }}
										</span>
									</p>
									<p class="success-content">
										{{ getPostBody(item.content) }}
									</p>
								</div>
							</div>
						</router-link>
					</div>
				</slide>
			</template>
			</carousel>
		</div>
	</section>
</template>

<script>
import Axios from 'axios'
import { Carousel, Slide } from 'vue-carousel'
import SkeletonBox from './SkeletonBox'

export default {
	name: 'SuccessStory',
	components: {
		Carousel,
		Slide,
		SkeletonBox,
	},
	data: () => ({
		items: {},
		loading: false,
	}),

	mounted() {
		this.fetchData()
	},

	methods: {
		async fetchData() {
			this.loading = true

			return await Axios.get('/api/blogs')
				.then((response) => {
					this.loading = false
					this.items = response.data.map((item) => {
						return {
							id: item.id,
							author:
								item.author !== null ? item.author.name : '-',
							title: item.title,
							image_url: `../storage/admin/${item.cover_image_url}`,
							content: item.content,
							slug: item.slug,
							created_at: item.created_at,
						}
					})
				})
				.catch(() => {
					this.loading = false
				})
		},

		getPostBody(value) {
			const content = this.stripTags(value)
			return content.length > 200
				? content.substring(0, 200) + '...'
				: content
		},

		stripTags(text) {
			return text.replace(/(<([^>]+)>)/gi, '')
		},
	},
}
</script>

<style src="../../css/success.css"></style>
<style scoped src="../../css/mobile.css">
