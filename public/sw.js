const CACHE_NAME = 'rns-pwa-v5';
const urlsToCache = [
    '/',
    '/assets/images/hp-logo.png',
    '/assets/images/favicon.ico',
    '/assets/images/splash-screen.png',
    '/assets/images/TaeAugust19.jpg'
];

self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => {
                return cache.addAll(urlsToCache);
            })
    );
});

self.addEventListener('fetch', event => {
    // For navigation requests (like the landing page '/'), try network first so dynamic settings updates show up
    if (event.request.mode === 'navigate' || event.request.url.endsWith('/')) {
        event.respondWith(
            fetch(event.request).then(response => {
                // If successful, and we have a valid response, cache the new version
                const responseClone = response.clone();
                caches.open(CACHE_NAME).then(cache => {
                    cache.put(event.request, responseClone);
                });
                return response;
            }).catch(() => {
                // If network fails (offline), fall back to cache
                return caches.match(event.request);
            })
        );
        return;
    }

    // For other assets (images, css, js), try cache first
    event.respondWith(
        caches.match(event.request)
            .then(response => {
                if (response) {
                    return response; // Cache hit
                }
                return fetch(event.request);
            })
    );
});
