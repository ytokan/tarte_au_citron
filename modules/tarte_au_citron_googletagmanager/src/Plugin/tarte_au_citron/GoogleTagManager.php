<?php

namespace Drupal\tarte_au_citron_googletagmanager\Plugin\tarte_au_citron;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\google_tag\Entity\ContainerManagerInterface;
use Drupal\tarte_au_citron\ServicePluginBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * A Google Tag Manager service plugin.
 *
 * @TarteAuCitronService(
 *   id = "drupal_googletagmanager",
 *   title = @Translation("Google Tag Manager")
 * )
 */
class GoogleTagManager extends ServicePluginBase {

  /**
   * The container manager from google_tag module.
   *
   * @var \Drupal\google_tag\Entity\ContainerManagerInterface
   */
  protected $containerManager;

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Create a plugin with the given input.
   *
   * @param array $configuration
   *   The configuration of the plugin.
   * @param string $plugin_id
   *   The plugin id.
   * @param array $plugin_definition
   *   The plugin definition.
   * @param \Drupal\google_tag\Entity\ContainerManagerInterface $container_manager
   *   The google tag container manager.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   *
   * @throws \Exception
   */
  public function __construct(array $configuration, $plugin_id, array $plugin_definition, ContainerManagerInterface $container_manager, EntityTypeManagerInterface $entity_type_manager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->enabled = $configuration['enabled'];
    if (!empty($configuration['settings'])) {
      $this->setSettings($configuration['settings']);
    }
    $this->containerManager = $container_manager;
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('google_tag.container_manager'),
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  protected function getLibraryName() {
    return 'tarte_au_citron_googletagmanager/googletagmanager';
  }

  /**
   * {@inheritdoc}
   */
  public function addJs(array &$page, array &$data) {
    parent::addJs($page, $data);
    $ids = $this->containerManager->loadContainerIDs();
    $containers = $this->entityTypeManager->getStorage('google_tag_container')->loadMultiple($ids);
    $data['googletagmanagerId'] = [];
    foreach ($containers as $container) {
      /**
       * @var \Drupal\google_tag\Entity\Container $container
       */
      $data['googletagmanagerId'][] = $container->variableClean('container_id');
    }
  }

}
