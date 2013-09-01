var map;
var markers;
var googleLayer;
var cloudmadeUrl = 'http://{s}.tile.cloudmade.com/5d205a745590448bbb2598e28fd70844/997/256/{z}/{x}/{y}.png',
cloudmadeAttribution = 'Map data &copy; 2011 OpenStreetMap contributors, Imagery &copy; 2011 CloudMade, Points &copy 2012 LINZ',
cloudmade = L.tileLayer(cloudmadeUrl, {maxZoom: 18, attribution: cloudmadeAttribution}),
latlng = L.latLng(21.6, 79);

jQuery(function() {
	googleLayer = new L.Google('ROADMAP');
	map = L.map('map', {center: latlng, zoom: 4, layers: [googleLayer]});
	
	//map = L.map('map', {center: latlng, zoom: 4, layers: [cloudmade]});
	
	markers = L.markerClusterGroup();
	
	jQuery( "#search" ).autocomplete({
		source: "search.php",
		minLength: 2,
		select: function( event, ui ) {
			jQuery('#search').val(ui.item.value);
			jQuery('#level').val(ui.item.level);
			//getMap();
		}
	});
	
	jQuery("#search-button").click(function(){
		getMap();
		return false;
	});
	
	jQuery( "#slider-range" ).slider({
		 orientation: "horizontal",
		 range: true,
		 values: [ 0, 100 ],
		 step: 5,
		 slide: function(event, ui){
			jQuery( "#percentage span" ).html( ui.values[ 0 ] + " - " + ui.values[ 1 ] );
			//getMap();
		}
	});
	jQuery( "#percentage span" ).html( jQuery( "#slider-range" ).slider( "values", 0 ) +
			 " - " + jQuery( "#slider-range" ).slider( "values", 1 ) );
	
	 
// for slide in slide out
jQuery('#arrow').on('click', function(){ 
  var $this = $('#search-controls');
  if ($this.hasClass('open')) {
	$(this).removeClass('open');
	$(this).addClass('close');
    $this.animate({
      left : '-22%'
    }, 500).removeClass('open');
  } else {
  $(this).removeClass('close');
	$(this).addClass('open');
    $this.animate({
      left : 0
    }, 500).addClass('open');
  }
});

/**
jQuery.get("india_states.geojson", function(india) { //Ajax load boundary file
        india = JSON.parse( india); //Parse the geojson
 var geojsonLayer = new L.GeoJSON(india);
 L.geoJson( india, {
        //Define boundary style to match map. Reference: http://leafletjs.com/reference.html#path-options
        style: function (feature) {
          return { color: "#000000", opacity: 1, fillOpacity: 0, weight: 1,clickable:false };
        }
      }).addTo(map);

      });
 */
	 
	 });



function plotMap(data){
	markers.clearLayers();
	for(var i in data)
	{
		var marker = L.marker(L.latLng(data[i].lat, data[i].lng),{title: data[i].title});
		if(data[i].calln == 1) {
			marker.on('click', function(e) {
				jQuery('#search').val(e.target.options.title);
				jQuery('#level').val('district');
				getMap();
			});
		}
		
		if(data[i].pop != "") {
			marker.bindPopup(data[i].pop);

		}
		
		/*marker.bindPopup(\"<a href='homer.php?a=$tmpdt'>Get Habitation Level Data</a><br><a href='home.php?a=$tmpdt'>Get Block Level Data</a>\");*/
		markers.addLayer(marker);
	}		

	map.addLayer(markers);
}

function getMap() {
	var search = jQuery('#search').val();
	var min_per = jQuery( "#slider-range" ).slider( "values", 0 );
	var max_per = jQuery( "#slider-range" ).slider( "values", 1 );
	var level = jQuery('#level').val();
	if(search != '') {
		var data = {term: search, max_per: max_per, min_per: min_per, level: level};
		jQuery.ajax({
			dataType: "json",
			url: 'getMap.php',
			data: data,
			success: function(response) {
				plotMap(response)
			}	
		});
	}
}

