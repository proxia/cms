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
			if ((act_type == "delete") && (act_value == 1)){
			{/literal}
					var potvrdenie = confirm('{insert name='tr' value='Pozor táto operácia je nevratná, vybrané položky sa navždy vymažú!!! Vymazať ?'}')
			{literal}
					if (potvrdenie){
							submitform(act_type,act_value);
							return;
						}
					else
							return false;
				}
			submitform(act_type,act_value)
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

function showPreview(path) {
	if (top.frames && top.frames['preview'])
		top.frames['preview'].document.location = "./?cmd=30&path=" + path;
}

</script>
{/literal}
<table class="tb_middle">
<form method="post" name="form_search" id="form_search">
	<tr>
		<td colspan="5">
			<table class="tb_title">
				<tr>
					<td><img class="img_middle" src="images/media_view.png" alt="" />&nbsp;&nbsp;{insert name='tr' value='Manažér médií'}&nbsp;[{$m_directory}]</td>
					<td class="td_align_right_bottom">
						{if $mediaView eq 'image'}
							<a href="./?cmd=26&m_directory={$m_directory}&setMediaView=list"><img src="images/list32.png"></a>
						{else}
							<img src="images/list32_check.png">
						{/if}
						{if $mediaView eq 'list'}
							<a href="./?cmd=26&m_directory={$m_directory}&setMediaView=image"><img src="images/image32.png"></a>
						{else}
							<img src="images/image32_check.png">
						{/if}
					</td>
				</tr>
			</table>
		</td>

	</tr>
	</form>
	<tr><td colspan="5" class="td_link_v"></td></tr>
	{foreach name='media' from=$media_list item='media_id' }
	{/foreach}
	{assign var='max_list' value=$smarty.foreach.media.iteration}
	<tr>
		<td class="td_middle_left">
			{include_php file="scripts/toolbar.php"}
		</td>
		<td class="td_link_h"><img src="images/pixel.gif" width="2" /></td>
		<td class="td_middle_center">

		{if $mediaView eq 'list'}
			{include file="media_list_list.tpl"}
		{elseif $mediaView eq 'image'}
			{include file="media_list_image.tpl"}
		{/if}

	<br />
		</td>
		<td class="td_link_h"><img src="images/pixel.gif" width="2" /></td>
		<td class="td_middle_center">
			<iframe width="300" frameborder="0" height="400" scrolling="no" name="preview" id="preview" src="./?cmd=30&path={$m_directory}"></iframe>
		</td>
	</tr>
	<tr><td colspan="5" class="td_link_v"></td></tr>
</table>
