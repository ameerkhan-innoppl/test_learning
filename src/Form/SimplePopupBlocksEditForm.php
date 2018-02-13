<?php

namespace Drupal\simple_popup_blocks\Form;

use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Form\FormInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\simple_popup_blocks\SimplePopupBlocksStorage;
use Drupal\Core\Access\AccessResult;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Form to add a database entry, with all the interesting fields.
 */
class SimplePopupBlocksEditForm extends SimplePopupBlocksAddForm {

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
    return 'simple_popup_blocks_edit_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $first = NULL) {  
    // Query for items to display.
    $entry = SimplePopupBlocksStorage::load($first);
    // Tell the user if there is nothing to display.
    // if (empty($entry)) {
    //   $form['no_values'] = [
    //     '#value' => t('No entries exist in the table simple_popup_blocks table.'),
    //   ];
    //   return $form;
    // }
    $entry = $entry[0];
   
    $form = parent::buildForm($form, $form_state);  
    $form['status'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enable this as popup.'),
      '#default_value' => $entry->status,
      '#weight' => -99,
    ]; 
    $form['type']['#default_value'] = $entry->type;
    $form['block_list']['#default_value'] = $entry->identifier;
    $form['custom_css']['#default_value'] = $entry->identifier;
    $form['css_selector']['#default_value'] = $entry->css_selector;
    $form['layout']['#default_value'] = $entry->layout;
    $form['minimize']['#default_value'] = $entry->minimize;
    $form['close']['#default_value'] = $entry->close;
    $form['escape']['#default_value'] = $entry->escape;
    $form['overlay']['#default_value'] = $entry->overlay;
    $form['delay']['#default_value'] = $entry->delay;
    $form['width']['#default_value'] = $entry->width;
    

    // Set a value by key.
    $form_state->set('simple_popup_blocks_id', $first);
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
  // Get a value by key.
    $first = $form_state->get('simple_popup_blocks_id');
    if ($form_state->getValue('type') == 0) {
      $identifier = $form_state->getValue('block_list');
    } 
    else {
      $identifier = $form_state->getValue('custom_css');
    }
    // Save the submitted entry.  
    $entry = [
      'pid' => $first,
      'identifier' => $identifier,
      'type' => $form_state->getValue('type'),
      'css_selector' => $form_state->getValue('css_selector'),
      'layout' => $form_state->getValue('layout'),
      'width' => $form_state->getValue('width'),
      'overlay' => $form_state->getValue('overlay'),
      'escape' => $form_state->getValue('escape'),
      'delay' => $form_state->getValue('delay'),
      'minimize' => $form_state->getValue('minimize'),
      'close' => $form_state->getValue('close'),
      'status' => $form_state->getValue('status'),
    ];
    $return = SimplePopupBlocksStorage::update($entry);
    if ($return) {
      drupal_set_message($this->t('Updated entry @entry', ['@entry' => print_r($entry, TRUE)]));
    }
  }

  /**
   * Checks access for a specific request.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   Run access checks for this account.
   */
  public function access() {
    // Check permissions and combine that with any custom access checking needed. Pass forward
    // parameters from the route and/or request as needed.
    return AccessResult::allowed();
  }




}
