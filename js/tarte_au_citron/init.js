(function ($, Drupal) {
  Drupal.tarte_au_citron.init(Drupal.settings.tarte_au_citron);

  Drupal.behaviors.tarte_au_citron  = {
    attach: function (context, settings) {
      tarteaucitron.job = tarteaucitron.job || [];
      tarteaucitron.user = Drupal.tarte_au_citron.settings.user || [];
      Drupal.tarte_au_citron.settings.services.forEach(function (item, index) {
        tarteaucitron.job.push(item);
      });
    },
  };
}(jQuery, Drupal));
