const CACHE_NAME = 'verdecalc-v1';
const urlsToCache = [
  '/',
  '/css/app.css',
  '/js/app.js',
  '/imagens/icon-192x192.png',
  '/imagens/icon-512x512.png'
];

self.addEventListener('install', function(event) {
  event.waitUntil(
    caches.open(CACHE_NAME).then(cache => cache.addAll(urlsToCache))
  );
});

self.addEventListener('fetch', function(event) {
  event.respondWith(
    caches.match(event.request).then(response => response || fetch(event.request))
  );
});
