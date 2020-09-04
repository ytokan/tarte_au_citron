// vimeo
tarteaucitron.services.drupal_vimeo = {
  "key": "drupal_vimeo",
  "type": "video",
  "name": "Vimeo",
  "uri": "https://vimeo.com/privacy",
  "needConsent": true,
  "cookies": ['__utmt_player', '__utma', '__utmb', '__utmc', '__utmv', 'vuid', '__utmz', 'player'],
  "js": function () {
    "use strict";
    tarteaucitron.fallback(['vimeo_player'], function (x) {
      var iframe_attr = x.getAttributeNames(),
        iframe_attr_final = '',
        video_frame;

      for (var i = 0; i < iframe_attr.length; i++) {
        if(iframe_attr[i].indexOf("data")) {
          continue;
        }
        iframe_attr_final += iframe_attr[i].substring(5) + '="' + x.getAttribute(iframe_attr[i]) + '" ';
      }

      video_frame = '<iframe type="text/html" ' + iframe_attr_final + 'webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
      return video_frame;
    });
  },
  "fallback": function () {
    "use strict";
    var id = 'drupal_vimeo';
    tarteaucitron.fallback(['vimeo_player'], function (elem) {
      elem.style.width = elem.getAttribute('data-width') + 'px';
      elem.style.height = elem.getAttribute('data-height') + 'px';
      return tarteaucitron.engage(id);
    });
  }
};
