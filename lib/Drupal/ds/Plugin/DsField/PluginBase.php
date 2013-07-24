<?php

/**
 * @file
 * Contains \Drupal\ds\Plugin\DsField\PluginBase.
 */

namespace Drupal\ds\Plugin\DsField;

use Drupal\Component\Plugin\PluginBase as ComponentPluginBase;

/**
 * Base class for all the ds plugins
 */
abstract class PluginBase extends ComponentPluginBase implements PluginBaseInterface {

  /**
   * {@inheritdoc}
   */
  public function render($field) {
    return '';
  }

  /**
   * {@inheritdoc}
   */
  public function settings() {
    return array();
  }

  /**
   * {@inheritdoc}
   */
  public function defaultSettings() {
    return array();
  }

  /**
   * {@inheritdoc}
   */
  public function formatters() {
    return array();
  }

  /**
   * {@inheritdoc}
   */
  public function displays() {
    return array();
  }

}
