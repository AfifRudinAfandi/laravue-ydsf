<template>
  <section :class="{ 'programs-category': home }">
    <div class="section-top-category container wow fadeInUp">
      <template v-if="home">
        <h2 class="category-program-title">
          Fundraising
          <span>Programs</span>
        </h2>
        <p class="category-program-content">Every donation you have millions of benefits for others</p>
      </template>

      <div v-if="!loading" class="wrapper-kategori">
        <div class="form-row">
          <div class="col-auto my-1">
            <label class="label-kategori" for="#kategori">Category</label>
          </div>
          <div class="col-auto my-1">
            <select class="custom-select" id="kategori" v-model="selectedCategories">
              <option selected value="0">Semua</option>
              <option
                v-for="category in categories"
                :key="category.id"
                :value="category.id"
              >{{category.category }}</option>
            </select>
          </div>
        </div>
        <div class="form-row">
          <div class="col-auto my-1">
            <label class="label-kategori" for="#lokasi">Location</label>
          </div>
          <div class="col-auto my-1">
            <select class="custom-select" id="lokasi" v-model="selectedLocations">
              <option selected value>Semua</option>
              <option v-for="location in locations" :key="location" :value="location">{{ location }}</option>
            </select>
          </div>
        </div>
        <div class="form-row">
          <div class="col-auto my-1">
            <label class="label-kategori" for="#sort">Sort</label>
          </div>
          <div class="col-auto my-1">
            <select class="custom-select" id="sort" v-model="sort">
              <option selected value="LATEST">Terbaru</option>
              <option value="OLDEST">Terlama</option>
            </select>
          </div>
        </div>
        <div class="form-row">
          <div class="col-auto my-1">
            <button type="button" class="btn btn-success btn-category" @click="reset">Reset</button>
          </div>
        </div>
      </div>
    </div>

    <div v-if="loading" class="container wow fadeInUp mb-4">
      <div class="row rw-category">
        <div v-for="n in 4" :key="n" class="col-md-3 card-col">
          <div class="card card-program">
            <img v-lazy class="card-img-top" />
            <div class="card-body">
              <skeleton-box />
              <skeleton-box />
              <div class="mt-4">
                <skeleton-box />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div v-else class="container wow fadeInUp">
      <div class="row rw-category">
        <div v-for="item in items" :key="item.id" class="col-md-3 card-col">
          <router-link
            :event="item.is_expired ? '' : 'click'"
            class="wrapper-card"
            :to="{
							name: 'single-campaign',
							params: { slug: item.slug },
						}"
          >
            <div class="card card-program">
              <img v-lazy="item.image_url" class="card-img-top" />
              <div class="card-body">
                <h5 class="card-category">{{ item.category }}</h5>
                <h3 class="title-project">{{ item.title }}</h3>
                <p class="cabang">
                  <i class="fa fa-map-marker"></i>
                  {{ item.location }}
                </p>
                <template v-if="item.max_time">
                  <div class="wrapper-value">
                    <p class="percent">{{ item.progress }}%</p>
                    <p class="value-idr">{{ item.nominal | currency }}</p>
                  </div>
                  <div class="progress">
                    <div
                      class="progress-bar"
                      role="progressbar"
                      :aria-valuenow="item.progress"
                      aria-valuemin="0"
                      aria-valuemax="100"
                      :style="{ width: `${item.progress}%` }"
                    ></div>
                  </div>
                  <div class="wrapper-time">
                    <p class="time-left">
                      <i
                        :class="
                          item.completed == 1 ? 'text-success' : item.is_expired ? 'text-danger' : '' 
                        "
                        class="fa fa-hourglass-half"
                      ></i>
                      <template v-if="item.completed == 1">
                        <span class="text-success">Completed</span>
                      </template>
                      <template v-else-if="!item.is_expired">
                        {{
                        item.max_time | timeLeft
                        }}
                      </template>
                      <template v-else>
                        <span class="text-danger">Closed</span>
                      </template>
                    </p>
                    <p v-show="item.progress > 0" class="status-project">Collected</p>
                  </div>
                </template>
                <div class="new-format" v-else>
                  <p>Total Donasi: </p>
                  <h4 class="heading">{{item.totalNominal|currency}}</h4>
                  <p>Total Donatur: </p>
                  <h4 class="heading">{{item.totalDonatur}}</h4>
                </div>
                <div class="float-category">
                  <i class="icon fa" :class="item.cat_icon"></i>
                </div>
              </div>
            </div>
          </router-link>
        </div>
      </div>

      <div class="show-more-wrapp">
        <router-link
          v-if="home"
          :to="{ name: 'campaigns' }"
          type="button"
          class="btn btn-outline-success btn-show-more"
        >Show More</router-link>
      </div>
    </div>
  </section>
</template>

<script>
import Axios from 'axios'
import moment from 'moment'
import SkeletonBox from './SkeletonBox'

export default {
	name: 'Program',

	data: () => ({
		programs: [],
		categories: [],
    selectedCategories: 0,
    locations: [],
    selectedLocations: '',
    sort: 'LATEST',
		loading: true,
	}),

	props: ['home', 'url'],

  components: {
    SkeletonBox
  },

	computed: {
		items() {
      var items = [];
      
      if (this.selectedCategories <= 0 && this.selectedLocations == '') {
        items = this.programs
      } else {
        items = this.programs.filter((program) => {
          if (this.selectedCategories > 0 && this.selectedLocations != '') {
            return program.location === this.selectedLocations && program.category_id === this.selectedCategories
          } else if (this.selectedCategories > 0 && this.selectedLocations == '') {
            return program.category_id === this.selectedCategories
          } else if(this.selectedCategories <= 0 && this.selectedLocations != '') {
            return program.location === this.selectedLocations
          } else {
            return program
          }
        })
      }

      if(this.sort == 'OLDEST') {
        return items.sort((a, b) => {
          return new Date(a.created_at) - new Date(b.created_at);
        });
      } else {
        return items.sort((a, b) => {
          return new Date(b.created_at) - new Date(a.created_at);
        });
      }

		},
	},

	mounted() {
    this.fetchCategories()
    
    this.fetchLocations()

		this.fetchData().then((data) => {
			this.programs = this.home ? data.splice(0, 4) : data
		})
	},

	methods: {
		async fetchData() {
			return await Axios.get(this.url)
				.then((response) => {
					return response.data.map((item) => {
						const donations = item.donations

						const verifiedDonation = donations.filter(
							(donation) => donation.is_verified === 1
						)

						const nominal = verifiedDonation.map(
							(donation) => donation.nominal
            )

            const userId = verifiedDonation.map((donation) => donation.user_id);
            const totalDonaturObj = userId.reduce((map, val) => {map[val] = (map[val] || 0)+1; return map}, {} );
            const totalDonatur = Object.keys(totalDonaturObj).length || 0

						let totalNominal = 0
						if (nominal.length > 0)
							totalNominal = nominal.reduce(
								(acc, val) => parseInt(acc) + parseInt(val)
							)

						const progress =
							(parseInt(totalNominal) /
								parseInt(item.max_nominal)) *
							100

						return {
							id: item.id,
							slug: item.slug,
							author: item.admin !== null ? item.admin.name : '-',
							title: item.title,
							location: item.location,
							image_url: `/storage/admin/${item.cover_image_url}`,
							video_url: item.video_url,
							max_time: item.max_time,
              is_expired: moment().isAfter(moment(item.max_time)),
							nominal: item.max_nominal,
							category: item.category.category,
							category_id: item.category.id,
							cat_icon: item.category.icon,
              progress: Math.ceil(progress),
              totalNominal: totalNominal,
              totalDonatur: totalDonatur,
              created_at: item.created_at,
              completed: item.is_complete,
						}
					})
				})
        .catch(() => {})
        .finally(() => this.loading = false)
		},

		async fetchCategories() {
			return await Axios.get('/api/campaigns/categories')
				.then((response) => {
					this.categories = response.data
				})
				.catch(() => {})
    },
    
    async fetchLocations() {
			return await Axios.get('/api/campaigns/location')
				.then((response) => {
					this.locations = response.data
				})
				.catch(() => {})
    },
    
    reset() {
      this.selectedCategories = 0
      this.selectedLocations = ''
      this.sort = 'LATEST'
    }
	},
}
</script>

<style src="../../css/program.css"></style>
<style scoped src="../../css/mobile.css">