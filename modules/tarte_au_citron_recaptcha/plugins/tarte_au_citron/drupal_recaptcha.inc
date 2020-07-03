<?php

$plugin = array(
  'title' => t('Recaptcha'),
);

function tarte_au_citron_recaptcha_drupal_recaptcha_add_js(&$library, &$data, $settings) {
  global $language;
  $library['js'][drupal_get_path('module', 'tarte_au_citron_recaptcha') . '/js/tarte_au_citron_recaptcha.js'] = array();
  $data['recaptchaHl'] = $language->language;
}
