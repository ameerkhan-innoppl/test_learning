/**
 * @file
 * Dropbutton feature.
 */

(function ($, Drupal) {

  'use strict';


	$(document).ready(function() {

		var popup_settings = drupalSettings.popup_blocks.popup_settings;
		var popup_wrap;
		var close_class;
		var minimize_class;
		var minimized_classs;		
		$.each(popup_settings, function (index, values) {

		  var block_id = values.bid;
		  var modal_class = block_id+"-modal";
		  var modal_close_class = block_id+"-modal-close";
		  var modal_minimize_class = block_id+"-modal-minimize";
		  var modal_minimized_class = block_id+"-modal-minimized";

		  $("#"+block_id).wrap('<div id="popup-blocks" class="'+modal_class+'"></div>');
		  $("#"+block_id).prepend($('<span class="'+modal_minimize_class+'">-</span>'));
		  $("#"+block_id).prepend($('<span class="'+modal_close_class+'">&times;</span>'));
		  $("."+modal_class).before($('<span class="'+modal_minimized_class+'"></span>'));

		  $("."+modal_close_class).css({
		  	"cursor": "pointer",
		  	"border": "1px solid", 
		  	"padding": "0 10px",  	
		  });			  
		  $("."+modal_minimize_class).css({
		  	"cursor": "pointer",
		  	"border": "1px solid", 
		  	"padding": "0 11px",  	
		  });			   
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
			if (values.delay > 0) {
				var delays = values.delay * 1000;
			  $("."+modal_class).hide();
			  $("."+modal_class).delay(delays).fadeIn('slow');
			}

		  $("#"+block_id).css({
		  	"border": "1px solid #888 !important",		  	
		  	"background-color": "#fefefe",
		  });

	    if (values.overlay == 1) {

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

	      if (values.layout != 4) {
				  $("#"+block_id).css({
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
			  	"background-color": "rgb(254, 254, 254)",
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
					  	"top": "30%",
					  	"left": "40%",					  	
					  	// "bottom": values.bottom,
					  });
				    break;
				  // Top center
				  case '5':
					  $("#"+block_id).css({
					  	"margin": "auto",
					  	"width": "200px",
					  	// "bottom": values.bottom,
					  });
				    break;
				  // Top bar
				  case '6':
					  $("#"+block_id).css({
					  	"top": "0",
					  	"left": "0",
					  	"right": "0",
					  });
				    break;
				  // Bottom bar
				  case '7':
					  $("#"+block_id).css({
					  	"bottom": "-25px",
					  	"left": "0",
					  	"right": "0",
					  });
				    break;
				  // Left bar
				  case '8':
					  $("#"+block_id).css({
					  	"margin": "auto",
					  	"width": "400px",
					  	"top": "0",
					  	"left": "0",	
					  	"bottom": "-20px",	
					  });
				    break;		
				  // Right bar
				  case '9':
					  $("#"+block_id).css({
					  	"margin": "auto",
					  	"width": "400px",
					  	"top": "0",
					  	"right": "0",	
					  	"bottom": "-20px",					  	
					  	// "bottom": values.bottom,
					  });
				    break;				    		    				    				    
				}
      }
      window.onload = function(){
				// Get the modal
				popup_wrap = document.getElementsByClassName(modal_class)[0];
				// Get the modal close btn
				close_class =  document.getElementsByClassName(modal_close_class)[0];
				minimize_class =  document.getElementsByClassName(modal_minimize_class)[0];
				minimized_class =  document.getElementsByClassName(modal_minimized_class)[0];
			  
				// When the user clicks on <span> (x), close the modal
				close_class.onclick = function() {
				  popup_wrap.style.display = "none";
				}
				// When the user clicks on <span> (x), close the modal
				minimize_class.onclick = function() {
				  popup_wrap.style.display = "none";
				  minimized_class.style.display = "block";
				}
				// When the user clicks on <span> (x), close the modal
				minimized_class.onclick = function() {
				  popup_wrap.style.display = "block";
				  minimized_class.style.display = "none";
				}  
			}  

		});
	});

})(jQuery, Drupal);