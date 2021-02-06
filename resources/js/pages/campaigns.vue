<template>
  <div>
    <Counter />

    <section class="program">
      <div class="container">
        <div class="wrapp-top-title">
          <div class="main-title">
            <h4 class="main-title-first">
              Fundraising
              <span>Programs</span>
            </h4>
            <p class="main-title-second">Every donation you have millions of benefits for others</p>
          </div>
        </div>
        <div class="row">
          <program url="/api/campaigns" />
        </div>
      </div>
    </section>

    <CardJoin />

    <Footer home="true" />
  </div>
</template>

<script>
import Axios from 'axios'
import Program from '~/components/Program.vue';
import CardJoin from "~/components/CardJoin.vue";
import Footer from "~/components/Footer.vue";
import Counter from '~/components/Counter.vue';

export default {
	name: 'DaftarProgram',

	data: () => ({
    loading: true,
    programs: [],
		counter: {
			totalCampaignProgress: 0,
			totalCampaignComplete: 0,
			totalUser: 0,
			totalDonationSuccess: 0,
		},
	}),
	
  components: {
    Program,
    CardJoin,
    Footer,
    Counter,
  },

	metaInfo() {
		return { title: 'Daftar Program' }
	},

	mounted() {
    this.fetchCounter().then(() => { this.loading = false; this.$store.dispatch('general/toggleLoading', false)})
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
		},
  }
}
</script>
<style scoped>
section.program {
    margin-top: 248px;
}
</style>
<style src="../../css/campaigns.css"></style>
<style scoped src="../../css/mobile.css">
