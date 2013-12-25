<?php

/**
 * @file
 * Contains \Drupal\ds\Plugin\DsField\Node\NodeSubmittedBy.
 */

namespace Drupal\ds\Plugin\DsField\Node;

use Drupal\ds\Plugin\DsField\Date;

/**
 * Plugin that renders the submitted by field.
 *
 * @DsField(
 *   id = "node_submitted_by",
 *   title = @Translation("Submitted by"),
 *   entity_type = "node",
 *   provider = "node"
 * )
 */
class NodeSubmittedBy extends Date {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $field = $this->getConfiguration();
    $account = $this->entity->getAuthor();
    switch ($field['formatter']) {
      case 'ds_time_ago':
        $interval = REQUEST_TIME - $this->entity->created->value;
        return array(
          '#markup' => t('Submitted !interval ago by !user.', array('!interval' => format_interval($interval), '!user' => theme('username', array('account' => $account)))),
        );
      default:
        $date_format = str_replace('ds_post_date_', '', $field['formatter']);
        return array(
          '#markup' => t('Submitted by !user on !date.', array('!user' => theme('username', array('account' => $account)), '!date' => format_date($this->entity->created->value, $date_format))),
        );
    }
  }

  /**
   * {@inheritdoc}
   */
  public function formatters() {
    // Fetch all the date formatters
    $date_formatters = parent::formatters();

    // Add a "time ago" formatter
    $date_formatters['ds_time_ago'] = t('Time ago');

    return $date_formatters;
  }

}