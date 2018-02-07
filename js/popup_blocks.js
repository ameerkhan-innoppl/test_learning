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
		  var modal_close_class = block_id+"-modal-close";
		  
		  $("#"+block_id).wrap('<div id="popup-blocks" class="'+modal_class+'"></div>');
		  $("#"+block_id).prepend($('<span class="'+modal_close_class+'">&times;</span>'));
		  $("."+modal_close_class).css({
		  	"color": "#aaaaaa", 
		  	"float": "right", 
		  	"font-size": "16px", 
		  	"font-weight": "bold",
		  	"border": "1px solid", 
		  	"padding": "0 10px",
		  	"margin": "1%", 
		  });	

		  // $("."+modal_class).hide();
		  if (values.overlay == 1) {
		    // setTimeout(function() {
		    //     $("."+modal_class).show('blind', {}, 500);
		    // }, 2000);		 
		    // $("."+modal_class).delay(3000).fadeOut('slow'); 	
		    // $("."+modal_class).show();
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

	    if (values.overlay == 1) {
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
					  	"width": "400px",
					  });	 
				    break;
				  // Top right
				  case '1':
					  $("#"+block_id).css({
					  	"top": "0px",
					  	"right": "0px",
					  	"width": "400px",
					  });
				    break;
				  // Bottom left  
				  case '2':
					  $("#"+block_id).css({
					  	"bottom": "75px",
					  	// "bottom": values.bottom,
					  	"width": "400px",
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
				  // Top Center
				  case '5':
					  $("#"+block_id).css({
					  	"top": "0",
					  	"left": "20%",
					  	"right": "20%",					  	
					  });
				    break;
				  // Top bar
				  case '6':
					  $("#"+block_id).css({
							"top": "0",
					  });
				    break;
				  // Right bar
				  case '7':
					  $("#"+block_id).css({
					  	"top": "0",
					  	"bottom": "0",
					  	"right": "0",
					  	"width": "200px",
					  	// "bottom": values.bottom,
					  });
				    break;
				  // Bottom bar
				  case '8':
					  $("#"+block_id).css({
					  	"bottom": "65px",
					  });
				    break;		
				  // Right bar
				  case '9':
					  $("#"+block_id).css({
					  	"top": "0",
					  	"bottom": "0",
					  	"left": "0",
					  	"width": "200px",
					  });
				    break;				    		    				    				    
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
					  	"left": "0px",
					  	"width": "400px",
					  });	 
				    break;
				  // Top right
				  case '1':
					  $("#"+block_id).css({
					  	"top": "0px",
					  	"right": "0px",
					  	"width": "400px",
					  });
				    break;
				  // Bottom left  
				  case '2':
					  $("#"+block_id).css({
					  	"left": "0px",
					  	"bottom": "-25px",
					  	// "bottom": values.bottom,
					  	"width": "400px",
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
				  // Center
				  case '5':
					  $("#"+block_id).css({
					  	"margin": "auto",
					  	"width": "200px",
					  	// "bottom": values.bottom,
					  });
				    break;
				  // Center
				  case '6':
					  $("#"+block_id).css({
					  	"top": "0px",
					  	"right": "0px",
					  });
				    break;
				  // Center
				  case '7':
					  $("#"+block_id).css({
					  	"margin": "auto",
					  	"width": "200px",
					  	// "bottom": values.bottom,
					  });
				    break;
				  // Center
				  case '8':
					  $("#"+block_id).css({
					  	"margin": "auto",
					  	"width": "200px",
					  	// "bottom": values.bottom,
					  });
				    break;		
				  // Center
				  case '9':
					  $("#"+block_id).css({
					  	"margin": "auto",
					  	"width": "200px",
					  	// "bottom": values.bottom,
					  });
				    break;				    		    				    				    
				}
      }

		});

/*	  $("#block-bartik-search, #block-searchform").wrap('<div class="modal"></div>');
	  $("#block-bartik-search, #block-searchform").addClass("modal-content");*/
	});

})(jQuery, Drupal);