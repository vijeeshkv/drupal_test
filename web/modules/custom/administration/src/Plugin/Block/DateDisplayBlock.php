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
    $markup  = '<b>Current Date and Time</b> ';
    $today = date('Y-m-d H:i:s');
    $markup .= $today;
    return [
      '#markup' => $markup,
    ];
  }

}