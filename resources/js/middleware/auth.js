import store from '~/store'

export default async (to, from, next) => {
	if (to.matched.some(record => record.meta.image)) {
		store.dispatch('auth/updateBgImage', to.meta.image)
	}

	if (to.matched.some(record => record.meta.auth)) {
		const unAuth = ['login', 'register']
		const checkUnAuth = unAuth.indexOf(to.name) !== -1

		if (!store.getters['auth/check']) {
			!checkUnAuth
				? next({ name: 'login', query: { redirect: to.fullPath } })
				: next()
		} else {
			checkUnAuth ? next({ name: 'home' }) : permission(to, from, next)
		}
	} else {
		next()
	}
}

const permission = async (to, from, next) => {
	if (to.matched.some(record => record.meta.permission)) {
		const userPermission = store.getters['auth/user'].permissions || []
		userPermission.indexOf(to.meta.permission) !== -1
			? next()
			: next({ name: '404' })
	} else {
		next()
	}
}
