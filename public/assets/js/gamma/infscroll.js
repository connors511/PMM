Gamma.InfiniteScrolling = {
	_threshold: 0,
	_bound: false,
	
	Init: function(){
		cLog("Gamma.InfiniteScrolling.Init() called. Initiating infinite scrolling");
		this._threshold = Math.ceil(Gamma.Movies._getMovieListDimensions().height * 1.5);
		this.Bind();
	},
	
	onScroll: function(_th) {
		_th = typeof(_th) != 'undefined' ? _th : 0;
		cLog($(window).scrollTop() + " vs " + ($(document).height() - $(window).height() - _th) + " treshold: " + _th);
		if ($(window).scrollTop() >= $(document).height() - $(window).height() - _th) 
		{
			cLog("Scrolled triggered. Getting new movies");
			// Unbind to prevent double load.
			this.Unbind();
			Gamma.Movies.getMovies();
		}
	},
	
	Bind: function() {
		if(!this._bound) {
			cLog("Binding infinite scrolling");
			$(window).scroll(function() 
			{
				Gamma.InfiniteScrolling.onScroll(Gamma.InfiniteScrolling._threshold);
			});
			this._bound = true;
		}
	},
	
	Unbind: function() {
		if(this._bound) {
			cLog("Unbinding infinite scrolling");
			$(window).unbind('scroll');
			this._bound = false;
		}
	}
}