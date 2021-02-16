{literal}
<script language="JavaScript" type="text/javascript">

function addelement(act_type,act_value){
	var newelement = document.createElement('INPUT'); 
	newelement.type = 'hidden'; 
	newelement.name = act_type; 
	newelement.value = act_value;
	document.form1.appendChild(newelement)
} 

function insertfile(form_name,form_text_name){
		var x1 = 700;
		var y1 = 400;
     	var left = screen.width/2 - x1/2;
     	var top = screen.height/2 - y1/2;
    	window.open("./?cmd=29&form_name="+form_name+"&form_text_name="+form_text_name,"prehlad","scrollbars=yes,width="+x1+",height="+y1+",left="+left+",top="+top);
} 

function submitform(act_type,act_value){
	addelement(act_type,act_value);
	
	try {
		document.form1.onsubmit();
		}
	catch(e){}
		document.form1.submit();
}

   // zoznam objektov ktore treba kontrolovat
	// E - kontrola na email
	// V - kontrola na retazec
	// N - kontrola na cislo
	// U - kontrola na url
	// H - kontrola na rovnost hesla musia byt dve polia z H alebo ziadne
	// "nazov pola" "min dlzka" "max dlzka" "typ kontroly"
	var pole=new Array(
			"f_title","0","100","V"
		);
</script>
{/literal}
{insert name=check}
{assign var='title' value='Atribút / detail'}
<table class="tb_middle">
	<tr>
		<td colspan="3">{include file="title_menu.tpl"}</td>
	</tr>
	<tr><td colspan="3" class="td_link_v"></td></tr>
	<tr>
		<td class="td_middle_left">
		{insert name='merge' value1=$path_relative value2='themes/default/scripts/toolbar.php' assign='path_toolbar'}
		{include_php file=$path_toolbar}
		</td>
		<td class="td_link_h"><img src="themes/default/images/pixel.gif" width="2" /></td>
		<td class="td_middle_center">
			<table class="tb_list">

				<tr class="tr_header">
					<td colspan="4">&nbsp;{insert name='tr' value='Detail atribútu'}</td>
				</tr>
				<form name="form1" id="form1" method="post" action="/vendor/cms_modules/cms_catalog/action.php">
				<input type="hidden" id="mcmd" name="mcmd" value="{$mcmd}" />
				<input type="hidden" id="row_id[]" name="row_id[]" value="{$detail_attribut->getId()}" />
				<input type="hidden" id="section" name="section" value="attribut" />
				{$detail_attribut->setContextLanguage("$localLanguage")}
				<tr><td colspan="4" class="td_link_space"></td></tr>
				<tr>
					<td>&nbsp;{insert name='tr' value='Názov'}*</td>
					<td width="85%" colspan="4"><input size="60" type="text" name="f_title" id="f_title" value="{$detail_attribut->getTitle()}" /></td>
				</tr>
				<tr>
					<td>&nbsp;{insert name='tr' value='Popis'}</td>
					<td width="85%" colspan="4"><input size="60" type="text" name="f_description" id="f_description" value="{$detail_attribut->getDescription()}" /></td>
				</tr>
				{php}
					$path = "..{$GLOBALS['project_folder']}/".$_SESSION['user']['name']."/mediafiles/".$GLOBALS['smarty']->get_template_vars(detail_attribut)->getImage();
					$name = basename($path);
					$GLOBALS["smarty"]->assign("icon_name",$name);
					$GLOBALS["smarty"]->assign("icon_path",$path);
				{/php} 
				<tr>
					<td>&nbsp;{insert name='tr' value='Obrázok'}</td>
					<td width="30%"><input size="40" type="text" name="f_image" id="f_image" value="{$detail_attribut->getImage()}" /></td>
	            	<td width="22"><a href="javascript:insertfile('form1','f_image')" title="{insert name='tr' value='vlož obrázok'}"><img src="../themes/default/images/paste.gif" width="21" height="21" border="0"></a></td>
					{if ($detail_attribut->getImage() eq '')}
	                	<td width=22>&nbsp;</td>
	             	{else}
	                 	<td width=22>&nbsp;<a  href="{$icon_path}" target="_blank" title="{insert name='tr' value='ukáž'}"><img src="../themes/default/images/view_s.png" border="0"></a></td>
	             	{/if}
	             </tr>
			</table>
			</form>
		</td>
	</tr>
	<tr><td colspan="3" class="td_link_v"></td></tr>
</table>