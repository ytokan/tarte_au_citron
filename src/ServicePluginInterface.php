<?php

namespace Drupal\tarte_au_citron;

use Drupal\Component\Plugin\PluginInspectionInterface;

/**
 * Providers an interface for embed providers.
 */
interface ServicePluginInterface extends PluginInspectionInterface {

  /**
   * Process js when plugin is added to the dom.
   */
  public function addJs(array &$page, array &$data);

  /**
   * Check if plugin is enabled.
   */
  public function isEnabled();

}
