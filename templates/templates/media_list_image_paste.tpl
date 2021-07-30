<table class="tb_list3">
	<form name="form1" id="form1" method="post" action="action.php">
	<input type="hidden" id="section" name="section" value="media" />
	<input type="hidden" id="cmd" name="cmd" value="{$cmd}" />
{assign var=num value=0}
{foreach name='media' from=$media_list item='media_id'}
	{insert name=url_decode l1=$m_directory l2=$media_id.flink assign=a}
				{php}
					$a = urldecode($GLOBALS['smarty']->get_template_vars('a'));
					$GLOBALS["smarty"]->assign("a",$a);
				{/php}
				{insert name=checkImageBind image=$a assign=checkImageBind}
				{if $checkImageBind eq 1}
					{assign var='disabled' value='disabled="disabled"'}
				{else}
					{assign var='disabled' value=''}
				{/if}
	{if $num eq 0}
	<tr>
	{/if}
		<td width="33%" class="td_align_center" onmouseover="pozadie('#f5f5f5',this)" onmouseout="pozadie('#ffffff',this)">
            {if $media_id.ftype eq 1}
            <a href="./?cmd=29&form_name={$form_name}&form_text_name={$form_text_name}&form_text_title={$form_text_title}&m_directory={insert name=url_decode l1=$m_directory l2=$media_id.flink}">
              <img src="images/folder.png"><br />
              {$media_id.name}
             </a><br />

            {elseif ($media_id.ftype eq 2) and (($media_id.fend eq "jpg") or ($media_id.fend eq "jpeg") or ($media_id.fend eq "gif") or ($media_id.fend eq "png"))}

			{insert name=url_decode l1=$m_directory l2=$media_id.flink assign=path}
			{php}
			$path = $GLOBALS['smarty']->get_template_vars('path');
			$GLOBALS["smarty"]->assign("path_prilep",$path);
			$GLOBALS["smarty"]->assign("paste",$_GET['paste'] ?? null);
			$GLOBALS["smarty"]->assign("path","{$GLOBALS['config']['mediadir']}$path");
			$relative_path = "$path";
			$path = "{$GLOBALS['config']['mediadir']}$path";
			
			$GLOBALS["smarty"]->assign("path",$relative_path);
			{/php}<br />
			<a href="javascript:showPreview('{insert name=url_decode l1=$m_directory l2=$media_id.flink}')">
              <img src="/image-preview?path={$path}&w=50"><br />
              {$media_id.name}<br />
              <a title="prilep obrázok" href="javascript:prilep('{$m_directory}{$media_id.flink}')"><img src="images/paste.gif" width="21" height="21" border="0"></a>
            </a><br /><br />

            {elseif ($media_id.ftype eq 2) and ($media_id.fend eq "xls")}
             <br />
             <a href="javascript:showPreview('{insert name=url_decode l1=$m_directory l2=$media_id.flink}')">
              <img src="images/excel16.png"><br />
              {$media_id.name}<br />
              <a title="prilep obrázok" href="javascript:prilep('{$m_directory}{$media_id.flink}')"><img src="images/paste.gif" width="21" height="21" border="0"></a>
           	</a><br /><br />
            {elseif ($media_id.ftype eq 2) and ($media_id.fend eq "pdf")}
            <br />
            <a href="javascript:showPreview('{insert name=url_decode l1=$m_directory l2=$media_id.flink}')">
              <img src="images/pdf16.png"><br />
              {$media_id.name}<br />
              <a title="prilep obrázok" href="javascript:prilep('{$m_directory}{$media_id.flink}')"><img src="images/paste.gif" width="21" height="21" border="0"></a>
           	</a><br /><br />
            {elseif ($media_id.ftype eq 2) and (($media_id.fend eq "doc") or ($media_id.fend eq "rtf"))}
            <br />
            <a href="javascript:showPreview('{insert name=url_decode l1=$m_directory l2=$media_id.flink}')">
              <img src="images/word16.png"><br />
              {$media_id.name}<br />
              <a title="prilep obrázok" href="javascript:prilep('{$m_directory}{$media_id.flink}')"><img src="images/paste.gif" width="21" height="21" border="0"></a>
           	</a><br /><br />
            {elseif ($media_id.ftype eq 2) and (($media_id.fend eq "rar") )}
            <br />
            <a href="javascript:showPreview('{insert name=url_decode l1=$m_directory l2=$media_id.flink}')">
              <img src="images/rar16.png"><br />
              {$media_id.name}<br />
              <a title="prilep obrázok" href="javascript:prilep('{$m_directory}{$media_id.flink}')"><img src="images/paste.gif" width="21" height="21" border="0"></a>
           	</a><br /><br />
            {elseif ($media_id.ftype eq 2) and ( ($media_id.fend eq "zip"))}
            <br />
            <a href="javascript:showPreview('{insert name=url_decode l1=$m_directory l2=$media_id.flink}')">
              <img src="images/winzip16.gif"><br />
              {$media_id.name}<br />
              <a title="prilep obrázok" href="javascript:prilep('{$m_directory}{$media_id.flink}')"><img src="images/paste.gif" width="21" height="21" border="0"></a>
           	</a><br /><br />
            {elseif $media_id.ftype eq 2}
           <br />
            <a href="javascript:showPreview('{insert name=url_decode l1=$m_directory l2=$media_id.flink}')">
              <img src="images/file.gif"><br />
              {$media_id.name}<br />
              <a title="prilep obrázok" href="javascript:prilep('{$m_directory}{$media_id.flink}')"><img src="images/paste.gif" width="21" height="21" border="0"></a>
           	</a><br /><br />
            {elseif $media_id.ftype eq 3}
           	 <br />
           	 <a href="./?cmd=29&form_name={$form_name}&form_text_name={$form_text_name}&form_text_title={$form_text_title}&m_directory=/{$media_id.flink}">
              <img src="images/up_folder.png">
             </a><br /><br />
            {/if}
        </td>
        {assign var=num value=$num+1}
     {if $num eq 3}
	</tr>
	<tr><td colspan="8" class="td_link_space"></td></tr>
	{assign var=num value=0}
	{/if}
{/foreach}
	</form>
</table>
