<var id="ncl-{ID}" class="hidden vset" data-id="{ID}" data-iid="{ID}" data-name="{NAME}" data-mod="ncl" data-from="{MOD}" data-use="vpool"></var>
<div class="nclblock">
{TYPE_TITLE}: 
<select id="nclfcm-{ID}" name="nclfcm-{NAME}" class="nclfcselect nclfcselectm" data-iid="{ID}" onchange="tao.run.ncl.nclFcM(this)">
<option value="I">Images</option>
<option value="D">Documents</option>
<option value="M">MultiMedia</option>
</select>
{FOLDER_TITLE}: 
<select id="nclfcf-{ID}" name="nclfcf-{NAME}" class="nclfcselect nclfcselectf" data-iid="{ID}" onchange="tao.run.ncl.nclFcFc(this)" onClick="tao.run.ncl.nclFcF(this)">
<option value=" ">...</option>
</select>
{FILES_TITLE}: 
<select id="nclfcp-{ID}" name="nclfcp-{NAME}" class="nclfcselect nclfcselectp" data-iid="{ID}" onchange="tao.run.ncl.nclFcP(this)">
<option value=" ">...</option>
</select>
&nbsp;<a data-iid="{ID}" onClick="tao.run.ncl.nclFcTnClear(this)">clear fields</a>
<div id="nclfctnfcd-{ID}">
	<div class="nclfctnneg">&nbsp;</div>
	<div id="nclfctnfcf-{ID}" class="nclfcthumbs"> </div>
	<div class="nclfctnneg">&nbsp;</div>
</div>
<textarea id="{ID}" name="{NAME}" class="nclarea"></textarea>
<div id="nclwrap-{ID}" class="nodisplay">{VALUE}</div>
</div>
