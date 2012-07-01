PMM.Movies = {
	
	_page: 0,
	_moviesPerPage: 0, // Movies per page
	_moviesOnPage: 0,
	_atEnd: false,
	
	Init: function() {
		cLog("PMM.Movies.Init called. Initiating Movies");
		
		this._moviesOnPage = $('.movie').length;
	},
	
	getMovieListDimensions: function() {
		$movie = '<div id="dummy" class="movie" style="display:none"></div>';
		$('#movies_space').before($movie);
		var dim = {
			'width': $('#dummy').outerWidth(),
			'height': $('#dummy').outerHeight()
		};
		$('#dummy').remove();
		return dim;
	},
	
	getCurrentPage: function() {
		return this._page;
	},
	
	getMoviesPerPage: function() {
		if (this._moviesPerPage != 0) {
			return this._moviesPerPage;
		}
		
		dim = this._getMovieListDimensions();
		cW = Math.floor($('#movies').outerWidth() / dim.width);
		cH = Math.floor(($(document).height() - $('#header').height() - $('#footer').height()) / dim.height);
		this._moviesPerPage = (cH + 1) * cW;
		return this._moviesPerPage; // Make sure 1 extra row is loaded
	},
	
	getMovies: function(callback) {
		if(this._atEnd)
			return;
		
		//Gamma.Loader.Display("Fetching new movies...");
					
		cLog("Retriving new movies for page "+(this._page + 1));
		
		$.ajax({
			type: "GET", 
			timeout: 15000,
			url: this.Url.getUrl(),
			success: function(m) 
			{
				cLog("Successfully sent AJAX request from getMovies");
				PMM.Movies._page++;
				PMM.Movies.processMovies(m, callback);
			},
			error: function(jqXHR, textStatus, errorThrown)
			{
				cLog("An error occured during getMovie AJAX request. Unbinding infinite scrolling to prevent unexpected behavior");
				cLog("AJAX error was: " + textStatus);
				cLog(jqXHR);
				//Gamma.Loader.Display("An error occured during the request.",500);
				PMM.InfiniteScrolling != null && PMM.InfiniteScrolling.Unbind();
			}
		});
	},
	
	processMovies: function(data, callback) {
		
		PMM.InfiniteScrolling.Bind();
		
		if(!data) {
			cLog("Recieved movie list was empty.");
			//Gamma.Loader.Display("No movies found",500);
			PMM.InfiniteScrolling != null && PMM.InfiniteScrolling.Unbind();
		}
		eval("var json = ("+data+")");
		cLog(json);
		if(json.total == 0) {
			cLog("Recieved movie list was empty.");
			//Gamma.Loader.Display("No movies found",500);
			PMM.InfiniteScrolling != null && PMM.InfiniteScrolling.Unbind();
		}
		
		if (this._clean) {
			this._moviesOnPage = 0;
		}
		this._moviesOnPage += json.count;
		
		if(this._moviesPerPage > json.count) {
			cLog("Got "+json.total+" movies. Unbinding scroll");
			this._atEnd = true;
			PMM.InfiniteScrolling != null && PMM.InfiniteScrolling.Unbind();
		}
		if(this._moviesOnPage >= json.total) {
			cLog("Total amount of movies exceeded. Got " + this._moviesOnPage + " and server got " + json.total);
			this._atEnd = true;
			PMM.InfiniteScrolling != null && PMM.InfiniteScrolling.Unbind();
		}
		
		// Push it
		if (this._clean) {
			$('#movies').html('<div id="movies_space"></div><div id="ruler" class="movie"><div class="title"></div></div>');
		}
		if (this._clean) {
			this._clean = false;
		}
		
		// TODO: Confirm this is working as intended
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
	
	setPermalink: function(page){
		cLog("Settings pushState to page "+page);
		var stateObj = {'page': page};
		history.pushState(stateObj, "Page: "+page, this.Url.getUrl(true));
	}
}

PMM.Movies.Url = {
	
	Settings: {
		'callback': 'json',
		'offset': 0,
		'count': 0,
		'urlbase': 'home/'
	},
	
	Params: {
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
	
	getUrl: function(current) {
		cLog("Compiling AJAX URL for movie retrival");
		current = typeof(current) != 'undefined' ? current : false;
		
		var uri = PMM.Settings.BASE_URL + this.Settings['urlbase'];
		uri += this.getUrlParams();
		if (this._page > 0 && !current) {
			uri += (PMM.Movies.getCurrentPage() + 1);
		} else {
			uri += (PMM.Movies.getCurrentPage() < 2) ? '' : PMM.Movies.getCurrentPage();
		}
		cLog("Compiled URL to: " + uri);
		return uri;
	},
	
	isSearching: function() {
		return this.Params.term != "";
	},
	
	getUrlParams: function() {
		var uri = '';
		if (this.isSearching()) {
			this.Params.same_movie = this.Params.same_movie.replace('Same movie','same');
			if (this.Params.term != '') {
				if (this.isOnlyParam('term')) {
					// We're only searching for a title.. This could still be from the advanced search
					cLog("Searching for '" + this.Params.term + "'");
					uri = 'search/' + this.Params.term + '/';
					return uri;
				}
			}
			// We might search for ratings, length, resolution, aspect ratio, file size, audio, people, release date, genres or date added
			if (this.hasMultipleParams()) {
				var string = '';
				for(var i in this.Params) {
					if (this.Params[i] != "") {
						var tmpParam = '';
						if (i == 'released') {
							tmpParam = this.Params[i].replace('&lt; 70s', 'pre70');
						} else if (i == 'added') {
							tmpParam = this.Params[i].replace('&gt; 1 year', 'post1year');
							tmpParam = tmpParam.replace(/ /g,'');
						} else {
							tmpParam = this.Params[i];
						}
						string += '&' + i + '=' + tmpParam;
					}
				}
				cLog("Searching for '" + string.substring(1, string.length) + "'");
				uri = 'advanced/' + string.substring(1, string.length) + '/';
			} else {
				// Can be any single param of the above stated.
				var param = this.getSingleParam();
				cLog("Searching for movies with " + param + " = '" + this.Params.term + "'");
				var tmpParam = '';
				if (param == 'released') {
					tmpParam = this.Params[param].replace('&lt; 70s', 'pre70');
				} else if (param == 'added') {
					tmpParam = this.Params[param].replace('&gt; 1 year', 'post1year');
					tmpParam = tmpParam.replace(/ /g,'');
				} else {
					tmpParam = this.Params[param];
				}
				cLog(param +' = '+tmpParam);
				uri = param + '/' + tmpParam + '/';
			}
		}
		return uri;
	},
	
	isOnlyParam: function(param) {
		for(var i in this.Params) {
			if (i != param && this.Params[i] != "") {
					return false;
			}
		}
		return true;
	},
	
	hasMultipleParams: function() {
		var count = 0;
		for(var i in this.Params) {
			if (this.Params[i] != "")
				count++;
			if (count == 2) {
				return true;
			}
		}
		return false;
	},
	
	hasNoParams: function() {
		for(var i in this.Params) {
			if (this.Params[i] != "")
				return false;
		}
		return true;
	},
	
	getSingleParam: function() {
		for(var i in this.Params) {
			if (this.Params[i] != "")
				return i;
		}
		return false;
	}
}