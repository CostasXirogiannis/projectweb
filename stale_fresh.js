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


/**********************************************************************************************/

function content_type_click()
{
  var content_type = document.forms[0]; //forms[1] gia na paei sth 1h forma pou uparxei sto document
    var txt = "";
    //var i;
    for (let i = 0; i < content_type.length; i++) {
      if (content_type[i].checked) {
        txt = txt + content_type[i].value + ",";
      }
    }
    last_selected_content_type(txt); //apothukeuei ta content_type
    last_isp = last_selected_isp(false); //vlepei to teleutaio isp
  	my_function(txt, last_isp);
}


function provider_click(clicked_id)
	{
		last_selected_isp(clicked_id); //apothikeuei ton isp
		last_con_type = last_selected_content_type(false); //pernei ta teleutaia content_type pou exoume epileksei
		my_function(last_con_type, clicked_id);
	}


function last_selected_isp(isp) {
	if (!isp) { //an einai false mpainei edw, sumainei oti thn exw kalesei apo thn content_type_click
		if(typeof last_isp === "undefined") //an den exw epileksei isp vazw last_isp = "all_providers"
		{
		  last_isp = "all_providers";
		} 
		return last_isp;
	}else{ //thn exw kalesei apo thn provider_click kai apla thn krataw xwris return
		last_isp = isp;
	}
}

function last_selected_content_type(con_type) {
	if (!con_type) { //an einai false mpainei edw, sumainei oti thn exw kalesei apo thn provider_click
		if(typeof last_con_type === "undefined") //an den exw epileksei content_type vazw all_content_types
		{
		  last_con_type = "all_content_types";
		} 
		return last_con_type;
	}else{ //thn exw kalesei apo thn content_type_click kai apla thn krataw xwris return
		last_con_type = con_type;
	}
}


/**********************************************************************************************/


function my_function(argument, isp) {
	var str_post = "isp="+isp;

	fetch('stale_fresh_fetch.php', {
		method: 'POST',
		headers: {
	    'Content-Type': 'application/x-www-form-urlencoded',
	  },
	  body: str_post,

	}).then((res) => res.json())
	.then(response =>{
	    response.splice(-1,1); //svhnw to null apo thn teleutaia grammh

		dupl = new Array();
		con_type = new Array();
		j = 0;
		c = 0;

		for (let i = 0; i < response.length - 1; i++) {
		    if (response[i + 1].entries_id === response[i].entries_id) {
		    	if (response[i].name === "content-type") { //gia na xerw an to content-type einai 1o h 2o	
		    		dupl[j++] = {content_type: response[i].value, cache_control: response[i+1].value};
				    con_type[c++] = response[i].value; //ftiaxnw pinaka me ola ta values me name content-type
		    	} else {
		    		dupl[j++] = {content_type: response[i+1].value, cache_control: response[i].value};
				    con_type[c++] = response[i+1].value; //ftiaxnw pinaka me ola ta values me name content-type
		    	}
		    }else if (response[i].name === "cache-control" && i>=1 && response[i - 1].entries_id !== response[i].entries_id){ //an uparxei cashe control kai den uparxei content type
		    	dupl[j++] = {content_type: "undefind", cache_control: response[i].value};
				con_type[c++] = "undefind"; //ftiaxnw pinaka me ola ta values me name content-type
		    }else if (response[i].name === "cache-control" && i===0 && response[i + 1].entries_id !== response[i].entries_id){ //an uparxei cashe control kai den uparxei content type sthn prwth grammh
				con_type[c++] = "undefind"; //ftiaxnw pinaka me ola ta values me name content-type

		    }
		  }

		//briskei ta monadika content-type
		function onlyUnique(value, index, self) {
		  return self.indexOf(value) === index;
		}

		var unique = con_type.filter(onlyUnique); //den dexetai dupl.content_type den xerw gt, gi auto ftiaxnw to con_type


		count = new Array();
		sum = new Array();

		for (var j = 0; j < unique.length; j++) {
			count [j] = new Array(3).fill(0);
			sum [j] = new Array(2).fill(0);
			for (let i = 0; i < dupl.length; i++) {
				if (dupl[i].cache_control.includes("max-stale") && dupl[i].content_type === unique[j]) {
					var stale = dupl[i].cache_control.match(/max-stale=[0-9]+/i); //to stale einai array, sth thesh 0 exw auto pou thelw
					var val_st = stale[0].match(/[0-9]+/i);

					sum[j][0] = sum[j][0] + parseInt(val_st[0]);
					count[j][0]++;
				}
				if (dupl[i].cache_control.includes("min-fresh")&& dupl[i].content_type === unique[j]) {
					var fresh = dupl[i].cache_control.match(/min-fresh=[0-9]+/i); //to stale einai array, sth thesh 0 exw auto pou thelw
					var val_fr = fresh[0].match(/[0-9]+/i);
					sum[j][1] = sum[j][1] + parseInt(val_fr[0]);

					count[j][1]++;
				} 
				if (dupl[i].content_type === unique[j]) { //gia na metrisw to plhthos twn eggrafwn, mia eggrafh mporei na exei kai min-fresh kai max-stale
					count[j][2]++;
				}
			}
		}


		count_max_stale = 0;
		count_min_fresh = 0;
		sum_max_stale = 0;
		sum_min_fresh = 0;
		count_selected = 0;

		if (argument !== "all_content_types"){ //otan den einai h 1h fora emfanizei mono gia ta checked
			selected_con_type = argument.slice(0, -1).split(","); //dioxnw to teleutaio "," kai to kanw array me bash to ","

			for (let i = 0; i < unique.length; i++) {
				for (let j = 0; j < unique.length; j++) {
					if (unique[i] === selected_con_type[j]) {
						count_max_stale = count_max_stale + count[i][0];
						count_min_fresh = count_min_fresh + count[i][1];
						sum_max_stale = sum_max_stale + sum[i][0];
						sum_min_fresh = sum_min_fresh + sum[i][1];
						count_selected = count_selected + count[i][2];
					}
				}
			}

		}else{	//thn prwth fora pou ekteleitai ta emganizei ola
			for (let i = 0; i < unique.length; i++) {
				count_max_stale = count_max_stale + count[i][0];
				count_min_fresh = count_min_fresh + count[i][1];
				sum_max_stale = sum_max_stale + sum[i][0];
				sum_min_fresh = sum_min_fresh + sum[i][1];
				count_selected = count_selected + count[i][2];
			}
		}


		if (count_selected) { //an einai 0 vgainei NaN
		
			data = [
	          ['max-stale και min-fresh directives', 'count'],
	          ['max-stale, average:'+Math.round(sum_max_stale/count_max_stale*100)/100, count_max_stale],
	          ['min-fresh, average:'+Math.round(sum_min_fresh/count_min_fresh*100)/100, count_min_fresh],
	          ['-', count_selected-count_max_stale-count_min_fresh]
	        ];

			google.charts.load('current', {'packages':['corechart']});
	      	google.charts.setOnLoadCallback(function () {
		     	drawChart(data);
		   	});

	   	}else{
        	alert("Δεν υπάρχουν στοιχεία για προβολή.");
        }


	}).catch(error => console.log(error)); //end of fetch
}

function drawChart(data) {

        var data = google.visualization.arrayToDataTable(data);

        var options = {
            backgroundColor:'#f1dcdc',
          title: 'Ποσοστό max-stale και min-fresh directives επί του συνόλου των αιτήσεων ανά CONTENT-TYPE'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
