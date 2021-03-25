// google analytics
tarteaucitron.services.drupal_addtoany = {
  "key": "drupal_addtoany",
  "type": "social",
  "name": "AddToAny",
  "uri": "",
  "needConsent": true,
  "cookies": [],
  "js": function () {
    "use strict";
    var social = document.getElementsByClassName('social-media-icons');
    for (var i = 0; i < social.length; i++) {
      social[i].style.display = 'inline-block'
    }
    tarteaucitron.addScript('//static.addtoany.com/menu/page.js');
  },
};
