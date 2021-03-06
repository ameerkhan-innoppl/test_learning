<?php

namespace Drupal\simple_popup_blocks\Form;

use Drupal\Core\Url;
use Drupal\Core\Routing;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Form\FormInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\simple_popup_blocks\SimplePopupBlocksStorage;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Form to add a database entry, with all the interesting fields.
 */
class SimplePopupBlocksAddForm implements FormInterface, ContainerInjectionInterface {

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
    return 'simple_popup_blocks_add_form';
  }

  /**
   * {@inheritdoc}
   */
  public function getCssValues($layout = 0, $overlay = 1) {
    $top = 999999;
    $right = 999999;
    $bottom = 999999;
    $left = 999999;
    if ($overlay == 1) {
      $top_layout = [0,1,5,6,7,9];
      if (in_array($layout, $top_layout)) {
        $top = 0;
      }
      $right_layout = [1,3,5];
      if (in_array($layout, $right_layout)) {
        $right = 0;
      }
      $bottom_layout = [2,3,8];
      if (in_array($layout, $bottom_layout)) {
        $bottom = 75;
      }  
      $bottom_layout = [7,9];
      if (in_array($layout, $bottom_layout)) {
        $bottom = 0;
      }       
      $left_layout = [9];
      if (in_array($layout, $left_layout)) {
        $left = 0;
      }          
    } else {
      $top_layout = [0,1,5,6,8,9];
      if (in_array($layout, $top_layout)) {
        $top = 0;
      }  
      $right_layout = [1,3,6,7,9];
      if (in_array($layout, $right_layout)) {
        $right = 0;
      }  
      $bottom_layout = [2,3,7,8,9];
      if (in_array($layout, $bottom_layout)) {
        $bottom = -25;
      }   
      $left_layout = [0,2,6,7,8];
      if (in_array($layout, $left_layout)) {
        $left = 0;
      }               
    }
    
    $positions = ['top' => $top, 'right' => $right, 'bottom' => $bottom, 'left' => $left];
    ksm($positions);
    return $positions;
  }
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    
    $block_ids = \Drupal::entityQuery('block')->execute();   
    $form = [];
   
    $form['type'] = array(
      '#type' => 'radios',
      '#title' => $this
        ->t('Choose the type'),
      '#default_value' => 0,
      '#options' => array(
        0 => $this
          ->t('Drupal blocks'),
        1 => $this
          ->t('Custom css id or class'),
      ),
    );    
    // Add a checkbox to registration form for terms.
    $form['block_list'] = [
      '#type' => 'select',
      '#title' => t("Choose the block"),
      '#options' => $block_ids,
      '#states' => [
        'visible' => [
          ':input[name="type"]' => ['value' => 0],
        ],
      ],
    ];
    // Add a checkbox to registration form for terms.
    $form['custom_css'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Add css id or class starting without # or .'),
      '#default_value' => t("custom-css-id"),
      '#description' => $this->t("Ex: my-profile, custom_div_cls, someclass, mypopup-class."),
      '#states' => [
        'visible' => [
          ':input[name="type"]' => ['value' => 1],
        ],
      ],
    ];   
    $form['css_selector'] = array(
      '#type' => 'radios',
      '#title' => $this
        ->t('Css selector'),
      '#default_value' => 1,
      '#options' => array(
        0 => $this
          ->t('Css class (.)'),
        1 => $this
          ->t('Css id (#)'),
      ),
      '#states' => [
        'visible' => [
          ':input[name="type"]' => ['value' => 1],
        ],
      ],
    );       
    $form['layout'] = array(
      '#type' => 'radios',
      '#title' => $this->t('Choose layout'),
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

   
    $form['minimize'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Include minimize button'),
      '#default_value' => 1,
    ];    
    $form['close'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Include close button'),
      '#default_value' => 1,
    ];  
    $form['escape'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('ESC key to close the popup'),
      '#default_value' => 1,
    ]; 
    $form['overlay'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Show popup with overlay'),
      '#default_value' => 1,
    ];  
    $form['trigger_method'] = array(
      '#type' => 'radios',
      '#title' => $this
        ->t('Trigger method'),
      '#default_value' => 0,
      '#options' => array(
        0 => $this
          ->t('Automatic'),
        1 => $this
          ->t('Manual - on click event'),
      ),
    );               
    $form['delay'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Delays'),
      '#size' => 5,
      '#default_value' => 0,
      '#description' => $this->t("Show popup after this seconds. 0 will show immediately after the page load."),
      '#states' => [
        'visible' => [
          ':input[name="trigger_method"]' => ['value' => 0],
        ],
      ],      
    ];
    $form['trigger_selector'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Add css id or class starting with # or .'),
      '#default_value' => t("#custom-css-id"),
      '#description' => $this->t("Ex: #my-profile, #custom_div_cls, .someclass, .mypopup-class."),
      '#states' => [
        'visible' => [
          ':input[name="trigger_method"]' => ['value' => 1],
        ],
      ],
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
    if ($form_state->getValue('type') == 0) {
      $identifier = $form_state->getValue('block_list');
    } 
    else {
      $identifier = $form_state->getValue('custom_css');
    }
    $positions = $this->getCssValues($form_state->getValue('layout'), $form_state->getValue('overlay'));
    // Save the submitted entry.
    $entry = [
      'identifier' => $identifier,
      'type' => $form_state->getValue('type'),
      'css_selector' => $form_state->getValue('css_selector'),
      'layout' => $form_state->getValue('layout'),
      'overlay' => $form_state->getValue('overlay'),
      'trigger_method' => $form_state->getValue('trigger_method'),
      'trigger_selector' => $form_state->getValue('trigger_selector'),
      'escape' => $form_state->getValue('escape'),
      'delay' => $form_state->getValue('delay'),
      'minimize' => $form_state->getValue('minimize'),
      'close' => $form_state->getValue('close'),
      'width' => 400,
      'position_top' => $positions['top'],
      'position_right' => $positions['right'],
      'position_bottom' => $positions['bottom'],
      'position_left' => $positions['left'],      
      'status' => 1,
    ];
    $return = SimplePopupBlocksStorage::insert($entry);
/*    if ($return) {
      drupal_set_message($this->t('Popup settings has been created Successfully.'));
      $url = Url::fromRoute('simple_popup_blocks.manage');
      $form_state->setRedirectUrl($url);      
    } 
    else {
      drupal_set_message($this->t('Error while creating.'),'error');
    }*/
    
  }

}
