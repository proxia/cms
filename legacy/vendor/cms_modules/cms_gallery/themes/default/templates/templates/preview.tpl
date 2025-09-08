{php}
$path = urldecode($_GET['path']);
$GLOBALS["smarty"]->assign("path_prilep",$path);
$GLOBALS["smarty"]->assign("paste",$_GET['paste'] ?? null);
$GLOBALS["smarty"]->assign("path","..".$GLOBALS['project_folder']."/".$_SESSION['user']['name']."/mediafiles$path");
$path = "..".$GLOBALS['project_folder']."/".$_SESSION['user']['name']."/mediafiles$path";
error_reporting(0);
$isDir = false;
$isFile = false;
$hasFtp = $GLOBALS['project_config']->hasFtp();
$ftpItem = null;

if($hasFtp){
	$ftp_username = $GLOBALS['project_config']->getFtpUser();
	$ftp_userpassword = $GLOBALS['project_config']->getFtpPassword();
	$ftp_server = $GLOBALS['project_config']->getFtpHost();

	$conn_id = ftp_connect($ftp_server);
	$login = ftp_login($conn_id, $ftp_username, $ftp_userpassword);
	
	$search = 'mediafiles/';
	$basePath = substr($path, strpos($path, $search) + strlen($search));

	$content = ftp_rawlist($conn_id, $basePath);

	if(count($content) > 1){
		$isDir = true;
		$isFile = false;
	}else{
		$ftpItem = parseFtpRawItem($content[0]);
		
		$isDir = false;
		$isFile = true;
	}
}else{
	$isDir = is_dir($path);
	$isFile = is_file($path);
}

if ($isDir){
		$GLOBALS["smarty"]->assign("file_type",'folder');
	}
elseif($isFile) {
		if($ftpItem){
			$file_stat = [
				'name' => basename($ftpItem['name']),
				'size' => $ftpItem['size']
			];
			
			$GLOBALS["smarty"]->assign("file_type",'file');
			$GLOBALS["smarty"]->assign("file_stat",$file_stat);
			$GLOBALS["smarty"]->assign("file_size",round($file_stat["size"]/1024,2));

			$GLOBALS["smarty"]->assign("size", []);
			$er = explode('.', basename($path));
			$GLOBALS["smarty"]->assign("ext",strtolower(end($er)));
		}else{
			$name['name'] =  basename($path);
			$stat = stat($path);
			$file_stat = array_merge($name,$stat);
			$GLOBALS["smarty"]->assign("file_type",'file');
			$GLOBALS["smarty"]->assign("file_stat",$file_stat);
			$GLOBALS["smarty"]->assign("file_size",round($file_stat["size"]/1024,2));

			$GLOBALS["smarty"]->assign("size",getimagesize($path));
			$er = explode('.', basename($path));
			$GLOBALS["smarty"]->assign("ext",strtolower(end($er)));
		}
	}

{/php}
{if $file_type=='file'}
<table width="100%">
	<tr>
		<td class="td_bold">{insert name='tr' value='Názov súboru'}:</td>
		<td>{$file_stat.name}</td>
	</tr>
	<tr>
		<td class="td_bold">{insert name='tr' value='Dátum'}:</td>
		<td>{$file_stat.mtime|date_format:"%e.%m.%Y %H:%M"}</td>
	</tr>
	<tr>
		<td class="td_bold">{insert name='tr' value='Veľkosť'}:</td>
		<td>{$file_size}kB</td>
	</tr>
	<tr>
		<td class="td_bold">{insert name='tr' value='Rozmery'}:</td>
		<td>{$size.0} x {$size.1} px</td>
	</tr>
</table>
<table width="300" height="200" align="center" border="0">
	<tr>
		<td align="center"><center>
		{if $file_stat.size < 153600}
			{if (($ext == "jpg") || ($ext == "jpeg") || ($ext == "gif") || ($ext == "png"))}
					<a href="{$path}" target="_blank"><img src="../themes/default/img.php?path={$path}&w=150"></a>
			{elseif $ext == "pdf"}
				<a target="_blank" href="{$path}"><img src="../themes/default/images/pdf16.png"></a>
			{elseif $ext == "doc"}
				<a target="_blank" href="{$path}"><img src="../themes/default/images/word16.png"></a>
			{elseif $ext == "xls"}
				<a target="_blank" href="{$path}"><img src="../themes/default/images/excel16.png"></a>
			{else}
			<iframe id="previewIframe" name="previewIframe" unselectable="true" atomicselection="true" src="{$path}" width="300" height="300" marginwidth="0" marginheight="0" topmargin="0" leftmargin="0" frameborder="0" border="0"></iframe>
			{/if}
		{else}
			{if (($ext == "jpg") || ($ext == "jpeg") || ($ext == "gif") || ($ext == "png"))}
				<a target="_blank" href="{$path}"><img src="../themes/default/images/media_view.png"></a>
			{elseif $ext == "pdf"}
				<a target="_blank" href="{$path}"><img src="../themes/default/images/pdf16.png"></a>
			{elseif $ext == "doc"}
				<a target="_blank" href="{$path}"><img src="../themes/default/images/word16.png"></a>
			{elseif $ext == "xls"}
				<a target="_blank" href="{$path}"><img src="../themes/default/images/excel16.png"></a>
			{else}
				<a target="_blank" href="{$path}"><img src="../themes/default/images/file.png"></a>
			{/if}
		{/if}

			</center>
		</td>
	</tr>
</table>
{/if}
