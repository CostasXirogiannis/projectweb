//fetch
fetch('admin_map_fetch.php').then((res) => res.json())
.then(response =>{
    response.splice(-1,1);

	//vriskw unique user_ip
	var unique_users = [];
	var user_colour = {};
    for (let i=0, l=response.length; i<l; i++){
        if (unique_users.indexOf(response[i][2]) === -1 && response[i][2] !== ''){
            unique_users.push(response[i][2]);
            user_colour[response[i][2]] = Math.floor(Math.random()*16777215).toString(16);
        }
    }

	//vriskw lat lon gia tis uniques ips
	var endpoint = 'http://ip-api.com/batch?fields=query,city,country,lat,lon';

	var xhr = new XMLHttpRequest();

	xhr.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
	    // Result array
	    var ip_api_response = JSON.parse(this.responseText);

			//vazw ta lat lon tou user sto response
			var points= [];
			var helper = [];
			var counts = {};
			parameters = [];
			ip = [];
			for (let i=0, l=response.length; i<l; i++){

				if (helper.indexOf(response[i][0]+response[i][1]+response[i][2]) === -1 && (response[i][0]+response[i][1]+response[i][2]) !== ''){
            		helper.push(response[i][0]+response[i][1]+response[i][2]);
					for (let j = 0; j < ip_api_response.length; j++) {
						if (response[i][2] === ip_api_response[j].query) {
		            		points.push([[response[i][0], response[i][1]], [ip_api_response[j].lat, ip_api_response[j].lon]]);
		            		ip.push(response[i][2]);
						}
					}
            	}
            	counts[response[i][0]+response[i][1]+response[i][2]] = counts[response[i][0]+response[i][1]+response[i][2]] ? counts[response[i][0]+response[i][1]+response[i][2]] + 1 : 1;
			}
			//kanonikopoiei to paxos ths grammhs
			weight = Array.from(new Set(Object.values(counts)));
			weight.sort(function(a, b){return a - b});
			max = 5.0;
			min = 0.1;
			step = (max-min)/weight.length;
			normalized = [];
			for (var i = weight.length - 1; i >= 0; i--) {
				normalized[i] = max - i*step;
			}

			for (let i = 0; i < points.length; i++) {
				for (var j = 0; j < unique_users.length; j++) {
					if (ip[i] === ip_api_response[j].query) {

						for (var k = 0; k < normalized.length; k++) {
							if (Object.values(counts)[i] === weight[k]) {
								parameters[i] = ["#"+user_colour[ip_api_response[j].query], normalized[k]];
							}
						}
					}
				}
			}


			if(mapid != null){ //an uparxei hdh xarths ton svhnei
				mapid._leaflet_id = null;
			}
			myMap(points, parameters);

		} // end XMLHttpRequest
     	
	};
	var data = JSON.stringify(unique_users);

	xhr.open('POST', endpoint, true);
	xhr.send(data);
}).catch(error => console.log(error));



function myMap(points, parameters){
	let mymap = L.map("mapid");
	let osmUrl = "https://tile.openstreetmap.org/{z}/{x}/{y}.png";
	let osmAttrib =
	'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors';
	let osm = L.tileLayer(osmUrl, { attribution: osmAttrib });
	mymap.addLayer(osm);
	mymap.setView([0, 0], 2);


  polygon = [];
  marker = [];
  for (var i = 0; i < parameters.length; i++) {
	polygon[i] = L.polygon(points[i], {
	color: parameters[i][0], 
	weight: parameters[i][1]}).addTo(mymap);


	marker[i] = L.marker(points[i][0]);
	marker[i].addTo(mymap);
	marker[i].bindPopup("<b>"+points[i][0][0]+", "+points[i][0][1]+"</b>");

	polygon[i].bindPopup("from: "+points[i][1][0]+", "+points[i][1][1]+", to: "+points[i][0][0]+", "+points[i][0][1]+", weight: "+parameters[i][1]) //emfanizetai otan patame th grammh
	let center = polygon[i].getBounds().getCenter();

  }
  mymap.setView(center, 17);
}