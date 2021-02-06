import { registerRoute } from 'workbox-routing'
import {
	CacheFirst,
	StaleWhileRevalidate,
	NetworkFirst,
} from 'workbox-strategies'
import { ExpirationPlugin } from 'workbox-expiration'

registerRoute(function ({ url, event }) {
	return !url.pathname.match(/^\/api\//)
}, new StaleWhileRevalidate())

registerRoute(
	new RegExp('.(?:js|css|ico)$'),
	new NetworkFirst({
		cacheName: 'static',
	})
)

registerRoute(
	new RegExp('.(?:jpg|png|gif|svg)$'),
	new CacheFirst({
		cacheName: 'images',
		plugins: [
			new ExpirationPlugin({
				maxEntries: 20,
				purgeOnQuotaError: true,
			}),
		],
	})
)

self.__WB_MANIFEST
