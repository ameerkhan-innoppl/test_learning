<?php

namespace Drupal\popup_blocks\Form;

use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Form\FormInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\popup_blocks\PopupBlocksStorage;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Form to add a database entry, with all the interesting fields.
 */
class PopupBlocksAddForm implements FormInterface, ContainerInjectionInterface {

  use StringTranslationTrait;

  /**
   * The current user.
   *
   * We'll need this service in order to check if the user is logged in.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;

  /**
   * {@inheritdoc}
   *
   * We'll use the ContainerInjectionInterface pattern here to inject the
   * current user and also get the string_translation service.
   */
  public static function create(ContainerInterface $container) {
    $form = new static(
      $container->get('current_user')
    );
    // The StringTranslationTrait trait manages the string translation service
    // for us. We can inject the service here.
    $form->setStringTranslation($container->get('string_translation'));
    return $form;
  }

  /**
   * Construct the new form object.
   */
  public function __construct(AccountProxyInterface $current_user) {
    $this->currentUser = $current_user;
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'popup_blocks_add_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    
    $block_ids = \Drupal::entityQuery('block')->execute();   
    $form = [];

    $form['add'] = [
      '#type' => 'details',
      '#title' => $this->t('Popup settings'),
      '#open' => TRUE,
    ];
    // Add a checkbox to registration form for terms.
    $form['add']['block_list'] = [
      '#type' => 'select',
      '#title' => t("Choose the block"),
      '#options' => $block_ids,
      '#weight' => '-99',
      // '#description' => 'Choose the block.',
    ];    
    $form['add']['layout'] = array(
      '#type' => 'radios',
      '#title' => $this
        ->t('Choose layout'),
      '#default_value' => 0,
      '#options' => array(
        0 => $this
          ->t('Top left'),
        1 => $this
          ->t('Top Right'),
        2 => $this
          ->t('Bottom left'),
        3 => $this
          ->t('Bottom Right'),
        4 => $this
          ->t('Center'),
        5 => $this
          ->t('Top center'),           
        6 => $this
          ->t('Top bar'),         
        7 => $this
          ->t('Bottom bar'),
        8 => $this
          ->t('Left bar'),
        9 => $this
          ->t('Right bar'),                                                
      ),
    );
    $form['add']['overlay'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Show popup with overlay'),
      '#default_value' => 1,
    ];
    $form['add']['escape'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('ESC key to close the popup'),
      '#default_value' => 1,
    ];     
    $form['add']['delay'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Delays'),
      '#size' => 5,
      '#default_value' => 0,
      '#description' => $this->t("Show popup after this seconds. 0 will show immediately after the page load."),
    ];

    $form['adjustments'] = [
      '#type' => 'details',
      '#title' => $this->t('Adjustment settings'),
      '#open' => TRUE,
      '#description' => $this->t("Once you created, you can adjust the positions on this popup's edit page."),
    ];    
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Convert to popup'),
    ];    
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // Verify that the user is logged-in.
    // if ($this->currentUser->isAnonymous()) {
    //   $form_state->setError($form['add'], $this->t('You must be logged in to add values to the database.'));
    // }
    // // Confirm that age is numeric.
    // if (!intval($form_state->getValue('age'))) {
    //   $form_state->setErrorByName('age', $this->t('Age needs to be a number'));
    // }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Save the submitted entry.
    $entry = [
      'bid' => $form_state->getValue('block_list'),
      'layout' => $form_state->getValue('layout'),
      'overlay' => $form_state->getValue('overlay'),
      'escape' => $form_state->getValue('escape'),
      'delay' => $form_state->getValue('delay'),
      'status' => 1,
    ];
    $return = PopupBlocksStorage::insert($entry);
    if ($return) {
      drupal_set_message($this->t('Created entry @entry', ['@entry' => print_r($entry, TRUE)]));
    }
  }

}
