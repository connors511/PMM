Gamma.Movies = {
	/**********
	 Settings
	 **********/ 
	_range_limit: 5000, //Gamma.Settings.Movies.maxMovies,
	_urlBase: 'http://82.211.220.249/serenity/public/movies/', //Gamma.Settings.Movies.urlBase,
	/**********
	 Computed variables
	 **********/
	_moviesPerPage: 50,
	_page: 1, // Current page
	_range_max: 0, // Used to determine when to disable infinite scroll
	_atEnd: false,
	_urlSettings: {
		'callback': 'json',
		'offset': 0,
		'count': 0
	},
	_urlParameters: {
		'term': '',
		'persons': '',
		'imdb_rating': '',
		'length': '',
		'resolution': '',
		'aspect': '',
		'size': '',
		'audio': '',
		'released': '',
		'genres': '',
		'added': '',
		'same_movie': ''
	},
	_isSearching : false,
	_replace: false,
	_clean: false,
	
	Init: function() {
		cLog("Gamma.Movies.Init called. Initiating Movies");
		//Gamma.Loader.Display("Loading movies");
		this._recalcRanges();
		this._moviesPerPage = this._calcMoviesPerPage();
	},
	
	_getMovieListDimensions: function() {
		$movie = '<div id="dummy" class="movie" style="display:none"></div>';
		$('#movies_space').before($movie);
		var dim = {
			'width': $('#dummy').outerWidth(),
			'height': $('#dummy').outerHeight()
		};
		$('#dummy').remove();
		return dim;
	},
	
	_calcMoviesPerPage: function() {
		dim = this._getMovieListDimensions();
		cW = Math.floor($('#movies').outerWidth() / dim.width);
		cH = Math.floor(($(document).height() - $('#header').height() - $('#footer').height()) / dim.height);
		return (cH + 1) * cW; // Make sure 1 extra row is loaded
	},
	
	_recalcRanges: function() {
		this._range_max = this._moviesPerPage * this._page + this._moviesPerPage;
		this._urlSettings.offset = this._page * this._moviesPerPage;
		this._urlSettings.count = this._moviesPerPage;
	},
	
	_compileUrlParams: function() {
	    /*var uri = '';
	    for(var i in this._urlParameters) {
		    uri += '&' + i + '=' + encodeURIComponent(this._urlParameters[i]);
	    }
	    uri = uri.replace('&','?');*/
	    var uri = '';
	    if (this._isSearching) {
		this._urlParameters.same_movie = this._urlParameters.same_movie.replace('Same movie','same');
		if (this._urlParameters.term != '') {
			if (this._isOnlyParam('term')) {
				// We're only searching for a title.. This could still be from the advanced search
				cLog("Searching for '" + this._urlParameters.term + "'");
				uri = 'search/' + this._urlParameters.term + '/';
				return uri;
			}
		}
		// We might search for ratings, length, resolution, aspect ratio, file size, audio, people, release date, genres or date added
		if (this._hasMultipleParams()) {
			var string = '';
			for(var i in this._urlParameters) {
				if (this._urlParameters[i] != "") {
					var tmpParam = '';
					if (i == 'released') {
						tmpParam = this._urlParameters[i].replace('&lt; 70s', 'pre70');
					} else if (i == 'added') {
						tmpParam = this._urlParameters[i].replace('&gt; 1 year', 'post1year');
						tmpParam = tmpParam.replace(/ /g,'');
					} else {
						tmpParam = this._urlParameters[i];
					}
					string += '&' + i + '=' + tmpParam;
				}
			}
			cLog("Searching for '" + string.substring(1, string.length) + "'");
			uri = 'advanced/' + string.substring(1, string.length) + '/';
		} else {
			// Can be any single param of the above stated.
			var param = this._getSingleParam();
			cLog("Searching for movies with " + param + " = '" + this._urlParameters.term + "'");
			var tmpParam = '';
			if (param == 'released') {
				tmpParam = this._urlParameters[param].replace('&lt; 70s', 'pre70');
			} else if (param == 'added') {
				tmpParam = this._urlParameters[param].replace('&gt; 1 year', 'post1year');
				tmpParam = tmpParam.replace(/ /g,'');
			} else {
				tmpParam = this._urlParameters[param];
			}
			cLog(param +' = '+tmpParam);
			uri = param + '/' + tmpParam + '/';
		}
	    }
	    return uri;
	},
	
	_isOnlyParam: function(param) {
		for(var i in this._urlParameters) {
			if (i != param) {
				if (this._urlParameters[i] != "")
					return false;
			}
		}
		return true;
	},
	
	_hasMultipleParams: function() {
		var count = 0;
		for(var i in this._urlParameters) {
			if (this._urlParameters[i] != "")
				count++;
			if (count == 2) {
				return true;
			}
		}
		return false;
	},
	
	_hasNoParams: function() {
		var count = 0;
		for(var i in this._urlParameters) {
			if (this._urlParameters[i] != "")
				return false;
		}
		return true;
	},
	
	_getSingleParam: function() {
		for(var i in this._urlParameters) {
			if (this._urlParameters[i] != "")
				return i;
		}
		return false;
	},
	
	_compileUrl: function(current) {
		cLog("Compiling AJAX URL for movie retrival");
		current = typeof(current) != 'undefined' ? current : false;
		
		var uri = Gamma.Settings.BASE_URL + this._urlBase;
		uri += this._compileUrlParams();
		if (this._page > 0 && !current) {
			uri += (this._page + 1);
		} else {
			uri += (this._page < 2) ? '' : this._page;
		}
		cLog("Compiled URL to: " + uri);
		return uri;
	},
	
	getMovies: function(callback) {
		if(this._atEnd)
			return;
		
		//Gamma.Loader.Display("Fetching new movies...");
		
		this._recalcRanges();
		if(this._range_max >= this._range_limit)
			this._range_max = this._range_limit;
			
		cLog("Retriving new movies for page "+(this._page + 1));
		
		$.ajax({
			type: "GET", 
			timeout: 15000,
			url: this._compileUrl(),
			success: function(m) 
			{
				cLog("Successfully sent AJAX request from getMovies");
				Gamma.Movies._page++;
				Gamma.Movies.populateMoviesList(m,callback);
				cLog("range_max: "+Gamma.Movies._range_max+" range_limit: "+Gamma.Movies._range_limit);
				if(Gamma.Movies._range_max < Gamma.Movies._range_limit)
				{
					cLog("Attempting to rebind infinite scrolling to enable more movies loaded");
					Gamma.InfiniteScrolling.Bind();
				}
			},
			error: function(jqXHR, textStatus, errorThrown)
			{
				cLog("An error occured during getMovie AJAX request. Unbinding infinite scrolling to prevent unexpected behavior");
				cLog("AJAX error was: " + textStatus);
				cLog(jqXHR);
				//Gamma.Loader.Display("An error occured during the request.",500);
				Gamma.InfiniteScrolling.Unbind();
			}
		});
	},
	
	populateMoviesList: function(data,callback) {
		if(!data) {
			cLog("Recieved movie list was empty.");
			//Gamma.Loader.Display("No movies found",500);
			Gamma.InfiniteScrolling.Unbind();
		}
		eval("var json = ("+data+")");
		cLog(json);
		if(json.total == 0) {
			cLog("Recieved movie list was empty.");
			//Gamma.Loader.Display("No movies found",500);
			Gamma.InfiniteScrolling.Unbind();
		}
		if(this._moviesPerPage > json.total) {
			cLog("Got "+json.total+" movies. Unbinding scroll");
			this._atEnd = true;
			Gamma.InfiniteScrolling.Unbind();
		}
		if(this._page * this._moviesPerPage + json.count > json.total) {
			cLog("Total amount of movies exceeded.");
			this._atEnd = true;
			Gamma.InfiniteScrolling.Unbind();
		}
		
		// Push it
		if ((this._replace || this._clean)/* && this._page == 0*/) {
			$('#movies').html('<div id="movies_space"></div><div id="ruler" class="movie"><div class="title"></div></div>');
		}
		if (this._clean) {
			this._clean = false;
		}
		
		var $titles = $('.title', json.movies);
		var $m = json.movies;
		$titles.each(function (i) {
			$m = $m.replace(this.innerHTML, this.innerHTML.trimToPx(177));
		});
		
		$('#movies_space').before($m);
		
		this.setPermalink(this._page);
		
		// Call callback, if provided
		if(callback) {
		    callback();
		} else {
			// Only change the loader, if we're finished loading pages
			//Gamma.Loader.Display("Movies loaded.",500);
		}
	},
	
	Permalink: function(page) {
		this.setPermalink(page);
		this.goToPermalink(page);
	},
	
	setPermalink: function(page){
		cLog("Settings pushState to page "+page);
		var stateObj = { 'page': page };
		history.pushState(stateObj, "Page: "+page, this._compileUrl(true));
	},
	
	goToPermalink: function(page) {
		$.scrollTo($('#movies_'+page),800);
	}
}