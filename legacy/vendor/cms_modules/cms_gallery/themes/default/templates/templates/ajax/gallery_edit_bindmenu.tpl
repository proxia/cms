{foreach name='menu_list' from=$menu_list_items item='menu_item'}
	<form name="form_bindmenu_list_{$smarty.foreach.menu_list.iteration}" id="form_bindmenu_list_{$smarty.foreach.menu_list.iteration}" method="post" >
	<input type="hidden" name="section" id="section" value="gallery_bindmenu" />
	<input type="hidden" name="row_id[]" id="row_id[]" value="{$gallery_detail->getId()}" />
	<input type="hidden" id="remove_menu_id" name="remove_menu_id" value="{$menu_item.id}" />
	<div style="border-bottom:1px solid silver;line-height:25px;">
		<div style="float:left;cursor:pointer;width:25px;height:25px;background-image:url(../themes/default/images/form_delete.gif);background-repeat:no-repeat;background-position:5px center;" onclick="updateAjax('form_bindmenu_list_{$smarty.foreach.menu_list.iteration}','zoznam_bindmenu','goIn','delete')">
		</div>
		<div style="float:left;">
			{$menu_item.title}
		</div>
		<div style="clear:both"></div>
	</div>
	</form>
{/foreach}
{if $count_menu_items eq 0}
	<div style="margin:5px;">{insert name='tr' value='žiadne priradenia'}</div>
{/if}