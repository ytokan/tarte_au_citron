<?php

namespace Drupal\tarte_au_citron_addtoany\Plugin\tarte_au_citron;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\google_tag\Entity\ContainerManagerInterface;
use Drupal\tarte_au_citron\ServicePluginBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * A AddToAny service plugin.
 *
 * @TarteAuCitronService(
 *   id = "drupal_addtoany",
 *   title = @Translation("AddToAny")
 * )
 */
class AddToAny extends ServicePluginBase {

  /**
   * {@inheritdoc}
   */
  protected function getLibraryName() {
    return 'tarte_au_citron_addtoany/addtoany';
  }

}
