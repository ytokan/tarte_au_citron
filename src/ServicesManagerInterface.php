<?php

namespace Drupal\tarte_au_citron;

/**
 * Interface for the class that gathers the provider plugins.
 */
interface ServicesManagerInterface {

  /**
   * Get an options list suitable for services selection.
   *
   * @return array
   *   An array of options keyed by plugin ID with label values.
   */
  public function getServicesOptionList();

  /**
   * Get an array of Service Object which are enabled.
   *
   * @param bool $enabled
   *   Only return enabled services.
   *
   * @return \Drupal\tarte_au_citron\ServicePluginBase[]
   *   An array of enabled services.
   */
  public function getServices($enabled = FALSE);

  /**
   * Get the list of available services in tarteaucitron.services.js.
   *
   * @return array
   *   The array of js services available.
   */
  public function getJsServices();

  /**
   * Check if a service is enabled.
   *
   * @param string $serviceId
   *   The service key.
   *
   * @return bool
   *   TRUE if service is enabled, FALSE otherwise.
   */
  public function isServiceEnabled($serviceId);

  /**
   * Check if tarte au citron is needed.
   *
   * @return bool
   *   TRUE if the service is needed, FALSE otherwise.
   */
  public function isNeeded();

}
