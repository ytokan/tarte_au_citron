// xiti smartTag
tarteaucitron.services.drupal_xiti_smarttag = {
  "key": "drupal_xiti_smarttag",
  "type": "analytic",
  "name": "Xiti (SmartTag)",
  "uri": "https://helpcentre.atinternet-solutions.com/hc/fr/categories/360002439300-Privacy-Centre",
  "needConsent": true,
  "cookies": ["atidvisitor", "atreman", "atredir", "atsession", "atuserid", "attvtreman", "attvtsession"],
  "js": function () {
    "use strict";

    if(!tarteaucitron.user.xiti_smarttagSiteId && !tarteaucitron.user.xiti_smarttagLocalPath) {
      return;
    }

    var url = '';
    if(tarteaucitron.user.xiti_smarttagLocalPath) {
      url = tarteaucitron.user.xiti_smarttagLocalPath;
    }
    else {
      url = '//tag.aticdn.net/' + tarteaucitron.user.xiti_smarttagSiteId + '/smarttag.js';
    }

    if(typeof tarteaucitron.user.xiti_smarttagMore === 'function') {
      tarteaucitron.addScript(url, 'smarttag', tarteaucitron.user.xiti_smarttagMore);
    }
    else {
      tarteaucitron.addScript(url, 'smarttag', null, null, "onload", "addTracker();");
    }
  }
};
