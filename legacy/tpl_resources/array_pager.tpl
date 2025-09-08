{strip}
	
	{insert name=initialize_array_pager_vars list=$list}
	
{if ($qs eq 0) OR ($perpage < $p_totalRecordCount)}
			<table align="right" width="550" border="0">
				<tr>
					<form method="get" name="pager" id="pager">
					{assignel var=novisible key=0 value='form_text_name'}
					{assignel var=novisible key=1 value='form_name'}
					{assignel var=novisible key=2 value='setPerPage'}
					{assignel var=novisible key=3 value='start'}
					{insert name='formGet' hidden=$novisible assign='link'}
					{$link}
					<td width="150">&nbsp;&nbsp;
						<select name="setPerPage" onchange="pager.submit()">
							<option value="10" {if $perpage eq 10}selected="selected"{/if}>10</option>
							<option value="20" {if $perpage eq 20}selected="selected"{/if}>20</option>
							<option value="50" {if $perpage eq 50}selected="selected"{/if}>50</option>
							<option value="100" {if $perpage eq 100}selected="selected"{/if}>100</option>
							<option value="200" {if $perpage eq 200}selected="selected"{/if}>200</option>
							<option value="999999" {if $perpage eq null || $perpage eq 999999}selected="selected"{/if}>všetky záznamy</option>
						</select>
					</td>
					</form>
					<td width="250">{insert name='tr' value='Počet záznamov'} {$p_size} {insert name='tr' value='z celkovo'} {$p_totalRecordCount}</td>
					{assignel var=novisible key=0 value='form_text_name'}
					{assignel var=novisible key=1 value='form_name'}
					{assignel var=novisible key=2 value='setPerPage'}
					{assignel var=novisible key=3 value='start'}
					{insert name='urlGet' hidden=$novisible assign='link'}
					{if ($p_currentPage>1)}
					
						<td align="center" width="37">
							<a href="./?start={$p_firstStart}{$link}" title="{insert name='tr' value='Úvodná stránka'}"><img src="images/p_start.png" /></a>
						</td>
						<td align="center" width="37">
							<a href="./?start={$p_previousStart}{$link}" title="{insert name='tr' value='Predchádzajúca stránka'}"><img src="images/p_back.png" /></a>
						</td>
					{else}
						<td align="center" width="37"></td>
						<td align="center" width="37"></td>
					{/if}
						<td width="40">{$p_currentPage}/{$p_pageCount}</td>
					{if ($p_nextStart < $p_totalRecordCount) AND ($p_nextStart neq 0)}
						<td align="center" width="38">
							<a href="./?start={$p_nextStart}{$link}" title="{insert name='tr' value='Ďalšia stránka'}"><img src="images/p_next.png" /></a>
						</td>
						<td align="center" width="38">
							<a href="./?start={$p_lastStart}{$link}" title="{insert name='tr' value='Posledná stránka'}"><img src="images/p_end.png" /></a>
						</td>
					{else}
						<td align="center" width="38"></td>
						<td align="center" width="38"></td>
					{/if}
				</tr>
			</table>
{/if}
{/strip}
