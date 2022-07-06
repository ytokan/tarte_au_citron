<?php

namespace Drupal\tarte_au_citron_media_remote_video\Plugin\tarte_au_citron;

use Drupal\Component\Plugin\Derivative\DeriverBase;
use Drupal\Component\Plugin\PluginManagerInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\Core\Plugin\Discovery\ContainerDeriverInterface;
use Drupal\Core\Transliteration\PhpTransliteration;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Derives remote video plugin definitions.
 *
 * @internal
 *   This is an internal part of the tarte au citron system and should only be used by
 *   tarte au citron related code.
 */
class OEmbedDeriver extends DeriverBase implements ContainerDeriverInterface {

  /**
   * The media source manager plugin.
   *
   * @var \Drupal\Component\Plugin\PluginManagerInterface
   */
  protected $mediaSourceManager;

  /**
   * The transliteration object.
   *
   * @var \Drupal\Core\Transliteration\PhpTransliteration
   */
  protected $transliteration;

  /**
   * Constructs.
   *
   * @param \Drupal\Component\Plugin\PluginManagerInterface $media_source_manager
   *   The media source manager plugin.
   * @param \Drupal\Core\Transliteration\PhpTransliteration $transliteration
   *   The transliteration object.
   */
  public function __construct(PluginManagerInterface $media_source_manager, PhpTransliteration $transliteration) {
    $this->mediaSourceManager = $media_source_manager;
    $this->transliteration = $transliteration;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, $base_plugin_id) {
    return new static(
      $container->get('plugin.manager.media.source'),
      $container->get('transliteration')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getDerivativeDefinitions($base_plugin_definition) {
    try {
      $videoPlugin = $this->mediaSourceManager->getDefinition('oembed:video');
      if ($videoPlugin) {
        foreach ($videoPlugin['providers'] as $currentProvider) {
          $machineName = $this->getMachineName($currentProvider);
          $this->derivatives[$machineName] = [
            'id' => $machineName,
            'title' => $currentProvider,
          ] + $base_plugin_definition;
        }
      }
    }
    catch (\Exception $exception) {

    }

    return parent::getDerivativeDefinitions($base_plugin_definition);
  }

  /**
   * Generates a machine name from a string.
   *
   * This is basically the same as what is done in
   * \Drupal\Core\Block\BlockBase::getMachineNameSuggestion() and
   * \Drupal\system\MachineNameController::transliterate(), but it seems
   * that so far there is no common service for handling this.
   *
   * @param string $string
   *   The provider.
   *
   * @return string
   *   The machine name.
   *
   * @see \Drupal\Core\Block\BlockBase::getMachineNameSuggestion()
   * @see \Drupal\system\MachineNameController::transliterate()
   */
  protected function getMachineName($string) {
    $transliterated = \Drupal::transliteration()->transliterate($string, LanguageInterface::LANGCODE_DEFAULT, '_');
    $transliterated = mb_strtolower($transliterated);

    $transliterated = preg_replace('@[^a-z0-9_.]+@', '_', $transliterated);

    return 'drupal_' . $transliterated;
  }

}
