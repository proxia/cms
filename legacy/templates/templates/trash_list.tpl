{literal}
<script language="JavaScript" type="text/javascript">
// start tabulator ***************************************************************
			var name_form = "form1";
			var max_list = 1;
			var max_list1 = 1;
			var max_list2 = 1;
			var max_list3 = 1;
			var max_list4 = 1;

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

	if(id == 2){
			name_form = "form3";
			max_list = max_list3;
		}

	if(id == 3){
			name_form = "form4";
			max_list = max_list4;
		}

}
// end tabulator ***************************************************************

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
					<td><img class="img_middle" src="images/trash_view.png" alt="" />&nbsp;&nbsp;{insert name='tr' value='Kôš'}</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr><td colspan="3" class="td_link_v"></td></tr>


	{foreach name='category' from=$trash_category_list item='category_id'}
	{/foreach}
	{assign var='max_list1' value=$smarty.foreach.category.iteration}

	{foreach name='article' from=$trash_article_list item='article_id'}
	{/foreach}
	{assign var='max_list2' value=$smarty.foreach.article.iteration}

	{foreach name='menu' from=$trash_menu_list item='menu_id'}
	{/foreach}
	{assign var='max_list3' value=$smarty.foreach.menu.iteration}

	{foreach name='weblink' from=$trash_weblink_list item='weblink_id'}
	{/foreach}
	{assign var='max_list4' value=$smarty.foreach.weblink.iteration}

	<script language="JavaScript" type="text/javascript">
		max_list1 = {$max_list1};
		max_list2 = {$max_list2};
		max_list3 = {$max_list3};
		max_list4 = {$max_list4};
	</script>
	<tr>
		<td class="td_middle_left">
			{include_php file="scripts/toolbar.php"}
		</td>
		<td class="td_link_h"><img src="images/pixel.gif" width="2" /></td>
		<td class="td_valign_top" align="center" width="100%">
			<table align="center" class="tb_tabs">
				<tr><td colspan="2"><br /></td></tr>
				<tr class="tr_header_tab">
					<td colspan="2" class="td_tabs_top">
					{$trash_menu}
					</td>
				</tr>
				<tr><td class="td_valign_top" colspan="2">
			<div id="blok0" style="display: none;">
			<table class="tb_list_in_tab" align="center">
				<tr class="tr_header">
					<td class="td_align_center">#</td>
					<td><input title="vybrať všetko / zrušiť všetko" id="ab" type="checkbox" name="selectall" value="1" onclick="selectall('form1',1,{$max_list1})" /></td>
					<td width="50%">{insert name='tr' value='Názov kategórie'}</td>
					<td>{insert name='tr' value='Nadradené menu'}</td>
					<td>{insert name='tr' value='Nadradená kategória'}</td>
				</tr>
				<form name="form1" id="form1" method="post" action="action.php">
				<input type="hidden" id="section" name="section" value="trash" />
				<input type="hidden" id="cmd" name="cmd" value="{$cmd}" />
				<input type="hidden" id="act" name="act" value="category" />
				<input type="hidden" id="showtable" name="showtable" value="0" />
			{foreach name='category' from=$trash_category_list item='category_id' }
				{$category_id->setContextLanguage($localLanguage)}
				{assign var=defaultView value=0}
				{if ($category_id->getTitle() eq '')}
					{$category_id->setContextLanguage($localLanguageDefault)}
					{assign var=defaultView value=1}
				{/if}
				<tr><td colspan="8" class="td_link_space"></td></tr>
				<tr onmouseover="pozadie('#f5f5f5',this)" onmouseout="pozadie('#ffffff',this)">
					<td class="td_align_center">{$smarty.foreach.category.iteration}</td>
					<td><input id="box{$smarty.foreach.category.iteration}" type="checkbox" name="row_id[]" value="{$category_id->getId()}" /></td>
					<td>

						{if $defaultView eq 1}{$defaultViewStartTag}{/if}
							{$category_id->getTitle()}
						{if $defaultView eq 1}{$defaultViewEndTag}{/if}

					</td>
					{insert name='getParentMenuList' id=$category_id->getId() class=$category_id assign=parentMenuList}
					<td>
						{foreach name='parentMenu' from=$parentMenuList item=parentMenu_id}
							{$parentMenu_id->getTitle()}
						{/foreach}
					</td>
					{insert name='getParentCategoryCat' id=$category_id->getId() assign=parentCategoryId}
					{insert name='getNameCategory' id=$parentCategoryId assign=parentCategory}
					<td>
						{$parentCategory}
					</td>
				</tr>
			{/foreach}
				</form>
			</table>
			</div>
			<div id="blok1" style="display: none;">
			<table class="tb_list_in_tab" align="center">
				<tr class="tr_header">
					<td class="td_align_center">#</td>
					<td><input title="vybrať všetko / zrušiť všetko" id="ab" type="checkbox" name="selectall" value="1" onclick="selectall('form2',1,{$max_list2})" /></td>
					<td width="50%">{insert name='tr' value='Názov článku'}</td>
					<td>{insert name='tr' value='Nadradené menu'}</td>
					<td>{insert name='tr' value='Nadradená kategória'}</td>
				</tr>
				<form name="form2" id="form2" method="post" action="action.php">
				<input type="hidden" id="section" name="section" value="trash" />
				<input type="hidden" id="cmd" name="cmd" value="{$cmd}" />
				<input type="hidden" id="act" name="act" value="article" />
				<input type="hidden" id="showtable" name="showtable" value="1" />
			{foreach name='article' from=$trash_article_list item='article_id' }
			{$article_id->setContextLanguage($localLanguage)}
				{assign var=defaultView value=0}
				{if ($article_id->getTitle() eq '')}
					{$article_id->setContextLanguage($localLanguageDefault)}
					{assign var=defaultView value=1}
				{/if}
				<tr><td colspan="8" class="td_link_space"></td></tr>
				<tr onmouseover="pozadie('#f5f5f5',this)" onmouseout="pozadie('#ffffff',this)">
					<td class="td_align_center">{$smarty.foreach.article.iteration}</td>
					<td><input id="box{$smarty.foreach.article.iteration}" type="checkbox" name="row_id[]" value="{$article_id->getId()}" /></td>
					<td>

							{if $defaultView eq 1}{$defaultViewStartTag}{/if}
							{$article_id->getTitle()}
							{if $defaultView eq 1}{$defaultViewEndTag}{/if}

					</td>
					{insert name='getParentMenuList' id=$article_id->getId() class=$article_id assign=parentMenuList}
					<td>
						{foreach name='parentMenu' from=$parentMenuList item=parentMenu_id}
							{$parentMenu_id->getTitle()}
						{/foreach}
					</td>

					{insert name='getParentsCategoryArt' id=$article_id->getId() assign=parentCategoryList}
					<td>
						{foreach name='parentCategory' from=$parentCategoryList item=parentCategory_id}
							{$parentCategory_id->getTitle()}
						{/foreach}
					</td>
				</tr>
			{/foreach}
				</form>
			</table>
			</div>
			<div id="blok2" style="display: none;">
			<table class="tb_list_in_tab" align="center">
				<tr class="tr_header">
					<td class="td_align_center">#</td>
					<td><input title="vybrať všetko / zrušiť všetko" id="ab" type="checkbox" name="selectall" value="1" onclick="selectall('form3',1,{$max_list3})" /></td>
					<td width="90%">{insert name='tr' value='Názov menu'}</td>
				</tr>
				<form name="form3" id="form3" method="post" action="action.php">
				<input type="hidden" id="section" name="section" value="trash" />
				<input type="hidden" id="cmd" name="cmd" value="{$cmd}" />
				<input type="hidden" id="act" name="act" value="menu" />
				<input type="hidden" id="showtable" name="showtable" value="2" />
			{foreach name='menu' from=$trash_menu_list item='menu_id' }
			{$menu_id->setContextLanguage($localLanguage)}
				{assign var=defaultView value=0}
				{if ($menu_id->getTitle() eq '')}
					{$menu_id->setContextLanguage($localLanguageDefault)}
					{assign var=defaultView value=1}
				{/if}
				<tr><td colspan="8" class="td_link_space"></td></tr>
				<tr onmouseover="pozadie('#f5f5f5',this)" onmouseout="pozadie('#ffffff',this)">
					<td class="td_align_center">{$smarty.foreach.menu.iteration}</td>
					<td><input id="box{$smarty.foreach.menu.iteration}" type="checkbox" name="row_id[]" value="{$menu_id->getId()}" /></td>
					<td>

						{if $defaultView eq 1}{$defaultViewStartTag}{/if}
							{$menu_id->getTitle()}
						{if $defaultView eq 1}{$defaultViewEndTag}{/if}

					</td>
				</tr>
			{/foreach}
				</form>
			</table>
			</div>
			<div id="blok3" style="display: none;">
			<table class="tb_list_in_tab" align="center">
				<tr class="tr_header">
					<td class="td_align_center">#</td>
					<td><input title="vybrať všetko / zrušiť všetko" id="ab" type="checkbox" name="selectall" value="1" onclick="selectall('form4',1,{$max_list4})" /></td>
					<td width="50%">{insert name='tr' value='Názov odkazu'}</td>
					<td>{insert name='tr' value='Nadradené menu'}</td>
					<td>{insert name='tr' value='Nadradená kategória'}</td>
				</tr>
				<form name="form4" id="form4" method="post" action="action.php">
				<input type="hidden" id="section" name="section" value="trash" />
				<input type="hidden" id="cmd" name="cmd" value="{$cmd}" />
				<input type="hidden" id="act" name="act" value="weblink" />
				<input type="hidden" id="showtable" name="showtable" value="3" />
			{foreach name='weblink' from=$trash_weblink_list item='weblink_id' }
			{$weblink_id->setContextLanguage($localLanguage)}
				{assign var=defaultView value=0}
				{if ($weblink_id->getTitle() eq '')}
					{$weblink_id->setContextLanguage($localLanguageDefault)}
					{assign var=defaultView value=1}
				{/if}
				<tr><td colspan="8" class="td_link_space"></td></tr>
				<tr onmouseover="pozadie('#f5f5f5',this)" onmouseout="pozadie('#ffffff',this)">
					<td class="td_align_center">{$smarty.foreach.weblink.iteration}</td>
					<td><input id="box{$smarty.foreach.weblink.iteration}" type="checkbox" name="row_id[]" value="{$weblink_id->getId()}" /></td>
					<td>

							{if $defaultView eq 1}{$defaultViewStartTag}{/if}
								{$weblink_id->getTitle()}
							{if $defaultView eq 1}{$defaultViewEndTag}{/if}

					</td>
					{insert name='getParentMenuList' id=$weblink_id->getId() class=$weblink_id assign=parentMenuList}
					<td>
						{foreach name='parentMenu' from=$parentMenuList item=parentMenu_id}
							{$parentMenu_id->getTitle()}
						{/foreach}
					</td>

					{insert name='getParentsCategoryWeblink' id=$weblink_id->getId() assign=parentCategoryList}
					<td>
						{foreach name='parentCategory' from=$parentCategoryList item=parentCategory_id}
							{$parentCategory_id->getTitle()}
						{/foreach}
					</td>
				</tr>
			{/foreach}
				</form>
			</table>
			</div>
		</td>
	</tr>
</table>
<br />
		</td>
	</tr>
	<tr><td colspan="3" class="td_link_v"></td></tr>
</table>
<script language="JavaScript" type="text/javascript">
	ukaz('{$showtable}','4')
</script>
