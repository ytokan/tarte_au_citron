// google analytics
tarteaucitron.services.drupal_googletagmanager = {
  "key": "drupal_googletagmanager",
  "type": "api",
  "name": "Google Tag Manager",
  "uri": "https://adssettings.google.com/",
  "needConsent": true,
  "cookies": ['_ga', '_gat', '__utma', '__utmb', '__utmc', '__utmt', '__utmz', '__gads', '_drt_', 'FLC', 'exchange_uid', 'id', 'fc', 'rrs', 'rds', 'rv', 'uid', 'UIDR', 'UID', 'clid', 'ipinfo', 'acs'],
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
