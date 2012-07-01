PMM.Search.Advanced = {
	Init: function() {
		cLog("PMM.Search.Advanced.Init called.");
        
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
		
		PMM.Search.Advanced.Populate();
		PMM.Search.Advanced.InitCheckboxes();
		PMM.Search.Advanced.InitSearchBars();
	},
    
	Populate: function() {
		cLog("PMM.Search.Advanced.Populate called.");
		// Set checkboxes and input fields so they match url
	},
    
	InitCheckboxes: function() {
		cLog("PMM.InitCheckboxes called.");
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
			PMM.Movies._urlParameters[tar] = (cb.val() == 0) ? '' : cb.val();
			PMM.Search.Advanced.updateSearch();
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
		cLog("PMM.Search.Advanced.InitSearchBars called.");
        
		var st = $('#search_titles_input');
		var sp = $('#search_people_input');
        
		st.focus(function() {
			if ($(this).val().toLowerCase() == PMM.Lang.SearchTitle.toLowerCase()) {
				$(this).val('');
			}
		}).blur(function() {
			if ($(this).val() == '') {
				$(this).val(PMM.Lang.SearchTitle);
			}
		});
	
		st.bind( "keyup", function() {
			clearTimeout( self.searching );
			self.term = $(this).val();
			cLog(self.term);
			self.searching = setTimeout(function() {
				// only search if the value has changed
				if ( self.term == $('#search_titles_input').val() ) {
					PMM.Search.Advanced.search(self.term);
				}
			}, PMM.Search._delay );
		});
        
		sp.focus(function() {
			if ($(this).val().toLowerCase() == PMM.Lang.SearchPeople.toLowerCase()) {
				$(this).val('');
			}
		}).blur(function() {
			if ($(this).val() == '') {
				$(this).val(PMM.Lang.SearchPeople);
			}
		});
	
		sp.bind( "keyup", function() {
			clearTimeout( self.searching );
			self.persons = $(this).val();
			cLog(self.persons);
			self.searching = setTimeout(function() {
				// only search if the value has changed
				if ( self.persons == $('#search_people_input').val() ) {
					PMM.Search.Advanced.searchPersons(self.persons);
				}
			}, PMM.Search._delay );
		});
        
		cLog("EVENT: Search bars onFocus hooked.");
	},
    
	search: function(term) {
		if (term == "") {
			cLog("No search term, start browsing");
			PMM.Movies._isSearching = false;
			PMM.Movies._clean = true;
			PMM.Movies._urlParameters.term = '';
			PMM.Movies._atEnd = false;
			PMM.Movies._page = 0;
			PMM.Movies._replace = false;
			PMM.Movies.getMovies();
		} else {
			cLog("SEARCHING FOR: " + self.term);
			PMM.Movies._isSearching = true;
			PMM.Movies._urlParameters.term = term;
			PMM.Movies._atEnd = false;
			PMM.Movies._page = 0;
			PMM.Movies._replace = true;
			PMM.Movies.getMovies();
		}
	},
    
	searchPersons: function(persons) {
		if (persons == "") {
			cLog("No search term, start browsing");
			PMM.Movies._isSearching = false;
			PMM.Movies._clean = true;
			PMM.Movies._urlParameters.persons = '';
			PMM.Movies._atEnd = false;
			PMM.Movies._page = 0;
			PMM.Movies._replace = false;
			PMM.Movies.getMovies();
		} else {
			cLog("SEARCHING FOR: " + self.persons);
			PMM.Movies._isSearching = true;
			PMM.Movies._urlParameters.persons = persons;
			PMM.Movies._atEnd = false;
			PMM.Movies._page = 0;
			PMM.Movies._replace = true;
			PMM.Movies.getMovies();
		}
	},
    
	updateSearch: function() {
		if (PMM.Movies._hasNoParams()) {
			PMM.Movies._isSearching = false;
			PMM.Movies._clean = true;
			PMM.Movies._atEnd = false;
			PMM.Movies._page = 0;
			PMM.Movies._replace = false;
			PMM.Movies.getMovies();
		} else {
			PMM.Movies._isSearching = true;
			PMM.Movies._clean = true;
			PMM.Movies._atEnd = false;
			PMM.Movies._page = 0;
			PMM.Movies._replace = true;
			PMM.Movies.getMovies();
		}
	}
}