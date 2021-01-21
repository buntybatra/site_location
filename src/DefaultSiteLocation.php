<?php

namespace Drupal\site_location;

use Drupal\Component\Datetime\Time;
use Drupal\Core\Config\ConfigFactory;
use Drupal\Core\Datetime\DateFormatter;

/**
 * Class DefaultSiteLocation service.
 */
class DefaultSiteLocation {

  /**
   * Drupal\Core\Datetime\DateFormatter; definition.
   *
   * @var \Drupal\Core\Datetime\DateFormatter
   */
  protected $dateTimeFormatter;

  /**
   * Drupal\Component\Datetime\Time definition.
   *
   * @var \Drupal\Component\Datetime\Time
   */
  protected $dateTime;

  /**
   * Config factory.
   *
   * @var \Drupal\Core\Config\ConfigFactory
   */
  protected $config;

  /**
   * Constructs a new DefaultSiteLocation object.
   */
  public function __construct(DateFormatter $datetime_time, ConfigFactory $config, Time $date_time) {
    $this->dateTimeFormatter = $datetime_time;
    $this->dateTime = $date_time;
    $this->config = $config->get('site_location.sitelocation');
  }

  /**
   * Get current time with details.
   *
   * @return array
   *   Return array of configuration and current time.
   */
  public function getCurrentTime() {
    $current_time['country'] = $this->config->get('site_location.country');
    $current_time['city'] = $this->config->get('site_location.city');
    $current_time['timezone'] = $this->config->get('site_location.timezone');
    $current_time['time'] = $this->dateTimeFormatter->format($this->dateTime->getCurrentTime(), '', 'dS M Y - h:i A', $current_time['timezone']);
    return $current_time;
  }

}
