{foreach name='gallery_list' from=$gallery_list_items item='gallery_item'}
	<form name="form_bindgallery_list_{$smarty.foreach.gallery_list.iteration}" id="form_bindgallery_list_{$smarty.foreach.gallery_list.iteration}" method="post" >
	<input type="hidden" name="section" id="section" value="movie_bindgallery" />
	<input type="hidden" name="row_id[]" id="row_id[]" value="{$detail_movie->getId()}" />
	<input type="hidden" id="unmap_gallery" name="unmap_gallery" value="{$gallery_item.id}" />
	<div style="border-bottom:1px solid silver;line-height:25px;">
		<div style="float:left;cursor:pointer;width:25px;height:25px;background-image:url(themes/default/images/form_delete.gif);background-repeat:no-repeat;background-position:5px center;" onclick="updateAjax('form_bindgallery_list_{$smarty.foreach.gallery_list.iteration}','zoznam_bindgallery','goIn','delete')">
		</div>
		<div style="float:left;">
			{$gallery_item.title}
		</div>
		<div style="clear:both"></div>
	</div>
	</form>
{/foreach}
{if $count_gallery_items eq 0}
	<div style="margin:5px;">{insert name='tr' value='žiadne priradenia'}</div>
{/if}
