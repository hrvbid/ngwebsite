<var id="ncl-{ID}" class="hidden vset" data-id="{ID}" data-name="{NAME}" data-mod="ncl"></var>
<div class="nclblock">
{TYPE_TITLE}: 
<select id="nclfcm-{ID}" name="nclfcm-{NAME}" class="nclfcselect nclfcselectm" data-pre="{ID}" onchange="nclFcM(this)">
<option value="I">Images</option>
<option value="D">Documents</option>
<option value="M">MultiMedia</option>
</select>
{FOLDER_TITLE}: 
<select id="nclfcf-{ID}" name="nclfcf-{NAME}" class="nclfcselect nclfcselectf" data-pre="{ID}" onchange="nclFcFc(this)" onClick="nclFcF(this)">
<option value=" ">...</option>
</select>
{FILES_TITLE}: 
<select id="nclfcp-{ID}" name="nclfcp-{NAME}" class="nclfcselect nclfcselectp" data-pre="{ID}" onchange="nclFcP(this)">
<option value=" ">...</option>
</select>
&nbsp;<a data-pre="{ID}" onClick="nclFcTnClear(this)">clear fields</a>
<textarea id="{ID}" name="{NAME}" class="nclarea"></textarea>
<div id="nclfctnfcf-{ID}" class="nclfcthumbs"> </div>
<div id="nclwrap-{ID}" class="nodisplay">{VALUE}</div>
</div>