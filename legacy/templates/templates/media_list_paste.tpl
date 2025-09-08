{literal}
<script language="JavaScript" type="text/javascript">
function pozadie (farba,idd){
		idd.style.background = farba;
	}

function showPreview(path) {
	if (top.frames && top.frames['preview'])
		top.frames['preview'].document.location = "./?cmd=30&paste=1&path=" + path;
}

function prilep(nazov){

{/literal}
{php}
 $GLOBALS["smarty"]->assign("project_name",$_SESSION['user']['name']);


{/php}
{if $form_name eq 'form_popup'}

	{if $media_path_output neq "no_support" && $media_path_output neq "undefined"}
	  ;//nic nerobit nechat premenu nazov bez zmeny
	{else}
	  nazov = "scripts/getImage.php?project={$project_name}&image=" + nazov ;
	{/if}
{/if}
{if $form_name eq 'id'}
	//nazov = "../../getImage.php?project={$project_name}&image=" + nazov ;
	nazov = "scripts/getImage.php?project={$project_name}&image=" + nazov ;
	window.opener.document.{$form_name}.{$form_text_name}.value=nazov;
	window.opener.UpdatePreview();
{/if}
{if $form_name eq 'id_fck'}
	//nazov = "../../getImage.php?project={$project_name}&image=" + nazov ;
	nazov = "scripts/getImage.php?project={$project_name}&image=" + nazov ;
	window.opener.document.{$form_name}.{$form_text_name}.value=nazov;
{/if}
{if $form_name neq 'id'}
	window.opener.document.{$form_name}.{$form_text_name}.value=nazov;
	{if $form_text_title neq "no_support" && $form_text_title neq "undefined"}
		lom_position = nazov.lastIndexOf("/");
		dot_position = nazov.lastIndexOf(".");
		paste_title = ""
		if(lom_position >= 0)
			paste_title = nazov.substr(lom_position+1,dot_position-lom_position-1);
		else
			paste_title = nazov.substr(0,dot_position-1);
		//if(window.opener.document.{$form_name}.{$form_text_title}.value.length == 0)
		window.opener.document.{$form_name}.{$form_text_title}.value=paste_title;
	{/if}
{/if}
{literal}
	this.window.close();
}
</script>
{/literal}

<table class="tb_middle">
	<tr><td colspan="5" class="bold">{$m_directory}</td></tr>
	<tr><td colspan="5" class="td_link_v"></td></tr>
	{foreach name='media' from=$media_list item='media_id' }
	{/foreach}
	{assign var='max_list' value=$smarty.foreach.media.iteration}
	<tr>
		<td class="td_link_h"><img src="images/pixel.gif" width="2" /></td>
		<td class="td_middle_center">


		{if $mediaView eq 'list'}
			{include file="media_list_list_paste.tpl"}
		{elseif $mediaView eq 'image'}
			{include file="media_list_image_paste.tpl"}
		{/if}

			<br />
		</td>
		<td class="td_link_h"><img src="images/pixel.gif" width="2" /></td>
		<td class="td_middle_center">
			<iframe width="300" frameborder="0" height="400" scrolling="no" name="preview" src="./?cmd=30&path={$m_directory}&paste=1"></iframe>
		</td>
	</tr>
	<tr><td colspan="5" class="td_link_v"></td></tr>
</table>