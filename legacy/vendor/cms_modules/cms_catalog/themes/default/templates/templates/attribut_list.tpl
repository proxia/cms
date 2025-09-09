{literal}
<script language="JavaScript" type="text/javascript">
var colorRowMouseOver = '#f5f5f5';
var colorRowMouseOut = '#ffffff';
var coloRowSelectedMouseOut = '#fbe6e6';
var coloRowSelectedMouseOver = '#f7cccc';

function pozadieIN (the_form, id){
	row_name = "row" + id;
	basename_checkbox = "box";
	
	if (document.forms[the_form].elements[basename_checkbox + id].checked)
		document.getElementById(row_name).style.background = coloRowSelectedMouseOver;
	else
		document.getElementById(row_name).style.background = colorRowMouseOver;
}

function pozadieOUT (the_form, id){
	row_name = "row" + id;
	basename_checkbox = "box";
	
	if (document.forms[the_form].elements[basename_checkbox + id].checked)
		document.getElementById(row_name).style.background = coloRowSelectedMouseOut;
	else
		document.getElementById(row_name).style.background = colorRowMouseOut;
}

function setRowBgColor(the_form, id){
	
	basename_checkbox = "box";
	row_name = "row" + id;
	is_check = document.forms[the_form].elements[basename_checkbox + id].checked;
	
	if (is_check){
		document.getElementById(row_name).style.background = coloRowSelectedMouseOut;
	}
	else{
		document.getElementById(row_name).style.background = colorRowMouseOut;
	}
}

var sel_value = 1;
function selectall(the_form, min, max){
	basename = "box";
	if (sel_value==2)
		do_check = false;
	if (sel_value==1)
		do_check = true;
    for (var i = min; i <= max; i++) {
        if (typeof(document.forms[the_form].elements[basename + i]) != 'undefined') {
            document.forms[the_form].elements[basename + i].checked = do_check;
				if (do_check == true)
					sel_value = 2;
				if (do_check == false)
					sel_value = 1;
			
			setRowBgColor (the_form, i);
        }
    }

    return true;
} 

function hiddencombo(id){
	
	var style=document.getElementById('combo'+id).style;
	style.visibility = "hidden";
	
}

function showcombo(id){
	{/literal}
		{foreach name='attribut' from=$attribut_list item='attribut_id' }
			hiddencombo({$smarty.foreach.attribut.iteration});
		{/foreach}
	{literal}
	var style=document.getElementById('combo'+id).style;
	style.visibility = "visible";
	
}

function ischecked(the_form,min,max,act_type,act_value){
	  var basename = "box";
      pocetChecked = 0;
      for (var i = min; i <= max; i++)
        {
			if (typeof(document.forms[the_form].elements[basename + i]) != 'undefined') {
            		if (document.forms[the_form].elements[basename + i].checked == true)
						pocetChecked++;
				}     			
        }
      if(pocetChecked == 0 ){
{/literal}
        	alert("{insert name='tr' value='Nevybrali ste žiadny záznam na spracovanie'}!");
{literal}
        	return false;
        }
		else{
		
				if ((act_type == "delete") && (act_value == 1)){
			{/literal}	
					var potvrdenie = confirm('{insert name='tr' value='Pozor táto operácia je nevratná, vybrané položky sa navždy vymažú !!! Vymazať ?'}')
			{literal}
					if (potvrdenie){
							submitform(act_type,act_value,the_form)
							return;
						}
					else
							return false;
				}
		
		
		
			submitform(act_type,act_value)
		}
  }

function listItemTask(the_form,min,max,act_type,act_value,act_type2,act_value2,row){
		document.forms[the_form].elements[row].checked = true;
	  var basename = "box";
      pocetChecked = 0;
      for (var i = min; i <= max; i++)
        {
			if (typeof(document.forms[the_form].elements[basename + i]) != 'undefined') {
            		if (document.forms[the_form].elements[basename + i].checked == true)
						pocetChecked++;
				}     			
        }
      if(pocetChecked == 0 ){
{/literal}
        	alert("{insert name='tr' value='Nevybrali ste žiadny záznam na spracovanie'}!");
{literal}
        	return false;
        }
		else{
		
		

		
		
			submitform(act_type,act_value,act_type2,act_value2)
		}
  }
  

function addelement(act_type,act_value){
	var newelement = document.createElement('INPUT'); 
	newelement.type = 'hidden'; 
	newelement.name = act_type; 
	newelement.value = act_value;
	document.form1.appendChild(newelement)
} 

function submitform(act_type,act_value,act_type2,act_value2){
	addelement(act_type,act_value);
	addelement(act_type2,act_value2);
	try {
		document.form1.onsubmit();
		}
	catch(e){}
		document.form1.submit();
}
</script>
{/literal}
{assign var='title' value='Atribúty / prehľad'}
<table class="tb_middle">
	<tr>
		<td colspan="3">{include file="title_menu.tpl"}</td>
	</tr>
	<tr><td colspan="3" class="td_link_v"></td></tr>
		{php}
					ob_start();
				{/php}
				
				{insert name='getOptionListBranch' catalog='$catalog_id' select=0 unselect=0 assign='strom'}
				{php}
					$GLOBALS['strom'] = ob_get_contents();
					ob_end_clean();
					$GLOBALS["smarty"]->assign("strom",$GLOBALS['strom']);
	{/php}
	{foreach name='attribut' from=$attribut_list item='attribut_id' }
	{/foreach}
	{assign var='max_list' value=$smarty.foreach.attribut.iteration}
	<tr>
		<td class="td_middle_left">
		{insert name='merge' value1=$path_relative value2='themes/default/scripts/toolbar.php' assign='path_toolbar'}
		{include_php file=$path_toolbar}
		</td>
		<td class="td_link_h"><img src="themes/default/images/pixel.gif" width="2" /></td>
		<td class="td_middle_center">
			<table class="tb_list2">
				{assign var="stlpcov" value=6}
				<tr class="tr_header">
					<td class="td_align_center">#</td>
					<td><input title="vybrať všetko / zrušiť všetko" id="ab" type="checkbox" name="selectall" value="1" onclick="selectall('form1',1,{$max_list})" /></td>
					<td>{insert name='tr' value='Názov atribútu'}</td>
					<td class="td_align_center">{insert name='tr' value='Priradiť k produktom'}</td>
					<td class="td_align_center">{insert name='tr' value='Odobrať z produktov'}</td>
					<td class="td_align_center">{insert name='tr' value='ID'}</td>
				</tr>
				<form name="form1" id="form1" method="post" action="/vendor/cms_modules/cms_catalog/action.php">
				<input type="hidden" id="mcmd" name="mcmd" value="{$mcmd}" />
				<input type="hidden" id="section" name="section" value="attribut" />
				<input type="hidden" id="go" name="go" value="list" />
				
{literal}
<script language="javascript">
window.onload = init; 
remo_x_pos = 0;
remo_y_pos = 0;
		
function init() {
 if (window.Event) {
 document.captureEvents(Event.MOUSEMOVE);
 } 
  document.onmousemove = getPosition;
 } 
 
 function getPosition(e) {
     e = e || window.event;
     var cursor = {x:0, y:0};
     if (e.pageX || e.pageY) {
         cursor.x = e.pageX;
         cursor.y = e.pageY;
     }
     else {
         cursor.x = e.clientX +
             (document.documentElement.scrollLeft ||
             document.body.scrollLeft) -
             document.documentElement.clientLeft;
         cursor.y = e.clientY +
             (document.documentElement.scrollTop ||
             document.body.scrollTop) -
             document.documentElement.clientTop;
     }
     remo_x_pos = cursor.x;
     remo_y_pos = cursor.y;

     return cursor;
}

 
function showDivCombo(row_selected){
            //alert (x_pos + " " + y_pos);
       sel_value = 2;
       {/literal}
       selectall('form1', 1,{$max_list})
       {literal}
       row = 'box'+row_selected;
       document.forms['form1'].elements[row].checked = true;
      if (document.all) {
        var remo_float_menu = document.all("divko2");
      } else if (document.layers) {
         var remo_float_menu = document.layers("divko2");
      } else if (document.getElementById) {
         var remo_float_menu = document.getElementById("divko2");
      } 
 
      remo_float_menu.style.left = remo_x_pos+"px";
      remo_float_menu.style.top = remo_y_pos-18+"px";  
      remo_float_menu.style.display = 'block';
      //alert (remo_y_pos);

}
function divko_hidden(){
	  if (document.all) {
        var remo_float_menu = document.all("divko2");
      } else if (document.layers) {
         var remo_float_menu = document.layers("divko2");
      } else if (document.getElementById) {
         var remo_float_menu = document.getElementById("divko2");
      } 
      remo_float_menu.style.display = 'none';
}
</script>
{/literal}
	<div id="divko2" name="divko2" style="padding:5px;text-align:right;display:none;height:40px;background-color:#f7e2d7;position:absolute;border:1px dotted gray">
		<span all><a href="javascript:divko_hidden()"><img src="../themes/default/images/delete_s.gif" /></a>
		<br />
		{if is_object($attribut_id)}
		<select name="filter_branch[{$attribut_id->getId()}]" onchange="form1.submit()">
			<option value=""></option>
			<option value="nofilter">{insert name='tr' value='zobraz všetky produkty'}</option>
			<option value="-1">{insert name='tr' value='nepriradené produkty'}</option>
			<optgroup label="{insert name='tr' value='filter podľa kategórií'}">
			{$strom}
			</optgroup>
		</select>
		{/if}
	</div>
	
	
			{foreach name='attribut' from=$attribut_list item='attribut_id'}
			
				{$attribut_id->setContextLanguage($localLanguage)}
				{assign var=defaultView value=0}
				{if ($attribut_id->getTitle() eq '')}
					{$attribut_id->setContextLanguage($localLanguageDefault)}
					{assign var=defaultView value=1}
				{/if}

				<tr>
					<td colspan="{$stlpcov}" class="td_link_space"></td>
				</tr>
				{assign var=showItem value=0}
        		{assign var=showItemEdit value=0}
			
            {if ($user_login->checkPrivilege(1050002, $privilege_view) eq 1)}
               {assign var=showItem value=1}
            {else}
               {assign var=showItem value=0} 
            {/if}
    		  
            {if ($user_login_type eq $admin_user)}
                {assign var=showItem value=1 }
            {/if}
    		            	
    		{if ($user_login->checkPrivilege(1050002, $privilege_update) eq 1)}
                {assign var=showItemEdit value=1}
            {else}
                {assign var=showItemEdit value=0}
            {/if}
           
            {if ($user_login_type eq $admin_user)}
                {assign var=showItemEdit value=1}
            {/if}
            
			{if (($user_login->checkPrivilege(1050002, $privilege_update) eq 1) OR ($user_login->checkPrivilege(1050002, $privilege_delete) eq 1) OR ($user_login->checkPrivilege(1050002, $privilege_add) eq 1))}
           		{assign var=showCheckbox value=1}
        	{else}
				{assign var=showCheckbox value=0}
        	{/if}
        	
        	{if ($user_login_type eq $admin_user)}
            	{assign var=showCheckbox value=1 }
       		{/if}
       		
				<tr id="row{$smarty.foreach.attribut.iteration}" onmouseover="pozadieIN('form1','{$smarty.foreach.attribut.iteration}')" onmouseout="pozadieOUT('form1','{$smarty.foreach.attribut.iteration}')">
					<td class="td_align_center">{$smarty.foreach.attribut.iteration+$start}</td>
					<td><input {if $showCheckbox eq 0}disabled="disabled"{/if} onclick="setRowBgColor('form1',{$smarty.foreach.attribut.iteration})"  id="box{$smarty.foreach.attribut.iteration}" type="checkbox" name="row_id[]" value="{$attribut_id->getId()}" /></td>
					<td>
						{if $showItem eq 1}
							<a href="./?module=CMS_Catalog&mcmd=9&row_id[]={$attribut_id->getId()}">
								{if $defaultView eq 1}{$defaultViewStartTag}{/if}
									{$attribut_id->getTitle()}
								{if $defaultView eq 1}{$defaultViewEndTag}{/if}
							</a>
						{else}
							{if $defaultView eq 1}{$defaultViewStartTag}{/if}
								{$attribut_id->getTitle()}
							{if $defaultView eq 1}{$defaultViewEndTag}{/if}
						{/if}
					</td>
					<td class="td_align_center" {if $showItemEdit eq 1}onclick="showDivCombo({$smarty.foreach.attribut.iteration})"{/if}>
						<img src="../themes/default/images/filter_s.gif" />
					</td>
					<td class="td_align_center">
						{if $showItemEdit eq 1}
							<a href="./?mcmd=14&module=CMS_Catalog&row_id[]={$attribut_id->getId()}"><img src="../themes/default/images/remove_s.gif" /></a>
						{else}
							<img src="../themes/default/images/remove_s.gif" />
						{/if}
					</td>
					<td class="td_align_center">{$attribut_id->getId()}</td>
				</tr>
			{/foreach}
				</form>
			</table>
			<br />
		</td>
	</tr>
	
	<tr><td colspan="3" class="td_link_v"></td></tr>
</table>