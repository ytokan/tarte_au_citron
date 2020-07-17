(function ($, Drupal) {
  Drupal.tarte_au_citron = Drupal.tarte_au_citron || {
    _init: false,
    settings: {},
    settings_alter: {},
    init: function(tacjs_settings) {
      if(this._init) {
        return;
      }

      this.settings = tacjs_settings;
      var keys = Object.keys(this.settings_alter);
      var self = this;
      keys.forEach(function (item, index) {
        self.settings_alter[item].call(self);
      });

      // force English in order for strings to be localized.
      tarteaucitronForceLanguage = "en";

      // Add custom translated texts to tarteaucitron.
      tarteaucitronCustomText = this.settings.texts;

      tarteaucitron.init(this.settings);

      this._init = true;
    }
  };
}(jQuery, Drupal));
