<?php

module_load_include('inc', 'google_tag', 'includes/entity/container');
module_load_include('inc', 'google_tag', 'includes/entity/manager');
module_load_include('inc', 'google_tag', 'includes/entity/manager_interface');
module_load_include('inc', 'google_tag', 'includes/entity/settings');

/**
 * Defines the Google tag container manager.
 */
class TarteAuCitronGTMContainerManager extends GTMContainerManager {

  /**
   * Singleton instance of this class.
   *
   * @var TarteAuCitronGTMContainerManager
   */
  private static $instance;

  /**
   * Returns singleton instance of this class.
   *
   * @return TarteAuCitronGTMContainerManager
   *   The instance.
   */
  public static function getInstance() {
    if (!self::$instance) {
      self::$instance = new TarteAuCitronGTMContainerManager();
    }
    return self::$instance;
  }

  /**
   * {@inheritdoc}
   */
  public function getScriptAttachments(array &$page) {
    $containers = $this->loadContainers();
    foreach ($containers as $container) {
      if (!$container->insertSnippet()) {
        continue;
      }

      static $weight = 9;
      $include_script_as_file = \GTMSettings::getInstance()->get('include_file');
      $include_classes = $container->get('include_classes');
      // @todo Only want one data_layer snippet even with multiple containers.
      // If user sorts containers such that the first does not define the data
      // layer, then validate this or adjust for it here.
      // Sort the items being added and put the data_layer at top?
      $types = $include_classes ? array('data_layer') : array();

      $data_layer = $container->get('data_layer');
      if ($include_classes && module_exists('datalayer') && $data_layer == 'dataLayer') {
        $container->dataLayerSnippet($classes);
        if ($classes) {
          // Add data_layer using dataLayer module.
          datalayer_add($classes);
        }
        $types = array();
      }

      // Add data_layer and script snippets to head (no longer by default).
      if ($include_script_as_file) {
        foreach ($types as $type) {
          // @todo Will it matter if file is empty?
          // @todo Check config for the whitelist and blacklist classes before adding.
          $container->fileTag($type, $weight++);
        }
      }
      else {
        foreach ($types as $type) {
          // @see drupal_get_js() in 7.x core.
          // For inline JavaScript to validate as XHTML, all JavaScript containing
          // XHTML needs to be wrapped in CDATA.
          $container->inlineTag($type, $weight++);
        }
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getNoScriptAttachments(array &$page) {

  }

}
