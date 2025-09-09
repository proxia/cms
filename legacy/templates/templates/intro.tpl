<br /><br /><br /><br />
<table align="center">
<tr><td>
{include_php file="scripts/bigtoolbar.php"}
</td>
<td valign=top ><img src="images/pixel.gif" width="25" /></td>
<td valign=top>

		<table align="center" class="tb_tabs">
		<tr><td colspan="2"><br /></td></tr>
		<tr class="tr_header_tab">
			<td colspan="2" class="td_tabs_top">
					{$tabs}
			</td>
		</tr>
		<tr><td class="td_valign_top" colspan="2">
				<div id="item1" style="visibility: hidden;">
							<table class="tb_list_in_tab" border=1>
								<tr class="tr_header">
									<td >&nbsp;{insert name='tr' value='Názov'}</td><td nowrap>&nbsp;{insert name='tr' value='Viditeľnosť'}</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td>
								</tr>
								<!-- doplnit -->
      				{foreach name='stat' from=$statistics_list_vektor item='stat_id'}
      					     	{$stat_id->setContextLanguage($localLanguage)}
									{assign var=defaultView value=0}
									{if ($stat_id->getTitle() eq '')}
										{$stat_id->setContextLanguage($localLanguageDefault)}
										{assign var=defaultView value=1}
									{/if}
      							<tr><td nowrap>&nbsp;
						{if (($user_login->checkEditorPrivilege($stat_id,false) eq 1) AND (($user_login->checkPrivilege(5, $privilege_view) eq 1) OR ($user_login->checkPrivilege(5, $privilege_update) eq 1))OR($user_login_type eq $admin_user))}
      							<a href="./?cmd=9&row_id[]={$stat_id->getId()}" class="href_aktuality">
									{if $defaultView eq 1}{$defaultViewStartTag}{/if}
										{$stat_id->getTitle()}
									{if $defaultView eq 1}{$defaultViewEndTag}{/if}
								</a>
						{else}
									{if $defaultView eq 1}{$defaultViewStartTag}{/if}
										{$stat_id->getTitle()}
									{if $defaultView eq 1}{$defaultViewEndTag}{/if}
						{/if}
                    </td><td nowrap class="td_align_center">

          					{if $stat_id->getIsPublished() eq 1 }
							{assign var=viewLang value=''}
							{foreach name='language' from=$LanguageList item='language_id'}
								{if $language_id.local_visibility eq 1}
									{$stat_id->setContextLanguage($language_id.code)}
									{if $stat_id->getLanguageIsVisible() eq 0}{assign var=viewLang value='cb'}{/if}
								{/if}
							{/foreach}
                      &nbsp;<img src="images/visible{$viewLang}.gif" />

                    {else}
                      &nbsp;<img src="images/hidden.gif" />
                    {/if}
                    </td><td nowrap>
                    {$stat_id->getCreation()|date_format:"%e.%m.%Y %H:%M"}
                    &nbsp;
                    </td>

                    {insert name='getUserInfo' id=$stat_id->getAuthorId() assign=autor}
					           <td>&nbsp;{$autor->getNickname()}&nbsp;</td>

                    </tr>
			       	{/foreach}
							</table>
							<div style="padding-top:5px;padding-bottom:25px;text-align:right;"><a href="./?cmd=7">{insert name='tr' value='zobraziť všetky články'}</a></div>
				</div>
				<div id="item2" style="visibility: hidden;">
							<table class="tb_list_in_tab" border=1>
								<tr class="tr_header">
									<td >&nbsp;{insert name='tr' value='Názov'}</td><td nowrap align=center>&nbsp;{insert name='tr' value='Viditeľnosť'}</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td>
								</tr>
							  <!-- doplnit -->
      				{foreach name='article' from=$article_recent item='article_id'}
      					     	{$article_id->setContextLanguage($localLanguage)}
									{assign var=defaultView value=0}
									{if ($article_id->getTitle() eq '')}
										{$article_id->setContextLanguage($localLanguageDefault)}
										{assign var=defaultView value=1}
									{/if}
      							<tr><td nowrap>&nbsp;
						{if (($user_login->checkEditorPrivilege($article_id,false) eq 1) AND (($user_login->checkPrivilege(5, $privilege_view) eq 1) OR ($user_login->checkPrivilege(5, $privilege_update) eq 1))OR($user_login_type eq $admin_user))}
      							<a href="./?cmd=9&row_id[]={$article_id->getId()}" class="href_aktuality">
									{if $defaultView eq 1}{$defaultViewStartTag}{/if}
										{$article_id->getTitle()}
									{if $defaultView eq 1}{$defaultViewEndTag}{/if}
								</a>
						{else}
									{if $defaultView eq 1}{$defaultViewStartTag}{/if}
										{$article_id->getTitle()}
									{if $defaultView eq 1}{$defaultViewEndTag}{/if}
						{/if}
                    </td><td nowrap class="td_align_center">

          					{if $article_id->getIsPublished() eq 1 }
							{assign var=viewLang value=''}
							{foreach name='language' from=$LanguageList item='language_id'}
								{if $language_id.local_visibility eq 1}
									{$article_id->setContextLanguage($language_id.code)}
									{if $article_id->getLanguageIsVisible() eq 0}{assign var=viewLang value='cb'}{/if}
								{/if}
							{/foreach}
                      &nbsp;<img src="images/visible{$viewLang}.gif" />
                    {else}
                      &nbsp;<img src="images/hidden.gif" />
                    {/if}
                    </td><td nowrap>&nbsp;
                    {$article_id->getCreation()|date_format:"%e.%m.%Y %H:%M"}
                    &nbsp;
                    </td>

                    {insert name='getUserInfo' id=$article_id->getAuthorId() assign=autor}
					           <td>&nbsp;{$autor->getNickname()}&nbsp;</td>
                    <td nowrap>
        						{if ($article_id->getExpiration() >= $time) OR ($article_id->getExpiration() eq "0000-00-00 00:00:00") OR ($article_id->getExpiration() eq null) }

        						{else}
        							&nbsp;{insert name='tr' value='po expirácii'}&nbsp;
        						{/if}
                    </td>
                    </tr>
			       	{/foreach}

							</table>
							<div style="padding-top:5px;padding-bottom:25px;text-align:right;"><a href="./?cmd=7">{insert name='tr' value='zobraziť všetky články'}</a></div>
				</div>
				<div id="item3" style="visibility: hidden;">
							<table class="tb_list_in_tab" border=1>
								<tr class="tr_header">
									<td >&nbsp;{insert name='tr' value='Priezvisko a Meno'}</td><td nowrap align=center>&nbsp;{insert name='tr' value='Viditeľnosť'}</td><td >{insert name='tr' value='Dátum registrácie'}</td>
								</tr>
							  <!-- doplnit -->
      				{foreach name='users' from=$registered_users item='user_id'}
      					    {$user_id->setContextLanguage("$localLanguage")}

      							<tr><td nowrap>&nbsp;
      							{if ($user_login->checkPrivilege(8, $privilege_view) eq 1) OR ($user_login_type eq $admin_user)}
								<a href="./?cmd=18&row_id[]={$user_id->getId()}">{$user_id->getFamilyname()}&nbsp;{$user_id->getFirstname()}</a>
                    			{else}
								{$user_id->getFamilyname()}&nbsp;{$user_id->getFirstname()}
								{/if}
								</td>
								<td nowrap class="td_align_center">

          					{if $user_id->getIsEnabled() eq 1 }
                      &nbsp;<img src="images/visible.gif" />
                    {else}
                      &nbsp;<img src="images/hidden.gif" />
                    {/if}
                    </td><td nowrap>&nbsp;
                    {$user_id->getCreation()|date_format:"%e.%m.%Y %H:%M"}
                    &nbsp;
                    </td>
                    </tr>
			       	{/foreach}

							</table>
							<div style="padding-top:5px;padding-bottom:25px;text-align:right;"><a href="./?cmd=16">{insert name='tr' value='zobraziť všetkých používateľov'}</a></div>
				</div>

				{if $user_login_type eq $regular_user}

				<div id="item4" style="visibility: hidden;">
							<table class="tb_list_in_tab" border=1>
								<tr class="tr_header">
									<td >&nbsp;{insert name='tr' value='Názov'}</td><td nowrap align=center>&nbsp;{insert name='tr' value='Viditeľnosť'}</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td>
								</tr>
							  <!-- doplnit -->
      				{foreach name='article' from=$article_my item='article_id'}
      					     	{$article_id->setContextLanguage($localLanguage)}
									{assign var=defaultView value=0}
									{if ($article_id->getTitle() eq '')}
										{$article_id->setContextLanguage($localLanguageDefault)}
										{assign var=defaultView value=1}
									{/if}
      							<tr><td nowrap>&nbsp;
						{if (($user_login->checkEditorPrivilege($article_id,false) eq 1) AND (($user_login->checkPrivilege(5, $privilege_view) eq 1) OR ($user_login->checkPrivilege(5, $privilege_update) eq 1))OR($user_login_type eq $admin_user))}
      							<a href="./?cmd=9&row_id[]={$article_id->getId()}" class="href_aktuality">
									{if $defaultView eq 1}{$defaultViewStartTag}{/if}
										{$article_id->getTitle()}
									{if $defaultView eq 1}{$defaultViewEndTag}{/if}
								</a>
						{else}
									{if $defaultView eq 1}{$defaultViewStartTag}{/if}
										{$article_id->getTitle()}
									{if $defaultView eq 1}{$defaultViewEndTag}{/if}
						{/if}
                    </td><td nowrap class="td_align_center">

          					{if $article_id->getIsPublished() eq 1 }
							{assign var=viewLang value=''}
							{foreach name='language' from=$LanguageList item='language_id'}
								{if $language_id.local_visibility eq 1}
									{$article_id->setContextLanguage($language_id.code)}
									{if $article_id->getLanguageIsVisible() eq 0}{assign var=viewLang value='cb'}{/if}
								{/if}
							{/foreach}
                      &nbsp;<img src="images/visible{$viewLang}.gif" />
                    {else}
                      &nbsp;<img src="images/hidden.gif" />
                    {/if}
                    </td><td nowrap>&nbsp;
                    {$article_id->getCreation()|date_format:"%e.%m.%Y %H:%M"}
                    &nbsp;
                    </td>

                    {insert name='getUserInfo' id=$article_id->getAuthorId() assign=autor}
					           <td>&nbsp;{$autor->getNickname()}&nbsp;</td>
                    <td nowrap>
        						{if ($article_id->getExpiration() >= $time) OR ($article_id->getExpiration() eq "0000-00-00 00:00:00") OR ($article_id->getExpiration() eq null) }

        						{else}
        							&nbsp;{insert name='tr' value='po expirácii'}&nbsp;
        						{/if}
                    </td>
                    </tr>
			       	{/foreach}

							</table>

				</div>
				{/if}

		</tr>
		</table>


</td></tr>
</table>
