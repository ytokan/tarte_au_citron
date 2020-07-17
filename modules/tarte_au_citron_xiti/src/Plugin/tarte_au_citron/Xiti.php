<?php

namespace Drupal\tarte_au_citron_xiti\Plugin\tarte_au_citron;

use Drupal\Core\Form\FormStateInterface;
use Drupal\tarte_au_citron\ServicePluginBase;

/**
 * A xiti service plugin.
 *
 * @TarteAuCitronService(
 *   id = "xiti",
 *   title = @Translation("AT Internet (Xiti)")
 * )
 */
class Xiti extends ServicePluginBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'xitiId' => '',
      'xitiMore' => '',
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements = parent::settingsForm($form, $form_state);
    $elements['xitiId'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Xiti Id'),
      '#description' => $this->t('Parameter Xiti Id for tarte au citron @serviceName service.', ['@serviceName' => $this->getPluginTitle()]),
      '#default_value' => $this->getSetting('xitiId'),
      '#required' => TRUE,
      '#placeholder' => $this->t('YOUR-ID'),
    ];

    $elements['xitiMore'] = [
      '#type' => 'markup',
      '#markup' => $this->t(
        '<p><strong>@varName</strong></p><p>You must implement the hook "hook_icdc_tarte_au_citron_@pluginId_alter" in a module and add a js file to define the function "tarteaucitron.user.@functionName"</p>',
        [
          '@varName' => 'Xiti More',
          '@pluginId' => $this->getPluginId(),
          '@functionName' => 'xitiMore',
        ]
      ),
    ];

    return $elements;
  }

}
