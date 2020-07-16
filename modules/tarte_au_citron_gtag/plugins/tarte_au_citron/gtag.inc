<?php

$plugin = array(
  'title' => t('Google Tag (Provided by Tarte au citron)'),
);

function tarte_au_citron_gtag_gtag_configure(&$form, $config) {
  $form['gtagUa'] = array(
    '#type' => 'textfield',
    '#title' => t('Gtag UA'),
    '#description' => t('Parameter for tarte au citron @serviceName service.', ['@serviceName' => 'Gtag']),
    '#default_value' => isset($config['gtagUa']) ? $config['gtagUa'] : '',
    '#required' => TRUE
  );

  $form['gtagMore'] = [
    '#type' => 'markup',
    '#markup' => t('<p><strong>@varName</strong></p><p>You must implement the hook hook_tarte_au_citron_@pluginId in a module and add a js file to define the function tarteaucitron.user.@functionName</p>', array('@varName' => 'Gtag More', '@pluginId' => 'gtag', '@functionName' => 'gtagMore'))
  ];
}

function tarte_au_citron_gtag_gtag_add_js(&$library, &$data, $settings) {
  $data = array_merge($settings, $data);
}
