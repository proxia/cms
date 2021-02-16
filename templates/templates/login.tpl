{include file="top.tpl"}
<br><br><br><br><br>
<center>{$message}</center>
<br>
<table background="images/login.jpg" align="center" width="328" height="206" class="logintable" border="0">
	<tr>
		<td align="center" class="loginnormal" valign="middle" height="21"><b>&nbsp;&nbsp;{insert name='tr' value='PROXIA'} - {$site_name}</b></td>
		<td colspan="2" align="right" height="21"></td>
	</tr>
	<form action="action.php" method="post" name="loginform" id="loginform" />
	<input type="hidden" name="site_name" value="{$site_name}">
	<input type="hidden" name="login_form" value="1">
	<tr>
		<td width="110" align="center" rowspan="3"><br></td>
		<td width="60"><br><br><br><br><br>{insert name='tr' value='Username'}</td>
		<td width="50"><br><br><br><br><br><input type="text" name="login" id="login" size="20" />
	</tr>
	<tr>
		<td width="60" valign="top">{insert name='tr' value='Password'}</td>
		<td width="50" valign="top"><input type="password" name="heslo" id="heslo" size="20" /></td>
	</tr>
	<tr>
		<td></td>
		<td><input class="button" type="submit" value="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{insert name='tr' value='Login'}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" /></td>
	</tr>
	</form>
</table>
<script language="JavaScript" type="text/javascript">
	document.loginform.login.focus();
</script>
