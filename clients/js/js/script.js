$(document).ready(function (e) {

	var base_url = "https://manifold.metamatic.us";

	var api_url = base_url + "/v1/render/";
    var seq = [];
    var curr_seq_index = -1;
    var anim_interval = null;
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
		    url: api_url,
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

    function get_next_seq_index() {
        if (curr_seq_index < 19) {
            curr_seq_index += 1;
        } else {
            curr_seq_index = 0;
        }
        return curr_seq_index;
    }

    function render_img(data64) {
        var dataURI = "data:image/jpeg;base64," + data64;
        $("#seq-frame").attr("src", dataURI);
    }

    function render_seq() {
        if (seq.length === 20) {
            seq = seq.sort(function (a, b) {
                if (a.name < b.name) return -1;
                if (a.name > b.name) return 1;
                return 0;
            });

            anim_interval = setInterval(function () {
                var index = get_next_seq_index();
                render_img(seq[index].data64);
            }, 500);
        }
    }


	function get_and_render_3D_sequence(path) {
        JSZipUtils.getBinaryContent(path, function (err, data) {
            if (err) {
                console.log(err);
            }
            JSZip.loadAsync(data).then(function (zip) {
                console.log(zip);
                zip.forEach(function (relativePath, file) {
                    file.async("base64").then(
                        function (data64) {
                            seq.push({name: file.name, data64: data64});
                            $("#loader_seq").hide();
                            render_seq();
                        }
                    );
                });
            });
        });
    }

	function get_result() {
		$.ajax({
		    url: api_url + "?task_id=" + $("#taskID").html(),
		    success: function(data){
			if(data == ""){
				if(poller_id == null){
					console.log("Polling result ...");
					poller_id = setInterval(get_result, 5000);
				}
			}else{	
				data['root_url'] = base_url;
				console.log(data);
				var source   = $("#entry-template").html();
				var template = Handlebars.compile(source);
				var html = template(data);
				get_and_render_3D_sequence(base_url + data.seq);
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

