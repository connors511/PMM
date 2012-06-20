Gamma.GenreScroll = {
	_startGenre: null,
	_genres: null,
	_currentGenre: null,
	_scrollOffset: 0,
	
	Init: function() {
		cLog("MMC.GenreScroll.Init called. Initiating genres");
		// This could happen on subpages
		if(!$('#left') || !$('#right')){
			cLog("Navigation buttons for GenreScroll not found. No need for futher processing.");
			return;
		}
		if($('#genres').length == 0) {
			cLog("Genres not found. No need for futher processing");
			return;
		}
		
		this._fetchGenres();
		
		this._scrollOffset = Math.round(Math.max($(document).width()*0.5, 300));
		
		$('#right,#left').click(function(e) {
			e.preventDefault();
			var _direction = $(this).attr('id');
			var _oDirection = (_direction == 'left') ? 'right' : 'left';
			var vWidth = $(document).width() - $('#'+_direction).width();
			var width  = $('#genre_items').width();
			var offset = $('#genre_items').position().left;
			var move   = MMC.GenreScroll._scrollOffset;
			if(_direction == 'left') {
				var maxOffset = 22;
				var nextOffset = offset + move;
				
				if(nextOffset >= maxOffset){
					var move = maxOffset - offset;
					$('#left').fadeOut(500);
				}
	
				$("#genre_items").animate({"left": "+="+move}, 600);
			} else {
				var maxOffset = vWidth - width;
				var nextOffset = offset - move;
				
				if(nextOffset <= maxOffset){
					var move = offset - maxOffset;
					$('#right').fadeOut(500);
				}
				
				$("#genre_items").animate({"left": "-="+move}, 600);
			}
			if(!$('#'+_oDirection).is(":visible")){
				$('#'+_oDirection).fadeIn(500);
			}
			return false;
		});
	},
	
	_fetchGenres: function() {
		cLog("Fetching genres");
		MMC.Loader.Display("Building menu...");
		
		$.ajax({
			type: "GET", 
			timeout: 1500,
			url: MMC.Settings.BASE_URL + MMC.Settings.GenreScroll.menuUrl,
			success: function(m) 
			{
				cLog("Successfully sent AJAX request from fetchGenres");
				MMC.GenreScroll._processGenres(m);
			},
			error: function()
			{
				cLog("An error occured during fetchGenres AJAX request.");
				MMC.Loader.Display("An error occured during the request.",500);
			}
		});
	},
	
	_processGenres: function(data) {
		cLog("Processiing genres");
		eval("var json = ("+data+")");
		
		this._genres = json.menus;
		this._buildMenu();
	},
	
	_buildMenu: function() {
		cLog("Building menus");
		if(this._genres == null) {
			cLog("Could not build menu due to empty genre list");
			return;
		}
		
		var menu = '';
		if(this._currentGenre == null) {
			if(MMC.Movies._urlParameters.genre) {
			    this._currentGenre = MMC.Movies._urlParameters.genre;
			} else {
			    this._currentGenre = 0;
			}
			cLog("Initiated currentGenre to " + this._currentGenre);
		}
		var $url = MMC.Settings.BASE_URL;
		if(MMC.Settings.SUB_URL != '' && !MMC.MOVIE_VIEW && MMC.Settings.SEARCH) {
			$url +=  MMC.Settings.SUB_URL;
			if(MMC.Settings.SEARCH) {// && MMC.Movies._urlParameters.query) {
				var uri = '';
				for(var i in MMC.Movies._urlParameters) {
					if(!in_array(i,['genre','offset','count','callback']))
					    uri += '&' + i + '=' + encodeURIComponent(MMC.Movies._urlParameters[i]);
				}
				uri = uri.replace('&','?');
				//$url += '?term='+MMC.Movies._urlParameters.query+'&genre=';
				$url += uri + '&genre=';
			} else {
				$url += '?genre=';
			}
		} else {
			$url += 'genre/';
		}
		for(var i = 0; i < this._genres.length; i++)
		{
			$j = this._genres[i];
			$e = '<li><a href="'+$url+$j['url']+'" id="'+$j['name'].replace(' ','-')+'" title="'+$j['name']+'">'+$j['name']+'</a></li>';
			menu += $e;
		}
		
		cLog("Populating " + this._genres.length + " genres into #genre_items");
		$('#genre_items').append(menu);
		$('#'+this._genres[this._currentGenre]['name'].replace(' ','-')).parent().addClass('current');
		
		$('#genre_items').css({'position':'relative','left':'0px','top':'0px', 'width': this._calcGenreWidth()+'px'});
		window.setTimeout(function(){
			MMC.GenreScroll.goTo(MMC.GenreScroll._currentGenre);
		}, 500);
		
		if(this._calcGenreWidth() <= $(document).width()) {
			// Get rid of them if the genre list is smaller than the screen width
			if($('#left'))
				$('#left').hide();
			if($('#right'))
				$('#right').hide();
		}
		
		// Lets display the menu ;)
		$('#footer').css({'display':'none', "visibility":"visible"}).fadeIn(1500);
	},
	
	_calcGenreWidth: function() {
		// Calc width of genres
		var $gWidth = 0;
		$('#genre_items').children().each(function() {
			$gWidth += $(this).width();
		});
		return $gWidth;
	},
	
	goTo: function(genre){
		cLog("Going to genre: "+this._genres[genre].name);
		var vWidth = $(document).width();
		var offset = $('#'+this._genres[genre].name.replace(' ','-')).position().left;
		if(offset > vWidth - 200){
			var move = vWidth - offset - 200;
			$("#genre_items").animate({"left": "+="+move}, 1200);
            
			window.setTimeout(function(){
				MMC.GenreScroll.updateButtons()
			}, 1500);
		}
	},
	
	didScrollRight: function(){
	    var vWidth = $(document).width() - $('#left').width();
	    var offset = $('#genre_items').position().left;
	    return offset < $('#right').width();
	},
	
	updateButtons: function(){
		cLog("Updating navigation buttons");
		if(this.didScrollRight() && !$('#left').is(":visible")) {
			$('#left').fadeIn(500);
		}
			
		var vWidth = $(document).width() - $('#right').width();
		var width  = $('#genre_items').width();
		var offset = $('#genre_items').position().left;
		var maxOffset = vWidth - width;
		
		if(offset < maxOffset && $('#right').is(":visible")) {
			$('#right').fadeOut(500);
		}
		else if(offset >= maxOffset && !$('#right').is(":visible")) {
			$('#right').fadeIn(500);
		}
	}
}