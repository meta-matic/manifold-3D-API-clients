$(document).ready(function (e) {

	var base_url = "http://manifold.metamatic.us/v1/compute/";

	var poller_id = null;
	$("#loader_upload").hide();
	$("#loader_compute").hide();

	$("#uploadForm").on('submit',(function(e) {
		e.preventDefault();
		$("#taskID").html("");
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
			$("#taskID").html(data.task_id);
			$("#loader_compute").show();
			console.log("Geting result ...");
			console.log(data.task_id);
			get_result();
		    }
		});
	}));

	function get_result() {
		$.ajax({
		    url: base_url + "?task_id=" + $("#taskID").html(),
		    success: function(data){
			if(data == ""){
				if(poller_id == null){
					console.log("Polling result ...");
					poller_id = setInterval(get_result, 5000);
				}
			}else{	
				console.log(data);
				$("#result").html("Volume: " + Math.ceil(data.volume.value) + " " + data.volume.UOM);
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

