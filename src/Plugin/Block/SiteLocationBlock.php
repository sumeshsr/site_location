<?php

namespace Drupal\site_location\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\site_location\SiteLocation;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'Site Location' Block.
 *
 * @Block(
 *   id = "site_location_block",
 *   admin_label = @Translation("Site Location"),
 *   category = @Translation("Site Location"),
 * )
 */
class SiteLocationBlock extends BlockBase implements ContainerFactoryPluginInterface {


  /**
   * The Site location service.
   *
   * @var \Drupal\site_location\SiteLocation
   */
  protected $siteLocation;

  /**
   * The drupal config factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $config;

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, SiteLocation $site_location, ConfigFactoryInterface $config_factory) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->siteLocation = $site_location;
    $this->config = $config_factory->get('site_location.settings');
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('site.location'),
      $container->get('config.factory')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $datetime = $this->siteLocation->getDateTime();
    return [
      '#theme' => 'site_location',
      '#content' => [
        'datetime' => $datetime,
        'country' => $this->config->get('site_location.country'),
        'city' => $this->config->get('site_location.city'),
      ],
    ];
  }

}
