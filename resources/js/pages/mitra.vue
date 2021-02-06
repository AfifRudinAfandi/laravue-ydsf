<template>
  <div>
    <Map/>
    <section class="mitra">
      <div class="container">
        <h4 class="title-mitra">
          Mitra
          <span>Salur</span>
          <span>YDSF</span>
        </h4>
        <p class="title-mitra-desc">Every donation you have millions of benefits for others</p>

        <div class="row">
          <template v-if="loading">
            <div v-for="n in 3" :key="n" class="col-md-4">
              <div class="link-mitra-card">
                <div class="card-mitra-salur">
                  <img class="image-card-mitra" v-lazy alt="image" />
                  <div class="card-mitra-body">
                    <p class="mitra-name">
                      <skeleton-box />
                    </p>
                    <p class="address-mitra">
                      <skeleton-box />
                    </p>
                    <skeleton-box />
                    <skeleton-box />
                    <skeleton-box />
                  </div>
                </div>
              </div>
            </div>
          </template>
          <template v-else>
            <div v-for="item in mitra" :key="item.mitra" class="col-md-4">
              <router-link
                :to="{ name: 'detail-mitra', params: {id: item.id} }"
                class="link-mitra-card"
              >
                <div class="card-mitra-salur">
                  <img class="image-card-mitra" v-lazy="item.image_url" alt="image" />
                  <div class="card-mitra-body">
                    <p class="mitra-name">{{ item.name }}</p>
                    <p class="address-mitra">
                      <i class="fa fa-map-marker"></i>
                      {{ item.address }}
                    </p>
                    <p class="mitra-program">Program Galangan Dana</p>
                    <div class="wrapper-horizon">
                      <div class="icon-wrapp color-active">
                        <img src="/images/ic-help.svg" alt />
                      </div>
                      <p class="count-program">{{ item.has }} Program Terdanai</p>
                    </div>
                    <div class="wrapper-horizon">
                      <div class="icon-wrapp color-danger">
                        <img src="/images/ic-help.svg" alt />
                      </div>
                      <p class="count-program">
                        {{ item.hasnt }} Program Belum
                        Terdanai
                      </p>
                    </div>
                  </div>
                </div>
              </router-link>
            </div>
          </template>
        </div>
      </div>
    </section>

    <CardJoin />

    <Footer />
  </div>
</template>

<script>
import Axios from 'axios'

import Map from '~/components/Map.vue'
import Footer from '~/components/Footer.vue'
import CardJoin from '~/components/CardJoin.vue'
import SkeletonBox from '~/components/SkeletonBox.vue'

export default {
	name: 'Mitra',

	data: () => ({
    mitra: {},
    loading: true,
	}),

	metaInfo() {
		return { title: 'Mitra Kami' }
	},

	components: {
    Footer,
    CardJoin,
    SkeletonBox,
    Map,
	},

	mounted() {
		this.fetchMitra()
	},

	methods: {
		async fetchMitra() {
			return await Axios.get('/api/regionals')
				.then((res) => {
					const data = res.data
					this.mitra = data.map((mitra) => {
						return {
              id: mitra.id,
							image_url: `/storage/admin/${mitra.image}`,
							name: mitra.name,
							address: mitra.address,
							has: mitra.hasDonation,
							hasnt: mitra.hasntDonation,
						}
					})
				})
        .catch(() => {})
        .finally(() => this.loading = false)
		},
	},
}
</script>

<style src="../../css/mitra.css"></style>
<style scoped src="../../css/mobile.css">
