		$(document).ready(function() {
			$('.upper_buttons > li').bind('mouseover', openSubMenu);
				function openSubMenu() {
					$(this).find('ul').css('visibility', 'visible');	
				};  // end mouseover
			$('.upper_buttons > li').bind('mouseout', closeSubMenu);
				function closeSubMenu(){
					$(this).find('ul').css('visibility', 'hidden');	
				};  // end mouseout
		});   //end ready