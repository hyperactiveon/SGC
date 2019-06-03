
var staticCacheName = 'CHOKOART-29052019-09h06';

var filesToCache = [
    'dist/css/vendor.min.css',
    'plugins/swiper/swiper.min.css',
    'plugins/noty/noty.min.css',
    'dist/css/style.min.css',
    'plugins/jquery/jquery.min.js',
    'plugins/bootstrap/js/bootstrap.bundle.min.js',
    'plugins/feather-icons/feather.min.js',
    'plugins/metismenu/metisMenu.min.js',
    'plugins/perfect-scrollbar/perfect-scrollbar.min.js',
    'plugins/swiper/swiper.min.js',
    'plugins/noty/noty.min.js',
    'plugins/jquery-countdown/jquery.countdown.min.js',
    'dist/js/script.min.js',
    'https://fonts.googleapis.com/css?family=Nunito:400,700',
    'https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700',
    'img/destaques/categorias/principal-1.jpg',
    'img/destaques/categorias/principal-2.jpg',
    'img/destaques/categorias/principal-3.jpg',
    'img/destaques/categorias/principal-4.jpg',
    'img/destaques/categorias/secundario-1.jpg',
    'img/destaques/categorias/secundario-2.jpg',
    'img/destaques/categorias/secundario-3.jpg',
    
];

//ABRE A API DE CACHE PARA ADICIONAR ARQUIVOS 
self.addEventListener('install', function(e) {
  console.log('[ServiceWorker] Install');
  e.waitUntil(

      caches.open(staticCacheName)
        .then(function(cache) {
            console.log('[ServiceWorker] Caching app shell');
            return cache.addAll(filesToCache); //REALIZA UM fetch E ARMAZENA NO CACHE
        })

  )
});

self.addEventListener('activate', function(e) {
    //console.log('[ServiceWorker] Activate');
    e.waitUntil(
        caches.keys()
          .then(
              function(cachesNames){
                  cachesNames.filter(function(cacheName){
                      return cacheName.startsWith('CHOKOART-') && cacheName != staticCacheName
                  })
                  .map(function(cacheName){ return cache.delete(cacheName) })  
              }
          )
      /*
        caches.keys()
          .then(function(keyList) {
              return Promise.all(keyList.map(function(key) {
                  if (key !== cacheName) {
                      console.log('[ServiceWorker] Removing old cache', key);
                      return caches.delete(key);
                  }
              }))
          })
      */
    )
    return self.clients.claim();
})

self.addEventListener('fetch', function(e) {
    //console.log('[ServiceWorker] Fetch -> ', e.request.url);
    e.respondWith(

      caches.match(e.request) //RETORNA O QUE ESTÁ NO CACHE
        .then(function(response) {
          return response || fetch(e.request);
        })
    
    )

})