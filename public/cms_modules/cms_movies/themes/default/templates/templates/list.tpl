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
					var potvrdenie = confirm('{insert name='tr' value='Pozor táto operácia je nevratná, vybraná položka sa navždy vymaže !!! Vymazať ?'}')
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
					<td><img class="img_middle" src="{insert name='merge' value1=$path_relative value2='themes/default/images/movies.png'}" alt="" />&nbsp;&nbsp;{insert name='tr' value='Kino - program'}</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr><td colspan="3" class="td_link_v"></td></tr>
	{foreach name='movie' from=$movies_list item='movie_id' }
	{/foreach}
	{assign var='max_list' value=$smarty.foreach.movie.iteration}
	<tr>
		<td class="td_middle_left">
		{insert name='merge' value1=$path_relative value2='themes/default/scripts/toolbar.php' assign='path_toolbar'}
		{include_php file=$path_toolbar}
		</td>
		<td class="td_link_h"><img src="themes/default/images/pixel.gif" width="2" /></td>
		{assign var=showItem value=0}
        		{assign var=showItemEdit value=0}
        		{assign var=showProduct value=0}
			
            {if ($user_login->checkPrivilege(109, $privilege_view) eq 1)}
               {assign var=showItem value=1}
            {else}
               {assign var=showItem value=0} 
            {/if}
    		  
            {if ($user_login_type eq $admin_user)}
                {assign var=showItem value=1 }
            {/if}
    		
    		{if ($user_login->checkPrivilege(109, $privilege_update) eq 1)}
                {assign var=showItemEdit value=1}
            {else}
                {assign var=showItemEdit value=0}
            {/if}
           
            {if ($user_login_type eq $admin_user)}
                {assign var=showItemEdit value=1}
            {/if}
            
			{if (($user_login->checkPrivilege(109, $privilege_update) eq 1) OR ($user_login->checkPrivilege(1050001, $privilege_delete) eq 1) OR ($user_login->checkPrivilege(1050001, $privilege_add) eq 1))}
           		{assign var=showCheckbox value=1}
        	{else}
				{assign var=showCheckbox value=0}
        	{/if}
        	
        	{if ($user_login_type eq $admin_user)}
            	{assign var=showCheckbox value=1}
       		{/if}
		<td class="td_middle_center">
			<table class="tb_list">

				<tr class="tr_header">
					<td class="td_align_center">#</td>
					<td><input title="vybrať všetko / zrušiť všetko" id="ab" type="checkbox" name="selectall" value="1" onclick="selectall('form1',1,{$max_list})" /></td>
					<td>{insert name='tr' value='Názov'}</td>
					<td class="td_align_center">{insert name='tr' value='Viditeľnosť'}</td>
				</tr>
				<form name="form1" id="form1" method="post" action="../modules/cms_movies/action.php">
				<input type="hidden" id="mcmd" name="mcmd" value="{$mcmd}" />
				<input type="hidden" id="section" name="section" value="edit" />
			{foreach name='movie' from=$movies_list item='movie_id'}
					{$movie_id->setContextLanguage($localLanguage)}
					{assign var=defaultView value=0}
					{if ($movie_id->getTitle() eq '')}
						{$movie_id->setContextLanguage($localLanguageDefault)}
						{assign var=defaultView value=1}
					{/if}
				<tr><td colspan="8" class="td_link_space"></td></tr>
				<tr onmouseover="pozadie('#f5f5f5',this)" onmouseout="pozadie('#ffffff',this)">
					<td class="td_align_center">{$smarty.foreach.movie.iteration}</td>
					<td><input {if $showCheckbox eq 0}disabled="disabled"{/if} id="box{$smarty.foreach.movie.iteration}" type="checkbox" name="row_id[]" value="{$movie_id->getId()}" /></td>
					<td>
						{if $showItem eq 1}
						<a href="./?module={$module}&mcmd=3&row_id[]={$movie_id->getId()}">
						{if $defaultView eq 1}{$defaultViewStartTag}{/if}
							{$movie_id->getTitle()}
						{if $defaultView eq 1}{$defaultViewEndTag}{/if}
						</a>
						{else}
						{if $defaultView eq 1}{$defaultViewStartTag}{/if}
							{$movie_id->getTitle()}
						{if $defaultView eq 1}{$defaultViewEndTag}{/if}
						{/if}
					</td>
					<td class="td_align_center">{if $movie_id->getIsPublished() eq 1}
						{if $showItemEdit eq 1}
						<a href="#" onclick="listItemTask('form1',1,{$max_list},'c_isPublished',0,'box{$smarty.foreach.movie.iteration}')"><img src="themes/default/images/visible.gif" /></a>
						{else}
							<img src="themes/default/images/visible.gif" />
						{/if}
						{else}
						{if $showItemEdit eq 1}
						<a href="#" onclick="listItemTask('form1',1,{$max_list},'c_isPublished',1,'box{$smarty.foreach.movie.iteration}')"><img src="themes/default/images/hidden.gif" /></a>
						{else}
						<img src="themes/default/images/hidden.gif" />
						{/if}
						{/if}</td>
				</tr>
			{/foreach}
				</form>
			</table>
			<br />
		</td>
	</tr>
	<tr><td colspan="3" class="td_link_v"></td></tr>
</table>