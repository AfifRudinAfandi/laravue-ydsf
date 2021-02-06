<template>
  <div>
    <section class="hero hero-success-story">
      <img class="thumbnail" v-lazy="blog.image_url" alt="image" />
    </section>
    <section class="body-success">
      <div class="container">
        <div class="row">
          <div class="col-md-8 db-left">
            <h4 class="db-title">{{ blog.title }}</h4>
            <div class="wrapper-db-post">
              <template v-if="loading.blog">
                <skeleton-box :min-width="50" :max-width="80" height="1.8em" />
                <br />
              </template>
              <p v-else class="post-by">
                <i class="fa fa-hourglass-half mr-2"></i>
                {{ blog.created_at }} |
                <span>{{ blog.author }}</span>
              </p>
              <div class="wrapper-share">
                <p class="title-share mr-2">Share :</p>
                <a class="sosmed-link" href="#">
                  <i class="fa fa-whatsapp"></i>
                </a>
                <a class="sosmed-link" href="#">
                  <i class="fa fa-twitter"></i>
                </a>
                <a class="sosmed-link" href="#">
                  <i class="fa fa-facebook-f"></i>
                </a>
              </div>
            </div>
            <template v-if="loading.blog">
              <skeleton-box />
              <skeleton-box />
              <skeleton-box />
              <skeleton-box />
            </template>
            <template v-else>
              <p class="desc-detail-success" v-html="blog.content"></p>
            </template>
          </div>

          <div class="col-md-4 db-right">
            <div class="wrapper-stiky">
              <template v-if="loading.recent">
                <div v-for="n in 3" :key="n">
                  <div class="link-float-berita">
                    <div class="floating-item-db">
                      <div class="wrapper-db-float">
                        <h4 class="berita-float-title">
                          <skeleton-box />
                        </h4>
                        <p class="post-by mb-2">
                          <skeleton-box />
                        </p>
                        <p class="desc-float-pengumuman">
                          <skeleton-box />
                          <skeleton-box />
                          <skeleton-box />
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </template>
              <template v-else>
                <div v-for="item in campaigns" :key="item.id">
                  <router-link
                    :to="{ name: 'single-campaign', params: { slug: item.slug } }"
                    class="link-float-berita"
                  >
                    <div class="floating-item-db">
                      <div class="wrapper-db-float">
                        <h3 class="title-project">{{ item.title }}</h3>
                        <div class="wrapper-value">
                          <p class="percent">{{ item.progress }}%</p>
                          <p class="value-idr">{{ item.max_nominal }}</p>
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
                              :class="{'text-danger': item.is_expired}"
                              class="fa fa-hourglass-half"
                            ></i>
                            <template v-if="!item.is_expired">
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
                      </div>
                    </div>
                  </router-link>
                </div>

                <div v-for="post in recent" :key="post.id">
                  <router-link
                    :to="{ name: 'single-blog', params: { slug: post.slug } }"
                    class="link-float-berita"
                  >
                    <div class="floating-item-db">
                      <div class="wrapper-db-float">
                        <h4 class="berita-float-title">{{ post.title }}</h4>
                        <p class="post-by mb-2">
                          <i class="fa fa-hourglass-half mr-2"></i>
                          <span>{{ post.created_at | formatDate }}</span> |
                          <span>{{ post.author }}</span>
                        </p>
                        <p class="desc-float-pengumuman">
                          {{ getPostBody(post.content) }}
                          <span>Read more</span>
                        </p>
                      </div>
                    </div>
                  </router-link>
                </div>
              </template>
            </div>
          </div>
        </div>
      </div>
    </section>
    <Footer />
  </div>
</template>

<script>
import Axios from 'axios'
import moment from 'moment'

import Footer from '~/components/Footer.vue'
import SkeletonBox from '~/components/SkeletonBox.vue'

export default {
	name: 'DetailBlog',

	data: () => ({
    blog: '',
    recent: [],
    campaigns: [],
    title: '',
    loading: {
      blog: true,
      recent: true,
      campaigns: true,
    }
	}),

	metaInfo() {
		return { title: this.title }
	},

  components: {
    Footer,
    SkeletonBox,
	},

	mounted() {
    this.fetchData().then(() => {
      this.fetchRecentCampaign().then(() => {
        this.fetchRecentPost()
      })
    })
  },
  
  methods: {
    async fetchData() {
			return await Axios.get(`/api/blogs/${this.$route.params.slug}`)
				.then((response) => {
					response.data.map((item) => {
            this.title = item.title
						this.blog = {
							id: item.id,
							slug: item.slug,
							author: item.author.name || '',
							title: item.title,
              image_url: `/storage/admin/${item.cover_image_url}`,
              content: item.content,
              tags: item.tags,
              created_at: moment(item.created_at).format('DD-MM-YYYY')
						}
					})
				})
        .catch(() => {})
        .finally(() => this.loading.blog = false)
    },

    async fetchRecentPost() {
			return await Axios.get(`/api/blogs/${this.blog.id}/recent`)
				.then((response) => {
					this.recent = response.data.map((item) => {
						return {
							id: item.id,
							slug: item.slug,
							author: item.author.name || '',
							title: item.title,
              content: item.content,
              created_at: item.created_at
						}
					})
				})
        .catch(() => {})
        .finally(() => this.loading.recent = false)
    },

    async fetchRecentCampaign() {
			return await Axios.get(`/api/campaigns/recent`)
				.then((response) => {
					this.campaigns = response.data.map((item) => {
						const donations = item.donations

						const verifiedDonation = donations.filter(
							(donation) => donation.is_verified === 1
						)

						const nominal = verifiedDonation.map(
							(donation) => donation.nominal
						)

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
              created_at: item.created_at,
						}
					})
				})
        .catch(() => {})
        .finally(() => this.loading.campaigns = false)
    },

    getPostBody(value) {
			const content = this.stripTags(value)
			return content.length > 100
				? content.substring(0, 100) + '...'
				: content
    },
    
    stripTags(text) {
			return text.replace(/(<([^>]+)>)/gi, '')
		},
  }
}
</script>

<style src="../../css/single-blog.css"></style>
<style scoped src="../../css/mobile.css">