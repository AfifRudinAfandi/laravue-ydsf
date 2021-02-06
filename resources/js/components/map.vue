<template>
	<radio-svg-map v-model="selectedLocation" :map="Indonesia" />
</template>

<script>
import { RadioSvgMap } from "vue-svg-map";
import Indonesia from "@svg-maps/indonesia";

export default {
	name: 'Map',
	components: {
		RadioSvgMap
	},
	data() {
		return {
			Indonesia,
			selectedLocation: [null]
		};
	}
}
</script>
<style lang="scss">
.svg-map {
	padding-top: 20px;
	padding-bottom: 20px;
	padding-left: 12px;
	margin-top: 64px;
    width: 100%;
    height: auto;
    stroke: #d3dae2;
    stroke-width: 0.1;
    stroke-linecap: round;
    stroke-linejoin: round;
	background-color: #F5FAFF;
}
.svg-map__location {
    fill: #E2EDF8;
    cursor: pointer;
}
.svg-map__location:focus,
.svg-map__location:hover {
    fill: #48B349;
    outline: 0;
}
.svg-map__location[aria-checked="true"] {
    fill: #48B349;
}
* {
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
}
.examples {
    width: 1000px;
    margin: 0 auto;
    font-family: Arial, sans-serif;
    text-align: center;
}
.examples__title {
    padding-bottom: 40px;
    font-size: 24px;
}
.examples__block,
.examples__title {
    margin-bottom: 80px;
    border-bottom: 1px dotted #000;
}
.examples__block {
    padding-bottom: 80px;
}
.examples__block__title {
    margin-bottom: 40px;
    font-size: 20px;
}
.examples__block__info {
    display: inline-block;
    vertical-align: top;
    width: 450px;
    text-align: left;
}
.examples__block__info__item {
    margin-bottom: 20px;
}
.examples__block__map {
    display: inline-block;
    width: 500px;
}
.examples__block__map--australia .svg-map {
    stroke-width: 0.5;
}
.examples__block__map--usa {
    width: 800px;
}
.examples__block__map--usa .svg-map__location--heat0 {
    fill: #00f;
}
.examples__block__map--usa .svg-map__location--heat1 {
    fill: #add8e6;
}
.examples__block__map--usa .svg-map__location--heat2 {
    fill: orange;
}
.examples__block__map--usa .svg-map__location--heat3 {
    fill: red;
}
.examples__block__map--usa .svg-map__location:focus,
.examples__block__map--usa .svg-map__location:hover {
    opacity: 0.75;
}
.examples__block__map__tooltip {
    position: fixed;
    width: 200px;
    padding: 10px;
    border: 1px solid #a9a9a9;
    background-color: #fff;
}
</style>