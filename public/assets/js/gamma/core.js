jQuery.extend(jQuery.expr[':'], {
  focus: "a == document.activeElement"
});

Gamma = {
	
	_delay: 50,
    
	Init: function() {
        
		cLog("Gamma.Init called. Initiating Gamma");
        
		$('#quick_search').click(function() {
			if($('#quick_search_input').is(':focus')) {
				return;
			}
			if($('#quick_search_form').is(':hidden')) {
				// advanced menu shown
				cLog("Collapsing advanced menu.");
				$('#menu').animate({
					height: '-=' + $('#advanced_search').height()
					});
				$('#quick_search_form').fadeIn('slow');
			} else {
				cLog("Expanding advanced menu.");
				$('#menu').animate({
					height: '+=' + $('#advanced_search').height()
					});
				$('#quick_search_form').fadeOut('slow');
			}
		});
		cLog("EVENT: Menu onClick hooked.");
	
		$('form').submit( function() {  });
        
		Gamma.InitQuickSearch();
		Gamma.AdvancedSearch.Init();
		Gamma.InfiniteScrolling.Init();
	/*$.pjax({
            url: 'api/movies',
            container: '#movies',
            fragment: '#movies'
        });*/
	},
    
	InitQuickSearch: function() {
		cLog("Gamma.InitQuickSearch called.");
        
		var qs = $('#quick_search_input');
        
		qs.focus(function() {
			if ($(this).val().toLowerCase() == Gamma.Lang.QuickSearch.toLowerCase()) {
				$(this).val('');
			}
		}).blur(function() {
			if ($(this).val() == '') {
				$(this).val(Gamma.Lang.QuickSearch);
			}
		})
        
		cLog("EVENT: QuickSearch onFocus hooked.");
	
		qs.bind( "keyup", function() {
			clearTimeout( self.searching );
			self.term = $(this).val();
			cLog(self.term);
			self.searching = setTimeout(function() {
				// only search if the value has changed
				if ( self.term == $('#quick_search_input').val() ) {
					Gamma._search(self.term);
				}
			}, Gamma._delay );
		});
	},
    
	_search: function(term) {
		if (term == "") {
			cLog("No search term, start browsing");
			Gamma.Movies._isSearching = false;
			Gamma.Movies._clean = true;
			Gamma.Movies._urlParameters.term = '';
			Gamma.Movies._atEnd = false;
			Gamma.Movies._page = 0;
			Gamma.Movies._replace = false;
			Gamma.Movies.getMovies();
		} else {
			cLog("SEARCHING FOR: " + self.term);
			Gamma.Movies._isSearching = true;
			Gamma.Movies._urlParameters.term = term;
			Gamma.Movies._atEnd = false;
			Gamma.Movies._page = 0;
			Gamma.Movies._replace = true;
			Gamma.Movies.getMovies();
		}
	}
}

Gamma.AdvancedSearch = {
	Init: function() {
		cLog("Gamma.AdvancedSearch.Init called.");
        
		Gamma.AdvancedSearch.Populate();
		Gamma.AdvancedSearch.InitCheckboxes();
		Gamma.AdvancedSearch.InitSearchBars();
	},
    
	Populate: function() {
	// Set checkboxes and input fields so they match url
	},
    
	InitCheckboxes: function() {
		cLog("Gamma.InitCheckboxes called.");
		$('.ticbox').click(function() {
			var tar = $(this).attr('target').substr(2, $(this).attr('target').length);
			var val = $(this).parent().attr('class');
			var cb = $('#' + $(this).attr('target'));
			var vals = cb.val();
			if(val == 'setting-include') {
				if (vals.search($(this).next().html()) > -1) {
					vals = vals.replace("inc" + $(this).next().html(), "exc" + $(this).next().html());
				} else {
					vals += ";exc"+$(this).next().html();
				}
				$(this).parent().attr('class','setting-exclude');
			} else if (val == 'setting-exclude') {
				vals = vals.replace("exc" + $(this).next().html(), "");
				if (vals == ";" || vals == "") {
					vals = 0;
				}
				$(this).parent().attr('class','setting-none');
			} else {
				if (vals == '0') {
					vals = "inc" + $(this).next().html();
				} else if (vals.search($(this).next().html()) > -1) {
					vals = vals.replace($(this).next().html(), "inc" + $(this).next().html());
				} else {
					vals += ";inc"+$(this).next().html();
				}
				$(this).parent().attr('class','setting-include');
			}
			if(vals && vals.charAt( vals.length-1 ) == ";") {
				vals = vals.slice(0, -1);
			}
			if(vals && vals.charAt( 0 ) == ";") {
				vals = vals.slice(0, 1);
			}
			cb.val(vals);
			cLog(tar + " = " +cb.val());
			Gamma.Movies._urlParameters[tar] = (cb.val() == 0) ? '' : cb.val();
			Gamma.AdvancedSearch._updateSearch();
		});
		$('input[type=hidden]').each(function(index, value) {
			cLog(index + ' = ' + $(this).attr('id'));
			var tar = $(this).attr('id').substr(2, $(this).attr('id').length);
			var params = $(this).attr('value').split(';');
			if (params[0] == 0) {
				return;
			}
			for (var i = 0; i < params.length; i++)
			{
				var type = params[i].substr(0, 3);
				var val = params[i].substr(3, params[i].length);
				var cls = 'setting-';
				if (type == 'inc') {
					cls += 'include';
				} else if (type == 'exc') {
					cls += 'exclude';
				} else {
					cls += 'none';
				}
				$('#s_' + tar + '_' + val).parent().attr('class', cls);
				cLog('#'+tar+'_'+val);
			}
		});
		cLog("EVENT: Checkboxes onClick hooked.");
	},
    
	InitSearchBars: function() {
		cLog("Gamma.AdvancedSearch.InitSearchBars called.");
        
		var st = $('#search_titles_input');
		var sp = $('#search_people_input');
        
		st.focus(function() {
			if ($(this).val().toLowerCase() == Gamma.Lang.SearchTitle.toLowerCase()) {
				$(this).val('');
			}
		}).blur(function() {
			if ($(this).val() == '') {
				$(this).val(Gamma.Lang.SearchTitle);
			}
		});
	
		st.bind( "keyup", function() {
			clearTimeout( self.searching );
			self.term = $(this).val();
			cLog(self.term);
			self.searching = setTimeout(function() {
				// only search if the value has changed
				if ( self.term == $('#search_titles_input').val() ) {
					Gamma.AdvancedSearch._search(self.term);
				}
			}, Gamma._delay );
		});
        
		sp.focus(function() {
			if ($(this).val().toLowerCase() == Gamma.Lang.SearchPeople.toLowerCase()) {
				$(this).val('');
			}
		}).blur(function() {
			if ($(this).val() == '') {
				$(this).val(Gamma.Lang.SearchPeople);
			}
		});
	
		sp.bind( "keyup", function() {
			clearTimeout( self.searching );
			self.persons = $(this).val();
			cLog(self.persons);
			self.searching = setTimeout(function() {
				// only search if the value has changed
				if ( self.persons == $('#search_people_input').val() ) {
					Gamma.AdvancedSearch._searchPersons(self.persons);
				}
			}, Gamma._delay );
		});
        
		cLog("EVENT: Search bars onFocus hooked.");
	},
    
	_search: function(term) {
		if (term == "") {
			cLog("No search term, start browsing");
			Gamma.Movies._isSearching = false;
			Gamma.Movies._clean = true;
			Gamma.Movies._urlParameters.term = '';
			Gamma.Movies._atEnd = false;
			Gamma.Movies._page = 0;
			Gamma.Movies._replace = false;
			Gamma.Movies.getMovies();
		} else {
			cLog("SEARCHING FOR: " + self.term);
			Gamma.Movies._isSearching = true;
			Gamma.Movies._urlParameters.term = term;
			Gamma.Movies._atEnd = false;
			Gamma.Movies._page = 0;
			Gamma.Movies._replace = true;
			Gamma.Movies.getMovies();
		}
	},
    
	_searchPersons: function(persons) {
		if (persons == "") {
			cLog("No search term, start browsing");
			Gamma.Movies._isSearching = false;
			Gamma.Movies._clean = true;
			Gamma.Movies._urlParameters.persons = '';
			Gamma.Movies._atEnd = false;
			Gamma.Movies._page = 0;
			Gamma.Movies._replace = false;
			Gamma.Movies.getMovies();
		} else {
			cLog("SEARCHING FOR: " + self.persons);
			Gamma.Movies._isSearching = true;
			Gamma.Movies._urlParameters.persons = persons;
			Gamma.Movies._atEnd = false;
			Gamma.Movies._page = 0;
			Gamma.Movies._replace = true;
			Gamma.Movies.getMovies();
		}
	},
    
	_updateSearch: function() {
		if (Gamma.Movies._hasNoParams()) {
			Gamma.Movies._isSearching = false;
			Gamma.Movies._clean = true;
			Gamma.Movies._atEnd = false;
			Gamma.Movies._page = 0;
			Gamma.Movies._replace = false;
			Gamma.Movies.getMovies();
		} else {
			Gamma.Movies._isSearching = true;
			Gamma.Movies._clean = true;
			Gamma.Movies._atEnd = false;
			Gamma.Movies._page = 0;
			Gamma.Movies._replace = true;
			Gamma.Movies.getMovies();
		}
	}
}

Gamma.Lang = {
	QuickSearch: "Quick Search",
	SearchTitle: "Search title",
	SearchPeople: "Search people"
}

Gamma.Settings = {
	// Settings for the movie library
	BASE_URL: '',
	SUB_URL: '',
	MOVIE_VIEW: 0,
	SEARCH: 0,
	NOT_FOUND: false,
     
	Movies: {
		'maxMovies': 20000, // Max amount of movies per page
		'urlBase': 'ajax',
		'sort': '',
		'filter': ''
	},
	InfiniteScrolling: {
         
	},
	Loader: {
		'loaderimg': 'assets/img/loader1.gif',  
		'minDisplayTime': 1
	},
	Backdrop: {
		'backdropRotateTime': 10 // 10 seconds
	},
	User: {
		'id': false,
		'firstname': 'John',
		'lastname': 'Doe',
		'movies_viewed': 1337,
		'bandwidth_left': 100
	}
}