<?php

/**
 * @file
 * Definition of Drupal\ds\Tests\SearchTest.
 */

namespace Drupal\ds\Tests;

/**
 * Tests for display of search results for nodes and users.
 *
 * @group display_suite
 */
class SearchTest extends BaseTest {

  function testDSSearch() {

    // Create nodes.
    $i = 15;
    while ($i > 0) {
      $settings = array(
        'title' => 'title' . $i,
        'type' => 'article',
        'promote' => 1,
      );
      $this->drupalCreateNode($settings);
      $i--;
    }

    // Set default search.
    $edit = array(
      'default_module' => 'ds_search',
    );
    $this->drupalPostForm('admin/config/search/settings', $edit, t('Save configuration'));

    // Run cron.
    $this->cronRun();
    $this->drupalGet('admin/config/search/settings');
    $this->assertText(t('100% of the site has been indexed. There are 0 items left to index.'), 'Site has been indexed');

    // Configure search result view mode.
    $svm = array('view_modes_custom[search_result]' => 'search_result');
    $this->dsConfigureUI($svm);
    $layout = array(
      'layout' => 'ds_2col_stacked',
    );
    $assert = array(
      'regions' => array(
        'header' => '<td colspan="8">' . t('Header') . '</td>',
        'left' => '<td colspan="8">' . t('Left') . '</td>',
        'right' => '<td colspan="8">' . t('Right') . '</td>',
        'footer' => '<td colspan="8">' . t('Footer') . '</td>',
      ),
    );
    $this->dsSelectLayout($layout, $assert, 'admin/structure/types/manage/article/display/search_result');
    $fields = array(
      'fields[title][region]' => 'header',
      'fields[post_date][region]' => 'header',
      'fields[author][region]' => 'left',
      'fields[body][region]' => 'right',
      'fields[node_link][region]' => 'footer',
    );
    $this->dsConfigureUI($fields, 'admin/structure/types/manage/article/display/search_result');

    // Configure ds search.
    $edit = array('user_override_search_page' => '1');
    $this->drupalPostForm('admin/structure/ds/list/search', $edit, t('Save configuration'));

    // Let's search.
    $this->drupalGet('search/content/title1');
    $this->assertNoRaw('/search/node/title1');
    $this->assertRaw('view-mode-search-result', 'Search view mode found');
    $this->assertRaw('group-left', 'Search template found');
    $this->assertRaw('group-right', 'Search template found');
    $this->assertNoText(t('Advanced search'), 'No advanced search found');


    $edit = array('node_form_alter' => '1');
    $this->drupalPostForm('admin/structure/ds/list/search', $edit, t('Save configuration'));
    $this->drupalGet('search/content/title1');
    $this->assertText(t('Advanced search'), 'Advanced search found');

    // Search on user.
    // Configure user. We'll just do default.
    $layout = array(
      'layout' => 'ds_2col_stacked',
    );
    $assert = array(
      'regions' => array(
        'header' => '<td colspan="8">' . t('Header') . '</td>',
        'left' => '<td colspan="8">' . t('Left') . '</td>',
        'right' => '<td colspan="8">' . t('Right') . '</td>',
        'footer' => '<td colspan="8">' . t('Footer') . '</td>',
      ),
    );
    $this->dsSelectLayout($layout, $assert, 'admin/config/people/accounts/display');
    $fields = array(
      'fields[name][region]' => 'left',
      'fields[member_for][region]' => 'right',
    );
    $this->dsConfigureUI($fields, 'admin/config/people/accounts/display');

    $this->drupalGet('search/user/' . $this->admin_user->name);
    $this->assertRaw('view-mode-search-result', 'Search view mode found');
    $this->assertRaw('group-left', 'Search template found');
    $this->assertRaw('group-right', 'Search template found');
  }
}