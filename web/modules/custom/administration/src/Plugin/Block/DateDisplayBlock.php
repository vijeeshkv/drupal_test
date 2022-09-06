<?php

namespace Drupal\administration\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use DateTime;
use Drupal\Core\Datetime\DrupalDateTime;

/**
 * Provides a 'DateDisplay' Block.
 *
 * @Block(
 *   id = "date_display_block",
 *   admin_label = @Translation("Date Display Block"),
 *   category = @Translation("Custom Block"),
 * )
 */
class DateDisplayBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $timezone = 'America/Chicago';
    $langcode = NULL;
    $formatted = \Drupal::service('date.formatter')->format(time(), 'custom', 'jS M Y h:i:s A', $timezone, $langcode);
    $markup = '<b>Current Date and Time</b> ';
    $markup .= $formatted;
    return [
      '#markup' => $markup,
    ];
  }

}