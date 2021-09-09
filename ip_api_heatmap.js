function myHeatmap() {

    fetch('ip_api_heatmap_fetch.php').then((res) => res.json())
    .then(response =>{
    response.splice(-1,1); //svhnw to null apo thn teleutaia grammh

      var arr = [];
      var len = response.length;
      for (var i = 0; i < len; i++) {
          arr.push({
              lat: response[i][0],
              lng: response[i][1],
              count: response[i][2]
          });
      }


    if(mapid != null){ //an uparxei hdh xarths ton svhnei
    mapid._leaflet_id = null;
    }
    myMap.apply(null, arr);


    }).catch(error => console.log(error)); //end of fetch




    function myMap(){ //sunarthsh gia emfanish tou xarth kai tou heatmap

        let mymap = L.map("mapid");
        let osmUrl = "https://tile.openstreetmap.org/{z}/{x}/{y}.png";
        let osmAttrib =
        'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors';
        let osm = new L.TileLayer(osmUrl, { attribution: osmAttrib });
        mymap.addLayer(osm);
        mymap.setView([40, 0],1.5);


        let testData = {
        data: arguments
        };

        let cfg = {
        // radius should be small ONLY if scaleRadius is true (or small radius is intended)
        // if scaleRadius is false it will be the constant radius used in pixels
        "radius": 40,
        "maxOpacity": 0.8,
        // scales the radius based on map zoom
        "scaleRadius": false,
        // if set to false the heatmap uses the global maximum for colorization
        // if activated: uses the data maximum within the current map boundaries
        //   (there will always be a red spot with useLocalExtremas true)
        "useLocalExtrema": true,
        // which field name in your data represents the latitude - default "lat"
        latField: 'lat',
        // which field name in your data represents the longitude - default "lng"
        lngField: 'lng',
        // which field name in your data represents the data value - default "value"
        valueField: 'count'
        };

        let heatmapLayer =  new HeatmapOverlay(cfg);

        mymap.addLayer(heatmapLayer);
        heatmapLayer.setData(testData);
    }

}