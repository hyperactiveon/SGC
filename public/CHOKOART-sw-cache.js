if ('serviceWorker' in navigator) {
    //*
    navigator.serviceWorker.register('CHOKOART-sw.js')
    .then(function(registration) { 
      
        if(registration.installing) {
          console.log('Service worker installing');
        } else if(registration.waiting) {
          console.log('Service worker installed');
        } else if(registration.active) {
          console.log('Service worker active');
        }

      })
    .catch(function(error) { console.error('Erro no Registro do Service Worker: sw.js', error); });
    //*/

    /* DESREGISTRA O SW
    if(window.navigator && navigator.serviceWorker) {
      navigator.serviceWorker.getRegistrations()
      .then(function(registrations) {
        for(let registration of registrations) { registration.unregister(); console.log('Service Worker Deletado!'); }
      });
    }
    //*/

} else { console.warn('Service Worker is not supported'); }




