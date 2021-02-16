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
							submitform(the_form, act_type, act_value);
							return;
						}
					else
							return false;
				}
			submitform(the_form, act_type, act_value);
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
			submitform(the_form, act_type, act_value)
		}
  }

function addelement(the_form, act_type, act_value){
	var newelement = document.createElement('INPUT');
	newelement.type = 'hidden';
	newelement.name = act_type;
	newelement.value = act_value;
	l=eval("document."+the_form);
	l.appendChild(newelement)
}

function submitform(the_form, act_type, act_value)
{
	l=eval("document."+the_form);

	addelement(the_form, act_type, act_value);
	try {
		l.onsubmit();
		}
	catch(e){
		l.submit();
	}

}

// start tabulator ***************************************************************
var pole = new Array();

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
			// zoznam objektov ktore treba kontrolovat
			// E - kontrola na email
			// V - kontrola na retazec
			// N - kontrola na cislo
			// U - kontrola na url
			// H - kontrola na rovnost hesla musia byt dve polia z H alebo ziadne
			// "nazov pola" "min dlzka" "max dlzka" "typ kontroly"
			pole=new Array(
					"distribution","0","100","V",
					"template","0","100","V",
					"sender_email","0","100","E"
				);
		}

	if(id == 1){ // distribucny zoznam

			// zoznam objektov ktore treba kontrolovat
			// E - kontrola na email
			// V - kontrola na retazec
			// N - kontrola na cislo
			// U - kontrola na url
			// H - kontrola na rovnost hesla musia byt dve polia z H alebo ziadne
			// "nazov pola" "min dlzka" "max dlzka" "typ kontroly"
			{/literal}
			{if $go eq 'new' AND $showtable eq 1}
				pole=new Array(
						"f_title","0","100","V"
					);
			{elseif $go eq 'edit' AND $showtable eq 1}
				pole=new Array(
						"f_title","0","100","V"
					);
			{elseif $go eq 'list_recipients' AND $showtable eq 1}
				pole=new Array(
					);
			{elseif $go eq 'new_recipient' AND $showtable eq 1}
				pole=new Array(
						"f_email","0","100","E"
					);
			{elseif $go eq 'new_internal_recipient' AND $showtable eq 1}
				pole=new Array(
						"f_email","0","100","E"
					);
			{elseif $go eq 'new_file_recipients' AND $showtable eq 1}
				pole=new Array(
					);
			{else}
				pole=new Array(
					);
			{/if}
			{literal}
		}

	if(id == 2){

			// zoznam objektov ktore treba kontrolovat
			// E - kontrola na email
			// V - kontrola na retazec
			// N - kontrola na cislo
			// U - kontrola na url
			// H - kontrola na rovnost hesla musia byt dve polia z H alebo ziadne
			// "nazov pola" "min dlzka" "max dlzka" "typ kontroly"
			{/literal}
			{if $go eq 'new' AND $showtable eq 2}
				pole=new Array(
						"f_title","0","100","V",
						"f_description","0","100000","V"
					);
			{elseif $go eq 'edit' AND $showtable eq 2}
				pole=new Array(
						"f_title","0","100","V",
						"f_description","0","100000","V"
					);
			{else}
				pole=new Array(
					);
			{/if}
			{literal}
		}

	if(id == 3){
			// zoznam objektov ktore treba kontrolovat
			// E - kontrola na email
			// V - kontrola na retazec
			// N - kontrola na cislo
			// U - kontrola na url
			// H - kontrola na rovnost hesla musia byt dve polia z H alebo ziadne
			// "nazov pola" "min dlzka" "max dlzka" "typ kontroly"
			pole=new Array(
				);
		}

}
// end tabulator ***************************************************************
</script>
{/literal}
{insert name=checkMoreForm}
<table class="tb_middle">
	<tr>
		<td colspan="3">
			<table class="tb_title">
				<tr>
					<td><img class="img_middle" src="{insert name='merge' value1=$path_relative value2='themes/default/images/newsletter_view.png'}" alt="" />&nbsp;&nbsp;{insert name='tr' value='Newsletter'}</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table align="center" class="tb_tabs_full">
				<tr class="tr_header_tab">
					<td class="td_tabs_top">{$newsletter_menu}</td>
				</tr>
				<tr>
					<td class="td_valign_top">
						<div id="blok0" style="display: none;">
							<table class="tb_list_in_tab" align="center">
								<tr><td colspan="3"><br></td></tr>
								{foreach name='forum' from=$forum_list item='forum_id' }
								{/foreach}
								{assign var='max_list' value=$smarty.foreach.forum.iteration}
								<form name="send_form" id="send_form" method="post" action="../modules/cms_newsletter/action.php">
								<input type="hidden" id="mcmd" name="mcmd" value="1" />
								<input type="hidden" id="section" name="section" value="send" />
								<tr>
									<td class="td_middle_left">
										{assign var='toolbar_id' value=1}
										{insert name='merge' value1=$path_relative value2='themes/default/scripts/toolbar.php' assign='path_toolbar'}
										{include_php file=$path_toolbar}
									</td>
									<td></td>
									<td class="td_middle_center">
										<table class="tb_list_modul">
											<tr>
												<td>{insert name='tr' value='Distribučný zoznam'}*:</td>
												<td>
													<select name="distribution" id="distribution">
														<option value="">{insert name='tr' value='vyberte si distribučný zoznam'}</option>
														{foreach name='distrib_list' from=$distribution_list2 item='distrib_id' }
															<option value="{$distrib_id->getId()}">{$distrib_id->getTitle()}</option>
														{/foreach}
													</select>
												</td>
											</tr>
											<tr>
												<td>{insert name='tr' value='Zoznam Šablón'}*:</td>
												<td>
													<select name="template" id="template">
															<option value="">{insert name='tr' value='vyberte si šablónu'}</option>
														{foreach name='templates_list' from=$templates_list2 item='template_id' }
															<option value="{$template_id->getId()}">{$template_id->getTitle()}</option>
														{/foreach}
													</select>
												</td>
											</tr>
											<tr>
												<td>{insert name='tr' value='Poslať ako'}:</td>
												<td>
													<select name="send_type" id="send_type">
														<option value="{$FORMAT_HTML}">html</option>
														<option value="{$FORMAT_PLAIN_TEXT}">text</option>
													</select>
												</td>
											</tr>
											<tr>
												<td>{insert name='tr' value='Email odosielateľa'}*:</td>
												<td>
													<input type="text" name="sender_email" id="sender_email" value="" />
												</td>
											</tr>
											<tr>
												<td>{insert name='tr' value='Názov odosielateľa'}:</td>
												<td>
													<input type="text" name="sender_name" id="sender_name" value="" />
												</td>
											</tr>
										</table>
										<br />
									</td>
								</tr>
								</form>
							</table>
						</div>
						<div id="blok1" style="display: none;">
							{if $go eq 'new' AND $showtable eq 1}
								{include file=distribution_new.tpl}
							{elseif $go eq 'edit' AND $showtable eq 1}
								{include file=distribution_edit.tpl}
							{elseif $go eq 'list_recipients' AND $showtable eq 1}
								{include file=list_recipients.tpl}
							{elseif $go eq 'new_recipient' AND $showtable eq 1}
								{include file=new_recipient.tpl}
							{elseif $go eq 'new_internal_recipient' AND $showtable eq 1}
								{include file=new_internal_recipient.tpl}
							{elseif $go eq 'new_file_recipients' AND $showtable eq 1}
								{include file=new_file_recipients.tpl}
							{else}
								{include file=distribution_list.tpl}
							{/if}
						</div>
						<div id="blok2" style="display: none;">
							{if $go eq 'new' AND $showtable eq 2}
								{include file=template_new.tpl}
							{elseif $go eq 'edit' AND $showtable eq 2}
								{include file=template_edit.tpl}
							{else}
								{include file=templates_list.tpl}
							{/if}
						</div>
						<div id="blok3" style="display: none;">
							{if $go eq 'history_list_recipients' AND $showtable eq 3}
								{include file=history_list_recipients.tpl}
							{elseif $go eq 'history_template' AND $showtable eq 3}
								{include file=history_template.tpl}
							{else}
								{include file=history_list.tpl}
							{/if}
						</div>
					</td>
				</tr>
			</table>
		</td>
	</tr>

</table>
<script language="JavaScript" type="text/javascript">
	ukaz('{$showtable}','4')
</script>
