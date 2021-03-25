<?php

namespace Drupal\tarte_au_citron\Form;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\tarte_au_citron\ServicesManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Implements an abstract form.
 */
abstract class AbstractForm extends ConfigFormBase {

  /**
   * The module handler.
   *
   * @var \Drupal\Core\Extension\ModuleHandlerInterface
   */
  protected $moduleHandler;

  /**
   * The service manager.
   *
   * @var \Drupal\tarte_au_citron\ServicesManagerInterface
   */
  protected $servicesManager;

  /**
   * {@inheritdoc}
   */
  public function __construct(ConfigFactoryInterface $config_factory, ModuleHandlerInterface $module_handler, ServicesManagerInterface $servicesManager) {
    parent::__construct($config_factory);
    $this->moduleHandler = $module_handler;
    $this->servicesManager = $servicesManager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory'),
      $container->get('module_handler'),
      $container->get('tarte_au_citron.services_manager')
    );
  }

}
