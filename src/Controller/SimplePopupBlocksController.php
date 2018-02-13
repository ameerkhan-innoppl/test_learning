<?php

namespace Drupal\simple_popup_blocks\Controller;

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
      // The header gives the table the information it needs in order to make
      // the query calls for ordering. TableSort uses the field information
      // to know what database column to sort by.
      ['data' => t('Numbers')],
      ['data' => t('Letters')],
      ['data' => t('Mixture')],
    ];

    $result = SimplePopupBlocksStorage::loadAll();

    $rows = [];
    foreach ($result as $row) {
      // Normally we would add some nice formatting to our rows
      // but for our purpose we are simply going to add our row
      // to the array.
      $rows[] = ['data' => (array) $row];
    }

    // Build the table for the nice output.
    $build = [
      '#markup' => '<p>' . t('The layout here is a themed as a table
           that is sortable by clicking the header name.') . '</p>',
    ];
    $build['table'] = [
      '#theme' => 'table',
      '#header' => $header,
      '#rows' => $rows,
    ];

    return $build;
  }

}
