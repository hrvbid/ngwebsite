
	$(function() {
		if ($('#ncfdq').is('#ncfdq')) {
				if (typeof(tao.vpool.ngcom.ncffi)=='undefined') {
					// ano (ie epc)
					var ano = true;
				} else {
					// use fc
					var ano = false;
				}
				if (ano) {
					var goto = tao.vshr.httpurl.dat + 'ngcom/xaop/taoanu';
				} else {
					var goto = './ngcom/xaop/taopi/authkey/' + tao.vshr.authkey.dat;
				}
				
				$(tao.lod.loadnow('plupload')).load(function() 
				{
					var uploader = new plupload.Uploader({
						runtimes : 'html5,flash',
						browse_button : 'ncfaqs',
						container: 'ncfdq',
						max_file_size : '10mb',
						url : goto,
						flash_swf_url : './javascript/ng_com/axup/plupload.flash.swf',
						filters : [
							{title : "Image files", extensions : "jpg,gif,png"}
						]
					});

					uploader.bind('Init', function(up, params) {
						// only for developers to debug - thus hidden
						$('#ncfdq').html('<div style="display:none;">Current runtime: ' + params.runtime + '</div>');
					});
				
					$('#ncfaqu').click(function(e) {
						uploader.start();
						e.preventDefault();
					});

					uploader.init();
				
					uploader.bind('FilesAdded', function(up, files) {
						$.each(files, function(i, file) {
							$('#ncfdq').append(
							'<div id="' + file.id + '"><tt>' +
							file.name + ' (' + plupload.formatSize(file.size) + ') <b></b>' +
							'</tt></div>');
						});

						up.refresh(); // Reposition Flash/Silverlight
					});

					uploader.bind('UploadProgress', function(up, file) {
						$('#' + file.id + " b").html( tao.vshr.ngaximg + ' ' + file.percent + "%");
					});
				
					uploader.bind('Error', function(up, err) {
						$('#ncfdq').append('<div><tt>' + (err.file ? err.file.name : ' ') + ' Error ' + err.code +
						', ' + err.message + ' ' + tao.vshr.ngkoimg +
						'</tt></div>'
						);

						up.refresh(); // Reposition Flash/Silverlight
					});

				
					uploader.bind('FileUploaded', function(up, file) {
						$('#' + file.id + " b").html('100% ' + tao.vshr.ngokimg);
						console.log(file.name);
						if (ano) {
							tao.run.epc.rearInImg('<img src="files/filecabinet/incoming/' + file.name + '" />');
						//} else {
							//$('img src...').attr('src',reply +"?timestamp=" + new Date().getTime());
							//$('#ncfatna').trigger('click')
							//tao.run.ngcom.ngFcTnReAll();
						}
					});
				}); 
		}
	});
