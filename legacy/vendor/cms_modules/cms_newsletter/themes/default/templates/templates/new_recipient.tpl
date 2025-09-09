<table class="tb_list_in_tab" align="center">
	<tr><td colspan="3"><br></td></tr>
	<tr>
		<td class="td_middle_left">
			{assign var='toolbar_id' value=7}
			{insert name='merge' value1=$path_relative value2='themes/default/scripts/toolbar.php' assign='path_toolbar'}
			{include_php file=$path_toolbar}
		</td>
		<td></td>
		<td class="td_middle_center">
			<table class="tb_list_modul">
	
				<tr class="tr_header">
					<td colspan="2">
						{$distribution_list->setContextLanguage("$localLanguage")}
						{insert name='tr' value='Distribučný zoznam'}: {$distribution_list->getTitle()}<br />
						{insert name='tr' value='Nový email'}
					</td>
				</tr>
				<form name="form_new_recipient" id="form_new_recipient" method="post" action="../modules/cms_newsletter/action.php">
					<input type="hidden" id="section" name="section" value="recipient" />
					<input type="hidden" id="showtable" name="showtable" value="2" />
					<input type="hidden" id="row_id" name="row_id[]" value="0" />
					<input type="hidden" id="distribution" name="distribution" value="{$distribution_list->getId()}" />
				<tr>
					<td>&nbsp;{insert name='tr' value='Email'}*</td>
					<td width="85%"><input size="60" type="text" name="f_email" id="f_email" /></td>
				</tr>
				<tr>
					<td>&nbsp;{insert name='tr' value='Meno'}</td>
					<td width="85%"><input size="60" type="text" name="f_firstName" id="f_firstName" /></td>
				</tr>
				<tr>
					<td>&nbsp;{insert name='tr' value='Priezvisko'}</td>
					<td width="85%"><input size="60" type="text" name="f_familyName" id="f_familyName" /></td>
				</tr>
				<tr>
					<td>&nbsp;{insert name='tr' value='Poznámka'}</td>
					<td width="85%"><input size="60" type="text" name="f_note" id="f_note" /></td>
				</tr>
				</form>
			</table>
			<br />
		</td>
	</tr>
</table>