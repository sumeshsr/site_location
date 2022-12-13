<?php

namespace Drupal\site_location;

use Drupal\Core\Config\ConfigFactoryInterface;

/**
 * Service that handles the site_location.
 */
class SiteLocation {

  /**
   * The drupal config factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $config;

  const TIMEZONE_LIST = [
    'chicago' => 'America/Chicago',
    'ny' => 'America/New_York',
    'tokyo' => 'Asia/Tokyo',
    'dubai' => 'Asia/Dubai',
    'kolkata' => 'Asia/Kolkata',
    'amsterdam' => 'Europe/Amsterdam',
    'oslo' => 'Europe/Oslo',
    'london' => 'Europe/London',
  ];

  /**
   * Constructs a new SiteLocation object.
   *
   * @param Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The drupal config factory.
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    $this->config = $config_factory->get('site_location.settings');
  }

  /**
   * Return Date Time.
   */
  public function getDateTime() {
    $timezone = self::TIMEZONE_LIST[$this->config->get('site_location.timezone')];
    $userTimezone = new \DateTimeZone(date_default_timezone_get());
    $gmtTimezone = new \DateTimeZone($timezone);
    $myDateTime = new \DateTime("now", $gmtTimezone);
    $offset = (string) $userTimezone->getOffset($myDateTime);
    $myInterval = \DateInterval::createFromDateString($offset . 'seconds');
    $myDateTime->add($myInterval);
    return [
      'date' => $myDateTime->format('l, j F Y'),
      'time' => $myDateTime->format('H:i a'),
    ];
  }

}
