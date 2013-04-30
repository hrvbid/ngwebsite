	// author Hilmar Runge
	// (c) 2012 ... 2013
	// 3.1.3
	
		;(function($) {
		// tao
		// top array object(s)
		window.tao = {};
		tao.vpool = new Array();
			// ["module"] ["instance"] =
			// 	{
			//		"var" : 'value'
			// 	}
		
		// variables shared for common use
		tao.vshr = {};
		tao.vshr.debug =	false;
		
		tao.vshr.$vpat = /^[a-z][a-z0-9]*$/;
		tao.vshr.ngaximgsrc =	'mod/ngcom/img/ajax10red.gif';
		tao.vshr.ngaximg = 		'<img src="' + './' + tao.vshr.ngaximgsrc + '" alt="..." />';
		tao.vshr.ngokimgsrc = 	'mod/ngcom/img/ok.10.gif';
		tao.vshr.ngokimg = 		'<img src="' + './' + tao.vshr.ngokimgsrc + '" alt="..." />';
		tao.vshr.ngkoimgsrc = 	'mod/ngcom/img/ko.10.gif';
		tao.vshr.ngkoimg = 		'<img src="' + './' + tao.vshr.ngkoimgsrc + '" alt="..." />';
		// predefinitions (with empty data and verification pattern) - required to be acceptable
		// phpws authkey - not suggested to use with vshr 
		tao.vshr.authkey = 		{};
		tao.vshr.authkey.dat = 	'';
		tao.vshr.authkey.pat =	/^[a-f0-9]*$/;
		// phpws_source_http
		tao.vshr.httpsrc = 		{};
		tao.vshr.httpsrc.dat = 	'';
		tao.vshr.httpsrc.pat = 	/^(http\:\/\/)([a-z0-9\.\=\/\?\&])*$/;
		// phpws_home_http
		tao.vshr.httpurl = 		{};
		tao.vshr.httpurl.dat = 	'';
		tao.vshr.httpurl.pat = 	/^(http\:\/\/)([a-z0-9\.\=\/\?\&])*$/;
		//
		tao.vshr.proxy = '';
		// geoip
		tao.vshr.geoip = {};
		tao.vshr.geoip.lat = '';
		tao.vshr.geoip.lng = '';
		tao.vshr.geoip.pat = /^[0-9]*\.[0-9]*$/;

		// fx templates	
		tao.vshr.fxtpl = {};
		tao.vshr.fxcsx = {};
		tao.vshr.fxtpl.hcGrow = {};			
		tao.vshr.fxtpl.hcGrow.perspective = '';
		tao.vshr.fxtpl.hcGrow.webkitPerspective = '';
		
		tao.vshr.fxtpl.hcgrow = {};			
		tao.vshr.fxtpl.hcgrow.animationName = 'ani';
		tao.vshr.fxtpl.hcgrow.webkitAnimationName = 'ani';
		tao.vshr.fxtpl.hcgrow.animationDuration = '10s';
		tao.vshr.fxtpl.hcgrow.webkitAnimationDuration = '10s';
		tao.vshr.fxtpl.hcgrow.animationDirection = 'forwards';
		tao.vshr.fxtpl.hcgrow.webkitAnimationDirection = 'forwards';
		tao.vshr.fxtpl.hcgrow.animationTimingFunction = 'ease';
		tao.vshr.fxtpl.hcgrow.webkitAnimationTimingFunction = 'ease';
		tao.vshr.fxtpl.hcgrow.animationIterationCount = 'infinite';
		tao.vshr.fxtpl.hcgrow.webkitAnimationIterationCount = 'infinite';
		tao.vshr.fxtpl.hcgrow.animationFillMode = 'forwards';
		tao.vshr.fxtpl.hcgrow.webkitAnimationFillMode = 'forwards';
		tao.vshr.fxtpl.hcgrow.transformOrigin = '';
		tao.vshr.fxtpl.hcgrow.webkitTransformOrigin = '';
		tao.vshr.fxtpl.hcgrow.transformStyle = '';
		tao.vshr.fxtpl.hcgrow.webkitTransformStyle = '';
		
		tao.vshr.fxcsx.hcgrowfade = '@keyframes ani {' +
					'	0%   { opacity: 0; transform: rotateY(90deg); }' +
					'	100% { opacity: 1; transform: rotateY( 0deg); }' +
					'} @-webkit-keyframes ani {' +
					'	0%   { opacity: 0; -webkit-transform: rotateY(90deg); }' +
					'	100% { opacity: 1; -webkit-transform: rotateY( 0deg); }' +
					'}';
		tao.vshr.fxcsx.hcgrowsolid = '@keyframes ani {' +
					'	0%   { opacity: 0; transform: rotateY(90deg); }' +
					'	1%   { opacity: 1; transform: rotateY(90deg); }' +
					'	100% { opacity: 1; transform: rotateY( 0deg); }' +
					'} @-webkit-keyframes ani {' +
					'	0%   { opacity: 0; -webkit-transform: rotateY(90deg); }' +
					'	1%   { opacity: 1; -webkit-transform: rotateY(90deg); }' +
					'	100% { opacity: 1; -webkit-transform: rotateY( 0deg); }' +
					'}';
		tao.vshr.fxcsx.hcgrowrot = '@keyframes ani {' +
					'	0%   { opacity: 0; transform: rotate(40deg); }' +
					'	100% { opacity: 1; transform: rotate( 0deg); }' +
					'} @-webkit-keyframes ani {' +
					'	0%   { opacity: 0; -webkit-transform: rotate(40deg); }' +
					'	100% { opacity: 1; -webkit-transform: rotate( 0deg); }' +
					'}';
		tao.vshr.fxcsx.hcgrowper = '@keyframes ani {' +
					'	0%   { opacity: 0; transform: rotateY(120deg); }' +
					'	100% { opacity: 1; transform: rotateY( 0deg); }' +
					'} @-webkit-keyframes ani {' +
					'	0%   { opacity: 0; -webkit-transform: rotateY(120deg); }' +
					'	100% { opacity: 1; -webkit-transform: rotateY( 0deg); }' +
					'}';

		// served dynamic load requests (Load On Demand)
		tao.lod = {};
		tao.lod.hi = {};
		tao.lod.hi.url = 'javascript/ng_com/hi.js';
		tao.lod.hi.css = false;
		
		tao.lod.fixedheadertable = {};
		tao.lod.fixedheadertable.url = 'javascript/ng_com/fixedheadertable/jquery.fixedheadertable.js';
		tao.lod.fixedheadertable.css = 'javascript/ng_com/fixedheadertable/fixed.table.defaultTheme.css';
		
		tao.lod.fastconfirm = {};
		tao.lod.fastconfirm.url = 'javascript/ng_com/fastconfirm/jquery.fastconfirm.js';
		tao.lod.fastconfirm.css = 'javascript/ng_com/fastconfirm/jquery.fastconfirm.css';
		
		tao.lod.jqcookie= {};
		tao.lod.jqcookie.url = 'javascript/ng_com/jquery.cookie.js';
		tao.lod.jqcookie.css = false;
		
		tao.lod.plupload = {};
		tao.lod.plupload.url = 'javascript/ng_com/axup/plupload.full.js';
		tao.lod.plupload.css = false;
		
		tao.lod.superfish = {};
		tao.lod.superfish.url = 'javascript/ng_com/superfish/superfish.js';
		tao.lod.superfish.css = 'javascript/ng_com/superfish/css/superfish.css';
		
		tao.lod.tabby = {};
		tao.lod.tabby.url = 'javascript/ng_com/tabby/jquery.tabby.textarea.js_0.js';
		tao.lod.tabby.css = false;
		// ...
		tao.lod.loadnow = (function(me) 
		{
			if (tao.lod[me]) {
				// note, atm css is only lod when associated with js
				if ($(tao.lod[me].rt).is(tao.lod[me].rt)) {
					if (tao.vshr.debug) {
						console.log('lod ' + me + ' is');
					}
					return tao.lod[me].rt;
				} else {
					if (tao.vshr.debug) {
						console.log('lod ' + me + ' js');
					}
					$.ajaxSetup({cache:true});
					var body = document.getElementsByTagName('body')[0];
					var script = document.createElement('script');
							script.type= 'text/javascript';
							script.src= tao.vshr.httpsrc.dat + tao.lod[me].url;
							script.id='jsod' + me;
					// whyever 
					//	$('body').append(script);
					//	cannot be used, thus:
					body.appendChild(script);
					tao.lod[me].rt = '#' + script.id;
					
					// atm works only together with lod js by design
					if (tao.lod[me].css) {
						if (tao.vshr.debug) {
							console.log('lod ' + me + ' css');
						}
						var css = document.createElement('link');
								css.type= 'text/css';
								css.rel = 'stylesheet';
								css.href = tao.vshr.httpsrc.dat + tao.lod[me].css;
								css.id='csod' + me;
						$('head meta:last').after(css);
					}
					return tao.lod[me].rt;
				}
			}
			console.log('lod ' + me + ' unsupported')
			return false;
		});

		// document ready state
		// --------------------------
		$(document).ready(function(){
		
			// enforce html5 var stmnts class if css does (yet) not apply
			// $('.hidden').css( {	display: 'none'	} );

			tao.vshr.thisurl = location.href;
			
			// run thru all (var) data
			tao.run.vset();
			$.each(tao.run, function(k,v) {
				// core or mod fun
				if (!v.length) {
					// mod fun, mod present / installed ?
					if (tao.vpool[k]) {
						if (tao.run[k].onReady) {
							// apply the modules ready handler
							tao.run[k].onReady(k);
						}
					}
				}
			});
			
			// vmsgs
			$('.vmsg').each(function(n,htm) {
				if ($('#'+htm.id).attr('data-use')=='vmsg') {
					var mid = $('#'+htm.id).attr('data-mod');
					// is mid initialized installed
					if (typeof(tao.vpool[mid])=='object') {
						var jso = jQuery.parseJSON($('#'+htm.id).text());
						tao.vpool[mid]['$vmsg']={};
						$.each(jso, function(k,v) {
							tao.vpool[mid]['$vmsg'][k]=v;
						});
					}
				}
			});
			
			// geoip
		// 	tao.run.geoip();
			// ng i18n stuff
			tao.run.ngLocale();
		
			//
			if ($('.nclngtable').is('.nclngtable')) {
				$(tao.lod.loadnow('fixedheadertable')).load(function() 
				{
					// used by ngcom fc folderlist
					$('.nclngtable').fixedHeaderTable({ height: 380 });
				});
			}
			
			// test
			$(tao.lod.loadnow('hi')).load(function(){hallo()});
			// test _/
												
		});
		//	-------------------------------------------------------------------
		
		//	core related functions
		//	----------------------
		tao.run = {
			// vpool api
			// api method to set all var data to vpool or vshr from dom nodes
			vset : function(one) {
					if (arguments.length == 1) {
						var nclvset = $(one).toArray();
					} else {
						var nclvset = $('.vset').toArray();
					}
					for (var ix in nclvset) {
						var iid = $(nclvset[ix]).attr('data-iid');
						var mod = $(nclvset[ix]).attr('data-mod');
						mod = (typeof(mod)==='undefined')?'':mod;
						var use = $(nclvset[ix]).attr('data-use');
						use = (typeof(use)==='undefined')?'':use;
						
						var ncldata = $(nclvset[ix]).prop('attributes');
						var ar=new Array();
						for (var iy in ncldata) {
							if (iy < ncldata.length) {
								if (ncldata[iy].name.substr(0,5)=='data-') {
									ar[ncldata[iy].name.replace('data-','')]=ncldata[iy].value;
								}
							}
						}
						if (!tao.vshr.debug) {	
							var htmnode = '#' + $(ncldata.id)[0].nodeValue;
							// suggested: var htmnode = '#' + $(ncldata.id)[0].value;
							// console.log($(htmnode)[0].outerHTML);
							// after remove each var node the html is xhtml conform (although tidy will complain var data-)
							$('var').remove(htmnode);
						}
						ar['$jso']=$(nclvset[ix]).text();
						if (use==='vshr') {
							var jso = jQuery.parseJSON(ar.$jso);
							if (jso) {
								$.each(jso, function(k,v) {
									// take only if predefined
									if (!(typeof(tao.vshr[k]['dat'])==='undefined')) {
										// verify
										if (tao.vshr[k]['pat'].test(v)) {
											tao.vshr[k]['dat']=v;
										}
									}
								});
							}
						} else {
							// default use vpool
							tao.run.vinit(mod,iid);
							tao.vpool[mod][iid]=$.extend({},ar);
							var jso = jQuery.parseJSON(ar.$jso);
							if (jso) {
								$.each(jso, function(k,v) {
									// verify
									if (tao.vshr.$vpat.test(k)) {
										tao.vpool[mod][iid][k]=v;
									}
								});
							}
						}
					}
			},
			
			// js api method to expand the text jso to var(s) into vpool
			vjso : function(mod,ins,allow)
			{
				var jso = jQuery.parseJSON(tao.vpool[mod][iid][$jso]);
				$.each(jso, function(k,v) {
					tao.vpool[mod][iid][k]=v;
				});
			},
			
			// api method to get var(s) from vpool
			vget : function(mod,ins,vname)
			{
				switch (arguments.length) {
					case 1:
						return tao.vpool[mod];
					break;
					case 2:
						return tao.vpool[mod][ins];
					break;
					case 3:
						return tao.vpool[mod][ins][vname];
					break;
				}
			},
			// api method to put a var to vpool by js
			vput : function(mod,ins,vname,vval)
			{
				tao.run.vinit(mod,ins);
				tao.vpool[mod][ins][vname]=vval;
			},
		
			// method to adjust vpool if not exists
			vinit : function(mod,ins)
			{
				if (typeof(tao.vpool[mod])=='undefined') {
					tao.vpool[mod]={};
					tao.vpool[mod]['$vmsg']={};
				}
				if (typeof(tao.vpool[mod][ins])=='undefined') {
					tao.vpool[mod][ins]={};
				}
			},
			
			// geoip	

			geoip : function () {
				if ($('#epccg').val()=='Y' && $('#epccg').attr('checked')=='checked') {
					if (navigator && navigator.geolocation) {
						navigator.geolocation.getCurrentPosition(tao.run.geoipSuccess, tao.run.geoipError);
						// note feedback is async (user has to agree with geoip)
					}
				}
			},
			
			geoipSuccess : function(posit)
			{
				// ver
				tao.vshr.geoip.lat = posit.coords.latitude;
				tao.vshr.geoip.lng = posit.coords.longitude;
				$('#epclat').val(tao.vshr.geoip.lat);
				$('#epclng').val(tao.vshr.geoip.lng);
				$('#epclcc').val(0);
			},
			
			geoipError : function(err)
			{
				$('#epclcc').val(err.code);
				switch (err.code) {
					case 1:
						console.log('The user denied the request for geoip informations.');
					break;
					case 2:
						console.log('geoip informations unavailable.');
					break;
					case 3:
						console.log('The request to get geoip informations timed out.');
					break;
					default:
						console.log('Unknown error.');
					break;
				}
 			},
			
			// ng i18n
			ngLocale : function()
			{
				if ($('#nglci18na').is('#nglci18na')) {
					$('#nglci18n').css('cursor','pointer');
					$('#nglci18na').mouseenter( function() {
						var lh = $('#nglci18n').css('line-height');
						var ctr = $('.nglcstr').length;
						var h = (lh.match(/\d+/) * (ctr + 1));
						$('#nglci18n').css('height', h + 'px');
						$('#nglci18nc').html('');
						$('.nglcs').show();
					});
				}
				if ($('#nglci18n').is('#nglci18n')) {
					var lh = $('#nglci18n').css('line-height');
					$('#nglci18n').css('height',lh);
					$('.nglcs').hide();
					$('#nglci18nc').html($('#nglci18ns').html());
					$('#nglci18n').mouseleave( function() {
						$('.nglcs').hide();
						$('#nglci18n').css('height',lh);
						$('#nglci18nc').html($('#nglci18ns').html());
					});
				}
				if ($('#nglci18n').is('#nglci18n')) {
					var peg = $('#nglci18n').attr('class');
					if ($(peg).is(peg)) {
						// moving
						$('#nglci18n').appendTo($(peg));
					}
				}
			},
			
			ngGetLocale : function()
			{
				if (typeof($.cookie)=='undefined') {
					$(tao.lod.loadnow('jqcookie')).load(function() {
						return $.cookie('phpws_default_language');
					});
				} else {
						return $.cookie('phpws_default_language');					
				}
			},
			
			ngSetLocale : function(pair)
			{
				var pat = /^[a-z][a-z]_[A-Z][A-Z]$/;
				if (pat.test(pair)) {
					if (typeof($.cookie)=='undefined') {
						$(tao.lod.loadnow('jqcookie')).load(function() {
							var httphost = window.location.protocol + '//' + window.location.host;
							var subdir = tao.vshr.httpurl.dat.replace(httphost,'');
							$.cookie('phpws_default_language',pair, {path: subdir});
							location.reload();
						});
					} else {
							var httphost = window.location.protocol + '//' + window.location.host;
							var subdir = tao.vshr.httpurl.dat.replace(httphost,'');
							$.cookie('phpws_default_language',pair, {path: subdir});
							location.reload();
					}
				}
			},
			
			// upload 2 fc
			upload : function(my)
			{
				console.log(my);
				//$('#ng007').html('<input id="ng008" class="button" type="file" multiple="multiple" />');
				//$('#ng008').css({background:"yellow", border:"0px red solid"});
				//console.log($('#ng008').val());
				/*
				$('input[type=file]').change(function(e){
					console.log($(this).firstChild);
					var f = $(this)[0].files;
					for (var i=0; i<f.length; i++) {
						console.log(f[i].name);
						// size in bytes
						// type img/png zb
					}
				});
				*/
		//		$.ajax({
		//			type: "GET",
		//			url: 'ngcom/xaop/taopi',
		//			success: function(reply) {
		//				console.log(reply);
		//			}
		//		});
			},
			
			// asu extented
			confirm : function(my)
			{
			//	tao.run.vset('#' + my.id);
				var mod = my.attributes['data-mod'].value;
				var peg = '#' + mod + my.attributes['data-peg'].value;
				var msg =  my.attributes['data-msg'].value;
				$(tao.lod.loadnow('fastconfirm')).load(function(){
					$('#' + my.id).fastConfirm({
						questionText: msg,
						onProceed: function(trigger) {$(peg).css('background-color','#800');},
						onCancel: function(trigger) {$(peg).css('background-color','#080');} 
					});
				});
			}
		}
		
		// module related functions
		// ------------------------
		//	ngcom
		tao.run.ngcom =
		{
			ngUniCS : function(ref,op,i) 
			{
				var url = 'ngcom/xaop/';
				switch (op) {
					case 'fcr':
						url = url + 'fcr';
						$('#tn'+i).attr('src',tao.vshr.ngaximgsrc);
						break;
					case 'fcra':
						url = url + 'fcra';
						break;
					case 'fcrotw': case 'fcrote': case 'fcrots':
						url = url + op;
						break;
					case 'nfhin':
						url = url + 'imin';
						break;
					default:
						return;
				}
				url = url + ref;
				if (tao.vshr.authkey.dat.length > 0) {
					url = url + '/authkey/' + tao.vshr.authkey.dat; 	
				}
				$.ajax({
					type: "GET",
					url: url,
					success: function(reply) {
						switch (op) {
							case 'fcr':
								var re = '#tn'+i;
								// 2 refresh
								$(re).attr('src',reply +"?timestamp=" + new Date().getTime());
								break;
							case 'fcra':
								var ret = reply.split('--');
								var n = ret.length - 1;
								for (n in ret) {
									tao.run.ngcom.ngFcTnRe(ret[n]);
								}
								break;
							case 'fcrotw': case 'fcrote': case 'fcrots':
								// recreate tn
								tao.run.ngcom.ngFcTnRe(i);
								break
							case 'nfhin':
								tao.run.epc.rearInImg(reply);
								break;
						}
					}
				});
			},
		
			ngFcTnRe : function(x) 
			{
				tao.run.ngcom.ngUniCS('/x/'+x,'fcr',x);
			},
	
			ngFcTnReAll : function() 
			{
				tao.run.ngcom.ngUniCS('','fcra');
			},
			
			ngFcRotW : function(x) 
			{
				tao.run.ngcom.ngUniCS('/x/'+x,'fcrotw',x);
			},
	
			ngFcRotE : function(x) 
			{
				tao.run.ngcom.ngUniCS('/x/'+x,'fcrote',x);
			},
	
			ngFcRotS : function(x) 
			{
				tao.run.ngcom.ngUniCS('/x/'+x,'fcrots',x);
			},
			
			ngFcEdit : function(hid)
			{
				// construction site
		var wo = '#i18n' + hid;
		var ar = wo.split('y', 1);
		var en = ar[0];
		var cl = $(wo).attr('class');
		var vsn = $(wo + ' td:nth-child(1)').html();
		var lan = $(wo + ' td:nth-child(2)').html();
		var now = new Date()
		var day = now.getDate()
		var month = now.getMonth() + 1
		var year = now.getFullYear()
		var ymd = year + '.' + month + '.' + day;
		
		var cntold = $(wo + ' td:nth-child(3)').text();

		$(wo +  ' td:nth-child(3)').html(
			'<input id="i18n' + hid + 'i" onblur="ngEdit(\'' + wo + '\')" onchange="ngEditChg(\'' + wo + '\')") class="nobo" type="text" maxsize="255" value="' + 
				cntold.replace(/"/g,'&quot;') + '" />');				
			},
	
			ngFcEditChg : function(wo)
			{
				// construction site
		var r = $(wo + 'i').val();
		// var r is html encoded and possibly mb
		$(wo + ' td:nth-child(3)').text(r);
			var now = new Date();
			var stamp = '' + now.getFullYear() + '.' + align(now.getMonth()) + '.' + align(now.getDate())
				+ '-' + align(now.getHours()) + ':' + align(now.getMinutes()) + ':' + align(now.getSeconds())
				+ '@ngI18n@' + author;
			$(wo + ' td:nth-child(4) a').attr('title',stamp);
		if  ( !$(wo).hasClass('i18nupd') ) {
			changes++;
			$('#i18nchanges').text(changes);
			$(wo).addClass('i18nupd');
			$(wo + ' td:nth-child(2)').css('background-color',csschanged);
		}
			},
			
			ngFcPicView : function(me,p)
			{
				var cssw = $('#ncomodal > div').width();
				var cssh = $('#ncomodal > div').height();
				if (!(typeof(cssw)==='undefined') && !(typeof(cssh)==='undefined')) {
					if (!(typeof(tao.vpool.ngcom.ncffi.$jso)==='undefined')) {
						tao.vpool.ngcom.ncffi.jsar=jQuery.parseJSON(tao.vpool.ngcom.ncffi.$jso);
					}
					if (tao.vpool.ngcom.ncffi.jsar[p].w > cssw
					||  tao.vpool.ngcom.ncffi.jsar[p].h > cssh) {
						// scale
						var scaleh = cssh / tao.vpool.ngcom.ncffi.jsar[p].h;
						var scalew = cssw / tao.vpool.ngcom.ncffi.jsar[p].w;
						var scale = scaleh < scalew ? scaleh : scalew;
						var h=Math.floor(tao.vpool.ngcom.ncffi.jsar[p].h * scale);
						var w=Math.floor(tao.vpool.ngcom.ncffi.jsar[p].w * scale);
					} else {
						var h=tao.vpool.ngcom.ncffi.jsar[p].h;
						var w=tao.vpool.ngcom.ncffi.jsar[p].w;
					}
					// center
					$('#ncomodalcnt').css('margin-top', cssh > h ? Math.floor((cssh - h) / 2) : 0);
					$('#ncomodalcnt').css('margin-left', cssw > w ? Math.floor((cssw - w) / 2) : 0);
					$('#ncomodalcnt').html('<img src="' 
						+ tao.vpool.ngcom.ncffi.ifo + tao.vpool.ngcom.ncffi.jsar[p].name 
						+ '" width="' + w + '" height="' + h + '" />');
					console.log(tao.vshr.thisurl);
					$('#ncomodalclose').attr('href', tao.vshr.thisurl + '#ncomodalclose');
					$('#' + me.id).attr('href', tao.vshr.thisurl + '#ncomodal');
				//	var href5 = location.href.split('#');
				//	console.log(href5[0]);
				//	$('#ncomodalclose').attr('href', href5[0] + '#ncomodalclose');
				//	$('#' + me.id).attr('href', href5[0] + '#ncomodal');
				}
			},
			
			recastImgNOP : function(me,p)
			{
				// dup from ngFcPicView(<-obsolete) ->both !! done by php 20121202
				// this is similar stuff in js for a display recast only
				var cssw = $('#ncomodal > div').width();
				var cssh = $('#ncomodal > div').height();
				if (!(typeof(cssw)==='undefined') && !(typeof(cssh)==='undefined')) {
					if (!(typeof(tao.vpool.ngcom.ncffi.$jso)==='undefined')) {
						tao.vpool.ngcom.ncffi.jsar=jQuery.parseJSON(tao.vpool.ngcom.ncffi.$jso);
					}
					if (tao.vpool.ngcom.ncffi.jsar[p].w > cssw
					||  tao.vpool.ngcom.ncffi.jsar[p].h > cssh) {
						// scale
						var scaleh = cssh / tao.vpool.ngcom.ncffi.jsar[p].h;
						var scalew = cssw / tao.vpool.ngcom.ncffi.jsar[p].w;
						var scale = scaleh < scalew ? scaleh : scalew;
						var h=Math.floor(tao.vpool.ngcom.ncffi.jsar[p].h * scale);
						var w=Math.floor(tao.vpool.ngcom.ncffi.jsar[p].w * scale);
					} else {
						var h=tao.vpool.ngcom.ncffi.jsar[p].h;
						var w=tao.vpool.ngcom.ncffi.jsar[p].w;
					}
					// center
					$('#ncomodalcnt').css('margin-top', cssh > h ? Math.floor((cssh - h) / 2) : 0);
					$('#ncomodalcnt').css('margin-left', cssw > w ? Math.floor((cssw - w) / 2) : 0);
					$('#ncomodalcnt').html('<img src="' 
						+ tao.vpool.ngcom.ncffi.ifo + tao.vpool.ngcom.ncffi.jsar[p].name 
						+ '" width="' + w + '" height="' + h + '" />');
					console.log(tao.vshr.thisurl);
					$('#ncomodalclose').attr('href', tao.vshr.thisurl + '#ncomodalclose');
					$('#' + me.id).attr('href', tao.vshr.thisurl + '#ncomodal');
				//	var href5 = location.href.split('#');
				//	console.log(href5[0]);
				//	$('#ncomodalclose').attr('href', href5[0] + '#ncomodalclose');
				//	$('#' + me.id).attr('href', href5[0] + '#ncomodal');
				}
			},
			
			recastImg : function(img)
			{
				// Api
				// I: tao.vpool.ngcom.imgtarget (.w and .h)
				// O: tao.vpool.ngcom.imgtarget (.newsrcw and .newsrch)
				if ($(img).is(img)) {
					tao.run.vinit('ngcom','imgtarget');					
					var srcw = $(img).prop('naturalWidth');
					var srch = $(img).prop('naturalHeight');
					if (srcw > tao.vpool.ngcom.imgtarget.w
					||  srch > tao.vpool.ngcom.imgtarget.h) {
						// scale to fit into target dim
						var scalew = srcw / tao.vpool.ngcom.imgtarget.w;
						var scaleh = srch / tao.vpool.ngcom.imgtarget.h;
						var scale = scalew > scaleh ? scalew : scaleh;
						tao.vpool.ngcom.imgtarget.newsrcw=Math.floor(srcw / scale);
						tao.vpool.ngcom.imgtarget.newsrch=Math.floor(srch / scale);
					} else {
						// take native dim because src is less target
						tao.vpool.ngcom.imgtarget.newsrcw=srcw;
						tao.vpool.ngcom.imgtarget.newsrch=srch;
					}
				}
			}
		}
		
		tao.run.ncl =
		{
			$mid : 'ncl',
			$url : 'ngcom/xaop/',
			$tmp : '',
			
			onReady : function(me)
			{
				tao.run.vput('ncl','','opt0','<option value=" ">...<\/option>');
				// tao.vpool[mod][instance]...
				// {
				//	"m" : 'media type class',
				//	"f" : 'folder name',
				//	"p" : 'pic or file name',
				//	"t" : 'title'
				//	"y" : 'id of db table row'
				// }
		
				//console.log($(tao.vpool['ncl']).length);
				for (var i in tao.vpool['ncl']) {
					var instance = tao.vpool['ncl'][i].id;
					// instance "#"+nclformid" ...summary ...entry = twice for blog i.e.
					var nclformid = tao.run.vget('ncl',i, 'id');
					// or var nclformid = tao.vpool['ncl'][i]['id'];
					if ($("#"+nclformid).is("#"+nclformid)) {
						// feed the textarea with the value
						$("#"+nclformid).val($("#nclwrap-"+nclformid).html());
						$("#nclwrap-"+nclformid).remove();
						tao.run.ncl.nclSetTbbFc();
						// note clfcx: is an artifical (non cle std) property representing the instance
						var editorcss = tao.vshr.httpsrc.dat + 'javascript/editors/cleditor/ngcle.src.css';
						$("#"+nclformid).cleditor({
							clfcx:	nclformid,
							width:	"99%",
							height: "99%",
							controls: $.cleditor.defaultOptions.controls.replace("image", "image pwsfc floatleft floatright hcode"),
							styles:[["Paragraph", "<p>"],
									["DivBlock", "<div>"],
									["Header 1", "<h1>"],
									["Header 2", "<h2>"],
									["Header 3", "<h3>"],
									["Header 4", "<h4>"],
									["Header 5", "<h5>"],
									["Header 6", "<h6>"],
									["Preformat", "<pre>"]],
							fonts:	"Georgia,monospace,Sans Serif,Serif,Tahoma,Verdana",
							sizes:	"1,2,3,4,5,6",
							docCSSFile: editorcss,
							useCSS: true
						});
						
						// trigger cle xhtml plugin in case no change will apply in the editor
						$("#"+nclformid).cleditor()[0].updateTextArea();
						
						// resize fun works instance save just by design of jqui
						var maxw = $('.cleditorMain').css('width').replace('px','');
						$('iframe').width($('.cleditorMain').width()-10);
						// default handles e,s,se reduced to s
						$('.ngwop').resizable({
							maxWidth: maxw,
							minHeight: 100,
							handles: "s",
							helper: "ncloutliner",
							stop: function (e, o) {
								$('iframe').height($('.ngwop').height()-10);
							}
						});
					}
				}
			},
			
			nclSetTbbFc : function()
			{
				$.cleditor.buttons.pwsfc = {
					name: "pwsfc",
					image: "fc2420.png",
					title: "Insert from pws FileCabinet",
					command: "inserthtml",
					buttonClick: tao.run.ncl.nclClickTbbFc
				};
				$.cleditor.buttons.floatleft = {
					name: "floatleft",
					image: "float_left.png",
					title: "floating left",
					command: "inserthtml",
					buttonClick: tao.run.ncl.nclClickFloat
				};
				$.cleditor.buttons.floatright = {
					name: "floatright",
					image: "float_right.png",
					title: "floating right",
					command: "inserthtml",
					buttonClick: tao.run.ncl.nclClickFloat
				};
				$.cleditor.buttons.hcode = {
					name: "hcode",
					image: "hc24.png",
					title: "Restyle selected code text",
					command: "inserthtml",
					buttonClick: tao.run.ncl.nclClickTbbHc
				};
			},
			
			nclClickTbbFc : function(e, data)
			{
				// the cl fc icon click
				var editor = data.editor;
				var inst = editor.options.clfcx;
				var cnt = '';
				// design mode to return true = nothing to do, false = done
				if (!(tao.vpool['ncl'][inst])) return false;
				switch (tao.vpool['ncl'][inst].m) {
					case 'I':
						cnt = '<img src="' + tao.vshr.httpurl.dat + tao.vpool['ncl'][inst].p + '" alt=" *noPic* "\/>';
						break;
					case 'D': 
						cnt = '<a href="' + tao.vshr.httpurl.dat + tao.vpool['ncl'][inst].p + '">' + tao.vpool['ncl'][inst].t + '<\/a>';
						break;
					case 'M':
						cnt = '[filecabinet:media:' + tao.vpool['ncl'][inst].y + ']';
						break;
				}
				var msg = 't010' in tao.vpool.ncl.$vmsg ? tao.vpool.ncl.$vmsg.t010 : 'msg ncl t010';
				if (typeof(tao.vpool.ncl[inst].f)=='undefined' || typeof(tao.vpool.ncl[inst].p)=='undefined') {
					editor.showMessage(msg, data.button);
				} else {
					editor.execCommand(data.command, cnt, null, data.button);
					editor.focus;
				}
				return false;
			},
			
			nclClickFloat: function(e, data) 
			{
				var editor = data.editor;
				var sel = editor.selectedHTML();
				if (sel.length > 0) {
					var sty1 = '';
					var sty = /(?:.*style=")(.*;)+(?:".*)/.exec(sel);
					if (sty == null) {
						var ar = new Array();
						sel=sel.replace(/\s+/,' style="" ');
					} else {
						sty1 = sty[1];
						var ar = sty1.replace(/\s/g,'').split(';');
						ar.pop();
					}
					var aq = new Array();
					$.each(ar, function(i,v) {
						var k = v.split(':');
						aq[k[0]]=k[1];
					});
					switch (data.buttonName) {
						case 'floatleft':
							aq['float']='left';
							aq['margin-right']='3px';
							delete aq['margin-left'];
						break;
						case 'floatright':
							aq['float']='right';
							aq['margin-left']='3px';
							delete aq['margin-right'];
						break;
					}
					tao.run.ncl.$tmp='';
					for (k in aq) {
						tao.run.ncl.$tmp = tao.run.ncl.$tmp + k + ': ' + aq[k] + '; ';
					}
					var newst = 'style="' + tao.run.ncl.$tmp.trimRight() + '"';
					var oldst = 'style="' + sty1 + '"';
					var cnt = sel.replace(oldst,newst);
					editor.execCommand(data.command, cnt, null, data.button);
					editor.focus;
				}
				// done
				return false;
			},

			nclClickTbbHc : function(e, data)
			{
				// the cl fc icon click
				var editor = data.editor;
				var inst = editor.options.clfcx;
				var cnt = editor.selectedHTML().replace(/(&lt;)([\/\?]?\w*)/g,
														'<span style="color:blue">$1<\/span><span style="color:maroon">$2<\/span>')
											   .replace(/(\/)?(&gt;)/g,
														'<span style="color:maroon;">$1</span><span style="color:blue;">$2</span>')
											   .replace(/(\w*)([=]["][a-z0-9\.\/]*["])/g,			
														'<span style="color:red;">$1</span><span style="color:blue;">$2</span>');
			//	console.log(cnt);
				editor.execCommand(data.command, cnt, null, data.button);
				return false;
			},
			
			nclFcM : function(my)
			{
				// onchange fcm the fc type
				var x=$(my).attr('data-iid')?$(my).attr('data-iid'):'single';
				// ...[x].m ... I image folders, D document folders, M media folders 
				tao.run.ncl.nclFcTnClear(my);
				tao.vpool.ncl[x]={ m: $('#'+my.id).val()	};
				if (tao.vpool.ncl[x].m=='I') {
					$('.jsfxb').show();
				} else {
					$('.jsfxb').hide();
				}
			},
			
			nclFcF : function(my)
			{
				// onclick fcf
				var x=$(my).attr('data-iid')?$(my).attr('data-iid'):'single';
				if (!('m' in tao.vpool.ncl[x])) {
					// initial to images if types not touched before
					tao.vpool.ncl[x].m = 'I';
				}
				if (!('f' in tao.vpool['ncl'][x])) {
					// prevent re-retrieval the same
					if ($('#'+my.id+' option').length > 1) return;
			
					switch (tao.vpool.ncl[x].m) {
						case "I" :
							tao.run.ncl.nclUniCS('','fcfi',my.id);
							break;
						case "D" :
							tao.run.ncl.nclUniCS('','fcfd',my.id);
							break;
						case "M" :
							tao.run.ncl.nclUniCS('','fcfm',my.id);
							break;
					}
				}
			},
			
			nclFcFc : function(my)
			{
				// onchange fcf
				var x=$(my).attr('data-iid')?$(my).attr('data-iid'):'single';
				var fcff=$('#'+my.id).val(); // selected folder title
				tao.vpool.ncl[x].m = $('#nclfcm-'+x).val();
				tao.vpool.ncl[x].f = fcff;
				if (fcff==' ') {
					$('#nclfctnfcf-'+x).html(' ');
					$('#nclfcp-'+x).html(tao.run.vget('ncl','','opt0'));
				} else {
					tao.run.ncl.nclUniCS('/s/'+fcff,('fcp'+tao.vpool['ncl'][x].m.toLowerCase()),my.id);
				}
			},
			
			nclFcP : function(my)
			{
				// onchange fcp or triggered by nclFcTn
				var x=$(my).attr('data-iid')?$(my).attr('data-iid'):'single';
				// selected file
				tao.vpool['ncl'][x].p = $('#'+my.id).val();
				tao.vpool['ncl'][x].t = $('#'+my.id+' option:selected').text();
			},
			
			nclFcTn : function(my)
			{
				// onclick a tn
				var s = $(my).attr('src').replace('/tn/','/');
				var t = '#' + $(my).parent().attr('id').replace('nclfctnfcf-','nclfcp-');
				$(t).val(s)
					.trigger('change');
			},
			
			nclFcTnClear : function(my)
			{
				var x=$(my).attr('data-iid')?$(my).attr('data-iid'):'single';
				$('#nclfctnfcf-'+x).html(' ');
				$('#nclfcf-'+x)
					.html(tao.run.vget('ncl','','opt0'))
					.val(' ');
				$('#nclfcp-'+x)
					.html(tao.run.vget('ncl','','opt0'))
					.val(' ');
				$('.nclfctnneg').hide();
				delete tao.vpool['ncl'][x]['f'];
				delete tao.vpool['ncl'][x]['p'];
			},
			
			nclUniCS : function(ref,op,i)
			{
				var url = tao.run.ncl.$url;
				switch (op) {
					case 'fcfi': case 'fcfd': case 'fcfm':
					case 'fcpi': case 'fcpd': case 'fcpm':
						url = url + op;
						break;
					default:
						return;
				}
				url = url + ref + '/authkey/' + tao.vshr.authkey.dat; 
				$.ajax({
					type: "GET",
					url: url,
					success: function(reply) 
					{
						var jso = jQuery.parseJSON(reply);
						if (!jso) return;
						if (jso.mid==tao.run.ncl.$mid) {
							switch (op) {
							case 'fcfi': case 'fcfm':
								$('#'+i).html(jso.fonas);
								break;
							case 'fcfd': 
								$('#'+i).html(jso.fonas);
								// in chrome the select field pre values of fcfd remain asis on screen (unrefreshed)
								// after a 2nd click the new content (options) are seen correct
								// ff=ok, opera=ok, webkit=no solution at the moment 201204
								break;
							case 'fcpi': case 'fcpd': case 'fcpm':
								var tn = '#nclfctnfcf-'+i.replace('nclfcf-','');
								var wo = '#nclfcp-'+i.replace('nclfcf-','');
								if (jso.picas > '') {
									$(tn).html(jso.picas);
								} else {
									$(tn).html('no pics');
								}
								$(wo).html(jso.pinas);
								$('.nclfctnneg').show();
								break;
							}
						}
					}
				});
			}
			
		}
		
		// ngblock
		tao.run.ngblock =
		{
			$lcfrom : 	'',
			$lcto : 	'',
			$lcflag : 	false,
			$fxiid: {},
			
			onReady : function(me) 
			{
				if (!me=='ngblock') return;
				// stuff for on ready here
				
				if ($('.nbkngtable').is('.nbkngtable')) {
					$(tao.lod.loadnow('fixedheadertable')).load(function() 
					{
						$('.nbkngtable').fixedHeaderTable({ height: 380 });
					});
				}
				
				if (!(typeof(tao.vpool.ngblock.nbk.$jso)==='undefined')) {
					var jso = jQuery.parseJSON(tao.vpool.ngblock.nbk.$jso);
					
					$.each(jso, function(k,v) {
						// lc and url is filtered well by rt
						var wo = '#ngblockcnt' + v.bname.replace(/\./g,'dot');
						if ($(wo).is(wo)) {
							if (v.bpinpoint !== '#') {
								if ($(v.bpinpoint).length > 0) {
									// move dom node to 
									$(v.bpinpoint).append($(wo));
								} else {
									$(wo).remove(); 
								}
							}
						}
					});
					
				} else {
					console.log('wop');
					// wop upd
					$('.ngblockcnt').remove();
				}				

				$('#phpws_form_bpinall').click (function() {
					if ($(this).attr('checked')) {
						$('#phpws_form_bpinpage').hide();
						$('#phpws_form_bpinpage_label').hide();
					} else {
						$('#phpws_form_bpinpage').show();
						$('#phpws_form_bpinpage_label').show();
					}
				});
				
				if ($('#phpws_form_bpinall').attr('checked')) {
						$('#phpws_form_bpinpage').hide();
						$('#phpws_form_bpinpage_label').hide();
				}
				
				// onReady init for ngFxSense
				if ($('#ngfxdiv').is('#ngfxdiv')) {
					tao.run.vinit('ngcom','imgtarget');
					if (typeof(tao.vpool.ngcom.imgtarget.w)==='undefined') {
						tao.vpool.ngcom.imgtarget.w = $('#ngfxpic').width();
						tao.vpool.ngcom.imgtarget.h = $('#ngfxpic').height();
						// note, jq cannot reset css properties comming from stylesheets
						//       but can set an element style
						$('#ngfxdiv').parent('div').css('max-height','100%');
					}
				}
				// _/
				
				// onReady init for ngFxSlide
				if ($('#ngfxpicm').is('#ngfxpicm')) {
					tao.run.vinit('ngcom','imgtarget');
					// once 4 1st pic
					if (typeof(tao.vpool.ngcom.imgtarget.w)==='undefined') {
						tao.vpool.ngcom.imgtarget.w = $('#ngfxpicm').width();
						tao.vpool.ngcom.imgtarget.h = $('#ngfxpicm').height();
						// adjust sth
						$('#ngfxpicm').parent('div').css( {
							'max-height': '100%',
							'min-height': tao.vpool.ngcom.imgtarget.h + 'px'
						});
						// ani type (slide, fade, ..., default fade)
						tao.vpool.ngcom.imgtarget.ani = 'fade';
						if ($('#ngfxpicm').hasClass('fxslide')) {
							tao.vpool.ngcom.imgtarget.ani = 'slide';				
						}
						if ($('#ngfxpicm').hasClass('fxfade')) {
							tao.vpool.ngcom.imgtarget.ani = 'fade';				
						}
					}
					// if autorun ...
					if ($('#ngfxpicm').hasClass('fxautorun')) {
						tao.run.ngblock.ngFxSlide();				
					}
					
				}
				// _/
								
			},
			// _/
			
			nbkDelY : function(my) {
				var ele = '#nbkc' + my;
				if ($(ele).attr('checked') == "checked") {
					$('#nbka' + my).attr('href',$('#nbka' + my).attr('href').replace('/delY/','/delY/' + tao.vshr.authkey.dat + '/' + my + '/'));
				}
			},
			
			ngFxB : function() {
				
				
				// cle fx designer
				var fxb = $('#phpws_form_fxb').val();
				$('#nbkmsg').html(' ');
				switch (fxb) {
					case 'boxscr':
						var editor = $('#single').cleditor()[0];
						$('#nbkarea').find('iframe').contents().find('body')
							.wrapInner('<div class="nbkbox box" />');
						editor.updateTextArea();
					break;
					
					case 'coltxt':
						var editor = $('#single').cleditor()[0];
						var nx = 0;
						var cp = $('#nbkarea').find('iframe').contents().find('table').filter('table').prop('cellpadding');
						var cs = $('#nbkarea').find('iframe').contents().find('table').filter('table').prop('cellspacing');
						var bo = $('#nbkarea').find('iframe').contents().find('table').filter('table').prop('border');
						nx = $('#nbkarea').find('iframe').contents().find('td').length;
						// max 5 cols,
						// take table only if one tr, td all have std val (0,0 1,0 ...)
						var htm = '<div class="nbkcoltxthr"><hr /><div class="nbkcoltxt nbkcoltxt' + nx + '">coltxt</div><hr /></div>';
						$('#nbkarea').find('iframe').contents().find('table').first().filter(function() {
							$(this).before(htm);
							$(this).remove();
						});
						editor.updateTextArea();
					break;
					
					case 'dc':
						var editor = $('#single').cleditor()[0];
						var dcdef = Array();
						var dctpl = Array();
						var fld = '';
						var dcfrm = '<table>';
						$('#nbkarea').find('iframe').contents().find('table').clone()
						.each( function (i,d) {
							if (i==0) {
								$(this).children('tbody').children('tr')
								.each( function(tri) {
									fld = $(this).children('td:first-child').text();									
									if (fld	&& fld !== '' && fld.substr(0,1) !== '#') {
										dcdef[fld] = Array();
										$(this).children('td')
										.each( function(tdi) {
											if (tdi > 0 && tdi < 5) {
												dcdef[fld][tdi - 1]=$(this).text();
											}
										});
									}
								});
							}
							if (i==1) {
								$(this).children('tbody').children('tr')
								.each( function(tri) {
									dcfrm = dcfrm + '<tr>';
									$(this).children('td')
									.each( function(tdi) {
										var tdcnt = $(this).text();
										var tdfid = tdcnt.substr(0,1);
										fld = tdcnt.substr(1);
										var style = typeof($(this).attr('style'))=='undefined' 
										? '' : ' style="' + $(this).attr('style') + '"';
										if (tdfid === '_' 
										&& dcdef[fld]) {
											switch (dcdef[fld][0]) {
												case 't':
													var atsiz = dcdef[fld][1] == '' 
													? '' : ' size="' + dcdef[fld][1] + '"';
													var atval = dcdef[fld][3] == '' 
													? '' : ' value="' + dcdef[fld][3] + '"';
													var tpl = '<input class="nbkfld" type="text" name="nbk' + fld + '"' 
													+ atsiz + atval + ' />';
													dcfrm = dcfrm + '<td' + style + '>' 
													+ ($(this).html().replace(tdcnt,tpl)) + '</td>';
												break;
												case 'a':
													var atopt = dcdef[fld][1].split(',',3);
													var atmax = (typeof(atopt[0]) == 'undefined' || atopt[0] == '')
													? '' : ' maxlength="' + atopt[0] + '"';
													var atcols = (typeof(atopt[1]) == 'undefined' || atopt[1] == '')
													? '' : ' cols="' + atopt[1] + '"';
													var atrows = (typeof(atopt[2]) == 'undefined' || atopt[2] == '') 
													? '' : ' rows="' + atopt[2] + '" noresize="noresize"';
													var atval = dcdef[fld][3] == '' 
													? '' : ' value="' + dcdef[fld][3] + '"';
													var tpl = '<textarea class="nbkfld" name="nbk' + fld + '"'
													+ atmax + atcols + atrows + '>' + atval + '</textarea>';
													dcfrm = dcfrm + '<td' + style + '>' 
													+ ($(this).html().replace(tdcnt,tpl)) + '</td>';
												break;
													case 'c':
													var atval = dcdef[fld][3] == '' 
													? '' : ' checked="checked"';
													var tpl = '<input class="nbkfld" type="checkbox" name="nbk' + fld + '"' 
													+ atval + ' />';
													dcfrm = dcfrm + '<td' + style + '>' 
													+ ($(this).html().replace(tdcnt,tpl)) + '</td>';
												break;
													case 'r':
													var atval = (dcdef[fld][3]).split('--');
													console.log(atval);
													var tpl='';
													for (var f=0; f < atval.length; f++) {
														tpl = tpl + '<input class="nbkfld" type="radio" name="nbk' + fld + '"' 
														+ ' value="' + atval[f] + '" />' + atval[f] + '&nbsp;';
													}
													dcfrm = dcfrm + '<td' + style + '>' 
													+ ($(this).html().replace(tdcnt,tpl)) + '</td>';
												break;
										}
										} else {
											dcfrm = dcfrm + '<td' + style + '>' + $(this).html() + '</td>';
										}
									});
								});
								dcfrm = dcfrm + '</tr>';
							}
						});
						dcfrm = dcfrm + '</table>';
						$('#nbkarea').find('iframe').contents().find('body').append(dcfrm);
						editor.updateTextArea();
						$('#phpws_form_fxb').val('');
					break;
					
					case 'debug':
						var editor = $('#single').cleditor()[0];
						console.log(editor.selectedHTML());
						$('#phpws_form_fxb').val('');
					break;
					
					case 'sensor':
						var editor = $('#single').cleditor()[0];
						var tns = $('#nclfctnfcf-single img');
						var tn = '';
						var bx = '0';
						var title = '';
						bx = $('#nbkarea').find('iframe').contents().find('table').filter('table').prop('cellspacing');
						$('#nbkarea').find('iframe').contents().find('td').each(function(ix) {
							if (!$(tns[ix]).attr('src')) {
								return false; // of this each
							} else {
								title = $(tns[ix]).attr('title');
								if (typeof(title)=='undefined') {
									title='';
								}
								tn = '<img id="i' + ix + '" alt="' + $(tns[ix]).attr('alt') 
									+ '" src="' + $(tns[ix]).attr('src')
									+ '" onclick="tao.run.ngblock.ngFxSense(' + "'" + ix + "'" + ')'
									+ '" />'
									+ '<span id="s' + ix + '" style="display:none;">' + title + '</span>';
								$(this).html(tn);
							}
						});
						if (tns.length > 0) {
							// any pics present
							title = $(tns[0]).attr('title');
							if (typeof(title)=='undefined') {
								title='';
							}
							var imgsrc = $(tns[0]).attr('src').replace("/tn/","/");
							var imghtm = '<div id="ngfxdiv"><img id="ngfxpic" src="'  + imgsrc + '" alt="mainpic" style="padding: ' + bx * 2 +'px;"/>'
									+ '<span id="ngfxtxt">' + title + '</span></div>';
							// console.log($('#nbkarea').find('iframe').contents().find('#ngfxdiv')[0].outerHTML);
							if ($('#nbkarea').find('iframe').contents().find('#ngfxdiv').length > 0) {
								$('#nbkarea').find('iframe').contents().find('#ngfxdiv')[0].outerHTML = imghtm;
							} else {
								$('#nbkarea').find('iframe').contents().find('br').first().filter(function() {
									$(this).before(imghtm);
								});
							}
							// iframe 2 textarea
							editor.updateTextArea();
							tao.run.ncl.nclFcTnClear();
						} else {
							$('#ngblockmsg').html('no pic folder selected');
						}
					break;
					
					case 'slider':
						tao.run.vinit('ngblock','shr');
						tao.vpool['ngblock']['shr']['tmp'] = '<img id="ngfxpicm" src="' 
							+ $('#nclfcp-single > option:eq(1)').val() 
							+ '" alt="*nopic*" onclick="tao.run.ngblock.ngFxSlide()" /><span id="ngfxpicfn" style="display:none;">none';
						$('#nclfcp-single').children().each( function(ix) {
							if ($(this).val() > ' ') {
								var w = $('#tn'+(ix - 1)).width();
								var h = $('#tn'+(ix - 1)).height();
								var c = $('#tn'+(ix - 1)).attr('class');
								var c = '';
								if (w > h) {
									c='ngfxland';
								} else {
									c='ngfxport';
								}
								tao.vpool['ngblock']['shr']['tmp'] += '<span id="ngfxpicn' + ix + '" class="ngfxpicpn ' + c + '">' + $(this).val() + '</span>';
							}
						});
						tao.vpool['ngblock']['shr']['tmp'] += '</span>';
						var editor = $('#single').cleditor()[0];
						$('#nbkarea').find('iframe').contents().find('br').first().filter(function() {
							$(this).before(tao.vpool['ngblock']['shr'].tmp);
						});
						editor.updateTextArea();
						tao.run.ncl.nclFcTnClear();
					break;
				}
			},

			ngFxSense : function(ix) {
				// fx runtime, init via onReady
				
				// pick clicked pic native size and preload and recast
				var picsrc = $('#i' + ix).attr('src').replace("/tn/","/");
				$('#ngfxdiv')
				.append('<img id="ngtmp" style="display:none;" src="' + picsrc + '" />');
				$('#ngtmp')
				.load( function () {
					tao.run.ngcom.recastImg('#ngtmp');
					$(this).remove();
				});

				$('#ngfxtxt').fadeOut(1000);
				$('#ngfxpic').fadeOut(1000, function() {
					$(this)
					.attr({
						src: picsrc,
						height: tao.vpool.ngcom.imgtarget.newsrch,
						width: tao.vpool.ngcom.imgtarget.newsrcw
						})
					.css({
						height: tao.vpool.ngcom.imgtarget.newsrch + 'px',
						width: tao.vpool.ngcom.imgtarget.newsrcw + 'px'
						})
					.load( function() {
						$(this).fadeIn(1000);
						$('#ngfxtxt')
							.html('<h3>' + $('#i'+ix).attr('alt') + '</h3> ' + $('#s'+ix).text())
							.fadeIn(1000)
						;
					});
				});
			},

			ngFxEset : function(eid) {
				if (eid.substr(0,1)=='#') {
					// need also native notation
					eid=eid.substr(1);
				}
				// instance id by blockname
				var iid = $('#' + eid).parent().attr('id');
				if (typeof(tao.run.ngblock.$fxiid[iid])=='undefined') {
					tao.run.ngblock['$fxiid'] = {};
					tao.run.ngblock.$fxiid[iid] =	{};
					// attention, some jq will not work
					tao.run.ngblock.$fxiid[iid].$iid = document.getElementById(iid);
					jQuery.extend(tao.run.ngblock.$fxiid[iid].$iid.style, tao.vshr.fxtpl.hcGrow);
					tao.run.ngblock.$fxiid[iid].$eid = document.getElementById(eid);
					tao.run.ngblock.$fxiid[iid].i = 1;
					tao.run.ngblock.$fxiid[iid].imax = $('.ngfxpicpn').length;
					jQuery.extend(tao.run.ngblock.$fxiid[iid].$eid.style, tao.vshr.fxtpl.hcgrow);
					tao.run.ngblock.$fxiid[iid].$eid.style.animationIterationCount = tao.run.ngblock.$fxiid[iid].imax;
					tao.run.ngblock.$fxiid[iid].$eid.style.webkitAnimationIterationCount = tao.run.ngblock.$fxiid[iid].imax;
					tao.run.ngblock.$fxiid[iid].$eid.addEventListener('animationstart', tao.run.ngblock.ngFxErun, false);
					tao.run.ngblock.$fxiid[iid].$eid.addEventListener('webkitAnimationStart', tao.run.ngblock.ngFxErun, false);
					tao.run.ngblock.$fxiid[iid].$eid.addEventListener('animationiteration', tao.run.ngblock.ngFxErun, false);
					tao.run.ngblock.$fxiid[iid].$eid.addEventListener('webkitAnimationIteration', tao.run.ngblock.ngFxErun, false);
					tao.run.ngblock.$fxiid[iid].$eid.addEventListener('animationend', tao.run.ngblock.ngFxErun, false);
					tao.run.ngblock.$fxiid[iid].$eid.addEventListener('webkitAnimationEnd', tao.run.ngblock.ngFxErun, false);
					var hcgrow = 'hcgrowfade';
					hcgrow = $('#ngfxpicm').hasClass('fxfade') ? 'hcgrowfade' : hcgrow;
					hcgrow = $('#ngfxpicm').hasClass('fxsolid') ? 'hcgrowsolid' : hcgrow;
					hcgrow = $('#ngfxpicm').hasClass('fxrot') ? 'hcgrowrot' : hcgrow;
					hcgrow = $('#ngfxpicm').hasClass('fxper') ? 'hcgrowper' : hcgrow;
					switch (hcgrow) {
						case 'hcgrowfade':
						break;
						case 'hcgrowsolid':
						break;
						case 'hcgrowrot':
						break;
						case 'hcgrowper':
							// iid diff
							tao.run.ngblock.$fxiid[iid].$iid.style.perspective = '1200px';
							tao.run.ngblock.$fxiid[iid].$iid.style.webkitPerspective = '1200px';
							// eid diff
							tao.run.ngblock.$fxiid[iid].$eid.style.animationTimingFunction = 'linear';
							tao.run.ngblock.$fxiid[iid].$eid.style.webkitAnimationTimingFunction = 'linear';
							tao.run.ngblock.$fxiid[iid].$eid.style.transformStyle = 'preserve-3d';
							tao.run.ngblock.$fxiid[iid].$eid.style.webkitTransformStyle = 'preserve-3d';
							tao.run.ngblock.$fxiid[iid].$eid.style.transformOrigin = '0 0 0';
							tao.run.ngblock.$fxiid[iid].$eid.style.webkitTransformOrigin = '0 0 0';
						break;
					}
					// keyframes 
					var csst = '<style id="nbkcsx' + iid + '">' + tao.vshr.fxcsx[hcgrow] + '</style>';
					if ($('#nbkcsx' + iid).is('#nbkcsx' + iid)) {
						$('#nbkcsx' + iid).html(csst);
					} else {
						$('#' + eid).parent().prepend(csst);	
					}
				}
			},
			
			ngFxErun : function(e) {
				var eid = $('#ngfxpicm').parent().attr('id');
				var iid = $('#' + eid).parent().attr('id');
				switch (e.type) {
					case 'animationstart': case 'webkitAnimationStart':
						if (tao.vshr.debug) {
							console.log('s' + e.elapsedTime);
						}
					break;
					case 'animationiteration': case 'webkitAnimationIteration':
						if (tao.vshr.debug) {
							console.log('i' + e.elapsedTime);
						}
						if (tao.run.ngblock.$fxiid[iid].i < tao.run.ngblock.$fxiid[iid].imax) {
							tao.run.ngblock.$fxiid[iid].i++;
							var nsrc = $('#ngfxpicn' + tao.run.ngblock.$fxiid[iid].i).text();
							$('#ngfxpicm').attr('src',nsrc);
							tao.run.ngcom.recastImg('#ngfxpicm');
						}
					break;
					case 'animationend': case 'webkitAnimationEnd':
						if (tao.vshr.debug) {
							console.log('e' + e.elapsedTime);
						}
					break;
				}
			},
			
			ngFxSlide : function() {
				// fx runtime, go53, init via onReady if fxautorun
				// interfaces also onclick
				var pid = $('#ngfxpicm').parent().attr('id');
				if (typeof(pid)=='undefined') {
					pid = 'nbktmp' + $('#ngfxpicm').parent().parent().attr('id');
					$('#ngfxpicm').parent().attr('id', pid);
				}
				var iid = $('#' + pid).parent().attr('id');
				if ($('#ngfxpicm').hasClass('fxautorun')) {
					if (typeof(tao.run.ngblock.$fxiid[iid])=='undefined') {
						// on a 1st click (always) and when reinvoked after a pause
						tao.run.ngblock.ngFxEset(pid);
					} else {
						// stop ani
						delete tao.run.ngblock.$fxiid[iid];
						$('#nbkcsx').remove();
						// ** ani is not stopped in webkit **
					}
				} else {
					// navigate by click
					$('#ngfxpicm').hide();
					var me = $('#ngfxpicm').attr('src');
					var mei = $('.ngfxpicpn:contains(\'' + me + '\')').attr('id').replace('ngfxpicn','');
					//var pc = $('.ngfxpicpn:contains(\'' + me + '\')').next('span.ngfxpicpn');
					if (mei < $('.ngfxpicpn').length) {
						mei++;
					} else {
						mei='1';						
					}
					var nsrc = $('#ngfxpicn' + mei).text();
					$('#ngfxpicm').attr('src',nsrc);
					$('#ngfxpicm').fadeIn(2000);
				}
			},
			// _/
			
			// google translate interface, google self needs native js
			goTrans : function(key,srctext)
			{
				var editor = $('#single').cleditor()[0];
				var st=editor.$area[0].value;
				var stu = st;
				var stul = st.length;
				var dlms = ['. ',', ','>'];
				var chnk = 1200;
				var hchunks = 0;
				var i = 0;
				var w = 0;
				var p = -1;
				var parf = [];
				var part = [];
				while (w<stul) {
					if ((w+chnk)>=stul) {
						// take rest
						parf[i]=w;
						part[i]=stul;			
						break;
					}
					for (var x in dlms) {
						p = stu.indexOf(dlms[x],w+1000);
						if ((p == -1) || ( p > w+chnk)) {
							if (x < dlms.length) {
								continue;
							}
							// not found or too far, take hard chunk
							parf[i]=w;
							part[i]=w+chnk;
							w=w+chnk;
							hchanks++;
						} else {
							// take soft chunk
							parf[i] = w;
							part[i] = p + dlms[x].length;
							w = p + dlms[x].length;
							break;
						}
					}
					i++;
				}
				$('#ngblockmsg').text('Textsize=' + stul + ', translation in ' + part.length + ' chunks, hardchunks=' + hchunks);
		
				var par = '';
				tao.run.ngblock.$lcflag=true;
				for (i=0; i<part.length; i++) {
					par = stu.substring(parf[i],part[i]);
					tao.run.ngblock.go2Trans(key,par);
				}
			},
			
			go2Trans : function(key,srctext)
			{
				var newScript = document.createElement('script');
				newScript.type = 'text/javascript';
				var srt = escape(srctext);
				var src = 'https://www.googleapis.com/language/translate/v2?key=' + key 
				+ '&source=' + $('#phpws_form_lcfrom').val() + '&target=' + $('#phpws_form_lcto').val()
				+ '&format=html'
				+ '&callback=tao.run.ngblock.backTrans&q=' + srt;
				newScript.src = src;
				// fire
				document.getElementsByTagName('head')[0].appendChild(newScript);
			},
			
			backTrans : function(reply)
			{
				//alert(reply.error.errors[0].reason);
				if (typeof reply.error === 'undefined') {
					if (tao.run.ngblock.$lcflag==true) {
						// clear docsrc before 1st chunk
						$('#nbkarea').contents().find('iframe').contents().find('body').html('');
						tao.run.ngblock.$lcflag=false;
					}
					$('#nbkarea').contents().find('iframe').contents().find('body').append(
						reply.data.translations[0].translatedText
					);
				} else {
					$('#ngblockmsg').append(', Feedback= <b>' + reply.error.message + '</b>');
				}
			},
			
			checkTrans : function()
			{
				var newScript = document.createElement('script');
				newScript.type = 'text/javascript';
				var src = 'https://www.googleapis.com/language/translate/v2?key=' + key 
				+ '&source=' + $('#phpws_form_lcfrom').val() + '&target=' + $('#phpws_form_lcto').val()
				+ '&format=text'
				+ '&callback=tao.run.ngblock.backTrans&q=Test';
				newScript.src = src;
				document.getElementsByTagName('head')[0].appendChild(newScript);
			},
			
			transChange : function()
			{
				tao.run.ngblock.$lcfrom = $('#phpws_form_lcfrom :selected').text();
				tao.run.ngblock.$lcto = $('#phpws_form_lcto :selected').text();	
			}
		}
		
		// ngmenu
		tao.run.ngmenu =
		{
			onReady : function(me) 
			{
				if (!me=='ngmenu') return;
				// stuff for on ready here
				if (tao.vshr.debug) {
					console.log('ngmenu ready');
				}
				if ($('.nmungtable').is('.nmungtable')) {
					$(tao.lod.loadnow('fixedheadertable')).load(function() 
					{
						$('.nmungtable').fixedHeaderTable({ height: 380 });
					});
				}
		
				if ($('#ngmenutxta').is('#ngmenutxta')) {
					$(tao.lod.loadnow('tabby')).load(function() 
					{
						$('#ngmenutxta').tabby();
						$('#ngmenutxta').scroll( function() {
							tao.run.ngmenu.synScroll();
						});
						$('#ngmenutxta').keyup( function() {
							$('#ngmenutxtn').html(tao.run.ngmenu.reNum());
						});
					});
						$('#ngmenutxtn').html(tao.run.ngmenu.reNum());
				}

				if (!(typeof(tao.vpool.ngmenu.nmu.$jso)==='undefined')) {
					var jso = jQuery.parseJSON(tao.vpool.ngmenu.nmu.$jso);
					$.each(jso, function(k,v) {
						var wo = '#ngmenucnt' + v.mname.replace(/\./g,'dot');
						if ($(wo).is(wo)) {
							if (v.mpinpoint !== '#') {
								// move dom node to (else leave where is)
								$(v.mpinpoint).append($(wo));
							}
						}
					});
				} else {
					// wop upd
					$('.ngmenucnt').remove();
				}
				
				if ($('ul.sf-menu').length) {
					$(tao.lod.loadnow('superfish')).load(function(){
						
					$('ul.sf-menu').superfish({
						delay:		100,
						autoArrows: true
					});
					});
				}
		
				$('#phpws_form_mpinall').click (function() {
					if ($(this).attr('checked')) {
						$('#phpws_form_mpinpage').hide();
						$('#phpws_form_mpinpage_label').hide();
					} else {
						$('#phpws_form_mpinpage').show();
						$('#phpws_form_mpinpage_label').show();
					}
				});
				if ($('#phpws_form_mpinall').attr('checked')) {
						$('#phpws_form_mpinpage').hide();
						$('#phpws_form_mpinpage_label').hide();
				}
			},
		
			reNum : function() {
				var txt='';
				var j = $('#ngmenutxta').val().match(/\n/g);
				if (j) {
					for (var i=1; i<=j.length+1; i++) {
						txt = txt + i + '<br />';
					}
				}
				return txt;
			},
		
			synScroll : function() {
				$('#ngmenutxtn').html(tao.run.ngmenu.reNum());
				var qo = $('#ngmenutxta').scrollTop();
				$('#ngmenutxtn').scrollTop(qo);
			},
			
			nmuDelY : function(my) {
				var ele = '#nmuc' + my;
				if ($(ele).attr('checked') == "checked") {
					$('#nmua' + my).attr('href',$('#nmua' + my).attr('href').replace('/delY/','/delY/' + tao.vshr.authkey.dat + '/' + my + '/'));
				}
			}
		}

		// epc
		tao.run.epc =
		{
			onReady : function(me) 
			{
				if (!me=='epc') return;
				
				$('#nfhupi').click( function () {
					tao.run.epc.mymEnum();
				});
					
				
				if ($('#nfhup').is('#nfhup')) {
										
					if (tao.vpool[me].nfh.umode == 'anu') {
						var go2s = tao.vshr.httpurl.dat + 'ngcom/xaop/taoanu';
					} else {
					var go2s = './ngcom/xaop/taopi/authkey/' + tao.vshr.authkey.dat;
					}
					var maxfsize = '' + tao.vpool.epc.nfh.maxsize + 'kb';
					
					var uploader = new plupload.Uploader({
						runtimes : 'html5,flash',
						browse_button : 'nfhupc',
						container: 'nfhupm',
						max_file_size : '10mb',
						url : go2s,
						flash_swf_url : './javascript/ng_com/axup/plupload.flash.swf',
						filters : [
							{title : "Image files", extensions : "jpg,gif,png"}
						]
					});
	
					uploader.bind('Init', function(up, params) {
						// only for developers to debug - thus hidden
						$('#nfhupm').html('<div style="display:none;">Current runtime: ' + 
							params.runtime + '</div>');
					});
				
					$('#nfhupl').click(function(e) {
						uploader.start();
						e.preventDefault();
					});

					uploader.init();
				
					uploader.bind('QueueChanged', function(up, files) {
						// console.log(uploader.files.length);
						// works each time when collect is called
					});
					
					uploader.bind('FilesAdded', function(up, files) {
						var msg = '';
						var add = '';
						var clq = '';
						$.each(files, function(i, file) {
							msg = 'nfh001e';
							if (tao.vpool.epc.nfh.maxfiles > ($('.nfhq1').length)) {
								msg = 'nfh002e';
								if (tao.vpool.epc.nfh.maxsize > (file.size / 1024)) {
									clq = '1';
									msg = '';
									add = '';
								}
							}
							if (msg > '') {
								clq = '0';
								add = tao.vshr.ngkoimg + ' ' + tao.vpool[me].$vmsg[msg];
								var rm = uploader.splice(($('.nfhq1').length),1);
							}
							$('#nfhupm').append(
								'<div id="nfh' + file.id + '" class="nfhq nfhq' + clq + '"><code>' +
								file.name + ' (' + plupload.formatSize(file.size) + ') ' + 
								add + '<b></b>' + '</code></div>');
						});
						up.refresh();
					});

					uploader.bind('UploadProgress', function(up, file) {
						$('#nfh' + file.id + " b").html( tao.vshr.ngaximg + ' ' + file.percent + "%");
					});
				
					uploader.bind('Error', function(up, err) {
						$('#ncfdq').append('<div><code>' + (err.file ? err.file.name : ' ') + 
							' Error ' + err.code +
							', ' + err.message + ' ' + tao.vshr.ngkoimg +
							'</code></div>'
						);
						up.refresh(); // Reposition Flash/Silverlight
					});

					uploader.bind('FileUploaded', function(up, file) {
						$('#nfh' + file.id + " b").html('100% ' + tao.vshr.ngokimg);
						// 2 rework - perform unics and put img due reply of unics
						tao.run.ngcom.ngUniCS('/in/' + file.name, 'nfhin');
					});
					
				}
			},
			
			rearIn : function() {
				tao.vshr.proxy = 'epc';
				$('#epcwopfore').slideToggle(1600, function() {
					if ($('#epcwoprear').is(':visible')) {
						$('#epcwoprear').hide();
					} else {
						$('#epcwoprear').slideToggle(1600);
					}
				});
			},
			
			rearInImg : function(himg) {
				if (himg.length > 8) {
					$('#nfhup').remove();
					$('#epcwoprear').append(himg);
					$('#epcita').text(encodeURIComponent(himg));
					// button save
					$('#epcsave').html(decodeURIComponent(tao.vpool.epc.nfh.linkback));
				}
			},
			
			mymEnum: function() {
				// bg xaop epc
				$.ajax({
					type: "GET",
					url: 'epc/xaop/mym',
					success: function(reply) 
					{
						$('#nfhis').html(reply);
						var tns = $('.epc1td').length;
						for (var i=0; i < tns; i++) {
							tao.run.epc.mymTn1(i);
						}
					}
				});
			},
			
			mymTn1: function(ix) {
				// bg xaop epc
				$.ajax({
					type: "GET",
					url: 'epc/xaop/mymi/x/' + ix,
					success: function(reply) 
					{
						$('#epc1' + ix).prepend(reply);
					}
				});
			},
			
			mymIm1: function(muid) {
				// bg xaop epc
				$.ajax({
					type: "GET",
					url: 'epc/xaop/myms/x/' + muid,
					success: function(reply) 
					{
						$('#nfhup').remove();
						$('#epcimg').html(reply);
						$('#epcsave').html(unescape(tao.vpool.epc.nfh.linkback));
					}
				});
			}
			
		}
		
	})(jQuery);
	