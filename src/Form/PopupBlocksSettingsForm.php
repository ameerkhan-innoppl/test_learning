<?php

namespace Drupal\popup_blocks\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class PopupBlocksSettingsForm.
 */
class PopupBlocksSettingsForm extends ConfigFormBase {

  const COUNTS = [
    '5' => '5',
    '10' => '10',
    '20' => '20',
    '30' => '30',
    '40' => '40',
    '50' => '50',
    '70' => '70',
    '100' => '100',
  ];

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory'),
      $container->get('library.discovery.collector')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'popup_blocks_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // $config = $this->config('devel_clipboard.settings');
    $form['enable'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enable Clipboard'),
      // '#default_value' => $config->get('enable'),
    ];
    $form['clipboardCount'] = [
      '#type' => 'select',
      '#title' => $this->t('Clipboard Count'),
      '#description' => $this->t('How many clipboard code want to store.'),
      '#options' => self::COUNTS,
      // '#default_value' => $config->get('clipboardCount'),
    ];

    // General settings.
    $form['layout_settings'] = [
      '#type' => 'details',
      '#title' => $this->t('Layout settings'),
      '#open' => FALSE,
    ];
    $form['visit_settings'] = [
      '#type' => 'details',
      '#title' => $this->t('Visit count settings'),
      '#open' => FALSE,
    ];
    $form['delay_settings'] = [
      '#type' => 'details',
      '#title' => $this->t('Popup delay settings'),
      '#open' => FALSE,
    ];
    $form['effect_settings'] = [
      '#type' => 'details',
      '#title' => $this->t('Effect settings'),
      '#open' => FALSE,
    ];    
    $form['adjustments_settings'] = [
      '#type' => 'details',
      '#title' => $this->t('position Adjustments'),
      '#open' => FALSE,
    ];
    $form['other_settings'] = [
      '#type' => 'details',
      '#title' => $this->t('Others'),
      '#open' => TRUE,
    ];        
    $form['general_settings']['id'] = [
      '#type' => 'item',
      '#title' => $this->t('ID'),
      // '#markup' => $webform->id(),
      // '#value' => $webform->id(),
    ];
    $form['general_settings']['title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Title'),
      '#maxlength' => 255,
      // '#default_value' => $webform->label(),
      '#required' => TRUE,
      '#id' => 'title',
    ];
    $form['general_settings']['description'] = [
      '#type' => 'webform_html_editor',
      '#title' => $this->t('Administrative description'),
      // '#default_value' => $webform->get('description'),
    ];
    /** @var \Drupal\webform\WebformEntityStorageInterface $webform_storage */
/*    $webform_storage = $this->entityTypeManager->getStorage('webform');
    $form['general_settings']['category'] = [
      '#type' => 'webform_select_other',
      '#title' => $this->t('Category'),
      '#options' => $webform_storage->getCategories(),
      '#empty_option' => $this->t('- None -'),
      '#default_value' => $webform->get('category'),
    ];
    $form['general_settings']['template'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Allow this webform to be used as a template'),
      '#description' => $this->t('If checked, this webform will be available as a template to all users who can create new webforms.'),
      '#return_value' => TRUE,
      '#access' => $this->moduleHandler->moduleExists('webform_templates'),
      '#default_value' => $webform->isTemplate(),
    ];
    $form['general_settings']['results_disabled'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Disable saving of submissions'),
      '#description' => $this->t('If saving of submissions is disabled, submission settings, submission limits, purging and the saving of drafts will be disabled. Submissions must be sent via an email or processed using a custom <a href=":href">webform handler</a>.', [':href' => Url::fromRoute('entity.webform.handlers', ['webform' => $webform->id()])->toString()]),
      '#return_value' => TRUE,
      '#default_value' => $settings['results_disabled'],
    ];*/

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $form_state->cleanValues();

    $this->config('popup_blocks.settings')
      ->setData($form_state->getValues())
      ->save();
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'popup_blocks.settings',
    ];
  }

}
