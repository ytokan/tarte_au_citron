<?php

namespace Drupal\tarte_au_citron_recaptcha\Plugin\tarte_au_citron;

use Drupal\tarte_au_citron\ServicePluginBase;

/**
 * A reCAPTCHA service plugin.
 *
 * @TarteAuCitronService(
 *   id = "drupal_recaptcha",
 *   title = @Translation("reCAPTCHA")
 * )
 */
class Recaptcha extends ServicePluginBase {

  /**
   * {@inheritdoc}
   */
  protected function getLibraryName() {
    return 'tarte_au_citron_recaptcha/recaptcha';
  }

}
