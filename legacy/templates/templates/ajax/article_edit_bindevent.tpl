{foreach name='event_list' from=$event_list_items item='event_item'}
	<form name="form_bindevent_list_{$smarty.foreach.event_list.iteration}" id="form_bindevent_list_{$smarty.foreach.event_list.iteration}" method="post" >
	<input type="hidden" name="section" id="section" value="article_bindevent" />
	<input type="hidden" name="row_id[]" id="row_id[]" value="{$article_detail->getId()}" />
	<input type="hidden" id="unmap_event" name="unmap_event" value="{$event_item.id}" />
	<div style="border-bottom:1px solid silver;line-height:25px;">
		{if (($user_login->checkPrivilege(5, $privilege_update) eq 1) OR ($user_login_type eq $admin_user))}
			<div style="float:left;cursor:pointer;width:25px;height:25px;background-image:url(images/form_delete.gif);background-repeat:no-repeat;background-position:5px center;" onclick="updateAjax('form_bindevent_list_{$smarty.foreach.event_list.iteration}','zoznam_bindevent','goIn','delete')">
			</div>
		{/if}
		<div style="float:left;">
			{$event_item.title}
		</div>
		<div style="clear:both"></div>
	</div>
	</form>
{/foreach}
{if $count_event_items eq 0}
	<div style="margin:5px;">{insert name='tr' value='žiadne priradenia'}</div>
{/if}
