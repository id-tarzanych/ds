<?php
/**
 * @file
 * The Display Suite field type theme plugin
 */

$plugin = array(
  'type' => DS_FIELD_TYPE_CODE,
  'name' => t('Code field'),
  'description' => t('Renders fields described as PHP code'),
  'class' => 'dsFieldCode',
);