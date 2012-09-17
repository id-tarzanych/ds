<?php

/**
 * @file
 * Definition of Drupal\ds\Tests\ViewModesTest.
 */

namespace Drupal\ds\Tests;

/**
 * Tests for Display Suite field permissions.
 */
class FieldPermissionsTest extends BaseTest {

  /**
   * Implements getInfo().
   */
  public static function getInfo() {
    return array(
      'name' => t('Field permissions'),
      'description' => t('Tests for testing field permissions.'),
      'group' => t('Display Suite'),
    );
  }

  function testFieldPermissions() {

    $fields = array(
      'fields[body][region]' => 'right',
      'fields[ds_test_field][region]' => 'left',
    );

    variable_set('ds_extras_field_permissions', TRUE);
    $this->refreshVariables();
    module_implements(FALSE, FALSE, TRUE);

    $this->dsSelectLayout();
    $this->dsConfigureUI($fields);

    // Create a node.
    $settings = array('type' => 'article');
    $node = $this->drupalCreateNode($settings);
    $this->drupalGet('node/' . $node->nid);
    $this->assertRaw('group-right', 'Template found (region right)');
    $this->assertNoText('Test code field on node ' . $node->nid, 'Test code field not found');

    // Give permissions.
    $edit = array(
      'authenticated[view author on node]' => 1,
      'authenticated[view ds_test_field on node]' => 1,
    );
    $this->drupalPost('admin/people/permissions', $edit, t('Save permissions'));
    $this->drupalGet('node/' . $node->nid);
    $this->assertRaw('group-left', 'Template found (region left)');
    $this->assertText('Test code field on node ' . $node->nid, 'Test code field found');
  }
}
