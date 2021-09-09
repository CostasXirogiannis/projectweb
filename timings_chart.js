function reply_click(clicked_id)
{

    document.getElementById("container").innerHTML = "";
    document.getElementById("container").value = chart_fun(clicked_id);

    document.getElementById("container_log").innerHTML = "";
}

function method_click()
      {
            var methods = document.forms[0];
            var txt = "method,";
            //var i;
            for (let i = 0; i < methods.length; i++) {
              if (methods[i].checked) {
                txt = txt + methods[i].value + ",";
              }
            }
            document.getElementById("container").innerHTML = "";
            document.getElementById("container").value = chart_fun(txt);

          document.getElementById("container_log").innerHTML = "";
      }

function provider_click(clicked_id)
      {
          document.getElementById("container").innerHTML = "";
          document.getElementById("container").value = chart_fun(clicked_id);

          document.getElementById("container_log").innerHTML = "";
      }

function content_type_click()
      {
          var content_type = document.forms[1]; //forms[1] gia na paei sth 2h forma pou uparxei sto document
            var txt = "content_type,";
            //var i;
            for (let i = 0; i < content_type.length; i++) {
              if (content_type[i].checked) {
                txt = txt + content_type[i].value + ",";
              }
            }
            document.getElementById("container").innerHTML = "";
          document.getElementById("container").value = chart_fun(txt);

          document.getElementById("container_log").innerHTML = "";
      }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
function myFunction(myDropdown) {
  //document.getElementById("myDropdown").classList.toggle("show");
  myDropdown.classList.toggle("show");
}
/*
// Close the dropdown if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}*/


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function chart_fun(clicked_id) {
array = 0;
  if (!(clicked_id <8)) { //an den einai noumero  //mpainei kai gia provider
    array = clicked_id.slice(0, -1).split(","); //dioxnw to teleutaio "," kai to kanw array me bash to ","
  }

  data_array = "";
  log_data_array = "";
  timing = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
  count = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

      //fetch
      fetch('timings_chart_fetch.php').then((res) => res.json())
        .then(response =>{
            response.splice(-1,1); //epistrefei thn teleutaia grammh null

            for (let i = 0; i <= response.length - 1; i++) {
              time = response[i].startedDateTime.substring(11, response[i].startedDateTime.length - 11); //krataei mono thn wra (xwris lepta) 11 11

              //time = response[i].startedDateTime.substring(18, response[i].startedDateTime.length - 5); //deuterolepta
              date = response[i].startedDateTime.substring(0, response[i].startedDateTime.length - 14); //hmeromhnia
              new_date = new Date(date);

              if (parseInt(new_date.getDay()) === parseInt(clicked_id) || parseInt(clicked_id) === 7 || clicked_id === response[i].provider) { //parametropoihsh me vash thn mera h ton provider
                for (let j = 0; j <= 23; j++) {     //prosthetei ta timings se omades kathe wras                
                  if (parseInt(time) === j) {
                    timing[j] = timing[j] + parseFloat(response[i].timings);
                    count[j]++;
                  }
                }
              }else if (array[0] === "method"){ //////////////////////otan exw method//////////////////////
                for (let m = 1; m < array.length; m++) { //to prwto stoixeio exei "method" ara den xreiazetai na to exetasw
                  if (array[m] === response[i].method) {
                    for (let j = 0; j <= 23; j++) {     //prosthetei ta timings se omades kathe wras                
                      if (parseInt(time) === j) {
                        timing[j] = timing[j] + parseFloat(response[i].timings);
                        count[j]++;
                      }
                    }
                  }
                }
              }else if (array[0] === "content_type"){ //////////////////////otan exw content_type//////////////////////
                for (let m = 1; m < array.length; m++) { //to prwto stoixeio exei "content_type" ara den xreiazetai na to exetasw
                  //console.log(array[i] + "  " + response[i].value);
                  if (array[m] === response[i].value) {
                    for (let j = 0; j <= 23; j++) {     //prosthetei ta timings se omades kathe wras                
                      if (parseInt(time) === j) {
                        timing[j] = timing[j] + parseFloat(response[i].timings);
                        count[j]++;
                      }
                    }
                  }
                }
              }
            } 

              for (let j = 0; j <= 23; j++) {
                if (count[j]) {
                  data_array = data_array + "\"" + j + "\", " + timing[j]/count[j] + ",\n";
                  log_data_array = log_data_array + "\"" + j + "\", " + Math.log(timing[j]/count[j]) + ",\n";
                } else {
                  data_array = data_array + "\"" + j + "\", " + 0 + ",\n";
                  log_data_array = log_data_array + "\"" + j + "\", " + 0 + ",\n";
                }
              }

            data_array = data_array.substring(0, data_array.length - 2);
            log_data_array = log_data_array.substring(0, log_data_array.length - 2);


//////////////////////////////////////////////////chart//////////////////////////////////////////////////
      //logarithmikos mesos xronos
      anychart.onDocumentReady(function () {
        // create column chart_log
        var chart_log = anychart.column();

        // turn on chart_log animation
        chart_log.animation(true);
       
        // set chart_log title text settings
        chart_log.title('Λογαριθμικός μέσος χρόνος απόκρισης αιτήσεων ανά ώρα.');
        
        //background color
        chart_log.background().fill("#fcf0f0");

        // create area series with passed data
        var series = chart_log.column(log_data_array);

        // set series tooltip settings
        series.tooltip().titleFormat('{%X}');

        series
          .tooltip()
          .position('center-top')
          .anchor('center-bottom')
          .offsetX(0)
          .offsetY(5)
          .format('{%Value}{groupsSeparator: }');

        // set scale minimum
        chart_log.yScale().minimum(0);

        // set yAxis labels formatter
        //chart_log.yAxis().labels().format('{%Value}{groupsSeparator: }');
        chart_log.yAxis().labels().format(function() {
          return this.value
        });

        // tooltips position and interactivity settings
        chart_log.tooltip().positionMode('point');
        chart_log.interactivity().hoverMode('by-x');

        // axes titles
        chart_log.xAxis().title('Time');
        chart_log.yAxis().title('Timings');

        // set container id for the chart_log
        chart_log.container('container_log');

        // initiate chart_log drawing
        chart_log.draw();
      });
///////////////////////////////////////////////////////////////////////
      //mesos xronos chart
      anychart.onDocumentReady(function () {
        // create column chart
        var chart = anychart.column();

        // turn on chart animation
        chart.animation(true);
       
        // set chart title text settings
        chart.title('Μέσος χρόνος απόκρισης αιτήσεων ανά ώρα.');
        
        //background color
        chart.background().fill("#fcf0f0");

        // create area series with passed data
        var series = chart.column(data_array);

        // set series tooltip settings
        series.tooltip().titleFormat('{%X}');

        series
          .tooltip()
          .position('center-top')
          .anchor('center-bottom')
          .offsetX(0)
          .offsetY(5)
          .format('{%Value}{groupsSeparator: }');

        // set scale minimum
        chart.yScale().minimum(0);

        // set yAxis labels formatter
        //chart.yAxis().labels().format('{%Value}{groupsSeparator: }');
        chart.yAxis().labels().format(function() {
          return this.value
        });

        // tooltips position and interactivity settings
        chart.tooltip().positionMode('point');
        chart.interactivity().hoverMode('by-x');

        // axes titles
        chart.xAxis().title('Time');
        chart.yAxis().title('Timings');

        // set container id for the chart
        chart.container('container');

        // initiate chart drawing
        chart.draw();
      });

      }).catch(error => console.log(error)); //end of fetch
}