<?php

function createButton($class="tb_toolbar",$func="",$form_name="",$list_start=0,$list_end=0,$href="",$act_type="",$act_value="",$image="",$text="",$title=""){

	if ($list_start > 0)
			$li_start=",$list_start";
		else
			$li_start="";

	$target="";
	if (($act_type=='cmd')&&($act_value=='help'))
			$target = "target=\"_blank\"";

	if ($list_end > 0)
			$li_end=",$list_end";
		else
			$li_end="";

	if ($list_end == -1)
			$li_end=",max_list";

	// problem v newsletter
	if (($func == "checkControls")||($form_name == "name_form"))
			$fname = $form_name;
		else
			$fname = "'$form_name'";

	// hack na newsletter
	//echo $form_name;exit;
	if ( ($_GET['module']=='CMS_Newsletter') && ($form_name == "name_form"))
			$fname = $form_name;
	elseif ($_GET['module']=='CMS_Newsletter')
		$fname = "'$form_name'";

	if (($func <> "") && ($class == "tb_toolbar"))
			echo"<tr>
						<td>
							<a $target title=\"$title\" class=\"$class\" onclick=\"$func($fname$li_start$li_end,'$act_type','$act_value')\" href=\"$href\"><img alt=\"$text\" src=\"images/$image\" /><br />$text</a>
						</td>
				</tr>";

	if (($func == "") && ($class == "tb_toolbar"))
			echo"<tr>
						<td>
							<a $target title=\"$title\" class=\"$class\" href=\"$href\"><img alt=\"$text\" src=\"images/$image\" /><br />$text</a>
						</td>
				</tr>";

	if (($func == "") && ($class == "tb_toolbar_big"))
			echo"<a $target title=\"$title\" class=\"$class\" href=\"$href\"><img alt=\"$text\" src=\"images/$image\" /><br />$text</a>";
}


function createOffButton($image="",$text="",$title=""){
			echo"<tr>
						<td>
							<a title=\"$title\" class=\"tb_toolbar\" href=\"javascript:\"><img alt=\"$text\" src=\"images/$image\" /><br />$text</a>
						</td>
				</tr>";
				//$priezvisko2 = StrTr($user[u_priezvisko], "áäčďéěëíľňôóöŕřšťúůüýžÁÄČĎÉĚËÍĽŇÓÖÔŘŔŠŤÚŮÜÝŽ ","aacdeeeilnooorrstuuuyzAACDEEELINOOORRSTUUUYZ_");
}

function createOffBigButton($image="",$text="",$title=""){
			echo"<a title=\"$title\" class=\"tb_toolbar_big\" href=\"javascript:\"><img alt=\"$text\" src=\"images/$image\" /><br />$text</a>";
}

function insert_check(){
?>
<script language="JavaScript" type="text/javascript">
function checkControls(f,act_type,act_value){

		window.status=pole.length;
		err=false;
		err_desc="";
		m_str="";
		var ii = 0;
		var mem = new Array();
		var heslo = "";
		for(i=0; i < pole.length; i++){
			x=i;
			y=x+1;
			z=x+2;
			w=x+3;

			m_pole0=pole[x];
			m_pole1=pole[z];
			m_pole2=pole[w];
			m_pole3=pole[y];

			l=eval("f."+m_pole0+".value");
			if(l.length > m_pole1)
				{err=true;err_desc = "<?=tr('Príliš dlhý text')?> \n";}
			if(l.length < m_pole3)
				{err=true;err_desc = "<?=tr('Príliš krátky text')?> \n"+m_pole3;}
			if(eval("f."+m_pole0+".value")=="" && m_pole2=="V")
				{err=true;err_desc += "<?=tr('Nezadali ste povinnú položku')?> \n";}
			if(isNaN(l) && m_pole2=="N")
				{err=true;err_desc += "<?=tr('Nie je číslo')?> \n";}
			if(!(isEmail(l)) && m_pole2=="E")
				{err=true;err_desc += "<?=tr('Nie je email')?> \n";}
			if(!(isURL(l)) && m_pole2=="U")
				{err=true;err_desc += "<?=tr('Nie je url')?> \n";}
			if(m_pole2=="H")
				{
					mem[ii]=l;
					if(ii>0)
						heslo += "==";
					heslo += "\""+mem[ii]+"\"";
					ii=ii+1;
					if((!eval(heslo))&&(mem.length==2))
						{err=true;err_desc += "<?=tr('Nie je zhodné heslo')?> \n";}
				}

			if(m_pole2=="S")
				{
					var flag = f.platba.value;
     				if(flag=="no")
					{err=true;err_desc += "<?=tr('Nevybrali ste žiadny spôsob platby')?> \n";}
				}

			if(err==true)
				{alert(err_desc);eval("f."+m_pole0).focus();return false;}
		i=i+3;
		}

		if(err!=true){
			submitform(act_type, act_value);
		}else
			return false;
}

function isEmail(argvalue) {
  if (argvalue.indexOf(" ") != -1)
    return false;
  else if (argvalue.indexOf("@") == -1)
    return false;
  else if (argvalue.indexOf("@") == 0)
    return false;
  else if (argvalue.indexOf("@") == (argvalue.length-1))
    return false;
   arrayString = argvalue.split("@");
   if (arrayString[1].indexOf(".") == -1)
    return false;
  else if (arrayString[1].indexOf(".") == 0)
    return false;
  else if (arrayString[1].charAt(arrayString[1].length-1) == ".") {
    return false;
  }
  return true;
}

function isURL(argvalue) {
  if (argvalue.indexOf(" ") != -1)
    return false;
  else if (argvalue.indexOf("http://") == -1)
    return false;
  else if (argvalue == "http://")
    return false;
  else if (argvalue.indexOf("http://") > 0)
    return false;

  argvalue = argvalue.substring(7, argvalue.length);
  if (argvalue.indexOf(".") == -1)
    return false;
  else if (argvalue.indexOf(".") == 0)
    return false;
  else if (argvalue.charAt(argvalue.length - 1) == ".")
    return false;

  if (argvalue.indexOf("/") != -1) {
    argvalue = argvalue.substring(0, argvalue.indexOf("/"));
    if (argvalue.charAt(argvalue.length - 1) == ".")
      return false;
  }

  if (argvalue.indexOf(":") != -1) {
    if (argvalue.indexOf(":") == (argvalue.length - 1))
      return false;
    else if (argvalue.charAt(argvalue.indexOf(":") + 1) == ".")
      return false;
    argvalue = argvalue.substring(0, argvalue.indexOf(":"));
    if (argvalue.charAt(argvalue.length - 1) == ".")
      return false;
  }

  return true;
}
</script>
<?php
}


function insert_checkMoreForm(){
?>
<script language="JavaScript" type="text/javascript">
function checkControls(f,act_type,act_value){

		//window.status=pole.length;
		err=false;
		err_desc="";
		m_str="";
		var ii = 0;
		var mem = new Array();
		var heslo = "";

		for(i=0; i < pole.length; i++)
		{

			x=i;
			y=x+1;
			z=x+2;
			w=x+3;

			m_pole0=pole[x];
			m_pole1=pole[z];
			m_pole2=pole[w];
			m_pole3=pole[y];

			l=eval("document."+f+"."+m_pole0+".value");

			//l=eval("f."+m_pole0+".value");

		//	 window.alert (f+"-"+m_pole0+"-"+act_value);
			if(l.length > m_pole1)
				{err=true;err_desc = "<?=tr('Príliš dlhý text')?> \n";}
			if(l.length < m_pole3)
				{err=true;err_desc = "<?=tr('Príliš krátky text')?> \n"+m_pole3;}
			if(eval("document."+f+"."+m_pole0+".value")=="" && m_pole2=="V")
				{err=true;err_desc += "<?=tr('Nezadali ste povinnú položku')?> \n";}
			if(isNaN(l) && m_pole2=="N")
				{err=true;err_desc += "<?=tr('Nie je číslo')?> \n";}
			if(!(isEmail(l)) && m_pole2=="E")
				{err=true;err_desc += "<?=tr('Nie je email')?> \n";}
			if(!(isURL(l)) && m_pole2=="U")
				{err=true;err_desc += "<?=tr('Nie je url')?> \n";}
			if(m_pole2=="H")
				{
					mem[ii]=l;
					if(ii>0)
						heslo += "==";
					heslo += "\""+mem[ii]+"\"";
					ii=ii+1;
					if((!eval(heslo))&&(mem.length==2))
						{err=true;err_desc += "<?=tr('Nie je zhodné heslo')?> \n";}
				}

			if(m_pole2=="S")
				{
					var flag = f.platba.value;
     				if(flag=="no")
					{err=true;err_desc += "<?=tr('Nevybrali ste žiadny spôsob platby')?> \n";}
				}

			if(err==true)
				{alert(err_desc);eval("document."+f+"."+m_pole0).focus();return false;}
		i=i+3;
		}


		if(err!=true)submitform(f,act_type,act_value)
}

function isEmail(argvalue) {
  if (argvalue.indexOf(" ") != -1)
    return false;
  else if (argvalue.indexOf("@") == -1)
    return false;
  else if (argvalue.indexOf("@") == 0)
    return false;
  else if (argvalue.indexOf("@") == (argvalue.length-1))
    return false;
   arrayString = argvalue.split("@");
   if (arrayString[1].indexOf(".") == -1)
    return false;
  else if (arrayString[1].indexOf(".") == 0)
    return false;
  else if (arrayString[1].charAt(arrayString[1].length-1) == ".") {
    return false;
  }
  return true;
}

function isURL(argvalue) {
  if (argvalue.indexOf(" ") != -1)
    return false;
  else if (argvalue.indexOf("http://") == -1)
    return false;
  else if (argvalue == "http://")
    return false;
  else if (argvalue.indexOf("http://") > 0)
    return false;

  argvalue = argvalue.substring(7, argvalue.length);
  if (argvalue.indexOf(".") == -1)
    return false;
  else if (argvalue.indexOf(".") == 0)
    return false;
  else if (argvalue.charAt(argvalue.length - 1) == ".")
    return false;

  if (argvalue.indexOf("/") != -1) {
    argvalue = argvalue.substring(0, argvalue.indexOf("/"));
    if (argvalue.charAt(argvalue.length - 1) == ".")
      return false;
  }

  if (argvalue.indexOf(":") != -1) {
    if (argvalue.indexOf(":") == (argvalue.length - 1))
      return false;
    else if (argvalue.charAt(argvalue.indexOf(":") + 1) == ".")
      return false;
    argvalue = argvalue.substring(0, argvalue.indexOf(":"));
    if (argvalue.charAt(argvalue.length - 1) == ".")
      return false;
  }

  return true;
}
</script>
<?php
}


// vrati do url premenne odovzdane metodou POST , argument je pole s nazvom premennej, ktora bude ignorovana
function urlPost($skry = Array("")){

	$retazec_f="";

	if (!is_array($skry))
		$skry = Array();

	foreach ($_POST as $key => $value){
		$preskoc = 0;

		foreach ($skry as $value_skry){
			if ($value_skry == $key)
				$preskoc = 1;
		}

		if ($preskoc == 1)
			continue;

		if (is_array($value)){
			foreach ($value as $key_1 => $value_1){
				if (is_array ($value_1)){
					foreach ($value_1 as $key_2 => $value_2){

						if (is_array ($key_2))
							continue;

						if ($value_2)
							$retazec_f.= "&".$key."[{$key_1}][{$key_2}]=".$value_2;
					}
				}
				else{
					if ($value_1)
						$retazec_f.= "&".$key."[{$key_1}]=".$value_1;
				}
			}
		}
		else{
			if ($value)
				$retazec_f .= "&".$key."=".$value;
		}
	}
	return $retazec_f."&";
}

// vrati do formulara premenne odovzdane metodou GET , argument je nazov premennej, ktora bude ignorovana
function insert_urlPost($input){
	return urlPost($input['hidden']);
}

// vrati do url premenne odovzdane metodou GET , argument je pole s nazvom premennej, ktora bude ignorovana
function urlGet($skry = Array()){
	$retazec_f="";

	if (!is_array($skry))
		$skry = Array();

	foreach ($_GET as $key => $value){
		$preskoc = 0;

		foreach ($skry as $value_skry){
			if ($value_skry == $key)
				$preskoc = 1;
		}

		if ($preskoc == 1)
			continue;

		if (is_array($value)){
			foreach ($value as $key_1 => $value_1){
				if (is_array ($value_1)){
					foreach ($value_1 as $key_2 => $value_2){

						if (is_array ($key_2))
							continue;

						if ($value_2)
							$retazec_f.= "&".$key."[{$key_1}][{$key_2}]=".$value_2;
					}
				}
				else{
					if ($value_1)
						$retazec_f.= "&".$key."[{$key_1}]=".$value_1;
				}
			}
		}
		else{
			if ($value)
				$retazec_f .= "&".$key."=".$value;
		}
	}
	return $retazec_f."&";
}

// vrati do url premenne odovzdane metodou GET , argument je nazov premennej, ktora bude ignorovana
function insert_urlGet($input){
	return urlGet($input['hidden']);
}


// vrati do formulara premenne odovzdane metodou GET , argument je nazov premennej, ktora bude ignorovana
function formGet($skry = Array()){
	$retazec_f="";

	if (!is_array($skry))
		$skry = Array();

	foreach ($_GET as $key => $value){
		$preskoc = 0;

		foreach ($skry as $value_skry){
			if ($value_skry == $key)
				$preskoc = 1;
		}

		if ($preskoc == 1)
			continue;

		if (is_array($value)){
			foreach ($value as $key_1 => $value_1){
				if (is_array ($value_1)){
					foreach ($value_1 as $key_2 => $value_2){

						if (is_array ($key_2))
							continue;

						if ($value_2)
							$retazec_f.= "<input type=\"hidden\" name=\"".$key."[{$key_1}][{$key_2}]\" value=\"".$value_2."\" />";
					}
				}
				else{
					if ($value_1)
						$retazec_f.= "<input type=\"hidden\" name=\"".$key."[{$key_1}]\" value=\"".$value_1."\" />";
				}
			}
		}
		else{
			if ($value)
				$retazec_f.= "<input type=\"hidden\" name=\"".$key."\" value=\"".$value."\" />";
		}
	}
	return $retazec_f."\n";
}

// vrati do formulara premenne odovzdane metodou GET , argument je nazov premennej, ktora bude ignorovana
function insert_formGet($input){
	return formGet($input['hidden']);
}

function insert_getNameCategory($category){
	$category_detail = new CMS_Category($category['id']);

	$category_detail->setContextLanguage($GLOBALS['localLanguage']);
	$defaultView = 0;
	if ($category_detail->getTitle() == ''){
		$category_detail->setContextLanguage($GLOBALS['localLanguageDefault']);
		$defaultView = 1;
	}

	if ($defaultView == 1){
		if ($category_detail->getTitle() <> '')
			return $GLOBALS['defaultViewStartTag'].$category_detail->getTitle().$GLOBALS['defaultViewEndTag'];
		else
			return;
	}
	else{
		return $category_detail->getTitle();
	}
}

function insert_getParentsCategoryArt($article){
	$article_detail = new CMS_Article($article['id']);
	$article_detail_output = $article_detail->getParents();
	return $article_detail_output;
}

function insert_getParentsCategoryWeblink($weblink){
	$weblink_detail = new CMS_Weblink($weblink['id']);
	$weblink_detail_output = $weblink_detail->getParents();
	return $weblink_detail_output;
}

function insert_getParentCategoryCat($caid){
	$category_detail = new CMS_category($caid['id']);
	$parent = $category_detail->getParent();
	if ($parent == null)
		return -1;
	else

	if ($parent->getId()>0)
		return $parent->getId();
	else
		return 0;
}

function insert_getParentCategoryBranch($caid){
	$category_detail = new CMS_Catalog_Branch($caid['id']);
	$parent = $category_detail->getParent();
	if ($parent == null)
			return -1;
		else

			if ($parent->getId()>0)
					return $parent->getId();
				else
					return 0;
}

function insert_getParentMenuList($input){
	if ($input['class'] != 'CMS_EventCalendar_Event'){
		$class = new $input['class'] ($input['id']);
		return $class->getMenuList();
	}
	else{
		$class = new $input['class'] ($input['id']);
		return $class->getParentMenus();
	}
}


function insert_getOptionListMappedCategory($zdroj){


	if(!(($zdroj['free'] == 'onlytotally') || ($zdroj['free'] == 'onlycategory'))){
			$menu = new CMS_MenuList();
			$menu->addCondition("is_trash", 0);
			$menu_list = $menu->execute();

			foreach($menu as $menu_id => $value){

					$value->setContextLanguage($GLOBALS['localLanguage']);

					$defaultView = 0;
					if ($value->getTitle() == ''){
						$value->setContextLanguage($GLOBALS['localLanguageDefault']);
						$defaultView = 1;
					}



					if($defaultView == 1)
						$menu_title = $GLOBALS['defaultViewStartTag'].$value->getTitle().$GLOBALS['defaultViewEndTag'];
					else
						$menu_title = $value->getTitle();

					$menu_id = $value->getId();

					$top_category = new CMS_Menu($value->getId());
					// div
					$top_category_foreach = $top_category->getItems();
					echo "<optgroup label='$menu_title'>";

					foreach($top_category_foreach as $cat_id => $cat_value){

						// VYPNUTIE ZOBRAZENIA INYCH TYPOV AKO JE CATEGORY
						//if(CMS_ProjectConfig::getSingleton()->checkModuleAvailability('CMS_Gallery')){
						//	if (!(($cat_value instanceof CMS_Category)||($cat_value instanceof CMS_Gallery)))
						//		continue;
						//}
						//else {
						//	if (!($cat_value instanceof CMS_Category))
						//		continue;
						//}


						if ($cat_value->getType() != CMS_Category::ENTITY_ID)
							continue;

            			$is_trash = $cat_value->getIsTrash();
            			if($is_trash)
               				continue;

					###################################################
					# privileges ######################################

					$disabled = null;

					if($GLOBALS['user_login_type'] != CMS_UserLogin::ADMIN_USER)
					{
						if($GLOBALS['user_login']->checkEditorPrivilege($cat_value,false) === false)
						{
							//if($GLOBALS['user_login']->checkPrivilege(6, CMS_Privileges::UPDATE_PRIVILEGE) === false)
								$disabled = 'disabled="disabled" style="color:#999; background:white;"';
						}
					}

					###################################################

							$cat_value->setContextLanguage($GLOBALS['localLanguage']);
							$defaultView = 0;
							if ($cat_value->getTitle() == ''){
								$cat_value->setContextLanguage($GLOBALS['localLanguageDefault']);
								$defaultView = 1;
							}

							if($defaultView == 1)
								$top_cat_title = $GLOBALS['defaultViewStartTag'].$cat_value->getTitle().$GLOBALS['defaultViewEndTag'];
							else
								$top_cat_title = $cat_value->getTitle();


							$top_cat_id = $cat_value->getId();
							if (isset($zdroj['zakaz']) and $zdroj['zakaz'] != $top_cat_id){
									echo "<option $disabled value=\"$top_cat_id\"";
									if(CMS_ProjectConfig::getSingleton()->checkModuleAvailability('CMS_Gallery')){
										if ($cat_value instanceof CMS_Gallery)
											echo " style=\"color:#ff0000\" ";
									}
									if($top_cat_id == $zdroj['select'])echo" selected=\"selected\" ";
									echo ">$top_cat_title </option>";
								}
							$send['adr'] = $top_cat_id;
							$send['uroven'] = 1;
							$send['select'] = $zdroj['select'] ?? null;
							$send['zakaz'] = $zdroj['zakaz'] ?? null;
							getOptionListMappedCategoryToMenu($send);
						}

					echo "</optgroup>";
				}
		}

	if ( ($zdroj['free'] == 'category') || ($zdroj['free'] == 'totally') || ($zdroj['free'] == 'onlytotally') || ($zdroj['free'] == 'onlycategory'))
			insert_getOptionListFreeCategory($zdroj);
}



function getOptionListMappedCategoryToMenu($zdroj){
//print_r($zdroj);exit;
	//return;
	static $stupen = 0;
	$stupen++;
	$i = 0;
	$adr = $zdroj['adr'];
	$uroven = $zdroj['uroven'];

	$category = new CMS_Category($adr);

	$category_filter_foreach_vektor = $category->getItems();
	$zaznamov = $category_filter_foreach_vektor->getSize();

	$space = "&nbsp;&nbsp;&nbsp;&nbsp;";

	$odstup = "";
	for ($f=0;$f<$uroven;$f++)
					$odstup .= $space;

	foreach($category_filter_foreach_vektor as $cat_id => $value){

		// VYPNUTIE ZOBRAZENIA INYCH TYPOV AKO JE CATEGORY
		//if(CMS_ProjectConfig::getSingleton()->checkModuleAvailability('CMS_Gallery')){
		//	if (!(($cat_value instanceof CMS_Category)||($cat_value instanceof CMS_Gallery)))
		//		continue;
		//}
		//else {
		//	if (!($cat_value instanceof CMS_Category))
		//		continue;
		//}

		if ($value->getType() != CMS_Category::ENTITY_ID)
			continue;

		$is_trash = $value->getIsTrash();
      if($is_trash)
          continue;

		###################################################
		# privileges ######################################

		$disabled = null;

		if($GLOBALS['user_login_type'] != CMS_UserLogin::ADMIN_USER)
		{
			if($GLOBALS['user_login']->checkEditorPrivilege($value,false) === false)
			{
				//if($GLOBALS['user_login']->checkPrivilege(6, CMS_Privileges::UPDATE_PRIVILEGE) === false)
					$disabled = 'disabled="disabled" style="color:#999; background:white;"';
			}
		}

		###################################################

      $i++;
			$value->setContextLanguage($GLOBALS['localLanguage']);
			$defaultView = 0;
			if ($value->getTitle() == ''){
				$value->setContextLanguage($GLOBALS['localLanguageDefault']);
				$defaultView = 1;
			}

			if($defaultView == 1)
				$title = $GLOBALS['defaultViewStartTag'].$value->getTitle().$GLOBALS['defaultViewEndTag'];
			else
				$title = $value->getTitle();

			$id = $value->getId();

			//
			//if (($stupen > 1) && ($i==1) && ($uroven > 0))
			//		echo "<optgroup>";

			if ($zdroj['zakaz'] != $id){
					echo "<option $disabled value=\"$id\"";
					if($id == $zdroj['select'])echo" selected=\"selected\" ";

					if(CMS_ProjectConfig::getSingleton()->checkModuleAvailability('CMS_Gallery')){
						if ($value instanceof CMS_Gallery)
							echo " style=\"color:#ff0000\" ";
					}
					echo "> $odstup$title</option>";
				}
			//
			//if (($stupen > 1) && ($i == $zaznamov) && ($uroven > 0))
			//		echo "</optgroup>";

			$send['adr'] = $id;
			$send['uroven'] = $uroven+1;
			$send['select'] = $zdroj['select'];
			$send['zakaz'] = $zdroj['zakaz'];
			getOptionListMappedCategoryToMenu($send);
		}

}

function insert_getOptionListFreeCategory($zdroj){
	if (($zdroj['free']=='totally')||($zdroj['free']=='onlytotally')){
				$category_free_foreach = CMS_CategoryList::getTotalyFreeCategories($execute=true);
		}

	if (($zdroj['free']=='category')||($zdroj['free']=='onlycategory')){
				$category_free_foreach = CMS_CategoryList::getFreeCategories($execute=true);
		}

	echo "<optgroup label='".tr('Nepriradené kategórie')."'>";
	foreach($category_free_foreach as $cat_id => $value){

		if(CMS_ProjectConfig::getSingleton()->checkModuleAvailability('CMS_Gallery')){
			if (!(($value instanceof CMS_Category)||($value instanceof CMS_Gallery)))
				continue;
		}
		else {
			if (!$value instanceof CMS_Category)
				continue;
		}
		$is_trash = $value->getIsTrash();
		if($is_trash)
			continue;

		###################################################
		# privileges ######################################

		$disabled = null;

		if($GLOBALS['user_login_type'] != CMS_UserLogin::ADMIN_USER)
		{
			if($GLOBALS['user_login']->checkEditorPrivilege($value,false) === false)
			{
				//if($GLOBALS['user_login']->checkPrivilege(6, CMS_Privileges::UPDATE_PRIVILEGE) === false)
					$disabled = 'disabled="disabled" style="color:#999; background:white;"';
			}
		}

		###################################################

			if (isset($zdroj['zakaz']) and $zdroj['zakaz'] != $value->getId()){

					$value->setContextLanguage($GLOBALS['localLanguage']);
					$defaultView = 0;
					if ($value->getTitle() == ''){
						$value->setContextLanguage($GLOBALS['localLanguageDefault']);
						$defaultView = 1;
					}

					if($defaultView == 1)
						$title = $GLOBALS['defaultViewStartTag'].$value->getTitle().$GLOBALS['defaultViewEndTag'];
					else
						$title = $value->getTitle();

					echo "<option $disabled value=\"".$value->getId()."\"";
					if($value->getId() == $zdroj['select'])echo" selected=\"selected\" ";

					if(CMS_ProjectConfig::getSingleton()->checkModuleAvailability('CMS_Gallery')){
						if ($value instanceof CMS_Gallery)
							echo " style=\"color:#ff0000\" ";
					}
					echo ">".$value->getTitle()."</option>";
				}
		}
	echo"</optgroup>";
}

function insert_getObjectType($object){

	if (get_class($object['item']) == 'CMS_Category'){
			if ($object['set'] == "number" )
					return 1;

			if ($object['set'] == "section")
					return "category";

			if ($object['set'] == "updatelink")
					return 3;

			if ($object['set'] == "3name")
					return "cat";

			if ($object['set'] == "privileges" )
					return 6;

			if ($object['set'] == "realname" ){

				if ($object['return'] == "name")
					return strtolower(substr(get_class($object['item']),4));

				if ($object['return'] == "fullname")
					return get_class($object['item']);
			}

		}
	elseif (get_class($object['item']) == 'CMS_Menu'){
			if ($object['set'] == "section")
					return "menu";

			if ($object['set'] == "updatelink")
					return 6;


			if ($object['set'] == "realname" ){

				if ($object['return'] == "name")
					return strtolower(substr(get_class($object['item']),4));

				if ($object['return'] == "fullname")
					return get_class($object['item']);
			}

			if ($object['set'] == "privileges" )
			return 1;

		}

	elseif (get_class($object['item']) == 'CMS_Article'){
			if ($object['set'] == "number" )
					return 2;

			if ($object['set'] == "section")
					return "article";

			if ($object['set'] == "updatelink")
					return 9;

			if ($object['set'] == "updatelinkjob")
					return 4;

			if ($object['set'] == "3name")
					return "art";

			if ($object['set'] == "privileges" )
					return 5;

			if ($object['set'] == "realname" ){

				if ($object['return'] == "name")
					return strtolower(substr(get_class($object['item']),4));

				if ($object['return'] == "fullname")
					return get_class($object['item']);
			}
		}
	elseif (get_class($object['item']) == 'CMS_Weblink'){
			if ($object['set'] == "number" )
					return 5;

			if ($object['set'] == "section")
					return "weblink";

			if ($object['set'] == "updatelink")
					return 14;

			if ($object['set'] == "updatelinkjob")
					return 5;

			if ($object['set'] == "3name")
					return "web";

			if ($object['set'] == "privileges" )
					return 7;

			if ($object['set'] == "realname" ){

				if ($object['return'] == "name")
					return strtolower(substr(get_class($object['item']),4));

				if ($object['return'] == "fullname")
					return get_class($object['item']);
			}
		}

	elseif (get_class($object['item']) == 'CMS_Gallery'){
			if ($object['set'] == "number" )
					return 1;

			if ($object['set'] == "section")
					return "category";

			if ($object['set'] == "updatelink")
					return 3;

			if ($object['set'] == "3name")
					return "cat";

			if ($object['set'] == "privileges" )
					return 6;

			if ($object['set'] == "realname" ){

				if ($object['return'] == "name")
					return strtolower(substr(get_class($object['item']),4));

				if ($object['return'] == "fullname")
					return get_class($object['item']);
			}

		}
	elseif (get_class($object['item']) == 'CMS_Catalog'){

			if ($object['set'] == "number" )
					return 1;

			if ($object['set'] == "section")
					return "catalog";

			if ($object['set'] == "updatelink")
					return 3;

			if ($object['set'] == "3name")
					return "cat";

			if ($object['set'] == "privileges" )
					return 6;

			if ($object['set'] == "realname" ){

				if ($object['return'] == "name")
					return strtolower(substr(get_class($object['item']),4));

				if ($object['return'] == "fullname")
					return get_class($object['item']);
			}

		}
elseif (get_class($object['item']) == 'CMS_EventCalendar_Event'){

			if ($object['set'] == "number" )
					return 1;

			if ($object['set'] == "section")
					return "eventcalendar_event";

			if ($object['set'] == "updatelink")
					return 3;

			if ($object['set'] == "3name")
					return "cat";

			if ($object['set'] == "privileges" )
					return 6;

			if ($object['set'] == "realname" ){

				if ($object['return'] == "name")
					return strtolower(substr(get_class($object['item']),4));

				if ($object['return'] == "fullname")
					return get_class($object['item']);
			}

		}
	if (get_class($object['item']) == 'CMS_Group'){

			if ($object['set'] == "number" )
					return 7;

			if ($object['set'] == "section")
					return "group";

			if ($object['set'] == "updatelink")
					return 35;

			if ($object['set'] == "3name")
					return "grp";

			if ($object['set'] == "privileges" )
					return 12;

			if ($object['set'] == "realname" ){

				if ($object['return'] == "name")
					return strtolower(substr(get_class($object['item']),4));

				if ($object['return'] == "fullname")
					return get_class($object['item']);
			}

		}
	elseif ($object['set'] == "realname" ){

		if ($object['return'] == "name")
			return strtolower(substr(get_class($object['item']),4));

		if ($object['return'] == "fullname")
			return get_class($object['item']);
	}
	else

		return null;
}

function getObjectType($item, $set = 'number', $return = "name"){

	$object['item'] = $item;
	$object['set'] = $set;
	$object['return'] = $return;

	return insert_getObjectType($object);

}

function insert_getOptionListAuthors($input){
	$editor_users = new CMS_UserList();
	$editor_users->addCondition('is_editor', 1);
	$editor_users->addCondition('is_enabled', 1);
	$editor_users->execute();
	$html = '';
	foreach ($editor_users as $user_id){
		$html .= "<option value='".$user_id->getId()."'";

		if ($input['select'] == $user_id->getId())
			$html .= " selected=\"selected\" ";

		$html .= ">".$user_id->getFamilyname()." ".$user_id->getFirstname()."</option>";
	}
	echo $html;
}


function insert_getOptionListWebUsers($input){
	$editor_users = new CMS_UserList();
	$editor_users->addCondition('is_editor', 0);
	$editor_users->addCondition('is_enabled', 1);
	$editor_users->execute();
	$html = '';
	foreach ($editor_users as $user_id){
		$html .= "<option value='".$user_id->getId()."'";

		if ($input['select'] == $user_id->getId())
			$html .= " selected=\"selected\" ";

		$html .= ">".$user_id->getFamilyname()." ".$user_id->getFirstname()."</option>";
	}
	echo $html;
}

function insert_getAuthor($input){
	if ($input['id'] > 0){
		$author = new CMS_User($input['id']);
		return $author->getFamilyname()." ".$author->getFirstname();
	}
}



function insert_makeCalendar($data){

	 $GLOBALS['calendar']->make_input_field(
          // calendar options go here; see the documentation and/or calendar-setup.js
          array('firstDay'       => 1, // show Monday first
                'showsTime'      => true,
                'showOthers'     => true,
                'ifFormat'       => '%Y-%m-%d %I:%M',
                'timeFormat'     => '24'),
          // field attributes go here
          array('style'       => 'width: 13em; color: #000; background-color: #fff; border: 1px solid #000; text-align: center',
                'name'        => $data['nazov'],
                'value'       => $data['value']));
}

function getDirectoryList($path = ""){
	$upfolder = true;
	if (($path == "") or ($path == "/")) $upfolder = false;
	$path = "{$GLOBALS['config']['mediadir']}/$path";

	$dh = @opendir($path);

	$files = array();
	$dirs = array();

	while (false !== ($file = @readdir($dh))){

		if (substr($file,0,1)!="."){
				if (is_dir($path.$file)){
				  if($file!="_thumbs"){
						  $file_n['name'] = $file;

						  $file_t['ftype'] = 1;

					   	$file_l['flink'] = $file.'/';

						  $dirs[$file]= array_merge($file_n,$file_t,$file_l);
						}
					}
				else{
						$file_n['name'] = $file;

						$file_n2 = stat($path.$file);

						$file_t['ftype'] = 2;

						$file_l['flink'] = $file;

						$er = explode('.', $file);
						$file_p['fend'] = strtolower(end($er));

						$files[$file]= array_merge($file_n,$file_n2,$file_t,$file_p,$file_l);
				}
			}

		}

	@closedir($dh);

	if ($files)
			ksort($files);
	if ($dirs)
			ksort($dirs);

	$files_all = array_merge($dirs,$files);
	$upname = "";
	if ($upfolder) {
			$first_row['aaa']['name'] = "[..]";
			$p = str_replace("//","/",$path);
			$p = substr($p, 0, -1);
			$folders = explode("/", $p);
			$num_folders = count($folders)-1;
			for ($f=4;$f<$num_folders;$f++)
				$upname .= $folders[$f].'/';

			$first_row['aaa']['flink'] = $upname;
			$first_row['aaa']['ftype'] = 3;
			$files_all = array_merge($first_row,$files_all);
		}

	return $files_all;
}

function insert_url_decode($linka){
	$new_link = urlencode($linka['l1'].$linka['l2']);
	return $new_link;
}

function insert_getOptionFolderList($input){
	$dir = rec_scandir("{$GLOBALS['config']['mediadir']}",0,$input['selected']);
	//array_ukmultisort($dir, "cmp");
	echo $dir;
}

function rec_scandir($dir,$uroven,$selected)
{
	static $stupen = 0;
	$stupen++;
		$space = "&nbsp;&nbsp;&nbsp;&nbsp;";
	static $files;
    $odstup = "";
	for ($f=0;$f<$uroven;$f++)
					$odstup .= $space;

   if ( $handle = opendir($dir) ) {
       while ( ($file = readdir($handle)) !== false ) {
           if ( $file != ".." && $file != "." ) {
               if (( is_dir($dir . "/" . $file) )&&($file != '_thumbs')) {
                   $files .= "<option value=\"$dir/$file/\"";
                   if(compare_dirName("$dir/$file/",$selected)) $files .= " selected=\"selected\" ";
					$files .= ">$odstup$file</option>";
				   rec_scandir($dir . "/" . $file,$uroven+1,$selected);
               }else {
                  // $files[] = $file;
               }
           }
       }
       closedir($handle);
       return $files;
   }
}

function compare_dirName($zdroj='',$compare=''){
	$dlzka = strlen($compare)-(2*strlen($compare));
	if (($dlzka == 0) || ($dlzka == -1))
		return FALSE;
	//echo $dlzka;exit;
	if (substr($zdroj,$dlzka) == $compare)
		return TRUE;
	else
		return FALSE;

}

###########  USER EXTENSION HANDLING ######################################################################

function insert_buildUserExtensionForm($user)
{
	$file = $GLOBALS['cms_root'].'www/'.$_SESSION['user']['name'].'/cms_classes/cms_user_ext.php';

	if(file_exists($file))
	{
		CN_ClassLoader::getSingleton()->addSearchPath($GLOBALS['cms_root'].'www/'.$_SESSION['user']['name'].'/cms_classes/');

		$e = new CMS_UserExt($user['value']->getId());

		echo '<tr><td colspan="3"><hr /></td></tr>';

		################################################################################################

		$table_info = CN_SqlTableInfo::getSingleton();
		$table_info->setName($e->getExtTable());
		$column_list = $table_info->getColumnList();

		foreach($column_list as $column)
		{
			if($column->getName() == 'user_id')
				continue;

			$name = $column->getComment();
			$control = null;

			if($column->getType() == 'tinyint(1)')
			{
				$method_name = 'get'.CN_Utils::getObjectName($column->getName());
				$checked = $e->$method_name() == 1 ? 'checked="checked"' : null;

				$control = '<input type="checkbox" name="f_'.$column->getName().'" id="f_'.$column->getName().'" value="1" '.$checked.' />';
			}
			elseif(strpos($column->getType(), 'varchar') !== false)
			{

				$method_name = 'get'.CN_Utils::getObjectName($column->getName());
				$value = $e->$method_name();

				$control = '<input type="text" size="50" name="f_'.$column->getName().'" id="f_'.$column->getName().'" value="'.$value.'" />';
			}else{

				$method_name = 'get'.CN_Utils::getObjectName($column->getName());
				$control = $e->$method_name();

			}

			echo <<<EXT
			<tr>
				<td>&nbsp;$name</td>
				<td>$control</td>
			</tr>
EXT;
		}
		echo '<tr><td colspan="3">&nbsp;</td></tr>';
	}
}


###########  ALL MODULES ###################################################################################
function insert_merge($value){
	return $value['value1'].$value['value2'].$value['value3'];
}
#######################################################################################################
###########  inquiry ###################################################################################
function insert_getQuestions($inquiry){

	$inquiry_detail = new CMS_Inquiry($inquiry[id]);
	$quest = $inquiry_detail->getQuestions();

	return $quest;

}

function insert_getAnswers($question){

	$question_detail = new CMS_Inquiry_Question($question[id]);
	$answers = $question_detail->getAnswers();

	return $answers;

}

function insert_getCountAnswersForInquiry($anketa){
	$count = 0;
	$inquiry_detail = new CMS_Inquiry($anketa[id]);
	$quest = $inquiry_detail->getQuestions();
	foreach($quest as $q_id => $value){
			$question_detail = new CMS_Inquiry_Question($value->getId());
			$answer = $question_detail->getAnswers();
			$count += $answer->getSize();
		}
	return $count;
}
#######################################################################################################

function getConfig($section,$option){
	$Array = $GLOBALS["config_all"]->getValue($section,$option);

	return $Array['value'];
}

function insert_getConfig($input){
	$Array = $GLOBALS["config_all"]->getValue($input['section'],$input['option']);

	return $Array['value'];
}

function insert_getUserInfo($input){

	return new CMS_User($input['id']);

}

function insert_language_enable($input){

	$enableLanguages = array_flip(CMS_ProjectConfig::getSingleton()->getAvailableTranslations());

	$language_vektor = CMS_Languages::getSingleton();
	$language_list = $language_vektor->getList();

	$language_list_enable = array_flip(array_diff_key($enableLanguages,$language_list));

	return($language_list_enable);
}

function insert_language_search($input){

	$kde_hladat = $input['input'];
	$co_hladat = $input['select'];

	if (array_search($co_hladat,$kde_hladat) !== false)
		return 1;
	else
		return 0;
}

###################################################################################################
# category privileges functions ###################################################################

function buildTree()
{
	$tree_menu = $GLOBALS["cp_tm"];

	$category_list = CMS_CategoryList::getFreeCategories(null, null, false);
	$category_list->addCondition('is_trash', 0);
	$category_list->execute();

	foreach($category_list as $category)
	{
		$item = new Apycom_TreeItem();
		$item->setItemStyle("menu_style");
		$item->setNormalIcon("images/icon_folder.gif");
    // tu bolo checkEditorPrivilege($category, false) uz nastavene
		$checked = $GLOBALS['current_user']->checkEditorPrivilege($category, false) === false ? 'checked=\"checked\"' : '';
		$checkbox = "&nbsp;&nbsp;&nbsp;<input class=checkboxSiteMap type='checkbox' name='category_privileges[]' ".$checked." value='".$category->getId()."'>&nbsp;&nbsp;&nbsp;";

		$item->setLabel($checkbox.$category->getTitle().'&nbsp;&nbsp;&nbsp;'.$category->getId());

		$tree_menu->addTreeItem($item);

		if($category->hasChildren())
			buildSubTree($item, $category);
	}
}

function buildSubTree($item, $parent_category)
{
	$children_list = $parent_category->getChildren();

	foreach($children_list as $category)
	{
		if($category->getIsTrash() == 1)
			continue;

		$child_item = new Apycom_TreeItem();
		$child_item->setNormalIcon("images/icon_folder.gif");
    // tu bolo checkEditorPrivilege($category, false) uz nastavene
		$checked = $GLOBALS['current_user']->checkEditorPrivilege($category, false) === false ? 'checked=\"checked\"' : '';
		$checkbox = "&nbsp;&nbsp;&nbsp;<input class=checkboxSiteMap type='checkbox' name='category_privileges[]' ".$checked." value='".$category->getId()."'>&nbsp;&nbsp;&nbsp;";

		$child_item->setLabel($checkbox.$category->getTitle().'&nbsp;&nbsp;&nbsp;'.$category->getId());

		$item->addChildItem($child_item);

		if($category->hasChildren())
			buildSubTree($child_item, $category);
	}
}

function number_login_name($login,$id=0){
	return User_extend::getNumberLoginName($login,$id);
}
function insert_stripslashes($input){
	return stripslashes($input['input']);
}

function setHistory($object,$action_type = 'view'){
	$time = time();
	$key = $time.$action_type;
	$_SESSION['history'][$key]['object'] = serialize($object);
	$_SESSION['history'][$key]['time'] = $time;
	$_SESSION['history'][$key]['action_type'] = $action_type;
}

function insert_unserialize($input){
	return unserialize($input['input']);
}

function setReturnPoint($layer = 0, $stop = array()){
	if ( empty($stop) ){
		$stop[]="form_name";
		$stop[]="form_text_name";
	}

	if (isset($_SESSION['returnParameter']) and is_array($_SESSION['returnParameter'])){
		$maxlayer = count ($_SESSION['returnParameter'])-1;

		if ($layer < $maxlayer){

			for ($num_layer=$layer+1; $num_layer<= $maxlayer; $num_layer++)
				unset ($_SESSION['returnParameter'][$num_layer]);

		}
	}
//die ("XXX");exit;
//	debug_print_backtrace();
	$_SESSION['returnParameter'][$layer] = urlGet($stop);
};


function getReturnParameter($layer = -1){
	if(!isset($_SESSION['returnParameter']))$_SESSION['returnParameter'] = null;
	if (is_array($_SESSION['returnParameter'])){

		if ($layer >= 0)
			return $_SESSION['returnParameter'][$layer];
		else {
			$maxlayer = count ($_SESSION['returnParameter'])-1;
			return $_SESSION['returnParameter'][$maxlayer];
		}

	}
	else
		return;
};


function insert_getReturnParameter($input){

	if(!isset($input['layer']))
		$input['layer'] = -1;

	return getReturnParameter($input['layer']);

};

###################################################################################################
# smarty resource plugin ##########################################################################

	function Proxia_getTemplate($block_path, &$tpl_source, &$smarty)
	{
		list($theme_name, $template_name) = explode('.', $block_path);

		$tpl_source = file_get_contents("../tpl_resources/{$template_name}.tpl");

		return true;
	}

	function Proxia_getTimestamp($block_path, &$tpl_timestamp, &$smarty)
	{
		list($theme_name, $template_name) = explode('.', $block_path);

		$tpl_timestamp = filemtime("../tpl_resources/{$template_name}.tpl");

		return true;
	}

	function Proxia_isSecure($block_path, &$smarty)
	{
		return true;
	}

	function Proxia_isTrusted($block_path, &$smarty)
	{
		return true;
	}

###################################################################################################

function insert_initialize_pager_vars($input){
	$GLOBALS["smarty"]->assign("start",$_GET['start']);
	$GLOBALS["smarty"]->assign("p_firstStart",$input['list']->getFirstPageOffset());
	$GLOBALS["smarty"]->assign("p_lastStart",$input['list']->getLastPageOffset());
	$GLOBALS["smarty"]->assign("p_nextStart",$input['list']->getNextPageOffset());
	$GLOBALS["smarty"]->assign("p_previousStart",$input['list']->getPreviousPageOffset());
	$GLOBALS["smarty"]->assign("p_pageCount",$input['list']->getPageCount());
	$GLOBALS["smarty"]->assign("p_currentPage",$input['list']->getCurrentPage());
	$GLOBALS["smarty"]->assign("p_size",$input['list']->getSize());
	$GLOBALS["smarty"]->assign("p_firstPage",$input['list']->getFirstPage());
	$GLOBALS["smarty"]->assign("p_lastPage",$input['list']->getLastPage());
	$GLOBALS["smarty"]->assign("perpage",$GLOBALS["perpage"]);
	$GLOBALS["smarty"]->assign("p_totalRecordCount",$input['list']->getTotalRecordCount());
}

function insert_getConfigProject($input){

	$file = "..".$GLOBALS['project_folder']."/".$input['project']."/config/config.xml";
	if(file_exists($file)){
		$GLOBALS['config'] = CN_Config::loadFromFile($file);
	  $Array = $GLOBALS['config']->getValue($input['section'],$input['option']);
	  return $Array['value'];
	}else return false;
}

function insert_getGlobalForm($input){

	switch ($input['key_name']) {

		case 'email_webmaster':
			echo "<input type=\"text\" size=\"50\" id=\"f_{$input['key_name']}\" name=\"f_{$input['key_name']}\" value=\"{$input['key_value']}\">";
		break;

		case 'name':
			echo "<input type=\"text\" size=\"30\" id=\"f_{$input['key_name']}\" name=\"f_{$input['key_name']}\" value=\"{$input['key_value']}\">";
		break;

		case 'default_site_language':
			$language_vektor = CMS_Languages::getSingleton();
			$language_list = $language_vektor->getList();

     		$enableLanguages = array_flip(CMS_ProjectConfig::getSingleton()->getAvailableTranslations());

      		$language_list_enable = array_intersect_key($language_list,$enableLanguages);
			echo "<select name=\"f_{$input['key_name']}\" id=\"f_{$input['key_name']}\">";
			foreach ($language_list_enable as $lang_id){
				echo "<option value=\"{$lang_id['code']}\"";
				if ($lang_id['code'] == $input['key_value'])
					echo " selected=\"selected\"";

				echo ">{$lang_id['native_name']}</option>";
			}
			echo "</select>";
		break;

		case 'records_per_page':
			$pager_list = array (10,20,50,100,200);
			echo "<select name=\"f_{$input['key_name']}\" id=\"f_{$input['key_name']}\">";
			foreach ($pager_list as $page){
				echo "<option value=\"$page\"";
				if ($page == $input['key_value'])
					echo " selected=\"selected\"";

				echo ">$page</option>";
			}
			echo "</select>";
		break;

		case 'prefered_editor_for_desc':
			$list = array ('none','tinymce_simple');
			echo "<select name=\"f_{$input['key_name']}\" id=\"f_{$input['key_name']}\">";
			foreach ($list as $list_id){
				echo "<option value=\"$list_id\"";
				if ($list_id == $input['key_value'])
					echo " selected=\"selected\"";

				echo ">$list_id</option>";
			}
			echo "</select>";
		break;

		case 'prefered_editor':
			$list = array ('none','tinymce_simple','tinymce_full','fck');
			echo "<select name=\"f_{$input['key_name']}\" id=\"f_{$input['key_name']}\">";
			foreach ($list as $list_id){
				echo "<option value=\"$list_id\"";
				if ($list_id == $input['key_value'])
					echo " selected=\"selected\"";

				echo ">$list_id</option>";
			}
			echo "</select>";
		break;


		case 'columns_display':
			$list = array ('simple','full');
			echo "<select name=\"f_{$input['key_name']}\" id=\"f_{$input['key_name']}\">";
			foreach ($list as $list_id){
				echo "<option value=\"$list_id\"";
				if ($list_id == $input['key_value'])
					echo " selected=\"selected\"";

				echo ">$list_id</option>";
			}
			echo "</select>";
		break;

		case 'logo':
			echo "<input type=\"text\" size=\"50\" name=\"f_{$input['key_name']}\" id=\"f_{$input['key_name']}\" value=\"{$input['key_value']}\">";
			echo "<a href=\"javascript:insertfile('form2','f_{$input['key_name']}')\" title=\"".tr('vlož obrázok')."\"><img src=\"images/paste.gif\" width=\"21\" height=\"21\" border=\"0\"></a>";
			if ($input['key_value'] != ''){
				$path = "{$GLOBALS['config']['mediadir']}/".$input['key_value'];
				$name = basename($path);
				echo "&nbsp;<a  href=\"$path\" target=\"_blank\" title=\"".tr('ukáž')."\"><img src=\"images/view_s.png\" border=\"0\"></a>";
			}
		break;

		case 'prefered_expand_tree':
			$list = array ('show','hidden');
			echo "<select name=\"f_{$input['key_name']}\" id=\"f_{$input['key_name']}\">";
			foreach ($list as $list_id){
				echo "<option value=\"$list_id\"";
				if ($list_id == $input['key_value'])
					echo " selected=\"selected\"";

				echo ">$list_id</option>";
			}
			echo "</select>";
		break;

		case 'upload_max_size':
			$list = array (
				1000000=>'1 MB',
				2000000=>'2 MB',
				4000000=>'4 MB',
				6000000=>'6 MB',
				8000000=>'8 MB',
				10000000=>'10 MB',
				15000000=>'15 MB',
				20000000=>'20 MB',
			);
			echo "<select name=\"f_{$input['key_name']}\" id=\"f_{$input['key_name']}\">";
			foreach ($list as $list_key => $list_id){
				echo "<option value=\"$list_key\"";
				if ($list_key == $input['key_value'])
					echo " selected=\"selected\"";

				echo ">$list_id</option>";
			}
			echo "</select>";
		break;

		case 'prefered_media_view':
			$list = array ('list','image');
			echo "<select name=\"f_{$input['key_name']}\" id=\"f_{$input['key_name']}\">";
			foreach ($list as $list_id){
				echo "<option value=\"$list_id\"";
				if ($list_id == $input['key_value'])
					echo " selected=\"selected\"";

				echo ">$list_id</option>";
			}
			echo "</select>";
		break;

		case 'default_local_language':
			$language_vektor = CMS_Languages::getSingleton();
			$language_list = $language_vektor->getList();

     		$enableLanguages = array_flip(CMS_ProjectConfig::getSingleton()->getAvailableTranslations());

      		$language_list_enable = array_intersect_key($language_list,$enableLanguages);
			echo "<select name=\"f_{$input['key_name']}\" id=\"f_{$input['key_name']}\">";
			foreach ($language_list_enable as $lang_id){
				echo "<option value=\"{$lang_id['code']}\"";
				if ($lang_id['code'] == $input['key_value'])
					echo " selected=\"selected\"";

				echo ">{$lang_id['native_name']}</option>";
			}
			echo "</select>";
		break;

		case 'prefered_language':
			$language_vektor = CMS_Languages::getSingleton();
			$language_list = $language_vektor->getList();

     		$enableLanguages = array_flip(CMS_ProjectConfig::getSingleton()->getAvailableTranslations());

      		$language_list_enable = array_intersect_key($language_list,$enableLanguages);
			echo "<select name=\"f_{$input['key_name']}\" id=\"f_{$input['key_name']}\">";
			foreach ($language_list_enable as $lang_id){
				echo "<option value=\"{$lang_id['code']}\"";
				if ($lang_id['code'] == $input['key_value'])
					echo " selected=\"selected\"";

				echo ">{$lang_id['native_name']}</option>";
			}
			echo "</select>";
		break;

		default:
			if ($input['key_type']=='bool'){
				echo "<input type=\"checkbox\" id=\"f_{$input['key_name']}\" name=\"f_{$input['key_name']}\" value=\"true\"";
				if ($input['key_value'] == 'true')
					echo "checked=\"checked\"";
				echo ">";
			}
			elseif ($input['key_type']=='numeric'){
				echo "<input type=\"text\" size=\"10\" id=\"f_{$input['key_name']}\" name=\"f_{$input['key_name']}\" value=\"{$input['key_value']}\" />";
			}
			elseif ($input['key_type']=='string'){
				echo "<input type=\"text\" size=\"70\" id=\"f_{$input['key_name']}\" name=\"f_{$input['key_name']}\" value=\"{$input['key_value']}\" />";
			}
			elseif ($input['key_type']=='longstring'){
				$input['key_value'] = stripslashes($input['key_value']);
				echo "<textarea cols=\"70\" rows=\"4\" name=\"f_{$input['key_name']}\">{$input['key_value']}</textarea>";
			}
		break;


	}
}


function getQuantumForEntity($entity_id){
	$object_name = CMS_Entity::getEntityNameById($entity_id)."List";
	$object = new $object_name();
	$object->execute();
	return $object->getSize();
}

function checkLimitAlert($entity_id){
	$entity_name = CMS_Entity::getEntityNameById($entity_id);
	if ($GLOBALS['project_config']->getQuantumForEntity($entity_name) == -1)
		return;

	if($GLOBALS['project_config']->getQuantumForEntity($entity_name) <= getQuantumForEntity($entity_id)){
		Header("Location: ./?message=".urlencode($GLOBALS['proxia']['limit_alert']));
		exit;
	}
}

function insert_bindImage($input){

	if($input['entita'] == 'article'){
		$bind = New CMS_ArticleList();
		$bind->setTableName('attachments,articles,articles_lang,articles_attachments');
		$bind->addCondition('`attachments`.`file` = \''.$input['image'].'\' AND `attachments`.`id` = `articles_attachments`.`attachment_id` AND `articles_attachments`.`article_id` = `articles`.`id` AND `articles`.`id` = `articles_lang`.`article_id` AND `articles_lang`.`language` = \''.$GLOBALS['localLanguage'].'\'',null,null,true);
		$bind->execute();
		if ($input['num'] == 0)
			return $bind;
		elseif ($input['num'] == 1)
			return $bind->getSize();
	}
	elseif($input['entita'] == 'gallery'){
		if(CMS_ProjectConfig::getSingleton()->checkModuleAvailability('CMS_Gallery')){
			$bind = New CMS_GalleryList();
			$bind->setTableName('attachments,categories,categories_lang,categories_bindings');
			$bind->addCondition('`attachments`.`file` = \''.$input['image'].'\' AND `attachments`.`id` = `categories_bindings`.`item_id` AND `categories_bindings`.`item_type` = '.CMS_Attachment::ENTITY_ID.' AND `categories_bindings`.`category_id` = `categories`.`id` AND `categories`.`id` = `categories_lang`.`category_id` AND `categories_lang`.`language` = \''.$GLOBALS['localLanguage'].'\'',null,null,true);
			$bind->execute();
			if ($input['num'] == 0)
				return $bind;
			elseif ($input['num'] == 1)
				return $bind->getSize();
		}
		else
			return null;
	}

	elseif($input['entita'] == 'categories'){
		$bind = new CMS_CategoryList();
		$bind->addCondition("image", "'{$input['image']}'");
		$bind->execute();
		if ($input['num'] == 0)
			return $bind;
		elseif ($input['num'] == 1)
			return $bind->getSize();
	}

	elseif($input['entita'] == 'weblink'){
		$bind = new CMS_WeblinkList();
		$bind->addCondition("image", "'{$input['image']}'");
		$bind->execute();
		if ($input['num'] == 0)
			return $bind;
		elseif ($input['num'] == 1)
			return $bind->getSize();
	}

	elseif($input['entita'] == 'categories_lang'){
		$bind = new CMS_CategoryList();
		$bind->setTableName('categories,categories_lang');
		$bind->addCondition(' (`categories`.`id` = `categories_lang`.`category_id` AND `categories_lang`.`localized_image` = \''.$input['image'].'\' )',null,null,true);
		$bind->execute();
		if ($input['num'] == 0)
			return $bind;
		elseif ($input['num'] == 1)
			return $bind->getSize();
	}

	elseif($input['entita'] == 'answer'){
		if(CMS_ProjectConfig::getSingleton()->checkModuleAvailability('CMS_Inquiry')){
			$bind = new CMS_InquiryList();
			$bind->setTableName('inquiry_inquiries_lang,inquiry_inquiries_bindings,inquiry_answers,inquiry_inquiries');
			$bind->addCondition(' (`inquiry_answers`.`image` = \''.$input['image'].'\' AND `inquiry_answers`.`question_id` = `inquiry_inquiries_bindings`.`question_id` AND `inquiry_inquiries_bindings`.`inquiry_id` = `inquiry_inquiries`.`id` AND `inquiry_inquiries`.`id` = `inquiry_inquiries_lang`.`inquiry_id` AND  `inquiry_inquiries_lang`.`language` = \''.$GLOBALS['localLanguage'].'\')',null,null,true);
			$bind->execute();
			if ($input['num'] == 0)
				return $bind;
			elseif ($input['num'] == 1)
				return $bind->getSize();
		}
		else
			return null;
	}

	elseif($input['entita'] == 'product'){
		if(CMS_ProjectConfig::getSingleton()->checkModuleAvailability('CMS_Catalog')){
			$bind = new CMS_Catalog_ProductList();
			$bind->addCondition("image", "'{$input['image']}'");
			$bind->execute();
			if ($input['num'] == 0)
				return $bind;
			elseif ($input['num'] == 1)
				return $bind->getSize();
		}
		else
			return null;
	}
	elseif($input['entita'] == 'attribut'){
		if(CMS_ProjectConfig::getSingleton()->checkModuleAvailability('CMS_Catalog')){
			$bind = new CMS_Catalog_AttributeDefinitionList();
			$bind->addCondition("image", "'{$input['image']}'");
			$bind->execute();
			if ($input['num'] == 0)
				return $bind;
			elseif ($input['num'] == 1)
				return $bind->getSize();
		}
		else
			return null;
	}
}

function insert_checkImageBind($input){

	$num = 0;
	$output['image'] = $input['image'];
	$output['num'] = 1;

	$output['entita'] = 'article';
	$num += insert_bindImage($output);

	if(CMS_ProjectConfig::getSingleton()->checkModuleAvailability('CMS_Gallery')){
		$output['entita'] = 'gallery';
		$num += insert_bindImage($output);
	}

	$output['entita'] = 'categories';
	$num += insert_bindImage($output);

	$output['entita'] = 'weblink';
	$num += insert_bindImage($output);

	$output['entita'] = 'categories_lang';
	$num += insert_bindImage($output);

	if(CMS_ProjectConfig::getSingleton()->checkModuleAvailability('CMS_Inquiry')){
		$output['entita'] = 'answer';
		$num += insert_bindImage($output);
	}

	if(CMS_ProjectConfig::getSingleton()->checkModuleAvailability('CMS_Catalog')){
		$output['entita'] = 'product';
		$num += insert_bindImage($output);

		$output['entita'] = 'attribut';
		$num += insert_bindImage($output);
	}
	if ($num > 0)
		return 1;
	else
		return 0;
}


function insert_getComboRegister($input){

	if(CMS_ProjectConfig::getSingleton()->checkModuleAvailability('CMS_Register')){
			$module = CMS_Module::addModule('CMS_Register');
			$module->utilise();

		}
	$register = New CMS_Register_List();
	$register->addCondition("name", "'{$input['code']}'");
	$register->addCondition("is_published", 1);
	$register->execute();
	$html = '';
	if($register->getSize() == 1){
		foreach ($register as $register_id){
			$entry_list = new CMS_Register_EntryList();
			$entry_list->addCondition("register_id", $register_id->getId());
			$entry_list->addCondition("is_published", 1);
			$entry_list->setSortBy('order');
			$entry_list->execute();

			if ($entry_list->getSize() > 0){
				foreach ($entry_list as $entry_id){
					$entry_id->setContextLanguage($GLOBALS['localLanguage']);
					$html .= "<option value=\"".$entry_id->getId()."\"";
					if ($input['select'] == $entry_id->getId())
						$html .= " selected=\"selected\" ";
					$html .= ">".$entry_id->getValue()."</option>";

				}
			}
		}
	}
	return $html;
}

function getComboRegister($entry_name,$entry_select){
	$output['code'] = $entry_name;
	$output['select'] = $entry_select;
	return insert_getComboRegister($output);
}

function insert_getRegisterEntryName($input){

	if(CMS_ProjectConfig::getSingleton()->checkModuleAvailability('CMS_Register')){
			$module = CMS_Module::addModule('CMS_Register');
			$module->utilise();

		}

	if ($input['id'] > 0){
		$register = New CMS_Register_List();
		$register->addCondition("name", "'{$input['code']}'");
		$register->addCondition("is_published", 1);
		$register->execute();
		$html = '';
		if($register->getSize() == 1){
			foreach ($register as $register_id){
				$entry_list = new CMS_Register_EntryList();
				$entry_list->addCondition("register_id", $register_id->getId());
				$entry_list->addCondition("is_published", 1);
				$entry_list->setSortBy('order');
				$entry_list->execute();

				if ($entry_list->getSize() > 0){
					foreach ($entry_list as $entry_id){
						$entry_id->setContextLanguage($GLOBALS['localLanguage']);
						if ($entry_id->getId() == $input['id'])
							return $entry_id->getValue();
					}
				}
			}
		}
		return $html;
	}
}

function utf2ascii($s){
	static $tbl = array("("=>"",")"=>"","&"=>""," "=>"_","\xc3\xa1"=>"a","\xc3\xa4"=>"a","\xc4\x8d"=>"c","\xc4\x8f"=>"d","\xc3\xa9"=>"e","\xc4\x9b"=>"e","\xc3\xad"=>"i","\xc4\xbe"=>"l","\xc4\xba"=>"l","\xc5\x88"=>"n","\xc3\xb3"=>"o","\xc3\xb6"=>"o","\xc5\x91"=>"o","\xc3\xb4"=>"o","\xc5\x99"=>"r","\xc5\x95"=>"r","\xc5\xa1"=>"s","\xc5\xa5"=>"t","\xc3\xba"=>"u","\xc5\xaf"=>"u","\xc3\xbc"=>"u","\xc5\xb1"=>"u","\xc3\xbd"=>"y","\xc5\xbe"=>"z","\xc3\x81"=>"A","\xc3\x84"=>"A","\xc4\x8c"=>"C","\xc4\x8e"=>"D","\xc3\x89"=>"E","\xc4\x9a"=>"E","\xc3\x8d"=>"I","\xc4\xbd"=>"L","\xc4\xb9"=>"L","\xc5\x87"=>"N","\xc3\x93"=>"O","\xc3\x96"=>"O","\xc5\x90"=>"O","\xc3\x94"=>"O","\xc5\x98"=>"R","\xc5\x94"=>"R","\xc5\xa0"=>"S","\xc5\xa4"=>"T","\xc3\x9a"=>"U","\xc5\xae"=>"U","\xc3\x9c"=>"U","\xc5\xb0"=>"U","\xc3\x9d"=>"Y","\xc5\xbd"=>"Z");
	return strtr($s, $tbl);
}

function insert_getUser($input){
	$user_id = array();
	$user_id = $input['value'];
	$user_detail = new CMS_User($user_id);
	$output['id'] = $user_id;
	$output['name'] = $user_detail->getFirstname()."&nbsp;".$user_detail->getFamilyname();
	return $output;
}

function insert_isSelectedGroup($input){
	$accessGroups = $input["groups"];
	if($accessGroups==null)
		return "";
	$current_group_id = $input["current_group_id"];
	$accessGroups = unserialize($accessGroups);
	foreach($accessGroups as $key => $value){
		if($value == $current_group_id)
			return "selected";
	}
	return "";
}
