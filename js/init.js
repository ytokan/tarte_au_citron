(function ($, Drupal, drupalSettings) {
  Drupal.tarte_au_citron.init(drupalSettings.tarte_au_citron);

  Drupal.behaviors.tarte_au_citron = {
    attach: function (context, settings) {
      tarteaucitron.job = tarteaucitron.job || [];
      tarteaucitron.user = $.extend(
        {},
        tarteaucitron.user || {},
        Drupal.tarte_au_citron.settings.user || {}
      );
      Drupal.tarte_au_citron.settings.services.forEach(function (item, index) {
        tarteaucitron.job.push(item);
      });
    },
  };
}(jQuery, Drupal, drupalSettings));
