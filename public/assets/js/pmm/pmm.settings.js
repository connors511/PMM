PMM.Settings = {
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
		'filter': '',
		'moviesOnPageLimit': 50000
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