
{foreach name='attach_list' from=$attachments_list key=kluc item='attach_item'}
	<div style="line-height:30px;border:1px solid silver;">
		<div style="float:left;width:70px">{insert name='tr' value='Viditeľnosť'}</div>
		<div style="float:left;width:60px">{insert name='tr' value='Názov'}</div>
		<div style="clear:both;"></div>
	<form name="form_zoznam_priloh_{$smarty.foreach.attach_list.iteration}" id="form_zoznam_priloh_{$smarty.foreach.attach_list.iteration}" action="action.php" method="post">
		<input type="hidden"  name="section" value="article_attachments" />
		<input type="hidden"  name="row_id[]" value="{$article_detail->getId()}" />
		<input type="hidden" name="update_atachment_id" value="{$attach_item.id}" />
		<div style="float:left;;width:30px;">
			 <input type="checkbox" name="language_visibility" value="1" {if $attach_item.languageisvisible eq 1} checked="checked"{/if} />
		</div>
		<div style="float:left;;margin-left:15px;">
			 <input type="text" name="p__title{$attach_item.id}" id="p__title{$attach_item.id}"  size="40" value="{$attach_item.title}" />
		</div>
		<div style="float:left;margin-left:15px;">
			<a href="{$attach_item.path}" target="_blank">{$attach_item.name}</a>
			{if $attach_item.size > 0}
				{$attach_item.size} kB
			{/if}
		</div>
		<div style="float:left;;margin-left:15px;">
			<input type="button" class="button" name="attach_update"  onclick="updateAjax('form_zoznam_priloh_{$smarty.foreach.attach_list.iteration}','zoznam_priloh','goIn','update')" value="{insert name='tr' value='Uložiť'}" />
		</div>
		<div style="float:left;margin-left:15px;">
			<a href="#" onclick="updateAjax('form_zoznam_priloh_{$smarty.foreach.attach_list.iteration}','zoznam_priloh','goIn','delete','attach_delete','{$attach_item.id}','section','article_attachments','row_id[]','{$article_detail->getId()}')"/>
			<img src="images/form_delete.gif" alt="delete" title="{insert name='tr' value='Vymazať'}"/>
			</a>
		</div>
		<div style="clear:both;"></div>
	</form>
	</div>
{/foreach}
