// google analytics
tarteaucitron.services.googletagmanager = {
  "key": "googletagmanager",
  "type": "analytic",
  "name": "Google Tag Manager",
  "needConsent": true,
  "cookies": [],
  "js": function () {
    "use strict";
    if (tarteaucitron.user.googletagmanagerId === undefined) {
      return;
    }
    window.tarte_au_citron_gtm = window.tarte_au_citron_gtm || [];
    for (var i = 0; i < tarteaucitron.user.googletagmanagerId.length; i++) {
      var gtm_id = tarteaucitron.user.googletagmanagerId[i];
      if(window.tarte_au_citron_gtm[gtm_id] === undefined || window.tarte_au_citron_gtm[gtm_id] !== true) {
        window.tarte_au_citron_gtm[gtm_id] = true;
        window.dataLayer = window.dataLayer || [];
        window.dataLayer.push({
          'gtm.start': new Date().getTime(),
          event: 'gtm.js'
        });
        tarteaucitron.addScript('https://www.googletagmanager.com/gtm.js?id=' + gtm_id);
      }
    }
  }
};
