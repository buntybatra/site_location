<?php

namespace Drupal\site_location\CacheContext;

use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Cache\Context\CacheContextInterface;
use Drupal\Core\Config\ConfigFactory;
use Drupal\Core\Datetime\DateFormatterInterface;
use Drupal\Component\Datetime\TimeInterface;

/**
 * Class CurrentTimeCacheContext for cache invalidation.
 */
class CurrentTimeCacheContext implements CacheContextInterface {

  /**
   * Drupal\Core\Datetime\DateFormatterInterface definition.
   *
   * @var \Drupal\Core\Datetime\DateFormatterInterface
   */
  protected $dateFormatter;

  /**
   * Drupal\Component\Datetime\TimeInterface definition.
   *
   * @var \Drupal\Component\Datetime\TimeInterface
   */
  protected $datetimeTime;

  /**
   * Config factory.
   *
   * @var \Drupal\Core\Config\ConfigFactory
   */
  protected $config;

  /**
   * Constructs a new CurrentTimeCacheContext object.
   */
  public function __construct(DateFormatterInterface $date_formatter, TimeInterface $datetime_time, ConfigFactory $config) {
    $this->dateFormatter = $date_formatter;
    $this->datetimeTime = $datetime_time;
    $this->config = $config->get('site_location.sitelocation');
  }

  /**
   * {@inheritdoc}
   */
  public static function getLabel() {
    \Drupal::messenger()->addMessage('Current time cache context');
  }

  /**
   * {@inheritdoc}
   */
  public function getContext() {
    $timezone = $this->config->get('site_location.timezone');
    return $this->dateFormatter
      ->format($this->datetimeTime->getCurrentTime(), '', 'dS M Y - H:i A', $timezone);
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheableMetadata() {
    return new CacheableMetadata();
  }

}
