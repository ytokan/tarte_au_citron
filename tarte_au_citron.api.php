<?php

/**
 * Alter tarte au citron settings.
 *
 * Called by _tarte_au_citron_default_settings() to allow modules to alter the
 * default settings.
 *
 * @param $settings
 *   The associative array of settings.
 *
 * @see _tarte_au_citron_default_settings()
 * @see tarte_au_citron_settings_form_submit()
 *
 * @ingroup tarte_au_citron
 */
function hook_tarte_au_citron_default_settings_alter(&$settings){
  $settings['new_settings'] = 'value';
}

/**
 * Alter tarte au citron texts.
 *
 * Called by _tarte_au_citron_default_translate() to allow modules to alter the
 * default texts.
 *
 * @param $translate
 *   The associative array of texts.
 *
 * @see _tarte_au_citron_default_translate()
 * @see tarte_au_citron_translate_form_submit()
 *
 * @ingroup tarte_au_citron
 */
function hook_tarte_au_citron_default_translate_alter(&$translate){
  $translate['en']['code'] = 'new translated sentence';
}
