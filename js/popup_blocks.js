/**
 * @file
 * Dropbutton feature.
 */

(function ($, Drupal) {

  'use strict';

	$(document).ready(function(){
	  $("#block-bartik-search, #block-searchform").wrap('<div class="modal"></div>');
	  $("#block-bartik-search, #block-searchform").addClass("modal-content");
	});

})(jQuery, Drupal);