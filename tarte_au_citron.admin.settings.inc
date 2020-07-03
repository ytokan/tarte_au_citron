<?php

function _tarte_au_citron_default_settings() {
  $ret = array(
    'hashtag' => '#tarteaucitron',
    'cookieName' => 'tarteaucitron',
    'orientation' => 'middle',
    'showAlertSmall' => TRUE,
    'cookieslist' => TRUE,
    'adblocker' => FALSE,
    'AcceptAllCta' => TRUE,
    'highPrivacy' => TRUE,
    'handleBrowserDNTRequest' => FALSE,
    'removeCredit' => FALSE,
    'moreInfoLink' => TRUE,
    'useExternalCss' => FALSE,
    'privacyUrl' => '',
    'readmoreLink' => '',
    'cookieDomain' => '',
    'services' => array()
  );

  drupal_alter('tarte_au_citron_default_settings', $ret);

  return $ret;
}

function tarte_au_citron_settings_form($form, &$form_state)
{
  $config = variable_get('tarte_au_citron', _tarte_au_citron_default_settings());
  $form = array();
  $form['title_conf'] = array(
    '#type' => 'markup',
    '#markup' => '<h2><b>' . t('Parameters') . '</b></h2>',
  );
  $form['hashtag'] = array(
    '#title' => 'Hashtag',
    '#description' => t('Open the panel with this hashtag.'),
    '#type' => 'textfield',
    '#default_value' => $config['hashtag']
  );

  $form['cookieName'] = array(
    '#title' => t('Cookie Name'),
    '#description' => t('Cookie name.'),
    '#type' => 'textfield',
    '#default_value' => $config['cookieName']
  );

  $form['orientation'] = array(
    '#title' => t('Orientation'),
    '#description' => t('Banner position (top - middle - bottom).'),
    '#type' => 'select',
    '#options' => array(
      'top' => t('Top'),
      'middle' => t('Middle'),
      'bottom' => t('Bottom'),
    ),
    '#required' => TRUE,
    '#default_value' => $config['orientation']
  );

  $form['checkboxes'] = array(
    '#type' => 'container',
    '#title' => t('Checkboxes'),
    '#title_display' => 'invisible',
  );

  $form['checkboxes']['showAlertSmall'] = array(
    '#title' => t('Show alert small'),
    '#description' => t('Show the small banner on bottom right.'),
    '#type' => 'checkbox',
    '#default_value' => $config['showAlertSmall']
  );

  $form['checkboxes']['cookieslist'] = array(
    '#title' => t('Cookies list'),
    '#description' => t('Show the cookie list.'),
    '#type' => 'checkbox',
    '#default_value' => $config['cookieslist']
  );

  $form['checkboxes']['adblocker'] = array(
    '#title' => 'Adblocker',
    '#description' => t('Show a Warning if an adblocker is detected.'),
    '#type' => 'checkbox',
    '#default_value' => $config['adblocker']

  );

  $form['checkboxes']['AcceptAllCta'] = array(
    '#title' => t('Accept All Cta'),
    '#description' => t('Show the accept all button when high Privacy on.'),
    '#type' => 'checkbox',
    '#default_value' => $config['AcceptAllCta']
  );

  $form['checkboxes']['highPrivacy'] = array(
    '#title' => t('High Privacy'),
    '#description' => t('Disable auto consent.'),
    '#type' => 'checkbox',
    '#default_value' => $config['highPrivacy']
  );

  $form['checkboxes']['handleBrowserDNTRequest'] = array(
    '#title' => t('Handle browser do not track request'),
    '#description' => t('If Do Not Track == 1, disallow all.'),
    '#type' => 'checkbox',
    '#default_value' => $config['handleBrowserDNTRequest']
  );

  $form['checkboxes']['removeCredit'] = array(
    '#title' => t('Remove credit'),
    '#description' => t('Remove credit link.'),
    '#type' => 'checkbox',
    '#default_value' => $config['removeCredit']
  );

  $form['checkboxes']['moreInfoLink'] = array(
    '#title' => t('More info link'),
    '#description' => t('Show more info link.'),
    '#type' => 'checkbox',
    '#default_value' => $config['moreInfoLink']
  );

  $form['checkboxes']['useExternalCss'] = array(
    '#title' => t('Use external css'),
    '#description' => t('If not checked, the tarteaucitron.css file will be loaded. If you want to customize the appearance of tarte au citron component, add your own css file based on tarteaucitron.css in a module or theme.'),
    '#type' => 'checkbox',
    '#default_value' => $config['useExternalCss']
  );

  $form['privacyUrl'] = array(
    '#title' => t('Privacy Url'),
    '#description' => t('Privacy policy.'),
    '#type' => 'textfield',
    '#placeholder' =>  t('relative path to privacy policy'),
    '#default_value' => $config['privacyUrl']
  );

  $form['readmoreLink'] = array(
    '#title' => t('Read more link'),
    '#description' => t('Change the default readmore link.'),
    '#type' => 'textfield',
    '#default_value' => $config['readmoreLink']
  );

  $form['cookieDomain'] = array(
    '#title' => t('Cookie Domain'),
    '#description' => t('Shared cookie for multisite.'),
    '#type' => 'textfield',
    '#placeholder' => 'my-multisite-domaine.fr',
    '#default_value' => $config['cookieDomain']
  );

  $form['title_service'] = array(
    '#type' => 'markup',
    '#markup' => '<h2><b>' . t('Services') . '</b></h2>',
    '#weight' => 97,
  );

  $services = tarte_au_citron_get_all_plugins();
  $form['services'] = array(
    '#title' => t('Services enabled'),
    '#description' => t('Services enabled.'),
    '#type' => 'checkboxes',
    '#options' => array(),
    '#default_value' => $config['services'],
    '#weight' => 98,
  );

  $form['services_settings'] = array(
    '#type' => 'container',
    '#title' => t('Services settings'),
    '#tree' => TRUE,
    '#weight' => 99,
  );
  foreach ($services as $service_id => $service_infos) {
    $form['services']['#options'][$service_id] = $service_infos['title'];
    if (!empty($service_infos['configure']) && function_exists($service_infos['configure'])) {
      $html_service_id = drupal_html_id($service_id);

      $form['services_settings'][$service_id] = array(
        '#type' => 'fieldset',
        '#title' => $service_infos['title'],
        '#states' => array(
          'visible' => array(
            ':input[id="edit-services-' . $html_service_id . '"]' => array('checked' => TRUE),
          ),
        ),
      );

      call_user_func_array(
        $service_infos['configure'],
        array(
          &$form['services_settings'][$service_id],
          !empty($config['services_settings'][$service_id]) ? $config['services_settings'][$service_id] : array()
        )
      );

      foreach (element_children($form['services_settings'][$service_id]) as $current_child) {
        if (isset($form['services_settings'][$service_id][$current_child]['#required']) && $form['services_settings'][$service_id][$current_child]['#required']) {
          unset($form['services_settings'][$service_id][$current_child]['#required']);
          if (empty($form['services_settings'][$service_id][$current_child]['#element_validate'])) {
            $form['services_settings'][$service_id][$current_child]['#element_validate'] = array();
          }
          $form['services_settings'][$service_id][$current_child]['#element_validate'][] = '_tarte_au_citron_settings_form_required_validate';

          if (empty($form['services_settings'][$service_id][$current_child]['#states'])) {
            $form['services_settings'][$service_id][$current_child]['#states'] = array();
          }
          $form['services_settings'][$service_id][$current_child]['#states']['required'] = array(
            ':input[id="edit-services-' . $html_service_id . '"]' => array('checked' => TRUE),
          );
        }
      }
    }
  }

  asort($form['services']['#options']);

  $form['save'] = array(
    '#type' => 'submit',
    '#value' => t('Save'),
    '#submit' => array('tarte_au_citron_settings_form_submit'),
    '#weight' => 100,
  );
  return $form;
}

function _tarte_au_citron_settings_form_required_validate($element, &$form_state) {
  $t = get_t();

  $services_enabled = array_filter($form_state['values']['services']);
  if (!in_array($element['#parents'][1], $services_enabled)) {
    return;
  }

  // A simple call to empty() will not cut it here as some fields, like
  // checkboxes, can return a valid value of '0'. Instead, check the
  // length if it's a string, and the item count if it's an array.
  // An unchecked checkbox has a #value of integer 0, different than string
  // '0', which could be a valid value.
  $is_countable = is_array($element['#value']) || $element['#value'] instanceof Countable;
  $is_empty_multiple = $is_countable && count($element['#value']) == 0;
  $is_empty_string = (is_string($element['#value']) && drupal_strlen(trim($element['#value'])) == 0);
  $is_empty_value = ($element['#value'] === 0);
  $is_empty_null = is_null($element['#value']);
  if ($is_empty_multiple || $is_empty_string || $is_empty_value || $is_empty_null) {
    // Although discouraged, a #title is not mandatory for form elements. In
    // case there is no #title, we cannot set a form error message.
    // Instead of setting no #title, form constructors are encouraged to set
    // #title_display to 'invisible' to improve accessibility.
    if (isset($element['#title'])) {
      form_error($element, $t('!name field is required.', array('!name' => $element['#title'])));
    }
    else {
      form_error($element);
    }
  }
}

function tarte_au_citron_settings_form_submit($form, &$form_state) {
  $services = tarte_au_citron_get_all_plugins();
  $services_enabled = array_filter($form_state['values']['services']);
  $services_enabled = array_intersect_key($services, $services_enabled);
  form_state_values_clean($form_state);
  $values = $form_state['values'];

  $bool_val = element_children($form['checkboxes']);
  foreach ($bool_val as $current_bool_val) {
    $values[$current_bool_val] = boolval($values[$current_bool_val]);
  }

  foreach ($services_enabled as $service_id => $service_infos) {
    if (!empty($service_infos['save']) && function_exists($service_infos['save'])) {
      call_user_func_array(
        $service_infos['save'],
        array(
          $form['services_settings'][$service_id],
          &$values['services_settings'][$service_id]
        )
      );
    }
  }

  variable_set('tarte_au_citron', $values);
}
