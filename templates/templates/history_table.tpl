<table width="500">
	<tr>
		<td class="td_valign_top">
				{assign var='num' value=0}
				{foreach name='history' from=$history_table item='history_id'}
					{insert name='unserialize' input=$history_id.object assign=object}
					{insert name='getObjectType' item=$object set='realname' return='name' assign=realname }
					{insert name='getObjectType' item=$object set='updatelink' assign=updatelink }
					{if $history_id.action_type eq 'view'}
						{assign var='num' value=$num+1}
					{/if}
				{/foreach}
			{if $num > 0}
			<table class="tb_list_history">
				<tr class="tr_header">
					<td colspan='3'>
						{insert name='tr' value='Prezerané položky'}
					</td>
				</tr>
				{foreach name='history' from=$history_table item='history_id'}
					{insert name='unserialize' input=$history_id.object assign=object}
					{insert name='getObjectType' item=$object set='realname' return='name' assign=realname }
					{insert name='getObjectType' item=$object set='updatelink' assign=updatelink }
					{if $history_id.action_type eq 'view'}
					
					{$object->setContextLanguage($localLanguage)}
					{assign var=defaultView value=0}
					{if ($object->getTitle() eq '')}
						{$object->setContextLanguage($localLanguageDefault)}
						{assign var=defaultView value=1}
					{/if}
					<tr bgcolor='#f3f3f3'>
						<td><img src="images/{$realname}_s.gif"></td>
						<td>
							<a href="./?cmd={$updatelink}&row_id[]={$object->getId()}">
							{if $defaultView eq 1}{$defaultViewStartTag}{/if}
							{$object->getTitle()}
							{if $defaultView eq 1}{$defaultViewEndTag}{/if}
							</a>
						</td>
						<td>{$history_id.time|date_format:"%H:%M:%S"}</td>
					</tr>
					{/if}
				{/foreach}
			</table>
			{/if}
		</td>
		<td class="td_valign_top">
				{assign var='num' value=0}
				{foreach name='history' from=$history_table item='history_id'}
					{insert name='unserialize' input=$history_id.object assign=object}
					{insert name='getObjectType' item=$object set='realname' return='name' assign=realname }
					{insert name='getObjectType' item=$object set='updatelink' assign=updatelink }
					{if $history_id.action_type eq 'edit'}
						{assign var='num' value=$num+1}
					{/if}
				{/foreach}
			{if $num > 0}
			<table class="tb_list_history">
				<tr class="tr_header">
					<td colspan='3'>
						{insert name='tr' value='Upravované položky'}
					</td>
				</tr>
				{foreach name='history' from=$history_table item='history_id'}
					{insert name='unserialize' input=$history_id.object assign=object}
					{insert name='getObjectType' item=$object set='realname' return='name' assign=realname }
					{insert name='getObjectType' item=$object set='updatelink' assign=updatelink }
					{if $history_id.action_type eq 'edit'}
					{$object->setContextLanguage($localLanguage)}
					{assign var=defaultView value=0}
					{if ($object->getTitle() eq '')}
						{$object->setContextLanguage($localLanguageDefault)}
						{assign var=defaultView value=1}
					{/if}
					<tr bgcolor='#f3f3f3'>
						<td><img src="images/{$realname}_s.gif"></td>
						<td>
							<a href="./?cmd={$updatelink}&row_id[]={$object->getId()}">
							{if $defaultView eq 1}{$defaultViewStartTag}{/if}
							{$object->getTitle()}
							{if $defaultView eq 1}{$defaultViewEndTag}{/if}
							</a>
						</td>
						<td>{$history_id.time|date_format:"%H:%M:%S"}</td>
					</tr>
					{/if}
				{/foreach}
			</table>
			{/if}
		</td>
	</tr>
</table>



