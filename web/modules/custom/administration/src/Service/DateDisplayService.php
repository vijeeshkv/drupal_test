<?php

namespace Drupal\administration\Service;

use Drupal\Core\Config\ConfigFactoryInterface;
use DateTime;
use Drupal\Core\Datetime\DrupalDateTime;

/**
 * DateDisplayService - Service for the Custom Date Display.
 */
class DateDisplayService {

  const SETTINGS = 'administration.settings';

  /**
   * The configuration factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Constructs a \Drupal\administration\DateDisplayService object.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   Injects the Config Factory Interface.
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    $this->configFactory = $config_factory;
  }

  /**
   * Gets the custom date value.
   *
   * @return string
   *   The current date converted with custom timezone configuration and return as a string.
   */
  public function getValue() {
    $config = $this->configFactory->get(static::SETTINGS);
    $timezone = $config->get('admin_timezone');
    $langcode = NULL;
    $formatted = \Drupal::service('date.formatter')->format(time(), 'custom', 'jS M Y - h:i:s A', $timezone, $langcode);
    $markup = 'Service Current Date and Time: ';
    $markup .= $formatted;
    return (string) $markup;
  }

  /**
   * Gets the custom date value.
   *
   * @return string
   *   The current date converted with custom timezone configuration and return as a string.
   */
  public function getConfigTimeZone() {
    $config = $this->configFactory->get(static::SETTINGS);
    $timezone = $config->get('admin_timezone');    
    return (string) $timezone;
  }

}
