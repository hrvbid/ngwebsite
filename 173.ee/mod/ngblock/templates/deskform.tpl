<div id="nbkwop" class="ngwop">
{START_FORM}
<table id="ngblockwt" cellspacing="0" width="100%">
	<tr class="ngtdbg"><td><h2 class="nbkwophx">{TITLE}</h2></td>
		<td colspan="3"  class="txtright">
			<a href="ngblock/op/list">{LIST}</a>&nbsp;&nbsp;&nbsp;
			<a href="ngblock/op/view/bname/{VIEW}{LC}">{VIEW_LABEL}</a>&nbsp;&nbsp;&nbsp;
			<a href="ngblock/op/edit">{EDIT}</a>&nbsp;&nbsp;&nbsp;
			Google: </td>
		<td>{TRANSLINK} {LCFROM_LABEL} {LCFROM}</td>
		<td class="txtcenter">{LCTO_LABEL}</td>
		<td>{LCTO}</td>
	</tr><tr>
		<td>{OPEN} {MAKE} {CANCEL}</td>
		<td class="txtright">{BNAME_LABEL}:</td>
		<td>{BNAME}</td>
		<td class="txtright">{BTITLE_LABEL}:</td>
		<td>{BTITLE}</td>
		<td class="txtright"><span id="phpws_form_blang_label"> {BLANG_LABEL}: </span></td>
		<td>{BLANG}</td>
	</tr><tr>
		<td></td>
		<td class="txtright"><span id="phpws_form_bpinpoint_label" >{BPINPOINT_LABEL}:</span></td>
		<td>{BPINPOINT}</td>
		<td class="txtright"><span id="phpws_form_bpinpage_label" >{BPINPAGE_LABEL}:</span></td>
		<td>{BPINPAGE}</td>
		<td colspan="2">
			{BPINALL}<div class="ngchkboxlbl">{BPINALL_LABEL}</div>
			{BPUBLIC}<div class="ngchkboxlbl">{BPUBLIC_LABEL}</div></td>
	</tr><tr class="ngtdbg">
		<td>{TYPE_TITLE}: {FCM}&nbsp;&nbsp;<span class="jsfxb">{FXB_LABEL}:</span> {FXB}</td>
		<td class="txtright">{FOLDER_TITLE}:</td>
		<td>{FCF}</td>
		<td class="txtright">{FILES_TITLE}:</td>
		<td>{FCP}</td>
		<td colspan="2">{FCTXT}</td>
	</tr>
</table>
<div id="nbkmsg" class="ngmsg">{MSG} </div>
<div id="nclfctnfcd-single" >
	<div class="nclfctnneg">&nbsp;</div>
	<div id="nclfctnfcf-single" class="nclfcthumbs"> </div>
	<div class="nclfctnneg">&nbsp;</div>
</div>
<var id="ncl-single" class="hidden vset" data-id="single" data-iid="single" data-mod="ncl">[]</var>
<div id="nbkarea">
	<textarea id="single" name="single" class="nclarea"></textarea>
</div>
{END_FORM}
<div id="nclwrap-single" class="hidden">{EDITOR}</div>
</div>
