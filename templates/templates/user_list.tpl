{literal}
<script language="JavaScript" type="text/javascript">

// start tabulator ***************************************************************
			var name_form = "form1";
			var max_list = 1;
			var max_list1 = 1;
			var max_list2 = 1;
			
function showtd(id){
	var style=document.getElementById(id).style;
	style.backgroundColor = "#ffffff";
	style.borderBottom = "0px";
}

function showtdhref(id){
	var style=document.getElementById(id).style;
	style.backgroundColor = "#ffffff";
	style.fontWeight = "normal";
	style.color = "#cc3333";
}

function hiddentd(id){
	var style=document.getElementById(id).style;
	style.backgroundColor = "#dedede";
	style.borderBottomWidth = "1px";
	style.borderStyle = "solid";
	style.borderColor = "#bcbcbc";
}

function hiddentdhref(id){
	var style=document.getElementById(id).style;
	style.backgroundColor = "#dedede";
	style.fontWeight = "normal";
	style.color = "#000000";
}

function hiddenblok(id){
	var style=document.getElementById(id).style;
	style.display = "none";
}

function showblok(id){
	//alert(id);
	var style=document.getElementById(id).style;
	style.display = "block";
}

function view(id){
	//alert(id);
	var style=document.getElementById(id).style;
	style.display = "block";
}

function ukaz(id,num_block){
	for (block=0;block<num_block;block=block+1){

			var b = "b"+block;
		//	hiddentd(b);
			var bh = "bh"+block;
		//	hiddentdhref(bh);
			var blok = "blok"+block;
			hiddenblok(blok);
		}
	var pid = "b"+id;
	var pid2 = "bh"+id;
	var pid3 = "blok"+id;
	
	//showtd(pid);
	//showtdhref(pid2);
	showblok(pid3);
	
	if(id == 0){
			name_form = "form1";
			max_list = max_list1;
		}
	
	if(id == 1){
			name_form = "form2";
			max_list = max_list2;
		}
	
}
// end tabulator ***************************************************************



function pozadie (farba,idd){
		idd.style.background = farba;
	}
			var max_list1 = 1;
			var max_list2 = 1;
			
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
			submitform(act_type,act_value,the_form)
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
			submitform(act_type,act_value,the_form)
		}
  }

function addelement(act_type,act_value,the_form){
	var newelement = document.createElement('INPUT'); 
	newelement.type = 'hidden'; 
	newelement.name = act_type; 
	newelement.value = act_value;
	document.forms[the_form].appendChild(newelement)
} 

function submitform(act_type,act_value,the_form){
	addelement(act_type,act_value,the_form);
	try {
		document.forms[the_form].onsubmit();
		}
	catch(e){}
		document.forms[the_form].submit();
}
</script>
{/literal}
<table class="tb_middle">
	<tr>
		<td colspan="3">
			<table class="tb_title">
				<tr>
					<td><img class="img_middle" src="images/user_view.png" alt="" />&nbsp;&nbsp;{insert name='tr' value='Manažér používateľov'}</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr><td colspan="3" class="td_link_v"></td></tr>
	{foreach name='user' from=$normal_user_list item='user_id'}
	{/foreach}
	{assign var='max_list1' value=$smarty.foreach.user.iteration}
	<script language="JavaScript" type="text/javascript">
		max_list1 = {$max_list1};
	</script>
	<tr>
		<td class="td_middle_left">
			{include_php file="../scripts/toolbar.php"}
		</td>
		<td class="td_link_h"><img src="images/pixel.gif" width="2" /></td>

		<td class="td_middle_center">

			<div align="left">{$tabs}</div>

			<div id="blok0" style="display: none;">

				<table class="tb_list">
					<tr class="tr_header">
						<td class="td_align_center">#</td>
						<td><input title="vybrať všetko / zrušiť všetko" id="ab" type="checkbox" name="selectall" value="1" onclick="selectall('form1',1,{$max_list1})" /></td>
						<td>{insert name='tr' value='Priezvisko a Meno'}</td>
						<td>{insert name='tr' value='Prihlasovacie meno'}</td>
						<td>{insert name='tr' value='Email'}</td>
						<td>{insert name='tr' value='Posledné prihlásenie'}</td>
						<td class="td_align_center">{insert name='tr' value='Viditeľnosť'}</td>
						<td class="td_align_center">{insert name='tr' value='ID používateľa'}</td>

					</tr>
					<form name="form1" id="form1" method="post" action="action.php">
					<input type="hidden" id="section" name="section" value="user" />
					<input type="hidden" id="cmd" name="cmd" value="{$cmd}" />
					<input type="hidden" id="go" name="go" value="0" />
					<input type="hidden" id="showtable" name="showtable" value="0" />
				{foreach name='user' from=$normal_user_list item='user_id'}
				{$user_id->setContextLanguage("$localLanguage")}
					<tr><td colspan="8" class="td_link_space"></td></tr>
		{assign var=showItem1 value=0}	
		{assign var=showItem2 value=0}	
		{assign var=showCheckbox value=0}
		
        {if ($user_login->checkPrivilege(8, $privilege_view) eq 1)}
           {assign var=showItem1 value=1}
        {else}
           {assign var=showItem1 value=0} 
        {/if}
		  
        {if ($user_login_type eq $admin_user)}
            {assign var=showItem1 value=1 }
        {/if}
		
        {if ($user_login->checkPrivilege(8, $privilege_update) eq 1)}
           {assign var=showItem2 value=1}
        {else}
           {assign var=showItem2 value=0} 
        {/if}
		  
        {if ($user_login_type eq $admin_user)}
            {assign var=showItem2 value=1 }
        {/if}
					<tr onmouseover="pozadie('#f5f5f5',this)" onmouseout="pozadie('#ffffff',this)">
						<td class="td_align_center">{$smarty.foreach.user.iteration}</td>
						<td><input {if $showItem2 eq 0}disabled="disabled"{/if} id="box{$smarty.foreach.user.iteration}" type="checkbox" name="row_id[]" value="{$user_id->getId()}" /></td>
						<td>
						{if $showItem1 eq 1}
							<a href="./?cmd=18&row_id[]={$user_id->getId()}">
								{$user_id->getFamilyname()}&nbsp;{$user_id->getFirstname()}
							</a>
						{else}
							{$user_id->getFamilyname()}&nbsp;{$user_id->getFirstname()}
						{/if}
						</td>
						<td>
							{$user_id->getLogin()}
						</td>
						<td>
							{$user_id->getEmail()}
						</td>
						<td>
							{$user_id->getLastLogin()}
						</td>
						<td class="td_align_center">
							{if $user_id->getIsEnabled() eq 1}
								{if $showItem2 eq 1}
								<a href="#" onclick="listItemTask('form1',1,{$max_list1},'f_isEnabled',0,'box{$smarty.foreach.user.iteration}')"><img src="images/visible.gif" /></a>
								{else}
								<img src="images/visible.gif" />
								{/if}
							{else}
								{if $showItem2 eq 1}
								<a href="#" onclick="listItemTask('form1',1,{$max_list1},'f_isEnabled',1,'box{$smarty.foreach.user.iteration}')"><img src="images/hidden.gif" /></a>
								{else}
								<img src="images/hidden.gif" />
								{/if}
							{/if}
						</td>
						<td class="td_align_center">{$user_id->getId()}</td>
					</tr>
				{/foreach}

					</form>
				</table>
				<br />

			</div>

			<div id="blok1" style="display: none;">
	{foreach name='user' from=$editor_user_list item='user_id'}
	{/foreach}
	{assign var='max_list2' value=$smarty.foreach.user.iteration}
	<script language="JavaScript" type="text/javascript">
		max_list2 = {$max_list2};
	</script>
				<table class="tb_list">
					<tr class="tr_header">
						<td class="td_align_center">#</td>
						<td><input title="vybrať všetko / zrušiť všetko" id="ab" type="checkbox" name="selectall" value="1" onclick="selectall('form2',1,{$max_list2})" /></td>
						<td>{insert name='tr' value='Priezvisko a Meno'}</td>
						<td class="td_align_center">{insert name='tr' value='Viditeľnosť'}</td>
						<td class="td_align_center">{insert name='tr' value='ID používateľa'}</td>
					</tr>
					<form name="form2" id="form2" method="post" action="action.php">
					<input type="hidden" id="section" name="section" value="user" />
					<input type="hidden" id="cmd" name="cmd" value="{$cmd}" />
					<input type="hidden" id="go" name="go" value="0" />
					<input type="hidden" id="showtable" name="showtable" value="1" />
				{foreach name='user' from=$editor_user_list item='user_id'}
				{$user_id->setContextLanguage("$localLanguage")}
					<tr><td colspan="8" class="td_link_space"></td></tr>
		{assign var=showItem1 value=0}	
		{assign var=showItem2 value=0}	
		{assign var=showCheckbox value=0}
		
        {if ($user_login->checkPrivilege(8, $privilege_view) eq 1)}
           {assign var=showItem1 value=1}
        {else}
           {assign var=showItem1 value=0} 
        {/if}
		  
        {if ($user_login_type eq $admin_user)}
            {assign var=showItem1 value=1 }
        {/if}
		
        {if ($user_login->checkPrivilege(8, $privilege_update) eq 1)}
           {assign var=showItem2 value=1}
        {else}
           {assign var=showItem2 value=0} 
        {/if}
		  
        {if ($user_login_type eq $admin_user)}
            {assign var=showItem2 value=1 }
        {/if}
<tr onmouseover="pozadie('#f5f5f5',this)" onmouseout="pozadie('#ffffff',this)">
						<td class="td_align_center">{$smarty.foreach.user.iteration}</td>
						<td><input {if $showItem2 eq 0}disabled="disabled"{/if} id="box{$smarty.foreach.user.iteration}" type="checkbox" name="row_id[]" value="{$user_id->getId()}" /></td>
						<td>
						{if $showItem1 eq 1}
							<a href="./?cmd=18&row_id[]={$user_id->getId()}">
								{$user_id->getFamilyname()}&nbsp;{$user_id->getFirstname()}
							</a>
						{else}
							{$user_id->getFamilyname()}&nbsp;{$user_id->getFirstname()}
						{/if}
						</td>
						<td class="td_align_center">
							{if $user_id->getIsEnabled() eq 1}
								{if $showItem2 eq 1}
								<a href="#" onclick="listItemTask('form2',1,{$max_list2},'f_isEnabled',0,'box{$smarty.foreach.user.iteration}')"><img src="images/visible.gif" /></a>
								{else}
								<img src="images/visible.gif" />
								{/if}
							{else}
								{if $showItem2 eq 1}
								<a href="#" onclick="listItemTask('form2',1,{$max_list2},'f_isEnabled',1,'box{$smarty.foreach.user.iteration}')"><img src="images/hidden.gif" /></a>
								{else}
								<img src="images/hidden.gif" />
								{/if}
							{/if}
						</td>
						<td class="td_align_center">{$user_id->getId()}</td>
					</tr>
				{/foreach}

					</form>
				</table>
				<br />

			</div>

		</td>
	</tr>

	<tr><td colspan="3" class="td_link_v"></td></tr>
</table>
<script language="JavaScript" type="text/javascript">
	ukaz('{$showtable}','2')
</script>