$.fn.bttabs = function() {
	var selector = this;
	
	this.each(function() {
		var obj = $(this); 
		
		$(obj.attr('href')).hide();
		
		obj.click(function() {
			$(selector).removeClass('selected');
			
			$(this).addClass('selected');
			
			$($(this).attr('href')).fadeIn();
			
			var tabmodule = $(this).attr('data-crs');
			
			loadslider(tabmodule);
			
			$(selector).not(this).each(function(i, element) {
				$($(element).attr('href')).hide();
			});
			
			return false;
		});
	});

	$(this).show();
	
	$(this).first().click();
};