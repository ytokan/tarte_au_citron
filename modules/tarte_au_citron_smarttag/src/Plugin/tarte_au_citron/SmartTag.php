<?php

namespace Drupal\tarte_au_citron_smarttag\Plugin\tarte_au_citron;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\google_tag\Entity\ContainerManagerInterface;
use Drupal\tarte_au_citron\ServicePluginBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * A Google Tag Manager service plugin.
 *
 * @TarteAuCitronService(
 *   id = "drupal_xiti_smarttag",
 *   title = @Translation("AT Internet (SmartTag)")
 * )
 */
class SmartTag extends ServicePluginBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'xiti_smarttagSiteId' => '',
      'xiti_smarttagLocalPath' => '',
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements = parent::settingsForm($form, $form_state);
    $elements['xiti_smarttagSiteId'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Xiti SmartTag Id'),
      '#description' => $this->t('Parameter Xiti SmartTag Id for tarte au citron @serviceName service.', ['@serviceName' => $this->getPluginTitle()]),
      '#default_value' => $this->getSetting('xiti_smarttagSiteId'),
      '#placeholder' => $this->t('YOUR-ID'),
    ];

    $elements['xiti_smarttagLocalPath'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Xiti SmartTag Local Path'),
      '#description' => $this->t('Parameter Xiti SmartTag local path for tarte au citron @serviceName service.', ['@serviceName' => $this->getPluginTitle()]),
      '#default_value' => $this->getSetting('xiti_smarttagLocalPath'),
      '#placeholder' => $this->t('PATH-TO-XITI-SMARTTAG-JS'),
    ];

    $elements['xiti_smarttagMore'] = [
      '#type' => 'markup',
      '#markup' => $this->t(
        '<p><strong>@varName</strong></p><p>You must implement the hook "hook_tarte_au_citron_@pluginId_alter" in a module and add a js file to define the function "tarteaucitron.user.@functionName"</p>',
        [
          '@varName' => 'Xiti SmartTag More',
          '@pluginId' => $this->getPluginId(),
          '@functionName' => 'xiti_smarttagMore',
        ]
      ),
    ];

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  protected function getLibraryName() {
    return 'tarte_au_citron_smarttag/smarttag';
  }

}
