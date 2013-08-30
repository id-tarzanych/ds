<?php

/**
 * @file
 * Contains \Drupal\ds_extras\Plugin\Block\DsRegionBlock.
 */

namespace Drupal\ds_extras\Plugin\Block;

use Drupal\block\BlockBase;
use Drupal\Block\Annotation\Block;
use Drupal\Core\Annotation\Translation;

/**
 * Provides the region block plugin.
 *
 * @Block(
 *   id = "ds_region_block",
 *   admin_label = @Translation("Ds region block"),
 *   derivative = "Drupal\ds_extras\Plugin\Derivative\DsRegionBlock"
 * )
 */
class DsRegionBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    list(, $id) = explode(':', $this->getPluginId());

    $data = drupal_static('ds_block_region');
    $region_blocks = \Drupal::config('ds.extras')->get('region_blocks');

    if (!empty($data[$id])) {
      return array(
        $data[$id],
      );
    }
    else {
      return array();
    }
  }

}
