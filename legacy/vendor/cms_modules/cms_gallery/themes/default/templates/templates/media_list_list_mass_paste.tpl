
			<table class="tb_list3">
				<tr class="tr_header">
					<td class="td_align_center">#</td>
					<td></td>
					<td></td>
					<td>{insert name='tr' value='Názov'}</td>
					<td>{insert name='tr' value='Veľkosť'}</td>

				</tr>
				<form name="form1" id="form1" method="post" action="action.php">
				<input type="hidden" id="section" name="section" value="media" />
				<input type="hidden" id="module" name="module" value="CMS_Gallery" />
				<input type="hidden" id="mcmd" name="mcmd" value="{$mcmd}" />
			{foreach name='media' from=$media_list item='media_id'}
				{insert name=url_decode l1=$m_directory l2=$media_id.flink assign=a}
				{php}
					$a = urldecode($GLOBALS['smarty']->get_template_vars(a));
					$path_to_file = "../mediafiles/".$a;
			
					if (is_file($path_to_file)){
							$name['name'] = basename($path_to_file);
							$stat = stat($path_to_file);
							$file_stat = array_merge($name,$stat);
							$GLOBALS["smarty"]->assign("file_size",round($file_stat["size"]/1024,2));
						}
					$GLOBALS["smarty"]->assign("a",$a);
				{/php}
				<tr><td colspan="8" class="td_link_space"></td></tr>
				<tr onmouseover="pozadie('#f5f5f5',this)" onmouseout="pozadie('#ffffff',this)">
					<td class="td_align_center" id="file_{$smarty.foreach.media.iteration}"><input type="hidden" id="mass_file_{$smarty.foreach.media.iteration}" name="mass_file_{$smarty.foreach.media.iteration}" value="{$m_directory}{$media_id.flink}" />{$smarty.foreach.media.iteration}</td>
					<td>{if $media_id.ftype eq 2}<a title="označenie obrázka" href="javascript:prilepMass('{$m_directory}{$media_id.flink}',{$smarty.foreach.media.iteration})"><img src="../themes/default/images/paste.gif" width="21" height="21" border="0"></a>{/if}</td>
					<td>
			            {if $media_id.ftype eq 1}
			              <img src="../themes/default/images/folder.gif">
			            {elseif ($media_id.ftype eq 2) and (($media_id.fend eq "jpg") or ($media_id.fend eq "jpeg") or ($media_id.fend eq "gif") or ($media_id.fend eq "png"))}
			              <img src="../themes/default/images/image.gif">
			            {elseif ($media_id.ftype eq 2) and ($media_id.fend eq "xls")}
			              <img src="../themes/default/images/excel16.png">
			            {elseif ($media_id.ftype eq 2) and ($media_id.fend eq "pdf")}
			              <img src="../themes/default/images/pdf16.png">
			            {elseif ($media_id.ftype eq 2) and (($media_id.fend eq "doc") or ($media_id.fend eq "rtf"))}
			              <img src="../themes/default/images/word16.png">
			            {elseif ($media_id.ftype eq 2) and (($media_id.fend eq "rar") )}
			              <img src="../themes/default/images/rar16.png">
			            {elseif ($media_id.ftype eq 2) and ( ($media_id.fend eq "zip"))}
			              <img src="../themes/default/images/winzip16.gif">
			            {elseif $media_id.ftype eq 2}
			              <img src="../themes/default/images/file.gif">
			            {elseif $media_id.ftype eq 3}
			              <img src="../themes/default/images/up_folder.gif">
			            {/if}
			        </td>

					<td>{if $media_id.ftype eq 2}<a href="javascript:showPreview('{insert name=url_decode l1=$m_directory l2=$media_id.flink}')">{$media_id.name}</a>{elseif $media_id.ftype eq 1}<a href="./?mcmd=999&module=CMS_Gallery&form_name={$form_name}&form_text_name={$form_text_name}&form_text_title={$form_text_title}&m_directory={insert name=url_decode l1=$m_directory l2=$media_id.flink}">{$media_id.name}</a>{elseif $media_id.ftype eq 3}<a href="./?mcmd=999&module=CMS_Gallery&form_name={$form_name}&form_text_name={$form_text_name}&form_text_title={$form_text_title}&m_directory={$media_id.flink}">{$media_id.name}</a>{/if}</td>
					<td>{$file_size} kB</td>

				</tr>
			{/foreach}
				</form>
			</table>
<button style="margin:10px;padding:10px;background-color:#53C4DF" type="button" onclick="massFilesToGallery({$smarty.foreach.media.iteration})">{insert name="tr" value="Pridaj označené súbory do galérie"}</button>

