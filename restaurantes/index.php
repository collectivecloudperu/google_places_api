<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>Buscar Restaurantes Cercanos</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">    
	    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

		<script src="https://maps.googleapis.com/maps/api/js?key=TUAPIKEYACA&libraries=places&callback=initMap" async defer></script>

		<style type="text/css">
			#map {
				width: 100%;			   
			    height: 500px;
			}
		</style>

	</head>
	<body>

		<div class="container">
			<h1>Buscar Restaurantes Cercanos:</h1>
			<div class="row">

				<div class="col-md-12">

					<div class="map_container">
						<div id="map"></div>
					</div>

				</div>

			</div>
			<br>
			<footer>
				<div align="center">
					Desarrollado por <a href="http://collectivecloudperu.com" target="_blank">Collective Cloud Perú</a>
				</div>
			</footer>
		</div>


		<script type="text/javascript">
	      function initMap() {

	        if (navigator.geolocation) { //Geolocalizar
	          navigator.geolocation.getCurrentPosition(function(position) {

	            pos = {
	              lat: position.coords.latitude/*-12.0872261*/,
	              lng: position.coords.longitude/*-77.0029128*/
	            }
	            map = new google.maps.Map(document.getElementById('map'), {
	              center: myLocation,
	              zoom: 17
	            });

	            infoWindow = new google.maps.InfoWindow({
	              map: map
	            });

	            infoWindow.setPosition(pos);
	            infoWindow.setContent('Mi ubicación.');
	            map.setCenter(pos);
	            var myLocation = pos;

	            var service = new google.maps.places.PlacesService(map);
	            service.nearbySearch({
	              location: myLocation,
	              radius: 500, /* Que detecte los lugares en un Radio de 500 metros a la redonda */
	              types: ['restaurant']
	            }, callback);
	          })
	        };
	      }

	      function callback(results, status) {
	        if (status === google.maps.places.PlacesServiceStatus.OK) {
	          for (var i = 0; i < results.length; i++) {
	            createMarker(results[i]);
	          }
	        }
	      }

	      function createMarker(place) {
	        var placeLoc = place.geometry.location;
	          if (place.icon) {
	            var image = new google.maps.MarkerImage(
	                  place.icon, new google.maps.Size(71, 71),
	                  new google.maps.Point(0, 0), new google.maps.Point(17, 34),
	                  new google.maps.Size(25, 25));
	          } else var image = null;

	          var marker = new google.maps.Marker({
	            map: map,
	            icon: image,
	            position: place.geometry.location
	          });

	          service = new google.maps.places.PlacesService(map);

	          var request =  {
	            reference: place.reference
	          };

	          google.maps.event.addListener(marker,'click',function(){
	              service.getDetails(request, function(place, status) {
	                if (status == google.maps.places.PlacesServiceStatus.OK) {
	                  var contentStr = '<h5><strong>'+place.name+'</strong></h5><p>'+place.formatted_address;
	                  if (!!place.formatted_phone_number) contentStr += '<br>'+place.formatted_phone_number;
	                  if (!!place.website) contentStr += '<br><a target="_blank" href="'+place.website+'">'+place.website+'</a>';
	                  /* contentStr += '<br>'+place.types+'</p>'; */
	                  contentStr += '<br>ID: '+place.place_id+'</p>';
	                  infowindow.setContent(contentStr);
	                  infowindow.open(map,marker);
	                } else { 
	                  var contentStr = "<h5>No Hubo Resultados, status="+status+"</h5>";
	                  infowindow.setContent(contentStr);
	                  infowindow.open(map,marker);
	                }
	              });
	          });
	      }

	    </script>			
		    
		

	</body>
</html>
