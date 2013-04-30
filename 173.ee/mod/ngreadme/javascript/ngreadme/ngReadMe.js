/**
  * @author Hilmar Runge <ngwebsite.net>
  * @version 201210
  */

	var ngaximg = '<img src="' + source_http + 'mod/ngreadme/img/ajax10red.gif" alt="..." />';
	var offtop = 0;
  
	$(document).ready(function(){
		// none
	});
  
	
	function nmeClick(hlpid) {
		var elmnt = document.getElementById(hlpid);
		var x = elmnt.previousSibling.offsetLeft;
		var y = elmnt.previousSibling.offsetTop + 20;
		elmnt.style.left = x + 'px';
		elmnt.style.top = y + 'px';
		elmnt.style.display='block';
	}

	function nmeOvr(hlpid) {
		var elmnt = document.getElementById(hlpid);
		if (elmnt.previousSibling.previousSibling.tagName=='A') {
			elmnt.previousSibling.style.textDecoration = 'underline';
			elmnt.previousSibling.previousSibling.style.textDecoration = 'underline';
		}
	}

	function nmeOff(hlpid) {
		var elmnt = document.getElementById(hlpid);
		elmnt.style.display='none';
		if (elmnt.previousSibling.previousSibling.tagName=='A') {
			elmnt.previousSibling.style.textDecoration = 'none';
			elmnt.previousSibling.previousSibling.style.textDecoration = 'none';
		}
	}

	function nmeTermsView(xf) {
		var wo = '#c' + xf;
		if ($(wo).html()=='') {
			nmeUniCS(xf,'1c','0');
		} else {
			$(wo).toggle();
		}
	}
	
	function nmePosit() {
		var offrel = $('#searchSelect')[0].offsetTop;
		var founds = $('.hilite').length;
		$('#searchtimes').text(founds + 'x');
		if (offtop >= founds) {
			offtop=0;
		}
		if (founds>0) {
			$('#searchSelect').scrollTop($('.hilite')[offtop].offsetTop - offrel);
			offtop++;
		}
	}

	function nmeDocDisplay(xf,i) {
		var wo = '#d' + xf;
		var cnt = $(wo).html();
		if (cnt == '') {
			nmeUniCS(xf,'1a',i);
		} else {
			$(wo).html('');
		}
	}
	
	function nmeBix(xf,i) {
		nmeUniCS(xf,'1b',i);
	}
	
	function nmeBixAll() {
		var mxref = $('#nmemxref');
		var xf = '';
		$('#nmemxref li').each(function(index) {
			xf = $(this).text();
			nmeBix(xf,'0');
		});
	}
	
	function nmeBixTotal() {
		var j = jQuery.parseJSON($('#nmeaxref').text());
		$.each(j, function(mod,ref) {
			$('#nmebxa'+mod)
			.html(ngaximg + '(re)indexing still <span id="ngmtx' + mod + '">' + ref.length + '</span> files' + ngaximg);
			$.each(ref, function(k,v) {
				nmeUniCS(v,'1t',mod);
			});
		});
	}

	function nmeDix(xf,i) {
		nmeUniCS(xf,'1d',i);
	}
	
	function nmeUniCS(ref,op,i) {
		var url = 'ngreadme/xaop/';
		var wo = '';
		switch (op) {
			case '1a':
				url = url + '1a/x/';
				break;
			case '1b':
				url = url + '1b/x/';
				wo = '#a' + ref;
				$(wo).html(ngaximg);
				break;
			case '1c':
				url = url + '1c/x/';
				break;
			case '1d':
				url = url + '1d/x/';
				wo = '#a' + ref;
				$(wo).html(ngaximg);
				break;
			case '1t':
				url = url + '1t/x/';
				break;
			default:
				return;
		}
		url = url + ref + '/authkey/' + authkey; 
		$.ajax({
			type: "GET",
			url: url,
			success: function(reply) {
						switch (op) {
							case '1a':
								var wo = '#d' + ref;
								$('.nghelpshown').html('');
								$(wo).addClass('nghelpshown');
								$(wo).html('<pre>' + reply + '</pre>');
								break;
							case '1b':
								var wo = '#a' + ref;
								var lnk = '&nbsp;<a onclick="nmeTermsView(' + "'" + ref + "'" + ')">' + 'showIndex</a> )'
											+ '<span class="inmono" id="c' + ref + '"></span>';
								$(wo).html(' (' + ngmsgh010 + ', ' + ngmsgh011 + ': ' + reply + lnk);
								break;
							case '1c':
								var wo = '#c' + ref;
								$(wo).html('<br />' + reply + '<br />');
								break;
							case '1d':
								var wo = '#a' + ref;
								$(wo).html(' (' + reply + ')');
								break;
							case '1t':
								var wo = '#ngmtx' + i;
								var n = $(wo).text();
								if (n>0) {
									n--;
									$(wo).text(n);
								}
								if (n==0) {
									wo = '#nmebxa' + i;
									$(wo).html('');
								}
								break;
						}
					}
		});
	}	
	

	
