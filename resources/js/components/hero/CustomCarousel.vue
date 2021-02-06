<template>
  <div id="CustomCarausel" class="carousel slide hero-slider" data-ride="carousel">
    <div class="carousel-inner">
      <div
        v-for="(image, index) in images"
        :key="image.id"
        class="carousel-item"
        :class="{'active': index === 0}"
      >
        <!-- <div class="main-background-custom"></div> -->
        <div class="overlay">
          <img :src="`/storage/admin/${image.image}`" class="main-background-custom" />
        </div>
        <div class="carousel-caption-custom">
          <div class="container animated fadeInLeft delay-1s">
            <h1 class="title-hero Custom">{{image.title}}</h1>
            <p class="desc-hero Custom">{{image.subtitle}}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "CustomHeroCarousel",
  props: ["images"],
};
</script>

<style src="../../../css/custom-hero.css"></style>
<style scoped src="../../../css/mobile.css">
