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
    $date_timezone = $config->get('admin_timezone');
    $today = 'jS M Y h:i:s A';
    return (string) $today;
  }

}
