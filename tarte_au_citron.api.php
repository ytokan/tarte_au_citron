<?php

/**
 * @file
 * Hooks related to tarte_au_citron API.
 */

/**
 * @addtogroup hooks
 * @{
 */

/**
 * Alter the render array to add library and settings needed.
 *
 * @param array $attachments
 *   The render array.
 */
function hook_tarte_au_citron_SERVICE_ID_alter(array &$attachments) {
  $attachments['#attached']['library'][] = 'my library';
  $attachments['#attached']['drupalSettings']['mymodule'] = ['key' => 'value'];
}

/**
 * @} End of "addtogroup hooks".
 */
