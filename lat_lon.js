lat_lon();

function lat_lon() {
    //fetch
    fetch('lat_lon_fetch.php').then((res) => res.json())
    .then(response =>{
        response.splice(-1,1); //svhnw to null apo thn teleutaia grammh

        var IPs = [].concat.apply([], response); //kanei to array of arrays aplo array


    if (IPs.length) { //an exw nea dedomena
        var myIPs = [];
        var i = 0;
        var j = 0;
        var k = 0;
        var num_of_ips_arrays = 0;
        var p = 0;
        var m = 0;
        trim_IPs = new Array();
        myIPs_count = new Array();

        for (var i = 0; i < IPs.length; i++) { //apaloifh agkulwn kai kenwn
          if (IPs[i]!=="") {
            myIPs[j] = IPs[i].replace("[", "").replace("]", "");
            j++;
          }
        }

        //aparithmish emfanisewn ips kai euresh max
        var count = {};
        myIPs.forEach(function(i) { count[i] = (count[i]||0) + 1;});
        max_count = Math.max.apply(Math, Object.values(count));

        myIPs_count = Object.keys(count);


        while (p < myIPs_count.length){ //kovw to my_IPs_count se kommatia me megethos k (100)
            if (k>=100) {
              k = 0;
              num_of_ips_arrays++;
              p--;
            }else{

              trim_IPs[m] = new Array();
              trim_IPs[num_of_ips_arrays][k] = myIPs_count[p];
              k++;
              m++;   
          }
          p++;
        }

        co_array = new Array();

        //klhsh ip api oses fores einai kai ta arrays twn 100
        for (let l = 0; l <= num_of_ips_arrays; l++) {
            var endpoint = 'http://ip-api.com/batch?fields=query,city,country,lat,lon';

            var xhr = new XMLHttpRequest();

          kt = 0;

            xhr.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
                // Result array
                var response = JSON.parse(this.responseText);

                for (let i = 0; i < response.length; i++) {
                    co_array[i] = new Array(4);

                    co_array[i][0] = response[i].lat;
                    co_array[i][1] = response[i].lon;
                    co_array[i][2] = trim_IPs[l][i];
                    co_array[i][3] = Object.values(count)[kt++];
                }

                var str = "coordinates_array="+co_array;

                const xmlhr = new XMLHttpRequest();

                xmlhr.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        myHeatmap(); //otan ginei update twn dedomenwn
                    }
                }


                xmlhr.open("POST", "lat_lon_upload.php", true);

                xmlhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xmlhr.send(str);

              }

        };
            var data = JSON.stringify(trim_IPs[l]);

            xhr.open('POST', endpoint, true);
            xhr.send(data);
        }


}else{ //den exw nea dedomena
    myHeatmap();
}

    }).catch(error => console.log(error)); //end of fetch

}