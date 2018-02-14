<?php

namespace Drupal\simple_popup_blocks;

/**
 * Class SimplePopupBlocksStorage.
 */
class SimplePopupBlocksStorage {

  /**
   * Save an entry in the database.
   *
   * The underlying DBTNG function is db_insert().
   *
   * Exception handling is shown in this example. It could be simplified
   * without the try/catch blocks, but since an insert will throw an exception
   * and terminate your application if the exception is not handled, it is best
   * to employ try/catch.
   *
   * @param array $entry
   *   An array containing all the fields of the database record.
   *
   * @return int
   *   The number of updated rows.
   *
   * @throws \Exception
   *   When the database insert fails.
   *
   * @see db_insert()
   */
  public static function insert(array $entry) {
    $return_value = NULL;
    try {
      $return_value = db_insert('simple_popup_blocks')
        ->fields($entry)
        ->execute();
    }
    catch (\Exception $e) {
      drupal_set_message(t('db_insert failed. Message = %message, query= %query', [
        '%message' => $e->getMessage(),
        '%query' => $e->query_string,
      ]
      ), 'error');
    }
    return $return_value;
  }

  /**
   * Update an entry in the database.
   *
   * @param array $entry
   *   An array containing all the fields of the item to be updated.
   *
   * @return int
   *   The number of updated rows.
   *
   * @see db_update()
   */
  public static function update(array $entry) {
    try {
      // db_update()...->execute() returns the number of rows updated.
      $count = db_update('simple_popup_blocks')
        ->fields($entry)
        ->condition('pid', $entry['pid'])
        ->execute();
    }
    catch (\Exception $e) {
      drupal_set_message(t('db_update failed. Message = %message, query= %query', [
        '%message' => $e->getMessage(),
        '%query' => $e->query_string,
      ]
      ), 'error');
    }
    return $count;
  }

  /**
   * Delete an entry from the database.
   *
   * @param array $entry
   *   An array containing at least the person identifier 'pid' element of the
   *   entry to delete.
   *
   * @see db_delete()
   */
  public static function deleteold(array $entry) {
    db_delete('simple_popup_blocks')
      ->condition('pid', $entry['pid'])
      ->execute();
  }
  /**
   * Load single popup from table.
   */  
  public static function load($pid) {
    // Read all fields from the dbtng_example table.
    $select = db_select('simple_popup_blocks', 'pb');
    $select->fields('pb');
    $select->condition('pid', $pid);

    // Return the result in object format.
    return $select->execute()->fetchAll();
  }

  /**
   * Load all popup from table.
   */
  public static function loadAll() {
    // Read all fields from the dbtng_example table.
    $select = db_select('simple_popup_blocks', 'pb');
    $select->fields('pb');

    // Return the result in object format.
    return $select->execute()->fetchAll();
  }

  /**
   * Delete popup from table.
   */
  public static function delete($pid) {
    // Read all fields from the dbtng_example table.
    $select = db_delete('simple_popup_blocks');
    $select->condition('pid', $pid);

    // Return the result in object format.
    return $select->execute();
  }  



}
