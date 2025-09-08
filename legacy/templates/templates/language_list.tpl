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
			if (document.forms[the_form].elements[basename + i].disabled == false ){
	            document.forms[the_form].elements[basename + i].checked = do_check;
					if (do_check == true)
						sel_value = 2
					if (do_check == false)
						sel_value = 1
			}
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

</script>
{/literal}
<table class="tb_middle">
	<tr>
		<td colspan="3">
			<table class="tb_title">
				<tr>
					<td><img class="img_middle" src="images/language_view.png" alt="" />&nbsp;&nbsp;{insert name='tr' value='Manažér jazykov'}</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr><td colspan="3" class="td_link_v"></td></tr>
	{foreach name='language' from=$language_list item='language_id' }
	{/foreach}
	{assign var='max_list' value=$smarty.foreach.language.iteration}
	<tr>
		<td class="td_middle_left">
			{include_php file="scripts/toolbar.php"}
		</td>
		<td class="td_link_h"><img src="images/pixel.gif" width="2" /></td>
		<td class="td_middle_center">
			<table class="tb_list">

				<tr class="tr_header">
					<td class="td_align_center">#</td>
					<td></td>
					<td>{insert name='tr' value='Názov jazyka'}</td>
					<td>{insert name='tr' value='Skratka jazyka'}</td>
					<td class="td_align_center">{insert name='tr' value='Globálna viditeľnosť'}</td>
					<td class="td_align_center">{insert name='tr' value='Lokálna viditeľnosť'}</td>
				</tr>
				<form name="form1" id="form1" method="post" action="action.php">
				<input type="hidden" id="section" name="section" value="language" />
				<input type="hidden" id="cmd" name="cmd" value="{$cmd}" />
			{foreach name='language' from=$language_list item='language_id'}
				<tr><td colspan="7" class="td_link_space"></td></tr>
		{assign var=showItem value=0}
		{assign var=showItemMenu value=0}
		{assign var=showCheckbox value=0}

        {if ($user_login->checkPrivilege(4, $privilege_update) eq 1)}
           {assign var=showItem value=1}
        {else}
           {assign var=showItem value=0}
        {/if}

        {if ($user_login_type eq $admin_user)}
            {assign var=showItem value=1 }
        {/if}

		{if ($user_login->checkPrivilege(4, $privilege_update) eq 1) OR ($user_login->checkPrivilege(4, $privilege_delete) eq 1) OR ($user_login->checkPrivilege(4, $privilege_restore) eq 1)}
           {assign var=showCheckbox value=1}
        {else}
           {assign var=showCheckbox value=0}
        {/if}

        {if ($user_login_type eq $admin_user)}
            {assign var=showCheckbox value=1}
        {/if}
				<tr onmouseover="pozadie('#f5f5f5',this)" onmouseout="pozadie('#ffffff',this)">
					<td class="td_align_center">{$smarty.foreach.language.iteration}</td>
					<td><input {if $showCheckbox eq 0}disabled="disabled"{/if} id="box{$smarty.foreach.language.iteration}" id="row_id[]" type="radio" name="row_id[]" value="{$language_id.code}" /></td>
					<td>
							{$language_id.native_name}
					</td>
					<td>{$language_id.code}</td>
					<td class="td_align_center">
						{if $language_id.global_visibility eq 1}
							{if $showItem eq 1}
							<a href="#" onclick="listItemTask('form1',1,{$max_list},'f_global_visibility',0,'box{$smarty.foreach.language.iteration}')"><img src="images/visible.gif" /></a>
							{else}
							<img src="images/visible.gif" />
							{/if}
						{else}
							{if $showItem eq 1}
							<a href="#" onclick="listItemTask('form1',1,{$max_list},'f_global_visibility',1,'box{$smarty.foreach.language.iteration}')"><img src="images/hidden.gif" /></a>
							{else}
							<img src="images/hidden.gif" />
							{/if}
						{/if}
					</td>
					<td class="td_align_center">
						{if $language_id.local_visibility eq 1}
							{if $showItem eq 1}
							<a href="#" onclick="listItemTask('form1',1,{$max_list},'f_local_visibility',0,'box{$smarty.foreach.language.iteration}')"><img src="images/visible.gif" /></a>
							{else}
							<img src="images/visible.gif" />
							{/if}
						{else}
							{if $showItem eq 1}
							<a href="#" onclick="listItemTask('form1',1,{$max_list},'f_local_visibility',1,'box{$smarty.foreach.language.iteration}')"><img src="images/hidden.gif" /></a>
							{else}
							<img src="images/hidden.gif" />
							{/if}
						{/if}
						</td>
 				</tr>
			{/foreach}
				</form>
			</table>
			<br />
		</td>
	</tr>
	<tr><td colspan="3" class="td_link_v"></td></tr>
</table>
