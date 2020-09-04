// youtube
tarteaucitron.services.drupal_youtube = {
  "key": "drupal_youtube",
  "type": "video",
  "name": "YouTube",
  "uri": "https://policies.google.com/privacy",
  "needConsent": true,
  "cookies": ['VISITOR_INFO1_LIVE', 'YSC', 'PREF', 'GEUP'],
  "js": function () {
    "use strict";
    tarteaucitron.fallback(['youtube_player'], function (x) {
      var iframe_attr = x.getAttributeNames(),
        iframe_attr_final = '',
        video_frame;

      for (var i = 0; i < iframe_attr.length; i++) {
        if(iframe_attr[i].indexOf("data")) {
          continue;
        }
        iframe_attr_final += iframe_attr[i].substring(5) + '="' + x.getAttribute(iframe_attr[i]) + '" ';
      }

      video_frame = '<iframe type="text/html" ' + iframe_attr_final + 'allowfullscreen></iframe>';
      return video_frame;
    });
  },
  "fallback": function () {
    "use strict";
    var id = 'drupal_youtube';
    tarteaucitron.fallback(['youtube_player'], function (elem) {
      elem.style.width = elem.getAttribute('data-width') + 'px';
      elem.style.height = elem.getAttribute('data-height') + 'px';
      return tarteaucitron.engage(id);
    });
  }
};
