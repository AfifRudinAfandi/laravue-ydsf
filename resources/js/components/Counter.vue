<template>
  		<section
			id="counter"
			class="content"
			:class="{ fixedCounter: isFixed }"
		>
			<div class="container wow fadeInUp">
				<div class="row horizontall-program">
					<div class="vertical-ct">
						<h1 class="program-count">
							<skeleton-box v-if="counter.loading" :min-width="72" :max-width="80"/>
							<template v-else>{{ counter.totalCampaignComplete }}</template>
						</h1>
						<p class="program-title">Program Complete</p>
					</div>
					<div class="line-vertical"></div>
					<div class="vertical-ct">
						<h1 class="program-count">
							<skeleton-box v-if="counter.loading" :min-width="72" :max-width="80"/>
							<template v-else>{{ counter.totalCampaignProgress }}</template>
						</h1>
						<p class="program-title">Program On Progress</p>
					</div>
					<div class="line-vertical"></div>
					<div class="vertical-ct">
						<h1 class="program-count">
							<skeleton-box v-if="counter.loading" :min-width="72" :max-width="80"/>
							<template v-else>{{ counter.totalUser }}</template>
						</h1>
						<p class="program-title">Relations Joined</p>
					</div>
					<div class="line-vertical line-vertical-3"></div>
					<div class="vertical-ct">
						<h1 class="program-count">
							<skeleton-box v-if="counter.loading" :min-width="72" :max-width="80"/>
							<template v-else>{{ counter.totalDonationSuccess | currency }}</template>
						</h1>
						<p class="program-title">Donations Collected</p>
					</div>
				</div>
			</div>
		</section>
</template>

<script>
import $ from 'jquery'
import Axios from 'axios'
import SkeletonBox from './SkeletonBox'

export default {
    name: 'Counter',

    data: () => ({
        isFixed: false,
        counter: {
			loading: true,
			totalCampaignProgress: 0,
			totalCampaignComplete: 0,
			totalUser: 0,
			totalDonationSuccess: 0,
		}
    }),
    
    components: {
        SkeletonBox
    },
    
	mounted() {
		this.offset = $('#counter').offset().top
        window.addEventListener('scroll', this.scroll)
        this.fetchCounter()
	},

	deactivated() {
		window.removeEventListener('scroll', this.scroll)
	},

	methods: {
		async fetchCounter() {
			return await Axios
				.get('/api/count')
				.then((response) => {
					const data = response.data
					this.counter.totalCampaignProgress =
						data.totalCampaignProgress || 0
					this.counter.totalCampaignComplete =
						data.totalCampaignComplete || 0
					this.counter.totalUser = data.totalUser || 0
					this.counter.totalDonationSuccess =
						data.totalDonationSuccess || 0
                })
				.catch(() => {})
				.finally(() => {
					this.counter.loading = false
				})
		},

		scroll() {
			if ($(window).scrollTop() >= this.offset) {
				this.isFixed = true
				$('.programs-category').addClass('add-margin')
			} else {
				this.isFixed = false
				$('.programs-category').removeClass('add-margin')
			}
		},
	},
}
</script>

<style>
.fixedCounter {
  background-color: #48b349;
  z-index: 99;
  margin-top: 64px !important;
  padding: 14px !important;
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
}
.fixedCounter .program-count,
.fixedCounter .program-title,
.fixedCounter .idr,
.fixedCounter .line-vertical {
  color: #ffffff;
  border-color: #ffffff;
}
</style>