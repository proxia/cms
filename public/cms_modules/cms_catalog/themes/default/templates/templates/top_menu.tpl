
<div class="menu" >
<ul>
<li >&nbsp;
</li>
<li ><a style="background-image:url('<?=$GLOBALS['path_relative'].'../themes/default/images/catalog_s.gif'?>');background-repeat: no-repeat;padding-left:5px;background-position: center left;" class="hide first_element" href="./?setProxia=catalog"><?=tr("Katalógy")?></a>
</li>



<?
if (isset($_SESSION['currentCatalog']))
{
?>

	<li ><a style="background-image:url('../themes/default/images/category_s.gif');background-repeat: no-repeat;padding-left:5px;background-position: center left;" class="hide" href=""><?=tr("Kategórie")?></a>
		<ul >
		<li><a href="./?module=CMS_Catalog&mcmd=4" title="<?=tr("Zoznam kategórií")?>"><?=tr("Zoznam kategórií")?></a></li>
		<li><a href="./?module=CMS_Catalog&mcmd=18" title="<?=tr("Strom kategórií")?>"><?=tr("Strom kategórií")?></a></li>
		<li><a href="./?module=CMS_Catalog&mcmd=19" title="<?=tr("Viditeľnosť kategórií")?>"><?=tr("Viditeľnosť kategórií")?></a></li>
		</ul>

	</li>

	<li ><a style="background-image:url('../themes/default/images/product_s.gif');background-repeat: no-repeat;padding-left:5px;background-position: center left;" class="hide" href=""><?=tr("Produkty")?></a>
		<ul >
		<li><a href="./?module=CMS_Catalog&mcmd=10" title="<?=tr("Zoznam produktov")?>"><?=tr("Zoznam produktov")?></a></li>
		<li class="subtitle"><?=tr("Nastavenia")?></li>
		<li><a href="./?module=CMS_Catalog&mcmd=17&setup_type=visibility" title="<?=tr("Viditeľnosť")?>"><?=tr("Viditeľnosť")?></a></li>
		<li><a href="./?module=CMS_Catalog&mcmd=17&setup_type=valid" title="<?=tr("Platnosť")?>"><?=tr("Platnosť")?></a></li>
		<li><a href="./?module=CMS_Catalog&mcmd=17&setup_type=image" title="<?=tr("Obrázok")?>"><?=tr("Obrázok")?></a></li>
		<li><a href="./?module=CMS_Catalog&mcmd=17&setup_type=access" title="<?=tr("Zobrazovacie práva")?>"><?=tr("Zobrazovacie práva")?></a></li>
		<li><a href="./?module=CMS_Catalog&mcmd=17&setup_type=price" title="<?=tr("Ceny")?>"><?=tr("Ceny")?></a></li>
		<li><a href="./?module=CMS_Catalog&mcmd=17&setup_type=news" title="<?=tr("Novinky")?>"><?=tr("Novinky")?></a></li>
		<li><a href="./?module=CMS_Catalog&mcmd=17&setup_type=sale" title="<?=tr("Výpredaj")?>"><?=tr("Výpredaj")?></a></li>
		<li><a href="./?module=CMS_Catalog&mcmd=17&setup_type=stock" title="<?=tr("Sklad")?>"><?=tr("Sklad")?></a></li>
		<li class="subtitle"><?=tr("Importy")?></li>
		<li><a href="./?module=CMS_Catalog&mcmd=29" title="<?=tr("Sklad")?>"><?=tr("Aktualizácia skladu")?></a></li>

		</ul>

	</li>

	<li ><a style="background-image:url('../themes/default/images/attribute_s.gif');background-repeat: no-repeat;padding-left:5px;background-position: center left;" class="hide" href=""><?=tr("Atribúty")?></a>
		<ul >
		<li><a href="./?module=CMS_Catalog&mcmd=7" title="<?=tr("Atribúty")?>"><?=tr("Atribúty")?></a></li>
		<li><a href="./?module=CMS_Catalog&mcmd=23" title="<?=tr("Skupiny atribútov")?>"><?=tr("Skupiny atribútov")?></a></li>
		</ul>

	</li>


<?
}
?>

<li ><a class="hide" href="./"><?=tr("Moduly")?></a>
	<ul class="popup">
	<li><a href="./?module=CMS_Gallery" title="<?=tr("Gallery")?>"><?=tr("Gallery")?></a></li>
	</ul>
</li>

	<li ><a style="background-image:url('../themes/default/images/help_s.gif');background-repeat: no-repeat;padding-left:5px;background-position: center left;" class="hide" href=""><?=tr("Pomocník")?></a>
		<ul >
		<li><a href="./?cmd=help" title="<?=tr("Pomocník")?>"><?=tr("Pomocník")?></a></li>
		</ul>

	</li>

	<li ><a style="background-image:url('../themes/default/images/lang_ss.gif');background-repeat: no-repeat;padding-left:5px;background-position: center left;" class="hide language" href=""><?=tr("Jazyk obsahu")." [".$GLOBALS['localLanguage']."]"?></a>
	<ul >
	<?
		$i=0;
		foreach($GLOBALS['LanguageList'] as $column_name => $language_id){
			if ($language_id['local_visibility']){
				$i++;
				$title = $language_id['native_name'];
				$id = $language_id['code'];
				$path = "./?setLocalLanguage=$id&cmd=".$_GET['cmd']."&mcmd=".$_GET['mcmd']."&row_id[]=".$_GET['row_id'][0]."&module=".$_GET['module']."&start=".$_GET['start']."&s_category=".$_GET['s_category'];
				$style = "";
				if($GLOBALS['localLanguage']==$id)
					$style = "style=\"background-image:url('../themes/default/images/visible.gif');background-repeat: no-repeat;background-position: center right;\"";
	?>
				<li><a <?=$style?> href="<?=$path?>" title="<?=$title?>"><?=$title?></a></li>
	<?

			}
		}
	?>
	</ul>
	</li>

</ul>

</div>
