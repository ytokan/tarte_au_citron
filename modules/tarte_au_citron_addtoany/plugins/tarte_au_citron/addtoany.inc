<?php

$plugin = array(
  'title' => t('Add To Any'),
);

function tarte_au_citron_addtoany_addtoany_add_js(&$library, &$data, $settings) {
  $library['js'][drupal_get_path('module', 'tarte_au_citron_addtoany') . '/js/tarte_au_citron_addtoany.js'] = array();
}

