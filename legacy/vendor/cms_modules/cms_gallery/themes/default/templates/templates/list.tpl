{literal}
<script language="JavaScript" type="text/javascript">
function pozadie (farba,idd){
		idd.style.background = farba;
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
					sel_value = 2
				if (do_check == false)
					sel_value = 1
        }
    }

    return true;
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
							submitform(act_type,act_value);
							return;
						}
					else
							return false;
				}
			submitform(act_type,act_value);
		}
  }


function listItemTask(the_form,min,max,act_type,act_value,row){
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
			submitform(act_type,act_value)
		}
  }

function addelement(act_type,act_value){
	var newelement = document.createElement('INPUT');
	newelement.type = 'hidden';
	newelement.name = act_type;
	newelement.value = act_value;
	document.form1.appendChild(newelement)
}

function submitform(act_type,act_value){
	addelement(act_type,act_value);
	try {
		document.form1.onsubmit();
		}
	catch(e){}
		document.form1.submit();
}
</script>
{/literal}
<table class="tb_middle">
	<tr>
		<td colspan="3">
			<table class="tb_title">
				<tr>
					<td><img class="img_middle" src="{insert name='merge' value1=$path_relative value2='themes/default/images/gallery_view.png'}" alt="" />&nbsp;&nbsp;{insert name='tr' value='Manažér Fotogalérií'}</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr><td colspan="3" class="td_link_v"></td></tr>
	{foreach name='gallery' from=$gallery_list item='gallery_id' }
	{/foreach}
	{assign var='max_list' value=$smarty.foreach.gallery.iteration}
	<tr>
		<td class="td_middle_left">
		{insert name='merge' value1=$path_relative value2='themes/default/scripts/toolbar.php' assign='path_toolbar'}
		{include_php file=$path_toolbar}
		</td>
		<td class="td_link_h"><img src="themes/default/images/pixel.gif" width="2" /></td>
		<td class="td_middle_center">
			<table class="tb_list">

				<tr class="tr_header">
					<td class="td_align_center">#</td>
					<td><input title="vybrať všetko / zrušiť všetko" id="ab" type="checkbox" name="selectall" value="1" onclick="selectall('form1',1,{$max_list})" /></td>
					<td>{insert name='tr' value='Názov fotogalérie'}</td>
					<td>{insert name='tr' value='Obrázky fotogalérie'}</td>
					<td>{insert name='tr' value='Zmena poradia obrázkov'}</td>
					<td class="td_align_center">{insert name='tr' value='Viditeľnosť'}</td>
				</tr>
				<form name="form1" id="form1" method="post" action="../modules/cms_gallery/action.php">
				<input type="hidden" id="mcmd" name="mcmd" value="{$mcmd}" />
				<input type="hidden" id="section" name="section" value="edit" />
				{foreach name='gallery' from=$gallery_list item='gallery_id'}
					{$gallery_id->setContextLanguage($localLanguage)}
					{assign var=defaultView value=0}
					{if ($gallery_id->getTitle() eq '')}
						{$gallery_id->setContextLanguage($localLanguageDefault)}
						{assign var=defaultView value=1}
					{/if}
					<tr><td colspan="8" class="td_link_space"></td></tr>
					<tr onmouseover="pozadie('#f5f5f5',this)" onmouseout="pozadie('#ffffff',this)">
					<td class="td_align_center">{$smarty.foreach.gallery.iteration}</td>
					<td><input id="box{$smarty.foreach.gallery.iteration}" type="checkbox" name="row_id[]" value="{$gallery_id->getId()}" /></td>
					<td>
  					{if (($user_login->checkPrivilege(103, $privilege_view) eq 1) OR ($user_login->checkPrivilege(103, $privilege_update) eq 1) OR ($user_login_type eq $admin_user))}
            			<a href="./?module={$module}&mcmd=3&row_id[]={$gallery_id->getId()}">
						{if $defaultView eq 1}{$defaultViewStartTag}{/if}
							{$gallery_id->getTitle()}
						{if $defaultView eq 1}{$defaultViewEndTag}{/if}
					   </a>
					   {else}
					  {if $defaultView eq 1}{$defaultViewStartTag}{/if}
							{$gallery_id->getTitle()}
						{if $defaultView eq 1}{$defaultViewEndTag}{/if}
            		{/if}
					</td>
					<td><a href="./?module={$module}&mcmd=4&row_id[]={$gallery_id->getId()}"><img src="../themes/default/images/photo_s.png"></td>
					<td><a href="./?module={$module}&mcmd=5&row_id[]={$gallery_id->getId()}"><img src="../themes/default/images/all_m_restore.png" width="16"></td>
					<td class="td_align_center">
					{if $gallery_id->getIsPublished() eq 1}
					{if (($user_login->checkPrivilege(103, $privilege_update) eq 1) OR ($user_login_type eq $admin_user))}
					<a href="#" onclick="listItemTask('form1',1,{$max_list},'f_isPublished',0,'box{$smarty.foreach.gallery.iteration}')"><img src="../themes/default/images/visible.gif" /></a>
					{else}
					<img src="../themes/default/images/visible.gif" />
					{/if}
					{else}
					{if (($user_login->checkPrivilege(103, $privilege_update) eq 1) OR ($user_login_type eq $admin_user))}
						<a href="#" onclick="listItemTask('form1',1,{$max_list},'f_isPublished',1,'box{$smarty.foreach.gallery.iteration}')"><img src="../themes/default/images/hidden.gif" /></a>
					{else}
						<img src="../themes/default/images/hidden.gif" />
					{/if}
					{/if}
				</td>
				</tr>
				{/foreach}
				</form>
			</table>
			{include file="Proxia:default.pager" list=$gallery_list}
			<br />
		</td>
	</tr>
	<tr><td colspan="3" class="td_link_v"></td></tr>
</table>
