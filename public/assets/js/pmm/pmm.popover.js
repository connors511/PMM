PMM.Popover = {
	
	Init: function() {
		cLog("PMM.Popover.Init called. Initiating Popovers");
		
		//var dim = PMM.Movies.getMovieListDimensions();
		//var count = Math.floor($('#movies').outerWidth() / dim.width);
		this.createPopovers();
	},
	
	createPopovers: function() {
		cLog("Creating popovers");
		
		$('.movie').popover({
			placement: function(pop, dom_el) {
				left_pos = $(dom_el).offset().left + $(dom_el).width();
				bottom_pos = $(dom_el).offset().top + $(dom_el).height();
				width = window.innerWidth;
				height = window.innerHeight;
				
				console.log(bottom_pos+' vs '+height);
				// 50 offset to prevent too much overlapping with the bottom bar
				if (bottom_pos > $(window).scrollTop() + height - 50)
					return false;
				console.log(left_pos+' vs '+width);
				if (width - left_pos < 300)
					return 'left';
				return 'right';
			},
			delay: {
				show: 500,
				hide: 100
			},
			content: function(dom_el) {
				return $(this).attr('data-content-body').replace(/<b>/g,'<b class="orange">');
			}
		});
	}
}