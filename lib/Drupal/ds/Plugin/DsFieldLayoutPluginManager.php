<?php

/**
 * @file
 * Contains \Drupal\ds\Plugin\DsFieldLayoutPluginManager.
 */

namespace Drupal\ds\Plugin;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Language\LanguageManager;
use Drupal\Core\Plugin\DefaultPluginManager;

/**
 * Plugin type manager for all ds field layout plugins.
 */
class DsFieldLayoutPluginManager extends DefaultPluginManager {

  /**
   * Constructs a new \Drupal\ds\Plugin\Type\DsPluginManager object.
   *
   * @param \Traversable $namespaces
   *   An object that implements \Traversable which contains the root paths
   *   keyed by the corresponding namespace to look for plugin implementations.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   Cache backend instance to use.
   * @param \Drupal\Core\Language\LanguageManager $language_manager
   *   The language manager.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler to invoke the alter hook with.
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, LanguageManager $language_manager, ModuleHandlerInterface $module_handler) {
    parent::__construct('Plugin/DsFieldLayout', $namespaces, 'Drupal\ds\Annotation\DsFieldLayout');

    $this->alterInfo($module_handler, 'ds_field_layouts_info');
    $this->setCacheBackend($cache_backend, $language_manager, 'ds_field_layouts_info');
  }

}
