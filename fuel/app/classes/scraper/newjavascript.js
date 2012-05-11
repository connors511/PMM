/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


WDV = {
	_map: null,
	_pos: null,
	_cloudmade: null,
	_initialized: false,
	_windfarms: [],
	_iconTemplate: null,
		
	Init: function() {
		if (!this._initialized) {
			_map = new L.Map('map');
			_cloudmade = new L.TileLayer('http://{s}.tile.cloudmade.com/6d31e7d426dc40368e1b7bd1f07c8aa6/997/256/{z}/{x}/{y}.png', {
				attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery ? <a href="http://cloudmade.com">CloudMade</a>',
				maxZoom: 18
			});
			// Our view position
			_pos = new L.LatLng(56.200, 11.200); 
			// Set the view
			_map.setView(_pos, 7).addLayer(_cloudmade);
			
			_iconTemplate = L.Icon.extend({
				iconUrl: WDV.Settings.Icon.iconUrl,
				shadowUrl: WDV.Settings.Icon.shadowUrl,
				iconSize: WDV.Settings.Icon.iconSize,
				shadowSize: WDV.Settings.Icon.shadowSize,
				iconAnchor: WDV.Settings.Icon.iconAnchor,
				popupAnchor: WDV.Settings.Icon.popupAnchor
			});
			
			WDV.InitWindfarms();
			_map.on('click', function() {
				var latlngStr = '(' + e.latlng.lat.toFixed(3) + ', ' + e.latlng.lng.toFixed(3) + ')';
				var popup = new L.Popup();
				popup.setLatLng(e.latlng);
				popup.setContent("You clicked the map at " + latlngStr);

				map.openPopup(popup);
			});
		}
	},
	InitWindfarms: function() {
		this._windfarms = [];
		for (i = 0; i < WDV.Settings.Windfarm.positions.length; i++) {
			// Create the marker
			this._windfarms[i] = new WDV.Obj.Marker();
			this._windfarms[i].position = new L.LatLng(WDV.Settings.Windfarm.positions[i][0], WDV.Settings.Windfarm.positions[i][1]);
			this._windfarms[i].marker = new L.Marker(this._windfarms[i].position, {
				icon: this._iconTemplate
			});
			
			// Click event
			marker.on('click', function(e) {
				var page = "chart/?lat=" + this.getLatLng().lat.toFixed(3) + "&lng=" + this.getLatLng().lng.toFixed(3);
				var $dialog = $( "#dialog-form" )
				.html('<iframe style="border: 0px; " src="' + page + '" width="100%" height="100%"></iframe>')
				.dialog({
					autoOpen: WDV.Settings.Marker.autoOpen,
					modal: WDV.Settings.Marker.modal,
					height: WDV.Settings.Marker.height,
					width: WDV.Settings.Marker.width,
					title: WDV.Settings.Marker.title,
					close: WDV.Settings.Marker.close
				});
				$("#map").fadeTo("slow", 0.3);
				$dialog.dialog('open');
			//alert("test " + '(' + this.getLatLng().lat.toFixed(3) + ', ' + this.getLatLng().lng.toFixed(3) + ')');
			});
			
			// Put it on the map
			this._map.addLayer(this._windfarms[i].marker);
		}
	}
};

WDV.Settings = {
	Icon: {
		iconUrl: 'test.png',
		shadowUrl: null,
		iconSize: new L.Point(64, 64),
		shadowSize: null,
		iconAnchor: new L.Point(32, 32),
		popupAnchor: new L.Point(-3, -75)
	},
	Marker: {
		autoOpen: false,
		modal: true,
		height: screen.height * 0.7,
		width: screen.width * 0.8,
		title: 'Chart',
		close: function(ev, ui) {
			$("#map").fadeTo("slow", 1);
		}
	},
	Windfarm: {
		positions: []
	}
};


/* Objects */
WDV.Obj.Marker = {
	position: null,
	marker: null
};