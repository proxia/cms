{strip}
<script type="text/javascript" src="js/prototype.js"></script>
<script type="text/javascript" src="js/SortTable.js"></script>
<style type="text/css">
	@import url('css/SortTable.css');
</style>
{literal}
<script language="JavaScript" type="text/javascript">

{/literal}

var parent_id = {$parent_id};
var parent_type = {$entity_type};

var message_saved_text 	= '{insert name='tr' value='Údaje boli aktualizované!'}';
var message_saving_text = '{insert name='tr' value='Aktualizujem údaje'}';
var path_relative		= '{$path_relative}';
{literal}

function sortItems()
{
	var url = path_relative+'action.php';
	sort_items = SortTableManipulator.getItems();
	var params = "&section=sort_items&entity_id="+parent_id+"&entity_type="+parent_type+sort_items;
	params	   += "&goAjax=1";
	new Ajax.Updater('entity_view_content',url, {
		parameters: params,
		evalScripts: true,
		onLoading: function(){
			setMessage(true,message_saving_text)
		},
		onSuccess: function(){
			setMessage(true,message_saved_text,true)
		},
		onFailure: 'Error'

	});
}

function setMessage(show,message,close){
	var vystup = $("system_message");
	if(show == true)
	{
		vystup.innerHTML = message;
		vystup.style.display = "block"
	}
	else{
		vystup.style.display = "none"
	}

	if(close){
	  self.setTimeout('setMessage(false)', 3000);
	}
}
</script>
{/literal}

<table class="tb_middle">
	<tr>
		<td colspan="3"><div id='system_message'></div>
			<table class="tb_title">
				<tr>
					<td style="height:35px;"><img class="img_middle" src="images/all_m_restore.png" alt="gallery" />&nbsp;&nbsp;{$section_title}</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr><td colspan="3" class="td_link_v"></td></tr>
	<tr>
		<td class="td_middle_left">{insert name='merge' value1=$path_relative value2='themes/default/scripts/toolbar.php' assign='path_toolbar'}
		{include_php file=$path_toolbar}</td>
		<td class="td_link_h"><img src="images/pixel.gif" width="1" /></td>
		<td class="td_middle_center">

			<div id="SortTable">

				<ul id="Content">
					{foreach from=$sort_table_items key='order' item='item'}
						<li	px:original_order="{$order+1}" px:item_id="{$item->data->getId()}" px:item_type="{$item->data->getType()}">
							{if $item->thumbnail}
								<div class="image_frame" style="background-image: url('{$item->thumbnail}');"></div>
							{/if}

							<div class="column"><strong>{$item->column_1}</strong></div>

							{if $item->column_2}<div>{$item->column_2}</div>{/if}
							{if $item->column_3}<div>{$item->column_3}</div>{/if}

							<div class="controlls">

								<img src="images/Icons/16x16/arrow_up.png" title="{insert name='tr' value='Posunúť hore'}" alt="" />
								<img src="images/Icons/16x16/arrow_down.png" title="{insert name='tr' value='Posunúť dole'}" alt="" />

								<input disabled type="text" value="{$order+1}" />

								<img src="images/Icons/16x16/arrow_top.png" title="{insert name='tr' value='Presunúť navrch'}" alt="" />
								<img src="images/Icons/16x16/arrow_bottom.png" title="{insert name='tr' value='Presunúť naspodok'}" alt="" />

							</div>
							<span class="spacer"></span>
						</li>
					{/foreach}
				</ul>
				{*
				<ul id="Buffer"></ul>

				<div id="ButtonGroupTop">
					<img src="images/Icons/32x32/arrow_left_green.png" title="{insert name='tr' value='Presunúť všetko doľava'}" alt="" class="left" />
					<img src="images/Icons/32x32/arrow_right_green.png" title="{insert name='tr' value='Presunúť všetko doprava'}" alt="" class="right" />
				</div>

				<div id="ButtonGroupBottom">
					<img src="images/Icons/32x32/arrow_left_blue.png" title="{insert name='tr' value='Presunúť doľava'}" alt="" class="left" />
					<img src="images/Icons/32x32/arrow_right_blue.png" title="{insert name='tr' value='Presunúť doprava'}" alt="" class="right" />
				</div>
				*}
			</div>

		</td>
	</tr>
	<tr><td colspan="3" class="td_link_v"></td></tr>
</table>
<div id="entity_view_content"></div>
{/strip}