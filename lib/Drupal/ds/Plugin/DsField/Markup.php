<?php

/**
 * @file
 * Contains \Drupal\ds\Plugin\DsField\Markup.
 */

namespace Drupal\ds\Plugin\DsField;

/**
 * DS field markup base field.
 */
abstract class Markup extends DsFieldBase {

  /**
   * {@inheritdoc}
   */
  public function render() {
    $key = $this->key();
    if (isset($this->entity->{$key}->value)) {
      $format = $this->format();

      return array(
        '#markup' => check_markup($this->entity->{$key}->value, $field['entity']->{$format}->value, '', TRUE),
      );
    }
  }

  /**
   * Gets the key of the field that needs to be rendered.
   */
  protected function key() {
    return '';
  }

  /**
   * Gets the text format.
   */
  protected function format() {
    return 'filtered_html';
  }

}
