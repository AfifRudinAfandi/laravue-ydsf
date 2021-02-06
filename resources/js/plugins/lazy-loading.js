import Vue from 'vue'
import VueLazyload from 'vue-lazyload'

Vue.use(VueLazyload, {
	preLoad: 1.3,
	error: '/images/Images-Banner-new.png',
	loading: '/images/img-loading.gif',
	attempt: 1,
})
