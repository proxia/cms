{foreach name='category_list' from=$category_list_items item='category_item'}
	<form name="form_bindcategory_list_{$smarty.foreach.category_list.iteration}" id="form_bindcategory_list_{$smarty.foreach.category_list.iteration}" method="post" >
	<input type="hidden" name="section" id="section" value="article_bindcategory" />
	<input type="hidden" name="row_id[]" id="row_id[]" value="{$article_detail->getId()}" />
	<input type="hidden" id="remove_category_id" name="remove_category_id" value="{$category_item.id}" />
	<div style="border-bottom:1px solid silver;line-height:25px;">
		<div style="float:left;cursor:pointer;width:25px;height:25px;background-image:url(images/form_delete.gif);background-repeat:no-repeat;background-position:5px center;" onclick="updateAjax('form_bindcategory_list_{$smarty.foreach.category_list.iteration}','zoznam_bindcategory','goIn','delete')">
		</div>
		<div style="float:left;">
			{$category_item.title}
		</div>
		<div style="clear:both"></div>
	</div>
	</form>
{/foreach}
{if $count_category_items eq 0}
	<div style="margin:5px;">{insert name='tr' value='žiadne priradenia'}</div>
{/if}