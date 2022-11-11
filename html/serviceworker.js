const cacheName = "";
const precacheList = [
	"index.php"
];

try {
	importScripts("");
} catch (e) {}

self.addEventListener("install", (event) => {
	event.waitUntil(
		caches
			.open(cacheName)
			.then((cache) => {
				cache.addAll(precacheList);
				// console.log(precacheList);
			})
			.then(() => {
				return self.skipWaiting();
			})
	);
});

self.addEventListener("activate", (event) => {
	console.log("Service worker activated");
	event.waitUntil(
		caches.keys().then((keyList) => {
			return Promise.all(
				keyList.map((key) => {
					if (key != cacheName) {
						console.log("Removing old cache", key);
						return caches.delete(key);
					}
				})
			);
		})
	);
	return self.clients.claim();
});

self.addEventListener("fetch", (event) => {
	const parsedUrl = new URL(event.request.url);
	
	{
		//Cache-first
		event.respondWith(
			caches.match(event.request).then((response) => {
				if (response) {
					return response;
				} else {
					if (
						parsedUrl.pathname.match(/^\/images*/) ||
						parsedUrl.pathname.match(/^\/fonts*/)
					) {
						const fetchRequest = fetch(event.request).then(
							(networkResponse) => {
								return caches.open(cacheName).then((cache) => {
									cache.put(event.request, networkResponse.clone());
									console.log("Newly added item to cache");

									return networkResponse;
								});
							}
						);
						return fetchRequest;
					} else {
						return fetch(event.request);
					}
				}
			})
		);
	}
});
