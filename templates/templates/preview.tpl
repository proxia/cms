{php}
$base_path = urldecode($_GET['path']);

$GLOBALS["smarty"]->assign("paste",$_GET['paste'] ?? null);
$GLOBALS["smarty"]->assign("path","$base_path");

$path = "{$GLOBALS['config']['mediadir']}$base_path";

$GLOBALS["smarty"]->assign("path","$path");
$GLOBALS["smarty"]->assign("path_prilep",$base_path);
$GLOBALS["smarty"]->assign("image_path","$base_path");


if (is_dir($path)){
		$GLOBALS["smarty"]->assign("file_type",'folder');
	}
else {
		$name['name'] = basename($path);
		$stat = stat($path);
		$file_stat = array_merge($name,$stat);
		$GLOBALS["smarty"]->assign("file_type",'file');
		$GLOBALS["smarty"]->assign("file_stat",$file_stat);
		$GLOBALS["smarty"]->assign("file_size",round($file_stat["size"]/1024,2));

		$GLOBALS["smarty"]->assign("size",getimagesize($path));
		$er = explode('.', basename($path));
		$GLOBALS["smarty"]->assign("ext",strtolower(end($er)));
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
		<td>{$file_size} kB</td>
	</tr>
	<tr>
		<td class="td_bold">{insert name='tr' value='Rozmery'}:</td>
		<td>{$size.0} x {$size.1} px</td>
	</tr>
</table>
<table width="300" height="200" align="center" border="0">
	<tr>
		<td align="center"><center>
		{if $file_stat.size < 1536000}
			{if (($ext == "jpg") || ($ext == "jpeg") || ($ext == "gif") || ($ext == "png"))}
					<a href="{$path}" target="_blank"><img src="/image-preview?path={$image_path}&w=150"></a>
			{elseif $ext == "pdf"}
				<a target="_blank" href="{$path}"><img src="images/pdf16.png"></a>
			{elseif $ext == "doc"}
				<a target="_blank" href="{$path}"><img src="images/word16.png"></a>
			{elseif $ext == "xls"}
				<a target="_blank" href="{$path}"><img src="images/excel16.png"></a>
			{else}
			<iframe id="previewIframe" name="previewIframe" unselectable="true" atomicselection="true" src="{$path}" width="300" height="300" marginwidth="0" marginheight="0" topmargin="0" leftmargin="0" frameborder="0" border="0"></iframe>
			{/if}
		{else}
			{if (($ext == "jpg") || ($ext == "jpeg") || ($ext == "gif") || ($ext == "png"))}
				<a target="_blank" href="{$path}"><img src="images/media_view.png"></a>
			{elseif $ext == "pdf"}
				<a target="_blank" href="{$path}"><img src="images/pdf16.png"></a>
			{elseif $ext == "doc"}
				<a target="_blank" href="{$path}"><img src="images/word16.png"></a>
			{elseif $ext == "xls"}
				<a target="_blank" href="{$path}"><img src="images/excel16.png"></a>
			{else}
				<a target="_blank" href="{$path}"><img src="images/file.png"></a>
			{/if}
		{/if}
			{if $paste == 1 }
					<br /><br /><br /><br /><a title="prilep obrázok" href="javascript:parent.prilep('{$path_prilep}')"><img border="0" src="images/media_view_paste.png"></a>
			{/if}
			</center>
		</td>
	</tr>
</table>
{if $paste != 1}

{insert name='bindImage' image=$path_prilep num=0 entita='article' assign=bindImageArticleList}
{insert name='bindImage' image=$path_prilep num=0 entita='gallery' assign=bindImageGalleryList}
{insert name='bindImage' image=$path_prilep num=0 entita='categories' assign=bindImageCategoryList}
{insert name='bindImage' image=$path_prilep num=0 entita='categories_lang' assign=bindImageCategoryLangList}
{insert name='bindImage' image=$path_prilep num=0 entita='product' assign=bindImageProductList}
{insert name='bindImage' image=$path_prilep num=0 entita='attribut' assign=bindImageAttributList}
{insert name='bindImage' image=$path_prilep num=0 entita='answer' assign=bindImageAnswerList}
{insert name='bindImage' image=$path_prilep num=0 entita='weblink' assign=bindImageWeblinkList}

	<table width="300" align="center" border="0" class="tb_list_history">
		<tr class="tr_header">
			<td colspan='2'>
				{insert name='tr' value='Priradenie súboru'}
			</td>
		</tr>
		<tr>
			<td>
				<div style="width:300px;height:100px;overflow:auto;border-width:0px;border-color:000000;border-style:solid;">
					<table width="100%" cellspacing="0" cellpadding="0">
						{foreach name='bindArticle' from=$bindImageArticleList item='article_id'}
						<tr bgcolor='#f3f3f3'><td><img src="images/article_s.gif"></td><td><a href="./?cmd=9&row_id[]={$article_id->getId()}" target="_top">{$article_id->getTitle()}</a></td></tr>
						{/foreach}
						{foreach name='bindGallery' from=$bindImageGalleryList item='gallery_id'}
						<tr bgcolor='#f3f3f3'><td><img src="images/gallery_s.gif"></td><td><a href="./?module=CMS_Gallery&mcmd=4&row_id[]={$gallery_id->getId()}" target="_top">{$gallery_id->getTitle()}</a></td></tr>
						{/foreach}
						{foreach name='bindCategory' from=$bindImageCategoryList item='category_id'}
						<tr bgcolor='#f3f3f3'><td><img src="images/category_s.gif"></td><td><a href="./?cmd=3&row_id[]={$category_id->getId()}" target="_top">{$category_id->getTitle()}</a></td></tr>
						{/foreach}
						{foreach name='bindWeblink' from=$bindImageWeblinkList item='weblink_id'}
						<tr bgcolor='#f3f3f3'><td><img src="images/weblink_s.gif"></td><td><a href="./?cmd=14&row_id[]={$weblink_id->getId()}" target="_top">{$weblink_id->getTitle()}</a></td></tr>
						{/foreach}
						{foreach name='bindCategoryLang' from=$bindImageCategoryLangList item='category_lang_id'}
						<tr bgcolor='#f3f3f3'><td><img src="images/category_s.gif"></td><td><a href="./?cmd=3&row_id[]={$category_lang_id->getId()}&setLocalLanguage={$language}&showtable=4" target="_top">{$category_lang_id->getTitle()}</a></td></tr>
						{/foreach}
						{foreach name='bindProduct' from=$bindImageProductList item='product_id'}
						<tr bgcolor='#f3f3f3'><td><img src="images/product_s.gif"></td><td><a href="./?module=CMS_Catalog&mcmd=12&row_id[]={$product_id->getId()}&setCatalog={$product_id->getCatalogId()}&setProxia=catalog" target="_top">{$product_id->getTitle()}</a></td></tr>
						{/foreach}
						{foreach name='bindAttribut' from=$bindImageAttributList item='attribut_id'}
						<tr bgcolor='#f3f3f3'><td><img src="images/attribute_s.gif"></td><td><a href="./?module=CMS_Catalog&mcmd=9&row_id[]={$attribut_id->getId()}" target="_top">{$attribut_id->getTitle()}</a></td></tr>
						{/foreach}
						{foreach name='bindAnswer' from=$bindImageAnswerList item='answer_id'}
						<tr bgcolor='#f3f3f3'><td><img src="images/inquiry_s.gif"></td><td><a href="./?module=CMS_Inquiry&mcmd=3&row_id[]={$answer_id->getId()}" target="_top">{$answer_id->getDescription()}</a></td></tr>
						{/foreach}
					</table>
				</div>
			</td>
		</tr>
	</table>
{/if}
{/if}
