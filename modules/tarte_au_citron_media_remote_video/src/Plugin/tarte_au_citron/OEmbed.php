<?php

namespace Drupal\tarte_au_citron_media_remote_video\Plugin\tarte_au_citron;

use Drupal\tarte_au_citron\ServicePluginBase;

/**
 * A remote video service plugin.
 *
 * @TarteAuCitronService(
 *   id = "oembed",
 *   title = @Translation("oEmbed source"),
 *   deriver = "Drupal\tarte_au_citron_media_remote_video\Plugin\tarte_au_citron\OEmbedDeriver"
 * )
 */
class OEmbed extends ServicePluginBase {

  /**
   * {@inheritdoc}
   */
  protected function getLibraryName() {
    return 'tarte_au_citron_media_remote_video/' . $this->getPluginDefinition()['id'];
  }

}
