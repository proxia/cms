{if $parent_category_id}
<div style="border-bottom:1px solid silver;line-height:25px;">
	<div style="float:left;cursor:pointer;width:25px;height:25px;background-image:url(images/form_delete.gif);background-repeat:no-repeat;background-position:5px center;" onclick="updateAjax('form_bindcategory','zoznam_bindcategory','goIn','delete','row_id[]','{$parent_category.id}','section','category_bindcategory')">
	</div>
	<div style="float:left;">
		{$parent_category.title}
	</div>
	<div style="clear:both"></div>
</div>
{else}
	<div style="margin:5px;">{insert name='tr' value='žiadne priradenie'}</div>
{/if}