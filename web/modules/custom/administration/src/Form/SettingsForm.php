<?php

namespace Drupal\administration\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * Configure administration settings for this site.
 */
class SettingsForm extends ConfigFormBase {
  use StringTranslationTrait;

  /**
   * Config settings.
   *
   * @var string
   */
  const SETTINGS = 'administration.settings';

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'administration.settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      static::SETTINGS,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config(static::SETTINGS);

    $form['admin_country'] = [
      '#title' => 'Country',
      '#type' => 'textfield',
      '#default_value' => $config->get('admin_country'),
      '#required' => TRUE,
    ];

    $form['admin_city'] = [
      '#title' => 'City',
      '#type' => 'textfield',
      '#default_value' => $config->get('admin_city'),
      '#required' => TRUE,
    ];

    $form['admin_timezone'] = [
      '#title' => 'Timezone',
      '#type' => 'select',
      '#options' => [
        'America/Chicago' => 'America/Chicago',
        'America/New_York' => 'America/New_York',
        'Asia/Tokyo' => 'Asia/Tokyo',
        'Asia/Dubai' => 'Asia/Dubai',
        'Asia/Kolkata' => 'Asia/Kolkata',
        'Europe/Amsterdam' => 'Europe/Amsterdam',
        'Europe/Oslo' => 'Europe/Oslo',
        'Europe/London' => 'Europe/London',
      ],
      '#default_value' => $config->get('admin_timezone'),
      '#required' => TRUE,
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    // Save the configuration.
    $this->configFactory->getEditable(static::SETTINGS)
      ->set('admin_country', $form_state->getValue('admin_country'))
      ->set('admin_city', $form_state->getValue('admin_city'))
      ->set('admin_timezone', $form_state->getValue('admin_timezone'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
