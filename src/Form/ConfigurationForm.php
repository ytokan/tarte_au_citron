<?php

namespace Drupal\tarte_au_citron\Form;

use Drupal\Component\Utility\Html;
use Drupal\Core\Form\FormStateInterface;

/**
 * Implements an example form.
 */
class ConfigurationForm extends AbstractForm {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'tarte_au_citron_configuration_form';
  }

  /**
   * The editable config name.
   */
  protected function getEditableConfigNames() {
    return ['tarte_au_citron.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Chosen settings:
    $config = $this->configFactory->get('tarte_au_citron.settings');

    $form['title_conf'] = [
      '#type' => 'markup',
      '#markup' => '<h2><b>' . $this->t('Parameters') . '</b></h2>',
    ];

    $form['hashtag'] = [
      '#title' => $this->t('Open the panel with this hashtag'),
      '#type' => 'textfield',
      '#default_value' => $config->get('hashtag'),
    ];

    $form['cookieName'] = [
      '#title' => $this->t('Cookie name'),
      '#type' => 'textfield',
      '#default_value' => $config->get('cookieName'),
    ];

    $form['orientation'] = [
      '#title' => $this->t('Banner position (top - middle - bottom)'),
      '#type' => 'select',
      '#options' => [
        'top' => $this->t('Top'),
        'middle' => $this->t('Middle'),
        'bottom' => $this->t('Bottom'),
      ],
      '#required' => TRUE,
      '#default_value' => $config->get('orientation'),
    ];

    $form['mandatory'] = [
      '#title' => $this->t('Show a message about mandatory cookies'),
      '#type' => 'checkbox',
      '#default_value' => $config->get('mandatory'),
    ];

    $form['showAlertSmall'] = [
      '#title' => $this->t('Show the small banner on bottom right'),
      '#type' => 'checkbox',
      '#default_value' => $config->get('showAlertSmall'),
    ];

    $form['cookieslist'] = [
      '#title' => $this->t('Show the cookie list'),
      '#type' => 'checkbox',
      '#default_value' => $config->get('cookieslist'),
    ];

    $form['showIcon'] = [
      '#title' => $this->t('Show cookie icon to manage cookies'),
      '#type' => 'checkbox',
      '#default_value' => $config->get('showIcon'),
    ];

    $form['iconPosition'] = [
      '#title' => $this->t('Position of the icon (bottom right - bottom left - top right - top left)'),
      '#type' => 'select',
      '#options' => [
        'BottomRight' => $this->t('Bottom right'),
        'BottomLeft' => $this->t('Bottom left'),
        'TopRight' => $this->t('Top right'),
        'TopLeft' => $this->t('Top left'),
      ],
      '#required' => TRUE,
      '#default_value' => $config->get('iconPosition'),
    ];

    $form['adblocker'] = [
      '#title' => $this->t('Show a Warning if an adblocker is detected'),
      '#type' => 'checkbox',
      '#default_value' => $config->get('adblocker'),

    ];

    $form['DenyAllCta'] = [
      '#title' => $this->t('Show the deny all button'),
      '#type' => 'checkbox',
      '#default_value' => $config->get('DenyAllCta'),
    ];

    $form['AcceptAllCta'] = [
      '#title' => $this->t('Show the accept all button when highPrivacy on'),
      '#type' => 'checkbox',
      '#default_value' => $config->get('AcceptAllCta'),
    ];

    $form['highPrivacy'] = [
      '#title' => $this->t('HIGHLY RECOMMANDED Disable auto consent'),
      '#type' => 'checkbox',
      '#default_value' => $config->get('highPrivacy'),
    ];

    $form['handleBrowserDNTRequest'] = [
      '#title' => $this->t('If Do Not Track == 1, disallow all'),
      '#type' => 'checkbox',
      '#default_value' => $config->get('handleBrowserDNTRequest'),
    ];

    $form['removeCredit'] = [
      '#title' => $this->t('Remove credit link'),
      '#type' => 'checkbox',
      '#default_value' => $config->get('removeCredit'),
    ];

    $form['moreInfoLink'] = [
      '#title' => $this->t('Show more info link'),
      '#type' => 'checkbox',
      '#default_value' => $config->get('moreInfoLink'),
    ];

    $form['useExternalCss'] = [
      '#title' => $this->t('If false, the tarteaucitron.css file will be loaded'),
      '#type' => 'checkbox',
      '#default_value' => $config->get('useExternalCss'),
    ];

    $form['privacyUrl'] = [
      '#title' => $this->t('Privacy policy url'),
      '#type' => 'textfield',
      '#placeholder' => $this->t('relative path to privacy policy'),
      '#default_value' => $config->get('privacyUrl'),
    ];

    $form['readmoreLink'] = [
      '#title' => $this->t('Change the default readmore link pointing to tarteaucitron.io'),
      '#type' => 'textfield',
      '#default_value' => $config->get('readmoreLink'),
    ];

    $form['cookieDomain'] = [
      '#title' => $this->t('Cookie Domain'),
      '#description' => $this->t('Shared cookie for multisite.'),
      '#type' => 'textfield',
      '#placeholder' => 'my-multisite-domaine.fr',
      '#default_value' => $config->get('cookieDomain'),
    ];

    $form['title_service'] = [
      '#type' => 'markup',
      '#markup' => '<h2><b>' . $this->t('Services') . '</b></h2>',
    ];

    $form['services'] = [
      '#title' => $this->t('Services enabled'),
      '#description' => $this->t('Services enabled.'),
      '#type' => 'checkboxes',
      '#options' => $this->servicesManager->getServicesOptionList(),
      '#default_value' => $config->get('services'),
    ];

    $form['services_settings'] = [
      '#type' => 'container',
      '#title' => $this->t('Services settings'),
      '#tree' => TRUE,
    ];
    foreach ($this->servicesManager->getServices() as $service) {
      $children = $service->settingsForm($form, $form_state);
      if (empty($children)) {
        continue;
      }
      $htmlId = Html::getId($service->getPluginId());
      $form['services_settings'][$service->getPluginId()] = [
        '#type' => 'fieldset',
        '#title' => $service->getPluginTitle(),
        '#states' => [
          'visible' => [
            ':input[id="edit-services-' . $htmlId . '"]' => ['checked' => TRUE],
          ],
        ],
      ];
      foreach ($children as &$current_child) {
        if (!empty($current_child['#required'])) {
          unset($current_child['#required']);
          $current_child['#states'] = [
            'required' => [
              ':input[id="edit-services-' . $service->getPluginId() . '"]' => ['checked' => TRUE],
            ],
          ];
        }
      }
      $form['services_settings'][$service->getPluginId()] += $children;
    }

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('tarte_au_citron.settings');

    $config
      ->set('hashtag', $form_state->getValue('hashtag'))
      ->set('cookieName', $form_state->getValue('cookieName'))
      ->set('orientation', $form_state->getValue('orientation'))
      ->set('mandatory', $form_state->getValue('mandatory'))
      ->set('showAlertSmall', $form_state->getValue('showAlertSmall'))
      ->set('cookieslist', $form_state->getValue('cookieslist'))
      ->set('showIcon', $form_state->getValue('showIcon'))
      ->set('iconPosition', $form_state->getValue('iconPosition'))
      ->set('adblocker', $form_state->getValue('adblocker'))
      ->set('DenyAllCta', $form_state->getValue('DenyAllCta'))
      ->set('AcceptAllCta', $form_state->getValue('AcceptAllCta'))
      ->set('highPrivacy', $form_state->getValue('highPrivacy'))
      ->set('handleBrowserDNTRequest', $form_state->getValue('handleBrowserDNTRequest'))
      ->set('removeCredit', $form_state->getValue('removeCredit'))
      ->set('moreInfoLink', $form_state->getValue('moreInfoLink'))
      ->set('useExternalCss', $form_state->getValue('useExternalCss'))
      ->set('readmoreLink', $form_state->getValue('readmoreLink'))
      ->set('privacyUrl', $form_state->getValue('privacyUrl'))
      ->set('cookieDomain', $form_state->getValue('cookieDomain'))
      ->set('services', array_filter($form_state->getValue('services')))
      ->set('services_settings', $form_state->getValue('services_settings'));

    $this->moduleHandler->alter('tarte_au_citron_config', $config, $form, $form_state);

    $config->save();

    parent::submitForm($form, $form_state);
  }

}
