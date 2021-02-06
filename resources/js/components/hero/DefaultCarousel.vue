<template>
  <div
    id="DefaultCarausel"
    class="carousel slide hero-slider"
    data-ride="carousel"
  >
    <div class="carousel-inner">
      <div class="carousel-item active">
        <div class="main-background"></div>
        <img class="cloud-1" src="/images/cloud-pnk.svg" alt />
        <img class="cloud-2" src="/images/cloud-pnk.svg" alt />
        <img class="cloud-3" src="/images/cloud-org.svg" alt />
        <img class="cloud-4" src="/images/cloud-org.svg" alt />
        <img class="sun" src="/images/sun.svg" alt />
        <img class="cloud-5" src="/images/cloud-org.svg" alt />
        <div class="person-1">
          <img
            class="caracter-1 animated fadeInDown delay-1s"
            src="/images/ilustrasi1.png"
            alt
          />
        </div>
        <div class="person-2">
          <img
            class="caracter-2 animated fadeInDown delay-1s"
            src="/images/ilustrasi2.png"
            alt
          />
        </div>
        <div class="person-3">
          <img
            class="caracter-3 animated fadeInUp delay-1s"
            src="/images/ilustrasi3.png"
            alt
          />
        </div>
        <div class="carousel-caption">
          <div class="container animated fadeInLeft delay-1s">
            <h1 class="title-hero">
              Share
              <br class="br-1-hero" />to <br class="br-2-hero" />Create
              <br class="br-3-hero" />
              <span class="span-first">Harmony</span>
              <span class="span-last">Lives</span>
            </h1>
            <p class="desc-hero">
              Every donation you have millions of benefits for others
            </p>
            <a href="#" type="button" class="btn btn-success btn-hero">
              Watch Stories
              <i class="fa fa-caret-right"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "DefaultHeroCarousel",
};
</script>

<style src="../../../css/home.css">
</style>
<style scoped src="../../../css/mobile.css"></style>
