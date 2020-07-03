<?php

function _tarte_au_citron_default_translate() {
  $ret = array(
    'middleBarHead' =>  t('☝ 🍪', array(), array('langcode' => 'en')),
    'adblock' =>  t('Hello! This site is transparent and lets you chose the 3rd party services you want to allow.', array(), array('langcode' => 'en')),
    'adblock_call' =>  t('Please disable your adblocker to start customizing.', array(), array('langcode' => 'en')),
    'reload' =>  t('Refresh the page', array(), array('langcode' => 'en')),
    'alertBigScroll' =>  t('By continuing to scroll,', array(), array('langcode' => 'en')),
    'alertBigClick' =>  t('If you continue to browse this website,', array(), array('langcode' => 'en')),
    'alertBig' =>  t('you are allowing all third-party services', array(), array('langcode' => 'en')),
    'alertBigPrivacy' =>  t('This site uses cookies and gives you control over what you want to activate', array(), array('langcode' => 'en')),
    'alertSmall' =>  t('Manage services', array(), array('langcode' => 'en')),
    'personalize' =>  t('Personalize', array(), array('langcode' => 'en')),
    'acceptAll' =>  t('OK, accept all', array(), array('langcode' => 'en')),
    'close' =>  t('Close', array(), array('langcode' => 'en')),
    'privacyUrl' =>  t('Privacy policy', array(), array('langcode' => 'en')),
    'all' =>  t('Preference for all services', array(), array('langcode' => 'en')),
    'info' =>  t('Protecting your privacy', array(), array('langcode' => 'en')),
    'disclaimer' =>  t('By allowing these third party services, you accept their cookies and the use of tracking technologies necessary for their proper functioning.', array(), array('langcode' => 'en')),
    'allow' =>  t('Allow', array(), array('langcode' => 'en')),
    'deny' =>  t('Deny', array(), array('langcode' => 'en')),
    'noCookie' =>  t('This service does not use cookie.', array(), array('langcode' => 'en')),
    'useCookie' =>  t('This service can install', array(), array('langcode' => 'en')),
    'useCookieCurrent' =>  t('This service has installed', array(), array('langcode' => 'en')),
    'useNoCookie' =>  t('This service has not installed any cookie.', array(), array('langcode' => 'en')),
    'more' =>  t('Read more', array(), array('langcode' => 'en')),
    'source' =>  t('View the official website', array(), array('langcode' => 'en')),
    'credit' =>  t('Cookies manager by tarteaucitron.js', array(), array('langcode' => 'en')),
    'noServices' =>  t('This website does not use any cookie requiring your consent.', array(), array('langcode' => 'en')),
    'toggleInfoBox' =>  t('Show/hide informations about cookie storage', array(), array('langcode' => 'en')),
    'title' =>  t('Cookies management panel', array(), array('langcode' => 'en')),
    'cookieDetail' =>  t('Cookie detail for', array(), array('langcode' => 'en')),
    'ourSite' =>  t('on our site', array(), array('langcode' => 'en')),
    'newWindow' =>  t('(new window)', array(), array('langcode' => 'en')),
    'allowAll' =>  t('Allow all cookies', array(), array('langcode' => 'en')),
    'denyAll' =>  t('Deny all cookies', array(), array('langcode' => 'en')),
    'fallback' =>  t('is disabled.', array(), array('langcode' => 'en')),
    'ads' => array(
      'title' =>  t('Advertising network', array(), array('langcode' => 'en')),
      'details' =>  t('Ad networks can generate revenue by selling advertising space on the site.', array(), array('langcode' => 'en')),
    ),
    'analytic' => array(
      'title' =>  t('Audience measurement', array(), array('langcode' => 'en')),
      'details' =>  t('The audience measurement services used to generate useful statistics attendance to improve the site.', array(), array('langcode' => 'en')),
    ),
    'social' => array(
      'title' =>  t('Social networks', array(), array('langcode' => 'en')),
      'details' =>  t('Social networks can improve the usability of the site and help to promote it via the shares.', array(), array('langcode' => 'en')),
    ),
    'video' => array(
      'title' =>  t('Videos', array(), array('langcode' => 'en')),
      'details' =>  t('Video sharing services help to add rich media on the site and increase its visibility.', array(), array('langcode' => 'en')),
    ),
    'comment' => array(
      'title' =>  t('Comments', array(), array('langcode' => 'en')),
      'details' =>  t('Comments managers facilitate the filing of comments and fight against spam.', array(), array('langcode' => 'en')),
    ),
    'support' => array(
      'title' =>  t('Support', array(), array('langcode' => 'en')),
      'details' =>  t('Support services allow you to get in touch with the site team and help to improve it.', array(), array('langcode' => 'en')),
    ),
    'api' => array(
      'title' =>  t('APIs', array(), array('langcode' => 'en')),
      'details' =>  t('APIs are used to load scripts: geolocation, search engines, translations, ...', array(), array('langcode' => 'en')),
    ),
    'other' => array(
      'title' =>  t('Other', array(), array('langcode' => 'en')),
      'details' =>  t('Services to display web content.', array(), array('langcode' => 'en')),
    )
  );

  $services = tarte_au_citron_get_all_plugins();
  foreach ($services as $service_id => $service_infos) {
    $ret['engage-' . $service_id] = t('@name is disabled.', array('@name' => $service_infos['title']), array('langcode' => 'en'));
  }

  drupal_alter('tarte_au_citron_default_translate', $ret);

  return $ret;
}

function tarte_au_citron_translate_form($form, &$form_state)
{
  $default_config = _tarte_au_citron_default_translate();
  $config = variable_get('tarte_au_citron_texts', $default_config);
  $form = array();
  $localModuleInstalled = module_exists('locale');

  $translate = '';
  if ($localModuleInstalled) {
    $translate = t('<b>Important, you need to use english</b> and then translate the text on the !translate page.<br>', ['!translate' => l(t('User interface translation'), 'admin/config/regional/translate/translate')]);
  }

  $form['texts'] = array(
    '#prefix' => '<p>' . $translate . t('Enter the text that will be presented to your website users. The same text is used in both the cookie declaration and the consent dialog.') .  '</p>',
    '#type' => 'container',
    '#tree' => TRUE
  );

  $weight = 0;
  foreach ($default_config as $key_text => $value_text) {
    if (is_string($value_text)) {
      $prefix = '<strong>' . $value_text . '</strong><br>';

      $default_value = NULL;
      if (!empty($config[$key_text]) && $config[$key_text] != $value_text) {
        $default_value = $config[$key_text];
      }
      $form['texts'][$key_text] = array(
        '#prefix' => $prefix,
        '#type' => 'textarea',
        '#title' => $value_text,
        '#title_display' => 'invisible',
        '#default_value' => $default_value,
        '#description' => '',
      );

      if (strpos($key_text, 'engage-') === 0) {
        $form['texts'][$key_text]['#weight'] = 99;
      }
      else {
        $form['texts'][$key_text]['#weight'] = $weight;
        $weight++;
      }
    }
    else if (is_array($value_text)) {
      $form['texts'][$key_text] = array(
        '#type' => 'container',
        '#tree' => TRUE,
        '#weight' => $weight
      );
      $weight++;

      foreach ($value_text as $sub_key_text => $sub_value_text) {
        $prefix = '<strong>' . $sub_value_text . '</strong><br>';

        $default_value = NULL;
        if (!empty($config[$key_text][$sub_key_text]) && $config[$key_text][$sub_key_text] != $sub_value_text) {
          $default_value = $config[$key_text][$sub_key_text];
        }
        $form['texts'][$key_text][$sub_key_text] = array(
          '#prefix' => $prefix,
          '#type' => 'textarea',
          '#title' => $sub_value_text,
          '#title_display' => 'invisible',
          '#default_value' => $default_value,
          '#description' => '',
        );
      }
    }

  }

  $form['save'] = array(
    '#type' => 'submit',
    '#value' => t('Save'),
    '#submit' => array('tarte_au_citron_translate_form_submit'),
  );

  $form['clear_cache'] = array(
    '#type' => 'submit',
    '#value' => t('Clear Tarte au citon translation cache'),
    '#submit' => array('tarte_au_citron_translate_form_clear_cache_submit'),
  );
  return $form;
}

function tarte_au_citron_translate_form_submit($form, &$form_state) {
  form_state_values_clean($form_state);
  $values = $form_state['values']['texts'];
  $default_values = _tarte_au_citron_default_translate();

  foreach ($values as $key_text => $key_value) {
    if (is_array($key_value)) {
      foreach ($key_value as $subkey_text => $subkey_value) {
        if (empty($subkey_value)) {
          $values[$key_text][$subkey_text] = $default_values[$key_text][$subkey_text];
        }
      }
    }
    elseif (empty($key_value)) {
      $values[$key_text] = $default_values[$key_text];
    }
  }
  variable_set('tarte_au_citron_texts', $values);
}

function tarte_au_citron_translate_form_clear_cache_submit($form, &$form_state) {
  cache_clear_all('tarte_au_citron_translate', 'cache');
}
