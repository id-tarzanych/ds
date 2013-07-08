<?php

/**
 * @file
 * Contains \Drupal\ds\Plugin\DSPlugin\PluginBaseInterface.
 */

namespace Drupal\ds\Plugin\DSPlugin;

/**
 * Interface for DS plugins.
 */
interface PluginBaseInterface {

  /**
   * Renders a field.
   *
   * @param array $field
   *   The field that should be rendered.
   *
   * @return string
   *   Returns the rendered field.
   */
  public function renderField($field);

  /**
   * Returns the settings for the field settings form.
   *
   * @return array
   *   The rsettings for the form.
   */
  public function settings();

  /**
   * Returns default settings for the settings form.
   *
   * @return array
   *   The default settings.
   */
  public function defaultSettings();

  /**
   * Returns a list of possible formatters for this field.
   *
   * @return array
   *   A list of possible formatters
   */
  public function formatters();

  /**
   * Returns a list of displays where the field will be showed.
   *
   * Only used for the manage display screen so you can limit fields to show
   * based on bundles or view modes the values are always in the form of
   * $bundle|$view_mode
   *
   * You may use * to select all.
   * Make sure you use the machine name.
   *
   * @return array
   *   Leave empty if you don't want to limit displaying the field.
   *   Returns FALSE if this field shouldn't be shown anywhere.
   */
  public function displays();

}