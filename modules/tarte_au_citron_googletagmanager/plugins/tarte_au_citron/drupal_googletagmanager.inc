<?php

$plugin = array(
  'title' => t('Google Tag Manager'),
);

function tarte_au_citron_googletagmanager_drupal_googletagmanager_add_js(&$library, &$data, $settings) {
  $library['js'][drupal_get_path('module', 'tarte_au_citron_googletagmanager') . '/js/tarte_au_citron_googletagmanager.js'] = array();

  module_load_include('inc', 'tarte_au_citron_googletagmanager', 'includes/entity/manager');
  $data['googletagmanagerId'] = array();
  $manager = \TarteAuCitronGTMContainerManager::getInstance();
  foreach ($manager->loadContainers() as $container) {
    $data['googletagmanagerId'][] = $container->get('container_id');
  }
}
