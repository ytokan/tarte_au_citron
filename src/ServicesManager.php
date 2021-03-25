<?php

namespace Drupal\tarte_au_citron;

use Drupal\Component\Plugin\Mapper\MapperInterface;
use Drupal\Component\Serialization\Json;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\Session\AccountProxyInterface;

/**
 * Gathers the services plugins.
 */
class ServicesManager extends DefaultPluginManager implements ServicesManagerInterface, MapperInterface {

  /**
   * List of all available services.
   *
   * @var array
   */
  protected $optionList = NULL;

  /**
   * The config object.
   *
   * @var \Drupal\Core\Config\ImmutableConfig|null
   */
  protected $config = NULL;

  /**
   * The current user.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;

  /**
   * The tarte_au_citron cache bin.
   *
   * @var \Drupal\Core\Cache\CacheBackendInterface
   */
  protected $tarteAuCitronCache;

  /**
   * Constructs a new SectionStorageManager object.
   *
   * @param \Traversable $namespaces
   *   An object that implements \Traversable which contains the root paths
   *   keyed by the corresponding namespace to look for plugin implementations.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   Cache backend instance to use.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler to invoke the alter hook with.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory.
   * @param \Drupal\Core\Session\AccountProxyInterface $current_user
   *   The current user.
   * @param \Drupal\Core\Cache\CacheBackendInterface $tarte_au_citron_cache
   *   Cache backend instance to use.
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler, ConfigFactoryInterface $config_factory, AccountProxyInterface $current_user, CacheBackendInterface $tarte_au_citron_cache) {
    parent::__construct('Plugin/tarte_au_citron', $namespaces, $module_handler, 'Drupal\tarte_au_citron\ServicePluginInterface', 'Drupal\tarte_au_citron\Annotation\TarteAuCitronService');
    $this->alterInfo('tarte_au_citron_services_info');
    $this->config = $config_factory->get('tarte_au_citron.settings');
    $this->currentUser = $current_user;
    $this->tarteAuCitronCache = $tarte_au_citron_cache;
  }

  /**
   * Get the list of available services to use in form.
   *
   * @return array
   *   The key/value array of available services.
   */
  public function getServicesOptionList() {
    if (!isset($this->optionList)) {
      $this->optionList = [];
      foreach ($this->getDefinitions() as $id => $definition) {
        $this->optionList[$id] = $definition['title'];
      }
      asort($this->optionList, SORT_STRING | SORT_FLAG_CASE | SORT_NATURAL);
    }
    return $this->optionList;
  }

  /**
   * Get the list of available services, enabled or not.
   *
   * @param bool $enabled
   *   If service need to be enalbed.
   *
   * @return \Drupal\tarte_au_citron\ServicePluginInterface[]
   *   The array of services object.
   */
  public function getServices($enabled = FALSE) {
    $enabledServices = $this->config->get('services');

    $services = [];
    foreach ($this->getServicesOptionList() as $currentServiceId => $currentServiceLabel) {
      if ($enabled && empty($enabledServices[$currentServiceId])) {
        continue;
      }

      $config = !empty($this->config->get('services_settings')[$currentServiceId]) ? $this->config->get('services_settings')[$currentServiceId] : [];
      $services[$currentServiceId] = $this->createInstance($currentServiceId, [
        'enabled' => !empty($enabledServices[$currentServiceId]),
        'settings' => $config
      ]);
    }
    return $services;
  }

  /**
   * Get the list of available services in tarteaucitron.services.js.
   *
   * @return array
   *   The array of js services available.
   */
  public function getJsServices() {
    $cid = 'tarte_au_citron:services_js';
    $data_cached = $this->tarteAuCitronCache->get($cid);
    if (!$data_cached) {
      $relative_path = dirname(__DIR__);
      $content_json_path = $relative_path . '/js/tarte_au_citron/tarteaucitron.services.js';
      $content_json = file_get_contents($content_json_path);
      preg_match_all('/tarteaucitron\.services\.([^\s]+)/i', $content_json, $matches);

      $data_cached = $matches[1];
      sort($data_cached);

      $this->tarteAuCitronCache->set($cid, $data_cached);
    }
    return $data_cached;
  }

  /**
   * Check if service is enabled.
   *
   * @param string $serviceId
   *   The key of the service.
   *
   * @return bool
   *   TRUE if the service is enabled, FALSE otherwise.
   */
  public function isServiceEnabled($serviceId) {
    $enabledServices = $this->config->get('services');
    return !empty($enabledServices[$serviceId]);
  }

  /**
   * Check if tarte au citron is needed.
   *
   * @return bool
   *   TRUE if the service is needed, FALSE otherwise.
   */
  public function isNeeded() {
    return !$this->currentUser->hasPermission('bypass tarte au citron');
  }

}
