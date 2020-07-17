<?php

namespace Drupal\tarte_au_citron_gtag\Plugin\tarte_au_citron;

use Drupal\Core\Form\FormStateInterface;
use Drupal\tarte_au_citron\ServicePluginBase;

/**
 * A gtag service plugin.
 *
 * @TarteAuCitronService(
 *   id = "gtag",
 *   title = @Translation("Google Analytics (gtag.js)")
 * )
 */
class Gtag extends ServicePluginBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'gtagUa' => '',
      'gtagMore' => '',
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements = parent::settingsForm($form, $form_state);
    $elements['gtagUa'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Gtag UA'),
      '#description' => $this->t('Parameter Gtag UA for tarte au citron @serviceName service.', ['@serviceName' => $this->getPluginTitle()]),
      '#default_value' => $this->getSetting('gtagUa'),
      '#required' => TRUE,
      '#placeholder' => $this->t('GTAG-UA'),
    ];

    $elements['gtagMore'] = [
      '#type' => 'markup',
      '#markup' => $this->t(
        '<p><strong>@varName</strong></p><p>You must implement the hook "hook_icdc_tarte_au_citron_@pluginId_alter" in a module and add a js file to define the function "tarteaucitron.user.@functionName"</p>',
        [
          '@varName' => 'Gtag More',
          '@pluginId' => $this->getPluginId(),
          '@functionName' => 'gtagMore',
        ]
      ),
    ];

    return $elements;
  }

}
