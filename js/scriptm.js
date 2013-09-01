var map;
var markers;
var cloudmadeUrl = 'http://{s}.tile.osm.org/{z}/{x}/{y}.png',
cloudmadeAttribution = 'Map data &copy; 2011 OpenStreetMap contributors, Imagery &copy; 2011 CloudMade, Points &copy 2012 LINZ',
cloudmade = L.tileLayer(cloudmadeUrl, {maxZoom: 18, attribution: cloudmadeAttribution}),
latlng = L.latLng(21.6, 79);

jQuery(function(){
		map = L.map('map', {center: latlng, zoom: 3, layers: [cloudmade]});
	
	markers = L.markerClusterGroup();
		
		jQuery( "#searchinput1" ).on( "listviewbeforefilter", function ( e, data ) {
			var $ul = $( this ),
			    $input = jQuery( data.input ),
			    value = $input.val(),
			    html = "";
				$ul.html( "" );
			if ( value && value.length > 1 ) {
			    $ul.html( "<li><div class='ui-loader'><span class='ui-icon ui-icon-loading'></span></div></li>" );
			    $ul.listview( "refresh" );
			    jQuery.ajax({
			        url: "search.php",
			        dataType: "json",
			        crossDomain: true,
			        data: {
			            term: $input.val()
			        }
			    })
			    .then( function ( response ) {
			        jQuery.each( response, function ( i, val ) {
			            html += "<li dvalue='"+val.value+"' dlavel='"+val.level+"' >" + val.label + "</li>";
			        });
			        
			        $ul.html( html );
			        $ul.listview( "refresh" );
			        $ul.trigger( "updatelayout");
			        
			        jQuery('#searchinput1 li').show();
			        
			        jQuery('#searchinput1 li').click(function(){
			        	jQuery('#searchinput1 li').hide();
			        	$input.val(jQuery(this).attr('dvalue'));
						jQuery('#search').val(jQuery(this).attr('dvalue'));
						jQuery('#level').val(jQuery(this).attr('dlavel'));
						//getMap();
			        });
			    });
			}
		});
		
		jQuery("#search-form").submit(function(){
			//jQuery('#search-form-content h3').trigger('click');
			getMap();
			return false;
		});
	});
	
	function plotMap(data){
	markers.clearLayers();
	for(var i in data)
	{
		var marker = L.marker(L.latLng(data[i].lat, data[i].lng),{title: data[i].title});
		if(data[i].calln == 1) {
			marker.on('click', function(e) {
				jQuery('input[data-type="search"]').val(e.target.options.title);
				//jQuery( "#searchinput1").val(e.target.options.title);
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
	var min_per = jQuery( "#range-1a" ).val();
	var max_per = jQuery( "#range-1b" ).val();
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


