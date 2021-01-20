<?php

namespace Drupal\site_location\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'CurrentTimeBlock' block.
 *
 * @Block(
 *  id = "current_time_block",
 *  admin_label = @Translation("Current Time"),
 * )
 */
class CurrentTimeBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Drupal\site_location\DefaultSiteLocation definition.
   *
   * @var \Drupal\site_location\DefaultSiteLocation
   */
  protected $siteLocationDefault;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    $instance = new static($configuration, $plugin_id, $plugin_definition);
    $instance->siteLocationDefault = $container->get('site_location.default');
    return $instance;
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $current_time = $this->siteLocationDefault->getCurrentTime();
    // Table render array.
    $table = [
      '#type' => 'table',
      '#caption' => $this->t('Site Location'),
      '#header' => [
        $this->t('Label'),
        $this->t('Value'),
      ],
    ];
    // Add rows in table.
    foreach ($current_time as $key => $value) {
      $table['#rows'][] = [
        $key,
        $value,
      ];
    }
    $build['current_time_block'] = $table;
    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheContexts() {
    return Cache::mergeContexts(
      parent::getCacheContexts(),
      ['currenttimecontext']
    );
  }

}
