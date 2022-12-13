<?php

namespace Drupal\site_location\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Settings form to configure 'Site Location'.
 */
class SiteLocationSettings extends ConfigFormBase {

  const CONFIG_KEY = 'site_location.settings';

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      self::CONFIG_KEY,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'site_location_settings';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config(self::CONFIG_KEY);

    $form['country'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Country Name'),
      '#description' => $this->t('This name will be displayed in the Site Location Location Block.'),
      '#default_value' => $config->get('site_location.country'),
    ];

    $form['city'] = [
      '#type' => 'textfield',
      '#title' => $this->t('City Name'),
      '#description' => $this->t('This name will be displayed in the Site Location Location Block.'),
      '#default_value' => $config->get('site_location.city'),
    ];

    $form['timezone'] = [
      '#type' => 'select',
      '#title' => $this->t('Timezone'),
      '#options' => [
        'America' => [
          'chicago' => 'Chicago',
          'ny' => 'New York',
        ],
        'Asia' => [
          'tokyo' => 'Tokyo',
          'dubai' => 'Dubai',
          'kolkata' => 'Kolkata',
        ],
        'Europe' => [
          'amsterdam' => 'Amsterdam',
          'oslo' => 'Oslo',
          'london' => 'London',
        ],
      ],
      '#required' => TRUE,
      '#default_value' => $config->get('site_location.timezone'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config(self::CONFIG_KEY)
      ->set('site_location.timezone', $form_state->getValue('timezone'))
      ->set('site_location.country', $form_state->getValue('country'))
      ->set('site_location.city', $form_state->getValue('city'))
      ->save();
  }

}
