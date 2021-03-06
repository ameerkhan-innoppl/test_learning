/**
 * @file
 * Dropbutton feature.
 */

(function ($, Drupal) {

  'use strict';


	$(document).ready(function() {

		var popup_settings = drupalSettings.simple_popup_blocks.settings;

		$.each(popup_settings, function (index, values) {
			if (values.status == 0) {
				return true;
			}
			var css_identity = '.';	
			if (values.css_selector == 1) {
				css_identity = '#';
			}			

		  var block_id = values.identifier;
		  var modal_class = block_id+"-modal";
		  var modal_close_class = block_id+"-modal-close";
		  var modal_minimize_class = block_id+"-modal-minimize";
		  var modal_minimized_class = block_id+"-modal-minimized";
		  
		  $(css_identity+block_id).wrap('<div id="popup-blocks" class="'+modal_class+'"></div>');

		  if (values.minimize == 1) {
		  	$(css_identity+block_id).prepend($('<span class="'+modal_minimize_class+'">-</span>'));
			  $("."+modal_minimize_class).css({
			  	"cursor": "pointer",
			  	"border": "1px solid", 
			  	"padding": "0 11px", 
			  	"margin": "3px",  	
			  });		
			  $(css_identity+block_id).before($('<span class="'+modal_minimized_class+'"></span>'));  
				   
			  $("."+modal_minimized_class).css({
			  	"position": "fixed", 
			  	"bottom": "30px", 
			  	"right": "20%", 
			  	"cursor": "pointer",
			  	"border": "1px solid", 
			  	"border-radius": "50%", 
			  	"display": "none", 
			  	"padding": "20px 20px", 	
			  	"background": "rgba(255, 170, 0, 0.34)", 	
			  });			   	
		  }
		  if (values.close == 1) {
				$(css_identity+block_id).prepend($('<span class="'+modal_close_class+'">&times;</span>'));
			  $("."+modal_close_class).css({
			  	"cursor": "pointer",
			  	"border": "1px solid", 
			  	"padding": "0 10px",  	
			  	"margin": "3px",
			  });				
		  } 	

		  $(css_identity+block_id).css({
		  	"border": "1px solid #888 !important",		  	
		  	"background-color": "#fefefe",
		  });

	    if (values.overlay == 1) {

			  $("."+modal_class).css({
			  	"position": "fixed", 
			  	"z-index": "999999", 
			  	"padding-top": "100px", 
			  	"left": "0",
			  	"top": "0", 
			  	"width": "100%",
			  	"height": "100%", 
			  	"overflow": "auto",
			  	"background-color": "rgb(0,0,0)",
			  	"background-color": "rgba(0,0,0,0.4)",
			  });	

	      if (values.layout != 4) {
				  $(css_identity+block_id).css({
				  	"position": "absolute",
				  });	      	
	      }

			  $("."+modal_close_class).css({
			  	"float": "right",	
			  });
			  $("."+modal_minimize_class).css({
			  	"float": "right",	
			  });		
				switch (values.layout) {
					// Top left
				  case '0':
					  $(css_identity+block_id).css({
					  	"top": values.position_top+"px",
					  	"width": values.width,
					  });	 
				    break;
				  // Top right
				  case '1':
					  $(css_identity+block_id).css({
					  	"top": values.position_top+"px",
					  	"right": values.position_right+"px",
					  	"width": values.width,
					  });
				    break;
				  // Bottom left  
				  case '2':
					  $(css_identity+block_id).css({
					  	"bottom": values.position_bottom+"px",
					  	
					  	"width": values.width,
					  });
				    break;
				  // Bottom right  
				  case '3':
					  $(css_identity+block_id).css({
					  	"right": values.position_right+"px",
					  	"bottom": values.position_bottom+"px",
					  	
					  	"width": values.width,
					  });
				     break;
				  // Center
				  case '4':
					  $(css_identity+block_id).css({
					  	"margin": "auto",
					  	"width": values.width,
					  	
					  });
				    break;
				  // Top Center
				  case '5':
					  $(css_identity+block_id).css({
					  	"top": values.position_top+"px",
					  	"left": "20%",
					  	"right": "20%",					  	
					  });
				    break;
				  // Top bar
				  case '6':
					  $(css_identity+block_id).css({
							"top": values.position_top+"px",
					  });
				    break;
				  // Right bar
				  case '7':
					  $(css_identity+block_id).css({
					  	"top": values.position_top+"px",
					  	"bottom": values.position_bottom+"px",
					  	"right": values.position_right+"px",
					  	"width": values.width,
					  	
					  });
				    break;
				  // Bottom bar
				  case '8':
					  $(css_identity+block_id).css({
					  	"bottom": values.position_bottom+"px",
					  });
				    break;		
				  // Right bar
				  case '9':
					  $(css_identity+block_id).css({
					  	"top": "0",
					  	"bottom": values.position_bottom+"px",
					  	"left": values.position_left+"px",
					  	"width": values.width,
					  });
				    break;				    		    				    				    
				}
      } 
      else {
			  $(css_identity+block_id).css({
			  	"position": "fixed",
			  	"background-color": "rgb(254, 254, 254)",
			  	"padding": "10px",	
			  	"border": "1px solid",
			  	"z-index": "999999", 
			  });	      	
			  $("."+modal_minimize_class).css({
			  	"position": "absolute", 
			  	"top": "0", 
			  	"right": "40px",
			  });			 
			  $("."+modal_close_class).css({
			  	"position": "absolute", 
			  	"top": "0", 
			  	"right": "0", 
			  });				   
				switch (values.layout) {
					// Top left
				  case '0':
					  $(css_identity+block_id).css({
					  	"top": values.position_top+"px",
					  	"left": values.position_left+"px",
					  	"width": values.width,
					  });	 
				    break;
				  // Top right
				  case '1':
					  $(css_identity+block_id).css({
					  	"top": values.position_top+"px",
					  	"right": values.position_right+"px",
					  	"width": values.width,
					  });
				    break;
				  // Bottom left  
				  case '2':
					  $(css_identity+block_id).css({
					  	"left": values.position_left+"px",
					  	"bottom": values.position_bottom+"px",
					  	
					  	"width": values.width,
					  });
				    break;
				  // Bottom right  
				  case '3':
					  $(css_identity+block_id).css({
					  	"right": values.position_right+"px",
					  	"bottom": values.position_bottom+"px",
					  	
					  	"width": values.width,
					  });
				     break;
				  // Center
				  case '4':
					  $(css_identity+block_id).css({
					  	"margin": "auto",
					  	"width": values.width,
					  	"top": "30%",
					  	"left": "40%",					  	
					  	
					  });
				    break;
				  // Top center
				  case '5':
					  $(css_identity+block_id).css({
					  	"top": values.position_top+"px",
					  	"margin": "auto",
					  	"width": values.width,
					  	
					  });
				    break;
				  // Top bar
				  case '6':
					  $(css_identity+block_id).css({
					  	"top": values.position_top+"px",
					  	"left": values.position_left+"px",
					  	"right": values.position_right+"px",
					  });
				    break;
				  // Bottom bar
				  case '7':
					  $(css_identity+block_id).css({
					  	"bottom": values.position_bottom+"px",
					  	"left": values.position_left+"px",
					  	"right": values.position_right+"px",
					  });
				    break;
				  // Left bar
				  case '8':
					  $(css_identity+block_id).css({
					  	"margin": "auto",
					  	"width": values.width,
					  	"top": values.position_top+"px",
					  	"left": values.position_left+"px",	
					  	"bottom": values.position_bottom+"px",	
					  });
				    break;		
				  // Right bar
				  case '9':
					  $(css_identity+block_id).css({
					  	"margin": "auto",
					  	"width": values.width,
					  	"top": values.position_top+"px",
					  	"right": values.position_right+"px",	
					  	"bottom": values.position_bottom+"px",					  	
					  	
					  });
				    break;				    		    				    				    
				}
      }
			if (values.trigger_method == 0 && values.delay > 0) {
				var delays = values.delay * 1000;
			  $("."+modal_class).hide();
			  $("."+modal_class).delay(delays).fadeIn('slow');
			} 
			else if(values.trigger_method == 1) {
				$("."+modal_class).hide();
		    $(values.trigger_selector).click(function(){
				  $("."+modal_class).show();
		    });				
			} 
	    $("."+modal_close_class).click(function(){
			  $("."+modal_class).hide();
	    });
	    $("."+modal_minimize_class).click(function(){
			  $(css_identity+modal_class).hide();
			  $("."+modal_minimized_class).show();
	    });
	    $("."+modal_minimized_class).click(function(){
			  $(css_identity+modal_class).show();
			  $("."+modal_minimized_class).hide();
	    });



		});
	});

})(jQuery, Drupal);