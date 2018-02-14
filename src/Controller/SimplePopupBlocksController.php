<?php

namespace Drupal\simple_popup_blocks\Controller;

use Drupal\Core\Url;
use Drupal\Core\Link;
use Drupal\Core\Routing;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\simple_popup_blocks\SimplePopupBlocksStorage;

/**
 * Controller routines for tablesort example routes.
 */
class SimplePopupBlocksController extends ControllerBase {

  /**
   * A simple controller method to explain what the tablesort example is about.
   */
  public function manage() {
    // We are going to output the results in a table with a nice header.
    $header = [
      ['data' => t('S.No')],
      ['data' => t('Popup selector')],
      ['data' => t('Popup sourse')],
      ['data' => t('Layout')],
      ['data' => t('Triggering')],
      ['data' => t('Status')],
      ['data' => t('Edit')],
      ['data' => t('Delete')],
    ];

    $result = SimplePopupBlocksStorage::loadAll();

    $rows = [];
    $increment = 1;
    foreach ($result as $row) {
      $popup_src = $row->type == 1 ? 'Custom css' : 'Drupal blocks';
      $url = Url::fromRoute('simple_popup_blocks.edit', array('first' => $row->pid));
      $edit = Link::fromTextAndUrl(t('Edit'), $url);
      $edit = $edit->toRenderable();

      $url = Url::fromRoute('simple_popup_blocks.delete', array('first' => $row->pid));
      $delete = Link::fromTextAndUrl(t('Delete'), $url);
      $delete = $delete->toRenderable();

      $rows[] = [
        ['data' => $increment],
        ['data' => $row->identifier],
        ['data' => $popup_src],
        ['data' => $row->layout],
        ['data' => 'Automatic'],
        ['data' => $row->status],
        ['data' => $edit],
        ['data' => $delete],
      ];    
      $increment++;  
    }

    $build['table'] = [
      '#theme' => 'table',
      '#header' => $header,
      '#rows' => $rows,
      '#empty' => 'No popup settings available.',

    ];

    return $build;
  }

  public function delete($first) {
    $result = SimplePopupBlocksStorage::delete($first);
    if ($result) {
      drupal_set_message($this->t('Successfully deleted the popup settings.'));
    }    
    return $this->redirect('simple_popup_blocks.manage');

  }  

}
