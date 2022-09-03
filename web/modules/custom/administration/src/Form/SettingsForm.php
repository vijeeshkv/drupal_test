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
        '1' => 'America/Chicago',
        '2' => 'America/New_York',
        '3' => 'Asia/Tokyo',
        '4' => 'Asia/Dubai',
        '5' => 'Asia/Kolkata',
        '6' => 'Europe/Amsterdam',
        '7' => 'Europe/Oslo',
        '8' => 'Europe/London',
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
