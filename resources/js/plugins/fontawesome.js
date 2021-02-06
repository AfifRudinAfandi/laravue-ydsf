import Vue from 'vue'
import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

import {
	faUser,
	faLock,
	faSignOutAlt,
	faCog,
	faSlidersH,
	faMapMarkerAlt,
	faHourglassHalf,
} from '@fortawesome/free-solid-svg-icons'

import { faGithub } from '@fortawesome/free-brands-svg-icons'

library.add(
	faUser,
	faLock,
	faSignOutAlt,
	faCog,
	faGithub,
	faSlidersH,
	faMapMarkerAlt,
	faHourglassHalf
)

Vue.component('fa', FontAwesomeIcon)
