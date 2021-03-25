<?php

/**
 * @file
 * Hooks related to tarte_au_citron API.
 */

/**
 * @addtogroup hooks
 * @{
 */

use Drupal\Core\Config\Config;
use Drupal\Core\Form\FormStateInterface;
use Drupal\tarte_au_citron\ServicePluginInterface;

/**
 * Alter the render array to add library and settings needed.
 *
 * @param array $attachments
 *   The render array.
 * @param \Drupal\tarte_au_citron\ServicePluginInterface $service
 *   The service.
 */
function hook_tarte_au_citron_SERVICE_ID_alter(array &$attachments, ServicePluginInterface $service) {
  $attachments['#attached']['library'][] = 'my library';
  $attachments['#attached']['drupalSettings']['mymodule'] = ['key' => 'value'];
}

/**
 * Alter the config before save.
 *
 * @param \Drupal\Core\Config\Config $config
 *   The render array.
 * @param array $form
 *   An associative array containing the structure of the form.
 * @param \Drupal\Core\Form\FormStateInterface $form_state
 *   The current state of the form.
 */
function hook_tarte_au_citron_config_alter(Config $config, array &$form, FormStateInterface $form_state) {
  $config->set('my_key', 'my_value');
}

/**
 * Alter the texts.
 *
 * @param array $texts
 *   The texts.
 */
function hook_tarte_au_citron_texts_alter(array &$texts) {
  $texts[] = ['id' => 'my_text_id', 'msg' => 'my_text_value'];
}

/**
 * @} End of "addtogroup hooks".
 */
