/**
 * @file
 * Dropbutton feature.
 */

(function ($, Drupal) {

  'use strict';

	$(document).ready(function(){
		// ARRAYS
		var arr = [
		 'one',
		 'two',
		 'three',
		 'four',
		 'five'
		];
		var popup_settings = drupalSettings.popup_blocks.popup_settings;
		$.each(popup_settings, function (index, values) {
		  var block_id = values.bid;
		  var modal_class = block_id+"-modal";
		  $("#"+block_id).wrap('<div id="popup-blocks" class="'+modal_class+'"></div>');
		  if (values.overlay) {
			  $("."+modal_class).css({
			  	"position": "fixed", 
			  	"z-index": "1", 
			  	"padding-top": "100px", 
			  	"left": "0",
			  	"top": "0", 
			  	"width": "100%",
			  	"height": "100%", 
			  	"overflow": "auto",
			  	"background-color": "rgb(0,0,0)",
			  	"background-color": "rgba(0,0,0,0.4)",
			  });		  	
		  }

		  $("#"+block_id).css({
		  	"border": "1px solid #888 !important",		  	
		  	"background-color": "#fefefe",
		  });

	    if (values.overlay) {
	      if (values.layout != 4) {
				  $("#"+block_id).css({
				  	"position": "absolute",
				  });	      	
	      }	    	
				switch (values.layout) {
					// Top left
				  case '0':
					  $("#"+block_id).css({
					  	"top": "0px",
					  });	 
				    break;
				  // Top right
				  case '1':
					  $("#"+block_id).css({
					  	"top": "0px",
					  	"right": "0px",
					  });
				    break;
				  // Bottom left  
				  case '2':
					  $("#"+block_id).css({
					  	"bottom": "75px",
					  	// "bottom": values.bottom,
					  });
				    break;
				  // Bottom right  
				  case '3':
					  $("#"+block_id).css({
					  	"right": "0px",
					  	"bottom": "80px",
					  	// "bottom": values.bottom,
					  	"width": "400px",
					  });
				     break;
				  // Center
				  case '4':
					  $("#"+block_id).css({
					  	"margin": "auto",
					  	"width": "200px",
					  	// "bottom": values.bottom,
					  });
				      break;
				  case 5:
				      day = "Friday";
				      break;
				  case  6:
				      day = "Saturday";
				}
      } 
      else {
			  $("#"+block_id).css({
			  	"position": "fixed",
			  });	      	
				switch (values.layout) {
					// Top left
				  case '0':
					  $("#"+block_id).css({
					  	"top": "0px",
					  });	 
				    break;
				  // Top right
				  case '1':
					  $("#"+block_id).css({
					  	"top": "0px",
					  	"right": "0px",
					  });
				    break;
				  // Bottom left  
				  case '2':
					  $("#"+block_id).css({
					  	"bottom": "75px",
					  	// "bottom": values.bottom,
					  });
				    break;
				  // Bottom right  
				  case '3':
					  $("#"+block_id).css({
					  	"right": "0px",
					  	"bottom": "-25px",
					  	// "bottom": values.bottom,
					  	"width": "400px",
					  });
				     break;
				  // Center
				  case '4':
					  $("#"+block_id).css({
					  	"margin": "auto",
					  	"width": "200px",
					  	// "bottom": values.bottom,
					  });
				      break;
				  case 5:
				      day = "Friday";
				      break;
				  case  6:
				      day = "Saturday";
				}
      }

		});

/*	  $("#block-bartik-search, #block-searchform").wrap('<div class="modal"></div>');
	  $("#block-bartik-search, #block-searchform").addClass("modal-content");*/
	});

})(jQuery, Drupal);