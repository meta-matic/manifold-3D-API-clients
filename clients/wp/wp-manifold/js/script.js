$(document).ready(function (e) {

	var base_url = "http://manifold.metamatic.us/v1/compute/";
	var task_id = null;
	var poller_id = null;
	$("#loader_upload").hide();
	$("#loader_compute").hide();

	$("#uploadForm").on('submit',(function(e) {
		e.preventDefault();
		$("#taskID").text("");
		$("#result").html("");
		console.log("Uploading ...");
		$("#loader_upload").show();
		$.ajax({
		    url: base_url,
		    type: "POST",
		    data:  new FormData(this),
		    contentType: false,
		    cache: false,
		    processData:false,
		    success: function(data){
				$("#loader_upload").hide();
				$("#taskID").attr("href",
				 "http://manifold.metamatic.us/v1/compute/?task_id="+data.task_id);
				task_id = data.task_id;
				$("#taskID").text("Permalink");
				$("#loader_compute").show();
				console.log("Geting result ...");
				console.log(data.task_id);
				get_result();
		    }
		});
	}));

	function get_result() {
		$.ajax({
		    url: base_url + "?task_id=" + task_id,
		    success: function(data){
			if(data == ""){
				if(poller_id == null){
					console.log("Polling result ...");
					poller_id = setInterval(get_result, 5000);
				}
			}else{	
				data['root_url'] = 'http://manifold.metamatic.us/';
				console.log(data);
				var source   = $("#entry-template").html();
				var template = Handlebars.compile(source);

				// Round to 1 decimal place
				data.volume.value = Math.round( data.volume.value * 10 ) / 10;
				data.bbox.value.length = Math.round( data.bbox.value.length * 10 ) / 10;
				data.bbox.value.width = Math.round( data.bbox.value.width * 10 ) / 10;
				data.bbox.value.height = Math.round( data.bbox.value.height * 10 ) / 10;
				data.time.value.max = Math.round( data.time.value.max * 10 ) / 10;
				data.time.value.min = Math.round( data.time.value.min * 10 ) / 10;

				var html = template(data);
				$("#entry-rendered").html(html);
				$("#loader_compute").hide();
				console.log("OK");
				if(poller_id != null){
					clearInterval(poller_id);
					poller_id = null;
					console.log("Relieved the poller."); 
				}
			}
		    }
		});
	}
});

