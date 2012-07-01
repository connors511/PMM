PMM.Search = {
	
	_delay: 50,
	
	InitQuickSearch: function() {
		cLog("PMM.Search.InitQuickSearch called.");
		var qs = $('#quick_search_input');
		
		qs.focus(function() {
			if ($(this).val().toLowerCase() == PMM.Lang.QuickSearch.toLowerCase()) {
				$(this).val('');
			}
		}).blur(function() {
			if ($(this).val() == '') {
				$(this).val(PMM.Lang.QuickSearch);
			}
		})
        
		cLog("EVENT: QuickSearch onFocus hooked.");
	
		qs.bind( "keyup", function() {
			clearTimeout( self.searching );
			self.term = $(this).val();
			// No idea why, but it doesnt work without this line
			$('#quick_search_input').val(self.term);
			
			self.searching = setTimeout(function() {
				// only search if the value has changed
				if ( self.term == $('#quick_search_input').val() ) {
					PMM.Search.search(self.term);
				}
			}, PMM.Search._delay );
		});
	},
    
	search: function(term) {
		this._moviesOnPage = 0;
		PMM.Movies._clean = true;
		PMM.Movies._atEnd = false;
		PMM.Movies._page = 1;
		if (term == "") {
			cLog("No search term, start browsing");
			PMM.Movies.Url.Params.term = '';
		} else {
			cLog("SEARCHING FOR: " + self.term);
			PMM.Movies.Url.Params.term = term;
		}
		PMM.Movies.getMovies();
	}
}