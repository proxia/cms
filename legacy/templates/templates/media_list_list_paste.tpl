
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
				<input type="hidden" id="cmd" name="cmd" value="{$cmd}" />
			{foreach name='media' from=$media_list item='media_id'}
				{insert name=url_decode l1=$m_directory l2=$media_id.flink assign=a}
				{php}
					$a = urldecode($GLOBALS['smarty']->get_template_vars('a'));
					$path_to_file = "{$GLOBALS['config']['mediadir']}/".$a;
					if (is_file($path_to_file)){
							$name['name'] = basename($path_to_file);
							$stat = stat($path_to_file);
							$file_stat = array_merge($name,$stat);
							$GLOBALS["smarty"]->assign("file_size",round($file_stat["size"]/1024,2));
						}
					$GLOBALS["smarty"]->assign("a",$a);
				{/php}
				{insert name=checkImageBind image=$a assign=checkImageBind}
				{if $checkImageBind eq 1}
					{assign var='disabled' value='disabled="disabled"'}
				{else}
					{assign var='disabled' value=''}
				{/if}
				<tr><td colspan="8" class="td_link_space"></td></tr>
				<tr onmouseover="pozadie('#f5f5f5',this)" onmouseout="pozadie('#ffffff',this)">
					<td class="td_align_center">{$smarty.foreach.media.iteration}</td>
					<td>{if $media_id.ftype eq 2}<a title="prilep obrázok" href="javascript:prilep('{$m_directory}{$media_id.flink}')"><img src="images/paste.gif" width="21" height="21" border="0"></a>{/if}</td>
					<td>
			            {if $media_id.ftype eq 1}
			              <img src="images/folder.gif">
			            {elseif ($media_id.ftype eq 2) and (($media_id.fend eq "jpg") or ($media_id.fend eq "jpeg") or ($media_id.fend eq "gif") or ($media_id.fend eq "png"))}
			              <img src="images/image.gif">
			            {elseif ($media_id.ftype eq 2) and ($media_id.fend eq "xls")}
			              <img src="images/excel16.png">
			            {elseif ($media_id.ftype eq 2) and ($media_id.fend eq "pdf")}
			              <img src="images/pdf16.png">
			            {elseif ($media_id.ftype eq 2) and (($media_id.fend eq "doc") or ($media_id.fend eq "rtf"))}
			              <img src="images/word16.png">
			            {elseif ($media_id.ftype eq 2) and (($media_id.fend eq "rar") )}
			              <img src="images/rar16.png">
			            {elseif ($media_id.ftype eq 2) and ( ($media_id.fend eq "zip"))}
			              <img src="images/winzip16.gif">
			            {elseif $media_id.ftype eq 2}
			              <img src="images/file.gif">
			            {elseif $media_id.ftype eq 3}
			              <img src="images/up_folder.gif">
			            {/if}
			        </td>

					<td>{if $media_id.ftype eq 2}<a href="javascript:showPreview('{insert name=url_decode l1=$m_directory l2=$media_id.flink}')">{$media_id.name}</a>{elseif $media_id.ftype eq 1}<a href="./?cmd=29&form_name={$form_name}&form_text_name={$form_text_name}&form_text_title={$form_text_title}&m_directory={insert name=url_decode l1=$m_directory l2=$media_id.flink}">{$media_id.name}</a>{elseif $media_id.ftype eq 3}<a href="./?cmd=29&form_name={$form_name}&form_text_name={$form_text_name}&form_text_title={$form_text_title}&m_directory={$media_id.flink}">{$media_id.name}</a>{/if}</td>
					<td>{$file_size} kB</td>

				</tr>
			{/foreach}
				</form>
			</table>
