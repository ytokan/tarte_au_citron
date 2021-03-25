<?php

namespace Drupal\tarte_au_citron;

use Drupal\Component\Plugin\PluginInspectionInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Providers an interface for embed providers.
 */
interface ServicePluginInterface extends PluginInspectionInterface {

  /**
   * Process js when plugin is added to the dom.
   *
   * @param array $page
   *   The page attachements.
   * @param array $data
   *   The javascript data.
   */
  public function addJs(array &$page, array &$data);

  /**
   * Check if plugin is enabled.
   *
   * @return bool
   *   True if plugin is enable, FALSE otherwise.
   */
  public function isEnabled();

  /**
   * Get default settings.
   *
   * @return array
   *   The default settings.
   */
  public static function defaultSettings();

  /**
   * Get the settings.
   *
   * @return array
   *   The settings.
   */
  public function getSettings();

  /**
   * Get the setting by key.
   *
   * @param string $key
   *   The setting's key.
   *
   * @return mixed
   *   The setting value.
   */
  public function getSetting($key);

  /**
   * Set the settings.
   *
   * @param array $settings
   *   The settings.
   */
  public function setSettings(array $settings);

  /**
   * Set the setting by key.
   *
   * @param string $key
   *   The setting's key.
   * @param mixed $value
   *   The setting value.
   */
  public function setSetting($key, $value);

  /**
   * Form settings constructor.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   *
   * @return array
   *   The form structure.
   */
  public function settingsForm(array $form, FormStateInterface $form_state);

  /**
   * Get the plugin's title, if exists.
   *
   * @return string
   *   The plugin's title or empty string.
   */
  public function getPluginTitle();

}
