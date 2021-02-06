import Vue from 'vue'
import VueCurrencyFilter from 'vue-currency-filter'
import moment from 'moment'

Vue.use(VueCurrencyFilter, {
	symbol: 'Rp.',
	thousandsSeparator: '.',
	fractionCount: 0,
	fractionSeparator: ',',
	symbolPosition: 'front',
	symbolSpacing: true,
})

Vue.filter('formatDate', (value) => {
	if (value) return moment(String(value)).format('DD-MM-YYYY')
})

Vue.filter('timeLeft', (value) => {
	if (value) {
		const date = moment(String(value)).format('YYYY-MM-DD')
		const now = moment().format('YYYY-MM-DD')
		const diff = moment(date).diff(moment(now), 'days')
		return `${diff} hari`
	}

	return 'Selamanya'
})
