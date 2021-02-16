<table class="tb_middle">
	<tr>
		<td colspan="3">
			<table class="tb_title">
				<tr>
					<td><img class="img_middle" src="images/client_view.png" alt="" />&nbsp;&nbsp;{insert name='tr' value='Karta zákazníka'}</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr><td colspan="3" class="td_link_v"></td></tr>
	<tr>
		<td class="td_middle_left">
			{*include_php file="../scripts/toolbar.php"*}
		</td>
		<td class="td_link_h"><img src="images/pixel.gif" width="2" /></td>
		<td class="td_middle_center">
		<table width="100%">
			<tr>
				<td class="td_valign_top">
					<table class="tb_list">
						<tr class="tr_header">
							<td colspan="2">&nbsp;{insert name='tr' value='Detail'}</td>
						</tr>
						<tr><td colspan="2" class="td_link_space"></td></tr>
						<tr>
							<td width="150" height="20">&nbsp;{insert name='tr' value='Názov projektu'}</td>
							<td>{$project_name}</td>
						</tr>
						<tr><td colspan="2"><hr /></td></tr>
						<tr>
							<td height="20">&nbsp;{insert name='tr' value='Názov zákazníka'}</td>
							<td>{$client_info.name}</td>
						</tr>
						<tr>
							<td height="20">&nbsp;{insert name='tr' value='Adresa'}</td>
							<td>{$client_info.address}</td>
						</tr>
						<tr>
							<td height="20">&nbsp;{insert name='tr' value='Telefón'}</td>
							<td>{$client_info.phone}</td>
						</tr>
						<tr>
							<td height="20">&nbsp;{insert name='tr' value='Email'}</td>
							<td>{$client_info.email}</td>
						</tr>
						<tr>
							<td height="20">&nbsp;{insert name='tr' value='ICO'}</td>
							<td>{$client_info.ico}</td>
						</tr>
						<tr>
							<td height="20">&nbsp;{insert name='tr' value='IC DPH'}</td>
							<td>{$client_info.icdph}</td>
						</tr>
						<tr><td colspan="2"><hr /></td></tr>
						<tr>
							<td height="20">&nbsp;{insert name='tr' value='Číslo licencie'}</td>
							<td>{$licence_info.licence_number}</td>
						</tr>
						<tr><td colspan="2"><hr /></td></tr>
						<tr>
							<td height="20" width="150">&nbsp;{insert name='tr' value='Maximálny počet článkov'}</td>
							<td>{$quantum_articles}</td>
						</tr>
						<tr>
							<td height="20">&nbsp;{insert name='tr' value='Maximálny počet kategórií'}</td>
							<td>{$quantum_categories}</td>
						</tr>
						<tr>
							<td height="20">&nbsp;{insert name='tr' value='Maximálny počet menu'}</td>
							<td>{$quantum_menus}</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td></td>
						</tr>
						<tr>
							<td height="20" width="150">&nbsp;{insert name='tr' value='Aktuálny počet článkov'}</td>
							<td>{$current_quantum_articles}</td>
						</tr>
						<tr>
							<td height="20">&nbsp;{insert name='tr' value='Aktuálny počet kategórií'}</td>
							<td>{$current_quantum_categories}</td>
						</tr>
						<tr>
							<td height="20">&nbsp;{insert name='tr' value='Aktuálny počet menu'}</td>
							<td>{$current_quantum_menus}</td>
						</tr>
						<tr><td colspan="2"><hr /></td></tr>
						

					</table>
				</td>


			</tr>
		</table>
		<br />
		</td>
	</tr>
	<tr><td colspan="3" class="td_link_v"></td></tr>
</table>