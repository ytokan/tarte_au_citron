<?php

$plugin = array(
  'title' => t('Xiti'),
);

function tarte_au_citron_xiti_xiti_configure(&$form, $config) {
  $form['xitiId'] = array(
    '#type' => 'textfield',
    '#title' => t('Xiti Id'),
    '#description' => t('Parameter for tarte au citron @serviceName service.', ['@serviceName' => 'Xiti']),
    '#default_value' => isset($config['xitiId']) ? $config['xitiId'] : '',
    '#required' => TRUE
  );

  $form['xitiMore'] = [
    '#type' => 'markup',
    '#markup' => t('<p><strong>@varName</strong></p><p>You must implement the hook hook_tarte_au_citron_@pluginId in a module and add a js file to define the function tarteaucitron.user.@functionName</p>', array('@varName' => 'Xiti More', '@pluginId' => 'xiti', '@functionName' => 'xitiMore'))
  ];
}

function tarte_au_citron_xiti_xiti_add_js(&$library, &$data, $settings) {
  $data = array_merge($settings, $data);
}
