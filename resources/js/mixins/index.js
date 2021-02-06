import Vue from 'vue'

import auth from './auth'
import window from './window'

Vue.mixin(window)
Vue.mixin(auth)
