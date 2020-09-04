<?php

namespace Drupal\tarte_au_citron_media_remote_video\Plugin\Field\FieldFormatter;

use Drupal\Component\Plugin\PluginManagerInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\media\IFrameUrlHelper;
use Drupal\media\OEmbed\ResourceFetcherInterface;
use Drupal\media\OEmbed\UrlResolverInterface;
use Drupal\media\Plugin\Field\FieldFormatter\OEmbedFormatter as OldOEmberFormatter;
use Drupal\tarte_au_citron\ServicesManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Plugin implementation of the 'oembed' formatter.
 *
 * @internal
 *   This is an internal part of the oEmbed system and should only be used by
 *   oEmbed-related code in Drupal core.
 *
 * @FieldFormatter(
 *   id = "oembed",
 *   label = @Translation("oEmbed content"),
 *   field_types = {
 *     "link",
 *     "string",
 *     "string_long",
 *   },
 * )
 */
class OEmbedFormatter extends OldOEmberFormatter {

  /**
   * The media source manager plugin.
   *
   * @var PluginManagerInterface
   */
  protected $mediaSourceManager;

  /**
   * The tarte au citron service manager.
   *
   * @var ServicesManagerInterface
   */
  protected $tacServiceManager;

  /**
   * Constructs an OEmbedFormatter instance.
   *
   * @param string $plugin_id
   *   The plugin ID for the formatter.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Field\FieldDefinitionInterface $field_definition
   *   The definition of the field to which the formatter is associated.
   * @param array $settings
   *   The formatter settings.
   * @param string $label
   *   The formatter label display setting.
   * @param string $view_mode
   *   The view mode.
   * @param array $third_party_settings
   *   Any third party settings.
   * @param \Drupal\Core\Messenger\MessengerInterface $messenger
   *   The messenger service.
   * @param \Drupal\media\OEmbed\ResourceFetcherInterface $resource_fetcher
   *   The oEmbed resource fetcher service.
   * @param \Drupal\media\OEmbed\UrlResolverInterface $url_resolver
   *   The oEmbed URL resolver service.
   * @param \Drupal\Core\Logger\LoggerChannelFactoryInterface $logger_factory
   *   The logger factory service.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory service.
   * @param \Drupal\media\IFrameUrlHelper $iframe_url_helper
   *   The iFrame URL helper service.
   * @param \Drupal\Component\Plugin\PluginManagerInterface $media_source_manager
   *   The media source manager plugin.
   * @param \Drupal\tarte_au_citron\ServicesManagerInterface $tacServiceManager
   *   The tarte au citron service manager.
   */
  public function __construct($plugin_id, $plugin_definition, FieldDefinitionInterface $field_definition, array $settings, $label, $view_mode, array $third_party_settings, MessengerInterface $messenger, ResourceFetcherInterface $resource_fetcher, UrlResolverInterface $url_resolver, LoggerChannelFactoryInterface $logger_factory, ConfigFactoryInterface $config_factory, IFrameUrlHelper $iframe_url_helper, PluginManagerInterface $media_source_manager, ServicesManagerInterface $tacServiceManager) {
    parent::__construct($plugin_id, $plugin_definition, $field_definition, $settings, $label, $view_mode, $third_party_settings, $messenger, $resource_fetcher, $url_resolver, $logger_factory, $config_factory, $iframe_url_helper);
    $this->mediaSourceManager = $media_source_manager;
    $this->tacServiceManager = $tacServiceManager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $plugin_id,
      $plugin_definition,
      $configuration['field_definition'],
      $configuration['settings'],
      $configuration['label'],
      $configuration['view_mode'],
      $configuration['third_party_settings'],
      $container->get('messenger'),
      $container->get('media.oembed.resource_fetcher'),
      $container->get('media.oembed.url_resolver'),
      $container->get('logger.factory'),
      $container->get('config.factory'),
      $container->get('media.oembed.iframe_url_helper'),
      $container->get('plugin.manager.media.source'),
      $container->get('tarte_au_citron.services_manager')
    );
  }

    /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $element = parent::viewElements($items, $langcode);
    if (!$this->tacServiceManager->isNeeded()) {
      return $element;
    }

    foreach ($items as $delta => $item) {
      if(!isset($element[$delta]['#tag']) || $element[$delta]['#tag'] !== 'iframe') {
        continue;
      }

      $main_property = $item->getFieldDefinition()->getFieldStorageDefinition()->getMainPropertyName();
      $value = $item->{$main_property};
      $max_width = $this->getSetting('max_width');
      $max_height = $this->getSetting('max_height');
      $resource_url = $this->urlResolver->getResourceUrl($value, $max_width, $max_height);
      $resource = $this->resourceFetcher->fetchResource($resource_url);
      $provider_name = mb_strtolower($resource->getProvider()->getName());

      if (!$this->tacServiceManager->isServiceEnabled('oembed:drupal_' . $provider_name)) {
        continue;
      }

      $element[$delta]['#tag'] = 'div';
      foreach($element[$delta]['#attributes'] as $attributeKey => $attributeValue) {
        if($attributeKey === 'class') {
          $element[$delta]['#attributes'][$attributeKey][] = $provider_name . '_player';
        }
        else {
          $element[$delta]['#attributes']['data-' . $attributeKey] = $attributeValue;
          unset($element[$delta]['#attributes'][$attributeKey]);
        }
      }
    }
    return $element;
  }

}
