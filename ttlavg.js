/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
function myFunction(myDropdown) {
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
  var content_type = document.forms[0]; //forms[0] gia na paei sth 1h forma pou uparxei sto document
    var txt = "";
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

function my_function(argument, isp) { //kanei select sth vash tis grammes pou exoun to isp
	var str_post = "isp="+isp;

	//fetch
	fetch('ttl_fetch.php', {
		method: 'POST',
		headers: {
	    'Content-Type': 'application/x-www-form-urlencoded',
	  },
	  body: str_post,

	}).then((res) => res.json())
	.then(response =>{
	    response.splice(-1,1); //svhnw to null apo thn teleutaia grammh

		entries = 0;

		ttl_array=[];
		ttl_array.push([]);
		var unique_content_type_flags = [];
		avgTTL=[];
		filtered_avgTTL=[];

		//order by name einai me seira  cache-control content-type expires last-modified an uparxoun
		for (let i = 0; i < response.length - 1; i++) {

	    	if (response[i].name === "content-type") {
	    		ttl_array[entries].unshift(response[i].value);  //to prosthetei sthn arxh tou array
	    		content_type_var = response[i].value;    		
	    	} 
	    	else if (response[i].name === "cache-control") {
	    		if (response[i].value.includes("max-age")) { //an uparxei max-age
	    			str = response[i].value;
					var patt = /max-age=[0-9]+/i;
					var result = str.match(patt);
					ttl_array[entries].push(String(result)); 
	    		}
	    	}
	    	else if (response[i].name === "expires"  ) { //an uparxei expires KAI den uparxei max age
	    		if (ttl_array[entries].length !== 0) { //an den exei tipota na mhn sunexisei
		    		if ( !(ttl_array[entries][ttl_array[entries].length - 1].includes("max-age")) ) {
			    		date_gmt = new Date(response[i].value);
			    		date_timestamp = date_gmt.getTime()/1000;
			    		ttl_array[entries].push("expires="+date_timestamp);
		    		}
		    	}
	    	} 
	    	else if (response[i].name === "last-modified" ) {
	    		if (ttl_array[entries].length !== 0) { //an den exei tipota na mhn sunexisei
		    		if (ttl_array[entries][ttl_array[entries].length - 1].includes("expires")) {
			    		date_gmt = new Date(response[i].value);
			    		date_timestamp = date_gmt.getTime()/1000;
			    		expires = ttl_array[entries][ttl_array[entries].length - 1];
			    		var patt = /[0-9]+/i;
						var result = str.match(patt);
			    		ttl_array[entries].pop();
			    		ttl = date_timestamp - result;
			    		ttl_array[entries].push("max-age="+ttl);
		    		}
		    	}
	    	}

	    	//an einai to teleutaio pedio tou entries
		    if (response[i].entries_id!==response[i+1].entries_id) { 

				if (ttl_array[entries].length === 0){
					//console.log("ERROR "+response[i].entries_id);
				}else{

			    	if (ttl_array[entries][ttl_array[entries].length - 1].includes("expires")) { //den uparxei last-modified enw uparxei expires
						ttl_array[entries].pop();
						ttl_array[entries].push("no_ttl");
			    	}
					if (ttl_array[entries][ttl_array[entries].length - 1].includes("no_ttl")){ //an den uparxei ttl to afairw apo to array		    		
			    		ttl_array.pop();
			    		entries--;
			    	}
			    	if (ttl_array[entries][ttl_array[entries].length - 1].includes("max-age")) { //metatrepei to pedio ttl se int
			    		var patt = /[0-9]+/i;
						var result = str.match(patt);
						ttl_int = parseInt(result[0]);
						ttl_array[entries].pop();
						ttl_array[entries].push(result[0]);
			    	}
			    	if (ttl_array[entries].length === 1) { //otan ena entrie exei mono 1 pedio kai tipota allo
			    		ttl_array.pop();
			    		entries--;
			    	}
			    	//briskw ta uniques
			    	if (!unique_content_type_flags[content_type_var]){
					    unique_content_type_flags[content_type_var] = true;
					    avgTTL.push([content_type_var,0]);
					}

			    	entries++; // metrhths gia na allaksw omada entries
			    	ttl_array.push([]);	

				}	    	
		    }
		}

	ttl_array.pop();

    var maxArray=[];
	//briskw average.
	for(var j=0; j<avgTTL.length;j++){

		if (argument.includes(avgTTL[j][0]) || argument === "all_content_types") { //an to content-type einai sta epilegmena
			var count=0;
			var value=0;
			var avg=0;
            
			for(var i=0;i<ttl_array.length-1;i++){

		    	if(avgTTL[j][0]===ttl_array[i][0]){
		        	count++;
		            value=value+ parseInt(ttl_array[i][1],10);
	
		        }
		    }
		    if(count!==0){
		     	avg=value/count; 
		     	if(!Number.isNaN(avg)){
			     	filtered_avgTTL.push([avgTTL[j][0],avg]);			     
			     	maxArray.push(avg);
			     }
		    }
		}
	}

	max = parseFloat(maxArray[0]);
	for (var i = 0; i < maxArray.length; i++) {
		if (max < parseFloat(maxArray[i])) {
			max = maxArray[i];
		}
	}

   var step = ( max / 10 );
    
    filtered_avgTTL.unshift(["Content Type","TTL"]);
    
    
	
	google.charts.load("current", {packages:["corechart"]});
	google.charts.setOnLoadCallback(function () {
	     drawChart(filtered_avgTTL,step);
	   });


	}).catch(error => console.log(error));
}




function drawChart(avgTTL,step) {

	var data = google.visualization.arrayToDataTable(avgTTL);

	var options = {
	    
	  backgroundColor:'#f1dcdc',
	  title: 'Average TTL ιστοαντικειμένων ανά CONTENT-TYPE',
	  legend: { position: 'none' },
      histogram:{minNumBuckets: 10, maxNumBuckets:10,}
	};

	var chart = new google.visualization.Histogram(document.getElementById('chart_div'));
	chart.draw(data, options);
}
