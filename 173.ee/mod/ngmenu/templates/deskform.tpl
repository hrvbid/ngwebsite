<div id="ngmenuwop" class="ngwop">
{START_FORM}
<table width="99%">
	<tr><td><h2 class="nmuwophx">{TITLE}</h2></td><td><a href="ngmenu/op/list">{LIST}</a></td><td></td><td></td><td></td></tr>
	<tr><td>{OPEN} {MAKE} {CANCEL}</td>
		<td class="txtright">{MNAME_LABEL}:</td><td>{MNAME}</td>
		<td class="txtright">{MTITLE_LABEL}:</td><td>{MTITLE}</td>
		<td>{MVERTICAL}<div class="ngchkboxlbl">{MVERTICAL_LABEL}</div></td>
		<td>{MPINALL}<div class="ngchkboxlbl">{MPINALL_LABEL}</div></td>
		<td>{MPUBLIC}<div class="ngchkboxlbl">{MPUBLIC_LABEL}</div></td>
	</tr><tr>
		<td class="txtright"><a href="ngmenu/op/view/mname/{VIEW}">{VIEW_LABEL}</a>&nbsp;</td>
		<td class="txtright"><span id="phpws_form_mpinpoint_label" >{MPINPOINT_LABEL}:</span></td><td>{MPINPOINT}</td>
		<td class="txtright"><span id="phpws_form_mpinpage_label" >{MPINPAGE_LABEL}:</span></td><td>{MPINPAGE}</td>
		<td colspan="3"><span id="phpws_form_mlang_label" > {MLANG_LABEL}: </span>{MLANG}</td>
	</tr>
</table>
<div id="ngmenumsg">{MSG}</div>
<div id="ngmenutxt">
	<div id="ngmenutxtn"></div>
	<textarea id="ngmenutxta" name="ngmenutxta" class="tabby">{EDITOR}</textarea>
</div>
{END_FORM}
</div>
