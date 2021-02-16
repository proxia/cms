
<table class="tb_middle">

	<tr>
		<td colspan="3">
		
			<table class="tb_title" border="0">
				<tr>
					<td>
						<img class="img_middle" src="images/activity_view.png" alt="" />&nbsp;&nbsp;{insert name='tr' value='Aktivity editora'}
						{if $s_author > 0}<font color=black>{$user->getFirstname()} {$user->getFamilyname()}</font>{/if}
					</td>
					<td class="td_align_right">
						<img class="img_middle" src="images/filter_m_add.png" alt="{insert name='tr' value='filter'}" />&nbsp;
					</td>

					<form method="get" name="form_search_author" id="form_search_author">
					<input type="hidden" name="cmd" value="36" />
					<td >
						<select name="s_author" onchange="form_search_author.submit()">
							<option value="0">{insert name='tr' value='všetci autori'}</option>
							{insert name='getOptionListAuthors' select=$s_author}
						</select>
					</td>
					</form>
				</tr>
			</table>
		</td>
	</tr>
	</form>
	<tr><td colspan="3" class="td_link_v"></td></tr>
	{foreach name='category' from=$category_list_filter item='category_id' }
	{/foreach}
	{assign var='max_list' value=$smarty.foreach.category.iteration}
	<tr>
		<td class="td_middle_left">
			{include_php file="../scripts/toolbar.php"}
		</td>
		<td class="td_link_h"><img src="images/pixel.gif" width="2" /></td>
		<td class="td_middle_center">
				{if $s_author > 0}
					{$table->getTable()}
				{else}
						<div style="margin:30px;font-size:150%">
						{insert name='tr' value='Nemáte vybratého žiadneho autora!'}
						</div>
				{/if}
			<br />
		</td>
	</tr>
	<tr><td colspan="3" class="td_link_v"></td></tr>
</table>
