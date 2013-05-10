<?php

/**
 * @file
 * Contains \Drupal\ds_ui\Form\ClassesForm.
 */

namespace Drupal\ds_ui\Form;

use Drupal\system\SystemConfigFormBase;

/**
 * Configures classes used by Display Suite.
 */
class ClassesForm extends SystemConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormID() {
    return 'ds_classes_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, array &$form_state) {
    $custom_field = parent::buildForm($form, $form_state);

    $form['code'] = array(
      '#type' => 'text_format',
      '#title' => t('Field code'),
      '#default_value' => isset($custom_field['properties']['code']['value']) ? $custom_field['properties']['code']['value'] : '',
      '#format' => isset($custom_field['properties']['code']['format']) ? $custom_field['properties']['code']['format'] : 'ds_code',
      '#base_type' => 'textarea',
      '#required' => TRUE,
    );

    $form['use_token'] = array(
      '#type' => 'checkbox',
      '#title' => t('Token'),
      '#description' => t('Toggle this checkbox if you are using tokens in this field.'),
      '#default_value' => isset($custom_field['properties']['use_token']) ? $custom_field['properties']['use_token'] : '',
    );

    // Token support.
    if (module_exists('token')) {

      $form['tokens'] = array(
        '#title' => t('Tokens'),
        '#type' => 'fieldset',
        '#collapsible' => TRUE,
        '#collapsed' => TRUE,
        '#states' => array(
          'invisible' => array(
            'input[name="use_token"]' => array('checked' => FALSE),
          ),
        ),
      );
      $form['tokens']['help'] = array(
        '#theme' => 'token_tree',
        '#token_types' => 'all',
        '#global_types' => FALSE,
      );
    }
    else {
      $form['use_token']['#description'] = t('Toggle this checkbox if you are using tokens in this field. If the token module is installed, you get a nice list of all tokens available in your site.');
    }

  return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, array &$form_state) {
    parent::submitForm($form, $form_state);

    $config = $this->configFactory->get('ds.classes');
    $config->set('regions', $form_state['values']['regions'])
      ->set('fields', $form_state['values']['fields'])
      ->save();
  }

}
