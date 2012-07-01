PMM.InfiniteScrolling = {
	_threshold: 0,
	_bound: false,
	
	Init: function(){
		cLog("PMM.InfiniteScrolling.Init() called. Initiating infinite scrolling");
		PMM.InfiniteScrolling._threshold = Math.ceil(PMM.Movies.getMovieListDimensions().height * 1.5);
		
		PMM.InfiniteScrolling.Bind();
	},
	
	onScroll: function(_th) {
		_th = typeof(_th) != 'undefined' ? _th : 0;
		cLog($(window).scrollTop() + " vs " + ($(document).height() - $(window).height() - _th) + " treshold: " + _th);
		
		if ($(window).scrollTop() >= $(document).height() - $(window).height() - _th) 
		{
			cLog("Scrolled triggered. Getting new movies");
			// Unbind to prevent double load.
			PMM.InfiniteScrolling.Unbind();
			PMM.Movies._page++;
			PMM.Movies.getMovies();
		}
	},
	
	Bind: function() {
		if(!this._bound) {
			cLog("Binding infinite scrolling");
			$(window).scroll(function() 
			{
				PMM.InfiniteScrolling.onScroll(PMM.InfiniteScrolling._threshold);
			});
			PMM.InfiniteScrolling._bound = true;
		}
	},
	
	Unbind: function() {
		if(this._bound) {
			cLog("Unbinding infinite scrolling");
			$(window).unbind('scroll');
			PMM.InfiniteScrolling._bound = false;
		}
	}
}