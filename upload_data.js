(function(){

  i=0;

    function onChange(event) {


        if (event.target.files[0].name.split('.').pop() !== "har"){
            alert("Sorry, only HAR files are allowed.");
            var x = document.getElementById("myDIV");
            x.style.display = "none";
            return 0;
      }

        var reader = new FileReader();
        reader.onload = onReaderLoad;
        reader.readAsText(event.target.files[0]);
    }

    function onReaderLoad(event){
        var data = event.target.result;
        var mydata = JSON.parse(data);
        var x = document.getElementById("myDIV");
        x.style.display = "block";

        processing(mydata);
    }
    
    function processing(dt){ //epexergasia eisodou, dinei exodo har me ta zhtoymena pedia
        output = '{\n\t"log": {' + '\n\t\t"entries": [';
        for (key_entries in dt.log.entries){
          output = output + '\n\t\t\t{';     
          output = output + '\n\t\t\t\t"startedDateTime": "'+ dt.log.entries[key_entries].startedDateTime +'",';
          
          //krataei mono to domain apo to url
          var myHostName = document.createElement('a');
          myHostName.href = dt.log.entries[key_entries].request.url;

          output = output + '\n\t\t\t\t"request": {\n\t\t\t\t\t"method": "'+ dt.log.entries[key_entries].request.method +'",\n\t\t\t\t\t"url": "' + myHostName.hostname + '"';
           
          flag = 0;

          for (key_request_headers in dt.log.entries[key_entries].request.headers){

            req_name = dt.log.entries[key_entries].request.headers[key_request_headers].name;
            if (req_name === "content-type" || req_name === "cache-control" ||req_name ===  "pragma" ||req_name ===  "expires" ||req_name ===  "age" ||req_name ===  "last-modified" ||req_name ===  "host"){

              if (flag === 0){
                output = output + ',\n\t\t\t\t\t"headers": [';
                flag++; 
            }          
                output = output + '\n\t\t\t\t\t\t{\n\t\t\t\t\t\t\t"name": "'+ dt.log.entries[key_entries].request.headers[key_request_headers].name + '",';

                var myJSONrequest = dt.log.entries[key_entries].request.headers[key_request_headers].value; //gia na mhn xanw special char apo request
                var myJSONStringrequest = JSON.stringify(myJSONrequest);

                  request_value = dt.log.entries[key_entries].request.headers[key_request_headers].value;

                var request_value = myJSONStringrequest.replace(/\\n/g, "\\n")
                                          .replace(/\\'/g, "\\'")
                                          .replace(/\\"/g, '\\"')
                                          .replace(/\\&/g, "\\&")
                                          .replace(/\\r/g, "\\r")
                                          .replace(/\\t/g, "\\t")
                                          .replace(/\\b/g, "\\b")
                                          .replace(/\\f/g, "\\f");

                output = output + '\n\t\t\t\t\t\t\t"value": '+ request_value + '\n\t\t\t\t\t\t},';
              }
            }
            if (flag === 1){
              flag++; 
                output = output.slice(0, -1);
                output = output + '\n\t\t\t\t\t]'; //telos headers      
        }

        output = output + '\n\t\t\t\t},'; //telos request//



          output = output + '\n\t\t\t\t"response": {\n\t\t\t\t\t"status": "'+ dt.log.entries[key_entries].response.status +'",\n\t\t\t\t\t"statusText": "' + dt.log.entries[key_entries].response.statusText + '"';

          flag_res = 0;

          for (key_response_headers in dt.log.entries[key_entries].response.headers){

            req_name = dt.log.entries[key_entries].response.headers[key_response_headers].name;
            if (req_name === "content-type" || req_name === "cache-control" ||req_name ===  "pragma" ||req_name ===  "expires" ||req_name ===  "age" ||req_name ===  "last-modified" ||req_name ===  "host"){

              if (flag_res === 0){
                output = output + ',\n\t\t\t\t\t"headers": [';
                flag_res++; 
            }          
                output = output + '\n\t\t\t\t\t\t{\n\t\t\t\t\t\t\t"name": "'+ dt.log.entries[key_entries].response.headers[key_response_headers].name + '",';

                var myJSONrequest = dt.log.entries[key_entries].response.headers[key_response_headers].value; //gia na mhn xanw special char apo response
                var myJSONStringrequest = JSON.stringify(myJSONrequest);

                  request_value = dt.log.entries[key_entries].response.headers[key_response_headers].value;

                var request_value = myJSONStringrequest.replace(/\\n/g, "\\n")
                                          .replace(/\\'/g, "\\'")
                                          .replace(/\\"/g, '\\"')
                                          .replace(/\\&/g, "\\&")
                                          .replace(/\\r/g, "\\r")
                                          .replace(/\\t/g, "\\t")
                                          .replace(/\\b/g, "\\b")
                                          .replace(/\\f/g, "\\f");

                output = output + '\n\t\t\t\t\t\t\t"value": '+ request_value + '\n\t\t\t\t\t\t},';
              }
            }
            if (flag_res === 1){
              flag_res++; 
                output = output.slice(0, -1);
                output = output + '\n\t\t\t\t\t]'; //telos headers
        }

        output = output + '\n\t\t\t\t},'; //telos response//

      
          output = output + '\n\t\t\t\t"timings": {\n\t\t\t\t\t"wait": "'+ dt.log.entries[key_entries].timings.wait +'"\n\t\t\t\t},';
          output = output + '\n\t\t\t\t"serverIPAddress": "'+ dt.log.entries[key_entries].serverIPAddress +'"';
          output = output + '\n\t\t\t}';
          if(key_entries !== Object.keys(dt.log.entries)[Object.keys(dt.log.entries).length-1]){
            output = output + ',';
          }
        }
        output = output + '\n\t\t]\n\t}\n}';
        download(); //enable download link
    }
    document.getElementById('file_selector').addEventListener('change', onChange);
}());



function download(){
var textFile = null,

  makeTextFile = function (text) {
    var data = new Blob([text], {type: 'text/plain'});

    if (textFile !== null) {
      window.URL.revokeObjectURL(textFile);
    }

    textFile = window.URL.createObjectURL(data);

    return textFile;
  };


    var link = document.getElementById('downloadlink');

    link.href = makeTextFile(output);

    link.style.display = 'block';
}



////////////////////////////////upload/////////////////////////////////////////////

// Upload file
function uploadFile() {

//gia ton paroxo tou client
fetch('http://edns.ip-api.com/json').then((res) => res.json())
.then(response =>{
    console.log(response);
    alert(response.dns.geo + "\n" + response.dns.ip);
    var geo = response.dns.geo;
    var ip = response.dns.ip;

      var str_json = "json_string="+output+"&"+"geo="+geo+"&"+"ip="+ip;

      const xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
                lat_lon(); //otan ginei upload twn dedomenwn
              }
            }

      xhr.open("POST", "upload_data.php", true);

      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.send(str_json);
      //svhnei to div
      var x = document.getElementById("myDIV");
      x.style.display = "none";

}).catch(error => console.log(error)); //end of fetch



}
