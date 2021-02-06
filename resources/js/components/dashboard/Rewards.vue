<template>
  <section id="dashboard-rewards">
    <div class="rewards-wrapper">
      <template v-if="loading">
        <div v-for="n in 2" :key="n" class="card item">
          <div class="card-body">
            <div class="row">
              <div class="col-md-4">
                <skeleton-box height="14em" width="12em" />
              </div>
              <div class="col-md-8">
                <skeleton-box width="8em" />
                <skeleton-box />
                <skeleton-box />
                <div class="mt-5">
                  <skeleton-box width="10em" height="1.4em" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </template>
      <template v-else>
        <template v-if="rewards.length > 0">
          <div v-for="item in rewards" :key="item.id" class="card item">
            <div class="card-body">
              <div class="row">
                <div class="col-md-4 image">
                  <img v-lazy="item.image" />
                </div>
                <div class="col-md-8 rewards-content">
                  <p class="date">{{item.created_at|formatDate}}</p>
                  <h4 class="title">{{ item.title }}</h4>
                  <p class="description">{{item.description}}</p>
                  <a :href="item.file" target="_blank" class="btn btn-download">
                    <i class="fa fa-download"></i>Download
                  </a>
                </div>
              </div>
            </div>
          </div>
        </template>
        <template v-else>
          <p>Lakukan donasi terlebih dahulu untuk dapat mengakses Majalah &amp; Ebook.</p>
        </template>
      </template>
    </div>
  </section>
</template>

<script>
import Axios from "axios";

import SkeletonBox from "~/components/SkeletonBox.vue";

export default {
  name: "Reward",
  data: () => ({
    rewards: [],
    loading: true,
  }),
  components: { SkeletonBox },
  computed: {
    user() {
      return this.$store.getters['auth/user']
    }
  },
  mounted() {
    this.fetchRewards();
  },
  methods: {
    async fetchRewards() {
      return await Axios.get(`/api/user/${this.user.id}/reward`)
        .then(({data}) => {
          console.log(data)
          this.rewards = data.map((item) => {
            return {
              id: item.id,
              title: item.title,
              description: item.description,
              image: `/storage/admin/${item.cover_image_url}`,
              file: `/storage/admin/${item.file_url}`,
              created_at: item.created_at,
            };
          });
        })
        .catch(() => {})
        .finally(() => (this.loading = false));
    },
  },
};
</script>

<style lang="scss" scoped>
#dashboard-rewards {
  .item {
    border-radius: 8px;
    border: 1px solid #e9ebef;
    margin-bottom: 28px;
    overflow: hidden;
    .info {
      font-size: 12px;
      padding: 10px 20px;
      background-color: #ecedf2;
      color: #546e7a;
      &.verified {
        background-color: #c8e6c9;
      }
    }
    .image img {
      width: 100%;
      height: 14em;
      object-fit: cover;
      object-position: center;
      border-radius: 8px;
    }
    .rewards-content {
      font-weight: 600;
      .date {
        font-size: 14px;
        color: #909aad;
        margin-bottom: 10px;
      }
      .title {
        color: #024e9b;
        font-size: 20px;
        font-weight: bold;
        line-height: 1.4em;
      }
      .description {
        font-size: 14px;
        color: #909aad;
        min-height: 80px;
      }
      .btn-download {
        margin-top: 10px;
        padding: 5px 18px;
        border-radius: 80px;
        color: #fff;
        background-color: #48b349;
        font-size: 14px;
        font-weight: 600;
        i.fa {
          margin-right: 10px;
        }
      }
    }
  }
  p {
    margin-bottom: 0px;
  }
}
</style>
