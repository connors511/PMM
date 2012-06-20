MMC.Backdrop = {
	
	Init: function() {
		cLog("MMC.Backdrop.Init called. Initiating backdrop");
		if(!$('#backdrop') || !$("#backdrop_image")) {
			cLog("Backdrop not found. Exiting.");
			return;
		}
		
		// Give the page a chance to load completely, before trying to determine the backdrop size
		setTimeout(function() {
			$('#backdrop').css('top',50);
			
			MMC.Backdrop.resizeAllBackdrops();
			
			$('#backdrop img:first').fadeIn(1000, function() {
				$(this).addClass('active');
				
				if($('#backdrop img').length > 1) {
					setInterval(function() {
						MMC.Backdrop.rotateBackdrop();
					}, MMC.Settings.Backdrop.backdropRotateTime * 1000);
				}
			});
			
			// Slow down
			setTimeout(function(){
				$('#movie').fadeIn(1000)
			},1000);
		}, 500);
	},
	
	resizeAllBackdrops: function() {
		$('#backdrop img').each(function() {
			MMC.Backdrop.resizeBackdrop($(this));
		});
	},
	
	resizeBackdrop: function(el) {
		var ratio = el.height() / el.width();
		var height = $(document).height();
		var width = $(document).width();
		var viewport_ratio = height / width;
		
		if($('#backdrop').height() != height){
		    $("#backdrop").height(height);
		    $("#backdrop").width(width);
		}
		
		if(viewport_ratio < ratio){
			el.height(null);
			el.width(width);
		}
		else
		{
			el.height(height);
			el.width(null);
		}
		if(el.width() < width) {
			el.width(width);
		}
	},
	
	rotateBackdrop: function() {
		cLog("--Rotating");
		// Remove last-active
		$('#backdrop .last-active').removeClass('last-active');
		// Setup vars
		$active = $('#backdrop .active');
		$next = ($active.next().length == 0) ? $('#backdrop img:first') : $active.next();
		// Change classes around
		$active.removeClass('active').addClass('last-active');
		$next.addClass('active');
		// Fadein the next element
		$next.fadeIn(3000);
		// jQuery changes the display to inline upon fadeIn(), change the hidden ones back for smooth fades
		setTimeout(function() {
			$active.css('display','none');
		}, 3000);
	}
}
