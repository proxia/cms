{literal}
<script language="JavaScript" type="text/javascript">
// start tabulator ***************************************************************
	var name_form = "form1";


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
		}

	if(id == 1){
			name_form = "form2";
		}

	if(id == 2){
			name_form = "form3";
		}


}
// end tabulator ***************************************************************

function pozadie (farba,idd){
		idd.style.background = farba;
	}

function send_form(the_form,min,max,act_type,act_value){
	  var basename = "box";
      pocetChecked = 0;

		submitform(act_type,act_value,the_form)

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

function insertfile(form_name,form_text_name){
		var x1 = 700;
		var y1 = 400;
     	var left = screen.width/2 - x1/2;
     	var top = screen.height/2 - y1/2;
    	window.open("./?cmd=29&form_name="+form_name+"&form_text_name="+form_text_name,"prehlad","scrollbars=yes,width="+x1+",height="+y1+",left="+left+",top="+top);
	}

</script>
{/literal}
<table class="tb_middle">
	<tr>
		<td colspan="3">
			<table class="tb_title">
				<tr>
					<td><img class="img_middle" src="images/options_view.png" alt="" />&nbsp;&nbsp;{insert name='tr' value='Hlavné nastavenia'}</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr><td colspan="3" class="td_link_v"></td></tr>

	<tr>
		<td class="td_middle_left">
			{include_php file="scripts/toolbar.php"}
		</td>
		<td class="td_link_h"><img src="images/pixel.gif" width="2" /></td>
		<td class="td_valign_top" align="center" width="100%">
			<table class="tb_tabs">
				<tr><td colspan="2"><br /></td></tr>
				<tr class="tr_header_tab">
					<td colspan="2" class="td_tabs_top">
					{$menu}
					</td>
				</tr>
				<tr><td class="td_valign_top" colspan="2">




			{foreach name='section' from=$options_list key='kluc' item='section_id'}
			<div id="blok{$smarty.foreach.section.iteration-1}" style="display: none;">
				<table class="tb_list">
				<form name="form{$smarty.foreach.section.iteration}" id="form{$smarty.foreach.section.iteration}" method="post" action="action.php">
					<input type="hidden" id="section" name="section" value="option" />
					<input type="hidden" id="cmd" name="cmd" value="{$cmd}" />
					<input type="hidden" id="sec_name" name="sec_name" value="{$kluc}" />
					<input type="hidden" id="showtable" name="showtable" value="{$smarty.foreach.section.iteration-1}" />
					<tr class="tr_header">
						<td class="td_align_center">#</td>
						<td>{insert name='tr' value='Názov kľúča'}</td>
						<td>{insert name='tr' value='Hodnota'}</td>
						<td></td>
					</tr>
					{foreach name='option' from=$section_id key='key_name' item='key_value'}
					<tr><td colspan="8" class="td_link_space"></td></tr>
					<tr onmouseover="pozadie('#f5f5f5',this)" onmouseout="pozadie('#ffffff',this)">
						<td class="td_align_center">{$smarty.foreach.option.iteration}</td>
						<td>{$key_value.name}</td>
						<td>{insert name='getGlobalForm' key_name=$key_value.name key_value=$key_value.value key_type=$key_value.type}</td>
						<td></td>
					</tr>
					{/foreach}
					</form>
				</table>
			</div>
			{/foreach}
			</td>
			</tr>
			</table>
			<br />
		</td>
	</tr>
	<tr><td colspan="3" class="td_link_v"></td></tr>
</table>
<script language="JavaScript" type="text/javascript">
	ukaz('{$showtable}','3')
</script>
