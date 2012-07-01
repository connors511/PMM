PMM = {
    
	Init: function() {
        
		cLog("PMM.Init called. Initiating PMM");
        	
		$('form').submit( function() {  });
        
		PMM.Search != null && 
			PMM.Search.InitQuickSearch();
		PMM.Movies != null &&
			PMM.Movies.Init();
		//PMM.Search != null && PMM.Search.Advanced != null && 
		//	PMM.Search.Advanced.Init();
		PMM.InfiniteScrolling != null && 
			PMM.InfiniteScrolling.Init();

	}
}