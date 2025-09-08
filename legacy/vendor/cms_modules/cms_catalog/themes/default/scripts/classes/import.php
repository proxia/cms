<?php

class ImportPneu
{

	public function updateProductData(array $data = array())
	{

		$product_id = null;
		$brand = trim($data[0]);
		$code = trim($data[1]);
		$pattern = trim($data[7]);
		$picture = trim($data[9]);

		$toSql = "Select * from `catalog_products` where `code`='{$code}'";
		$query = new CN_SqlQuery($toSql);
		$query->execute();
		while($query->next())
		{
			$record = $query->fetchRecord();
			$product_id = $record->getValue('id');
			$product = new CMS_Catalog_Product($product_id);
			$product->setContextLanguage($GLOBALS['localLanguage']);
			$title = !empty($pattern) ? $pattern : $brand;
			$product->setTitle($title);
			$product->setCatalogId($_SESSION['currentCatalog']);

			if(!empty($picture))
				$product->setImage($picture);
			$product->save();
		}
		if(!$product_id)
		{
			$product = new CMS_Catalog_Product();
			$product->setContextLanguage($GLOBALS['localLanguage']);
			$title = !empty($pattern) ? $pattern : $brand;
			$product->setTitle($title);
			$product->setCode($code);
			$product->setCatalogId($_SESSION['currentCatalog']);

			if(!empty($picture))
				$product->setImage($picture);
			$product->save();
			$product_id = $product->getId();
		}
		return $product_id;
	}

	public function updatePneuDiskyProductData(array $data = array())
	{

		$product_id = null;
		$brand = trim($data[0]);
		$code = trim($data[1]);
		$picture = isset($data[8]) ? trim($data[8]) : "";

		$toSql = "Select * from `catalog_products` where `code`='{$code}'";
		$query = new CN_SqlQuery($toSql);
		$query->execute();
		while($query->next())
		{
			$record = $query->fetchRecord();
			$product_id = $record->getValue('id');
			$product = new CMS_Catalog_Product($product_id);
			$product->setContextLanguage($GLOBALS['localLanguage']);
			$product->setTitle($brand);
			//$product->setDescription($desc);
			$product->setCatalogId($_SESSION['currentCatalog']);

			if(!empty($picture))
				$product->setImage($picture);
			$product->save();
		}
		if(!$product_id)
		{
			$product = new CMS_Catalog_Product();
			$product->setContextLanguage($GLOBALS['localLanguage']);
			$product->setTitle($brand);
			//$product->setDescription($desc);
			$product->setCode($code);
			$product->setCatalogId($_SESSION['currentCatalog']);

			if(!empty($picture))
				$product->setImage($picture);
			$product->save();
			$product_id = $product->getId();
		}
		return $product_id;
	}

	public function updatePneuDuseProductData(array $data = array())
	{

		$product_id = null;
		$brand = trim($data[0]);
		$code = trim($data[1]);
		$picture = isset($data[5]) ? trim($data[5]) : "";
		$desc = isset($data[6]) ? trim($data[6]) : "";

		$toSql = "Select * from `catalog_products` where `code`='{$code}'";
		$query = new CN_SqlQuery($toSql);
		$query->execute();
		while($query->next())
		{
			$record = $query->fetchRecord();
			$product_id = $record->getValue('id');
			$product = new CMS_Catalog_Product($product_id);
			$product->setContextLanguage($GLOBALS['localLanguage']);
			$product->setTitle($brand);
			$product->setDescription($desc);
			$product->setCatalogId($_SESSION['currentCatalog']);

			if(!empty($picture))
				$product->setImage($picture);
			$product->save();
		}
		if(!$product_id)
		{
			$product = new CMS_Catalog_Product();
			$product->setContextLanguage($GLOBALS['localLanguage']);
			$product->setTitle($brand);
			$product->setDescription($desc);
			$product->setCode($code);
			$product->setCatalogId($_SESSION['currentCatalog']);

			if(!empty($picture))
				$product->setImage($picture);
			$product->save();
			$product_id = $product->getId();
		}
		return $product_id;
	}

	public function update_PPRESS_ProductData(array $data = array())
	{

		$product_id = null;
		$code = trim($data[0]);
		$title = trim($data[1]);
		$picture = "";//trim($data[9]);

		$toSql = "Select * from `catalog_products` where `code`='{$code}'";
		$query = new CN_SqlQuery($toSql);
		$query->execute();
		while($query->next())
		{
			$record = $query->fetchRecord();
			$product_id = $record->getValue('id');
			$product = new CMS_Catalog_Product($product_id);
			$product->setContextLanguage($GLOBALS['localLanguage']);
			$product->setTitle($title);
			$product->setCatalogId($_SESSION['currentCatalog']);

			if(!empty($picture))
				$product->setImage($picture);
			$product->save();
		}
		if(!$product_id)
		{
			$product = new CMS_Catalog_Product();
			$product->setContextLanguage($GLOBALS['localLanguage']);
			$product->setTitle($title);
			$product->setCode($code);
			$product->setCatalogId($_SESSION['currentCatalog']);

			if(!empty($picture))
				$product->setImage($picture);
			$product->save();
			$product_id = $product->getId();
		}
		return $product_id;
	}


	public function update_AMI_ProductData($kod,$popis,$zasoby,$picture = "")
	{
		$product_id = null;
		$code = $kod;
		$title = $kod;
		$desc = $popis;

		$toSql = "Select * from `catalog_products` where `code`='{$code}'";
		$query = new CN_SqlQuery($toSql);
		$query->execute();
		while($query->next())
		{
			$record = $query->fetchRecord();
			$product_id = $record->getValue('id');
			$product = new CMS_Catalog_Product($product_id);
			$product->setContextLanguage($GLOBALS['localLanguage']);
			$product->setTitle($title);
			$product->setDescription($desc);
			$product->setCatalogId($_SESSION['currentCatalog']);
			$product->setInStock($zasoby);

			if(!empty($picture))
				$product->setImage($picture);
			$product->save();

			$product->setContextLanguage("en");
			$product->setTitle($title);
			$product->setDescription($desc);
			$product->save();

		}
		if(!$product_id)
		{
			$product = new CMS_Catalog_Product();
			$product->setContextLanguage($GLOBALS['localLanguage']);
			$product->setTitle($title);
			$product->setCode($code);
			$product->setDescription($desc);
			$product->setCatalogId($_SESSION['currentCatalog']);
			$product->setInStock($zasoby);

			if(!empty($picture))
				$product->setImage($picture);
			$product->save();
			$product_id = $product->getId();

			$product = new CMS_Catalog_Product($product_id);
			$product->setContextLanguage("en");
			$product->setTitle($title);
			$product->setDescription($desc);
			$product->save();
		}
		return $product_id;
	}


	public function update_REWAN_ProductData($kod,$nazov,$popis,$popis2,$picture = "")
	{
		$product_id = null;
		$code = $kod;
		$title = $nazov;
		$desc = $popis;
		$desc2 = $popis2;

		$toSql = "Select * from `catalog_products` where `code`='{$code}'";
		$query = new CN_SqlQuery($toSql);
		$query->execute();
		while($query->next())
		{
			$record = $query->fetchRecord();
			$product_id = $record->getValue('id');
			$product = new CMS_Catalog_Product($product_id);
			$product->setContextLanguage($GLOBALS['localLanguage']);
			$product->setTitle($title);
			$product->setDescription($desc);
			$product->setDescriptionExtended($desc2);
			$product->setCatalogId($_SESSION['currentCatalog']);
			//$product->setInStock($zasoby);

			if(!empty($picture))
				$product->setImage($picture);
			$product->save();

// 			$product->setContextLanguage("en");
// 			$product->setTitle($title);
// 			$product->setDescription($desc);
// 			$product->save();

		}
		if(!$product_id)
		{
			$product = new CMS_Catalog_Product();
			$product->setContextLanguage($GLOBALS['localLanguage']);
			$product->setTitle($title);
			$product->setCode($code);
			$product->setDescription($desc);
			$product->setDescriptionExtended($desc2);
			$product->setCatalogId($_SESSION['currentCatalog']);
			//$product->setInStock($zasoby);

			if(!empty($picture))
				$product->setImage($picture);
			$product->save();
			$product_id = $product->getId();

// 			$product = new CMS_Catalog_Product($product_id);
// 			$product->setContextLanguage("en");
// 			$product->setTitle($title);
// 			$product->setDescription($desc);
// 			$product->save();

		}
		return $product_id;
	}


	public function updateAttribute($product_id, $att_def_id, $value,$value_lang = null)
	{
		if(!$att_def_id)
			return;
		$toSql = "Select * from `catalog_product_attributes` where `product_id`={$product_id} and `attribute_definition_id`={$att_def_id}";
		$query = new CN_SqlQuery($toSql);
		$query->execute();
		$is_new = true;
		while($query->next())
		{
			$is_new = false;
			$record = $query->fetchRecord();
			$att_id = $record->getValue('id');
			$attribute = new CMS_Catalog_ProductAttribute($att_id);
			$attribute->setContextLanguage("sk");
			$attribute->setProductId($product_id);
			$attribute->setAttributeDefinitionId($att_def_id);
			$attribute->setValue($value);
			$attribute->save();

			$attribute->setContextLanguage("en");
			$value = $value_lang ? $value_lang : $value;
			$attribute->setValue($value);
			$attribute->save();
		}
		if($is_new)
		{
			$attribute = new CMS_Catalog_ProductAttribute();
			$attribute->setContextLanguage("sk");
			$attribute->setProductId($product_id);
			$attribute->setAttributeDefinitionId($att_def_id);
			$attribute->setValue($value);
			$attribute->save();

			$attribute_id = $attribute->getId();

			$attribute = new CMS_Catalog_ProductAttribute($attribute_id);
			$attribute->setContextLanguage("en");
			$value = $value_lang ? $value_lang : $value;
			$attribute->setValue($value);
			$attribute->save();
		}
	}

	public function updateAttachment($product_id,$title,$file)
	{
		$attachment = new CMS_Attachment();
		$attachment->setContextLanguage($GLOBALS['localLanguage']);
		$attachment->setTitle($title);
		$attachment->setFile($file);
		$attachment->save();

		if($title == "Katalógový list")
		{
			$attachment->setContextLanguage('en');
			$attachment->setTitle("Catalog");
			$attachment->save();
		}

		$product = new CMS_Catalog_Product($product_id);
		$product->addAttachment($attachment);
	}

	public function updatePrice($product_id, $price)
	{

		$price = str_replace(",",".",$price);
		$price = (float) $price;//floatval($price);

		if(!is_numeric($price))
			return false;
		$toSql = "Select * from `catalog_prices` where `product_id`={$product_id} and access=1";
		$query = new CN_SqlQuery($toSql);
		$query->execute();
		$is_new = true;
		while($query->next())
		{
			$is_new = false;
			$record = $query->fetchRecord();
			$price_id = (float) $record->getValue('id');
			$price_value = (float) $record->getValue('price');
			if($price_value == $price )
				continue;
			$obj_price = new CMS_Catalog_Price($price_id);
			$obj_price->setContextLanguage($GLOBALS['localLanguage']);
			$obj_price->setProductId($product_id);
			$obj_price->setCurrency("EUR");
			$obj_price->setPrice($price);
			$obj_price->save();
		}
		if($is_new)
		{
			$obj_price = new CMS_Catalog_Price();
			$obj_price->setContextLanguage($GLOBALS['localLanguage']);
			$obj_price->setProductId($product_id);
			$obj_price->setCurrency("EUR");
			$obj_price->setPrice($price);
			$obj_price->save();
		}
	}

	public function getAttributeIdByName($i_locale, $attribute_name , $catalog_id)
	{
		$sql =<<<SQL
		SELECT
			*
		FROM
			`catalog_attributes_definition`,`catalog_attributes_definition_lang`
		WHERE
			`id` = `catalog_attributes_definition_lang`.`attribute_definition_id`  AND
			`language` = '{$i_locale}' AND `title` = '{$attribute_name}' AND `catalog_id` = '{$catalog_id}'
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
		$attribute_id = null;
		while($query->next())
		{
			$record = $query->fetchRecord();
			$attribute_id = (float) $record->getValue('id');
		}
		return $attribute_id;
	}

	public function getCategoryIdByName($i_locale, $category_name)
	{
		$sql =<<<SQL
		SELECT
			*
		FROM
			`categories`,`categories_lang`
		WHERE
			`id` = `categories_lang`.`category_id` AND `language` = '{$i_locale}' AND `title` = '{$category_name}' AND `usable_by` = '100'
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
		$category_id = null;
		while($query->next())
		{
			$record = $query->fetchRecord();
			$category_id = (float) $record->getValue('id');
		}
		return $category_id;
	}
	
	public function createTOPCategory($language,$kategoria)
	{
		$sql =<<<SQL
		INSERT INTO `categories` (code,usable_by) values ('{$kategoria}',100)
SQL;
		$query = new CN_SqlQuery($sql);
		$query->execute();
		$id = $query->getInsertId();

		$sql =<<<SQL
		INSERT INTO `categories_lang` (category_id,language,title) values ($id,'$language','$kategoria')
SQL;
		$query = new CN_SqlQuery($sql);
		$query->execute();

		$sql =<<<SQL
		INSERT INTO `catalog_branch_bindings` (catalog_id , branch_id ) values (1,$id)
SQL;
		$query = new CN_SqlQuery($sql);
		$query->execute();

		return $id;
	}

	public function createTOPCategoryLang($id,$language,$kategoria)
	{
		$sql =<<<SQL
		INSERT INTO `categories_lang` (category_id,language,title) values ($id,'$language','$kategoria')
SQL;
		$query = new CN_SqlQuery($sql);
		$query->execute();

	}

	public function createCategory($parent_category_id,$language,$kategoria, $produktovy_rad)
	{
		$sql =<<<SQL
		INSERT INTO `categories` (code,usable_by) values ('{$kategoria} - {$produktovy_rad}',100)
SQL;
		$query = new CN_SqlQuery($sql);
		$query->execute();
		$id = $query->getInsertId();

		$sql =<<<SQL
		INSERT INTO `categories_lang` (category_id,language,title) values ($id,'$language','$produktovy_rad')
SQL;
		$query = new CN_SqlQuery($sql);
		$query->execute();

		$sql =<<<SQL
		INSERT INTO `categories_bindings` (category_id ,item_id ,item_type ) values ($parent_category_id,$id,104)
SQL;
		$query = new CN_SqlQuery($sql);
		$query->execute();

		return $id;
	}

	public function createCategoryLang($id,$language,$produktovy_rad)
	{
		$sql =<<<SQL
		INSERT INTO `categories_lang` (category_id,language,title) values ($id,'$language','$produktovy_rad')
SQL;
		$query = new CN_SqlQuery($sql);
		$query->execute();

	}

	public function addProductToCategory($product_id, $two_level_category)
	{

		$sql =<<<SQL
		INSERT INTO `categories_bindings` (category_id ,item_id ,item_type ) values ($two_level_category,$product_id,101)
SQL;
		$query = new CN_SqlQuery($sql);
		$query->execute();
	}

	/*
	* maze vsetky zavislosti katalogu
	* pozor !!! maze vsetko bez vazby na catalog_id s vynimkami...
	*/
	public function deleteKatalogData($catalog_id)
	{
		// catalog_branch_bindings
		$sql = " TRUNCATE TABLE `catalog_branch_bindings`";
		$query = new CN_SqlQuery($sql);
		$query->execute();

		// `catalog_prices`
		$sql = "TRUNCATE TABLE `catalog_prices` ";
		$query = new CN_SqlQuery($sql);
		$query->execute();

		// `catalog_prices_lang`
		$sql = " TRUNCATE TABLE `catalog_prices_lang`";
		$query = new CN_SqlQuery($sql);
		$query->execute();

		// `catalog_products`
		$sql = " TRUNCATE TABLE `catalog_products` ";
		$query = new CN_SqlQuery($sql);
		$query->execute();

		// `catalog_products_lang`
		$sql = " TRUNCATE TABLE `catalog_products_lang` ";
		$query = new CN_SqlQuery($sql);
		$query->execute();

		// `catalog_products_lang`
		$sql = " TRUNCATE TABLE `catalog_product_attributes` ";
		$query = new CN_SqlQuery($sql);
		$query->execute();
		// `catalog_products_lang`
		$sql = " TRUNCATE TABLE `catalog_product_attributes_lang` ";
		$query = new CN_SqlQuery($sql);
		$query->execute();


		// `catalog_products_lang`
		$sql = " DELETE FROM `attachments`  WHERE id IN (SELECT attachment_id FROM `attachments_bindings`  WHERE `entity_type`=104 OR `entity_type`=101)";
		$query = new CN_SqlQuery($sql);
		$query->execute();
		// `catalog_products_lang`
		$sql = " DELETE FROM `attachments_lang` WHERE attachment_id IN (SELECT attachment_id FROM `attachments_bindings`  WHERE `entity_type`=104 OR `entity_type`=101)";
		$query = new CN_SqlQuery($sql);
		$query->execute();


		// `catalog_products_lang`
		$sql = " DELETE FROM `attachments_bindings` WHERE `entity_type`=104 OR  `entity_type`=101"; //produkt attachments
		$query = new CN_SqlQuery($sql);
		$query->execute();

		// `catalog_products_lang`
		$sql = " DELETE FROM `categories_lang` WHERE `category_id` IN (SELECT `id` FROM `categories` where `usable_by`=100 ) ";
		$query = new CN_SqlQuery($sql);
		$query->execute();

		// `catalog_products`
		$sql = " DELETE FROM `categories` where `usable_by`=100";
		$query = new CN_SqlQuery($sql);
		$query->execute();



		// `catalog_products_lang`
		$sql = " DELETE FROM `categories_bindings` WHERE `item_type`=104 OR  `item_type`=101"; //produkt attachments
		$query = new CN_SqlQuery($sql);
		$query->execute();

		$this->optimizeKatalogData();
	}

	public function optimizeKatalogData()
	{

		// catalog_branch_bindings
		$sql = "OPTIMIZE TABLE `catalog_branch_bindings`";
		$query = new CN_SqlQuery($sql);
		$query->execute();

		// `catalog_prices`
		$sql = "OPTIMIZE TABLE `catalog_prices` ";
		$query = new CN_SqlQuery($sql);
		$query->execute();

		// `catalog_prices_lang`
		$sql = " OPTIMIZE TABLE `catalog_prices_lang`";
		$query = new CN_SqlQuery($sql);
		$query->execute();

		// `catalog_products`
		$sql = " OPTIMIZE TABLE `catalog_products` ";
		$query = new CN_SqlQuery($sql);
		$query->execute();

		// `catalog_products_lang`
		$sql = " OPTIMIZE TABLE `catalog_products_lang` ";
		$query = new CN_SqlQuery($sql);
		$query->execute();

		// `catalog_products_lang`
		$sql = " OPTIMIZE TABLE `catalog_product_attributes` ";
		$query = new CN_SqlQuery($sql);
		$query->execute();
		// `catalog_products_lang`
		$sql = " OPTIMIZE TABLE `catalog_product_attributes_lang` ";
		$query = new CN_SqlQuery($sql);
		$query->execute();

		// `catalog_products_lang`
		$sql = " OPTIMIZE TABLE `attachments_bindings`"; //produkt attachments
		$query = new CN_SqlQuery($sql);
		$query->execute();

		// `catalog_products_lang`
		$sql = " OPTIMIZE TABLE `categories_lang` ";
		$query = new CN_SqlQuery($sql);
		$query->execute();

		// `catalog_products`
		$sql = " OPTIMIZE TABLE `categories` ";
		$query = new CN_SqlQuery($sql);
		$query->execute();


		// `catalog_products_lang`
		$sql = " OPTIMIZE TABLE `categories_bindings` "; //produkt attachments
		$query = new CN_SqlQuery($sql);
		$query->execute();

	}

}

?>