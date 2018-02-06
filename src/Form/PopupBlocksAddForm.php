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

    $form['message'] = [
      '#markup' => $this->t('Add an entry to the dbtng_example table.'),
    ];

    $form['add'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Add a person entry'),
    ];
    // Add a checkbox to registration form for terms.
    $form['add']['block_list'] = [
      '#type' => 'select',
      '#title' => t("Choose the code"),
      '#options' => $block_ids,
      '#weight' => '-99',
      '#description' => 'Choose the block.',
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
      ),
    );    
    $form['add']['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Name'),
      '#size' => 15,
    ];
    $form['add']['surname'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Surname'),
      '#size' => 15,
    ];
    $form['add']['age'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Age'),
      '#size' => 5,
      '#description' => $this->t("Values greater than 127 will cause an exception. Try it - it's a great example why exception handling is needed with DTBNG."),
    ];
    $form['add']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Create'),
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
      'status' => 1,
    ];
    $return = PopupBlocksStorage::insert($entry);
    if ($return) {
      drupal_set_message($this->t('Created entry @entry', ['@entry' => print_r($entry, TRUE)]));
    }
  }

}
