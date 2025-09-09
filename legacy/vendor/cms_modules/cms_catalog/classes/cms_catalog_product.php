<?php

if(!defined('CMS_CATALOG_PRODUCTS_PHP')):
	define('CMS_CATALOG_PRODUCTS_PHP', true);

class CMS_Catalog_Product extends CMS_Entity
{
	const ENTITY_ID = 101;

###################################################################################################
# public
###################################################################################################

	public function __construct($product_id=null)
	{
		$this->main_table = 'catalog_products';
		$this->lang_table = 'catalog_products_lang';
		$this->id_column_name = 'product_id';

		###########################################################################################

		parent::__construct(self::ENTITY_ID, $product_id);
	}

###################################################################################################

	public function isValid()
	{
		$current_date = strtotime('now');
		$valid_from = strtotime($this->current_data[$this->main_table]['valid_from']);
		$valid_to = strtotime($this->current_data[$this->main_table]['valid_to']);

		if($current_date >= $valid_from && ($valid_to == null || $valid_to == 943916400))
			return true;
		elseif($current_date <= $valid_to && ($valid_to == null || $valid_to == 943916400))
			return true;
		elseif(($current_date >= $valid_from) && ($current_date <= $valid_to))
			return true;

		return false;
	}

	public function isDisplayable()
	{
		$is_displayable = true;

		if(!$this->isValid())
			$is_displayable = false;

		if($this->getIsPublished() == 0)
			$is_displayable = false;

		return $is_displayable;
	}

###################################################################################################
# price handling ##################################################################################

	public function getPriceList($offset=null, $limit=null, $execute=true, $currency = null, $access = null)
	{
		if(!Is_null($access))
		{
			$access_code = substr($access,0,1);
			if($access_code == 3)
			{
				$access_group = substr($access,2);
				$access = 3;
			}
		}
		$price_list = new CMS_Catalog_PriceList($offset, $limit);
		$price_list->addCondition('product_id', $this->id);
		if(!Is_null($access))
		{
			$price_list->addCondition('access', $access);
			if($access == 3)
				$price_list->addCondition('access_groups like \'%:"'.$access_group.'";%\' ', null,null,true);
		}
		if($currency != null)
			$price_list->addCondition('currency', $currency);
		if($execute === true)
			$price_list->execute();

		return $price_list;
	}

	public function getValidPrice()
	{
	/* // tato sa nedoporucuje....
		$price_list = new CMS_Catalog_PriceList();
		$price_list->addCondition('product_id', $this->id);
		$price_list->addCondition('is_published', 1);

		$price_list->addCondition('(CURRENT_DATE BETWEEN `valid_from` AND `valid_to` OR (`valid_from` IS NULL AND `valid_to` IS NULL) OR (`valid_from` IS NULL AND `valid_to` >= CURRENT_DATE) OR (`valid_from` <= CURRENT_DATE AND `valid_to` IS NULL))', null, null, true);

		if(CMS_UserLogin::getSingleton()->isUserLogedIn() === true)
			$price_list->addCondition('(`access` = 1 OR `access` = 2)', null, null, true);
		else
			$price_list->addCondition('access', CMS::ACCESS_PUBLIC);

		$price_list->execute();

		foreach($price_list as $price)
		{
			return $price;
		}

		return null;
	*/
		return null;
	}

	public function getValidPriceList($currency = "'EUR'", $show_all_currencies = false)
	{
		$price_list = new CMS_Catalog_PriceList();
		$price_list->addCondition('product_id', $this->id);
		$price_list->addCondition('is_published', 1);
		if($show_all_currencies)
			$price_list->addCondition('currency', $currency);

		$price_list->addCondition('(NOW() BETWEEN `valid_from` AND `valid_to` OR (`valid_from` IS NULL AND `valid_to` IS NULL) OR (`valid_from` IS NULL AND `valid_to` >= NOW()) OR (`valid_from` <= NOW() AND `valid_to` IS NULL))', null, null, true);

		$groups = null;
		if(CMS_UserLogin::getSingleton()->isUserLogedIn() === true)
			$groups = CMS_UserLogin::getSingleton()->getUser()->getGroups();
		//$user = new CMS_User(3);
		//$groups = $user->getGroups();
		$is_set_group = false;
		$count_groups = 0;
		if(!is_null($groups)){
			foreach($groups as $group){
				$is_set_group = true;
				$count_groups++;
			}
		}


		if(CMS_UserLogin::getSingleton()->isUserLogedIn() === true && $is_set_group)
		{
			$sql = "(`access` = 1 OR `access` = 2 OR (`access` = 3 AND ";
			$current_row = 0;
			foreach($groups as $group)
			{
				$current_row ++;
				$expression = '"'.$group->getId().'"';
				$sql .= " (`access_groups` LIKE '%$expression%')";
				if($count_groups != $current_row)
					$sql .= " OR ";
			}
			$sql .= "))";
			$price_list->addCondition($sql, null, null, true);
		}
		elseif(CMS_UserLogin::getSingleton()->isUserLogedIn() === true)
			$price_list->addCondition('(`access` = 1 OR `access` = 2)', null, null, true);
		else
			$price_list->addCondition('access', CMS::ACCESS_PUBLIC);

		$price_list->execute();
		return $price_list;
	}

	public function addPrice($price_value, $valid_from=null, $valid_to=null,$currency = "EUR",$access=null,$access_groups = null)
	{
		$price = new CMS_Catalog_Price();
		$price->setProductId($this->id);
		$price->setPrice($price_value);
		$price->setValidFrom($valid_from);
		$price->setValidTo($valid_to);
		$price->setCurrency($currency);
		if(!is_null($access))
			$price->setAccess($access);
		if(!is_null($access_groups))
			$price->setAccessGroups($access_groups);
		$price->save();
	}

###################################################################################################

	public function getParents($offset=null, $limit=null, $execute=true)
	{
		$branch_list = new CMS_Catalog_BranchList($offset, $limit);
		$branch_list->removeCondition('usable_by');
		$branch_list->setTableName('categories_bindings');
		$branch_list->setIdColumnName('category_id');
		$branch_list->addCondition('item_id', $this->id);
		$branch_list->addCondition('item_type', self::ENTITY_ID);

		if($execute === true)
			$branch_list->execute();

		return $branch_list;
	}

	public function getPath($displayable_only=true)
	{
		$path = array();

		###########################################################################################

		$parent_list = $this->getParents();

		foreach($parent_list as $parent)
		{
			$parent_path = $parent->getPath($displayable_only);

			$product_path = $parent_path[CMS_Catalog_Branch::ENTITY_ID];
			$product_path[] = $parent;

			$path[CMS_Catalog_Branch::ENTITY_ID][] = $product_path;
		}

		###########################################################################################

		return $path;
	}

###################################################################################################
# galleries #######################################################################################

	public function getGalleries($offset=null, $limit=null, $execute=true)
	{
		$gallery_list = new CMS_GalleryList($offset, $limit);
		$gallery_list->setTableName('gallery_bindings');
		$gallery_list->setIdColumnName('gallery_id');
		$gallery_list->removeCondition('usable_by');
		$gallery_list->addCondition('entity_id', $this->id);
		$gallery_list->addCondition('entity_type', $this->getType());

		if($execute === true)
			$gallery_list->execute();

		return $gallery_list;
	}

	public function addGallery(CMS_Gallery & $gallery)
	{
		$sql =<<<SQL
		INSERT INTO
			`gallery_bindings`
			(
				`entity_id`,
				`entity_type`,
				`gallery_id`
			)
		VALUES
			(
				{$this->id},
				{$this->getType()},
				{$gallery->getId()}
			)
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}

	public function removeGallery(CMS_Gallery & $gallery)
	{
		$sql =<<<SQL
		DELETE
		FROM
			`gallery_bindings`
		WHERE
			`entity_id` = {$this->id} AND
			`entity_type` = {$this->getType()} AND
			`gallery_id` = {$gallery->getId()}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}

###################################################################################################
# attributes ######################################################################################

	public function getAttributes($offset=null, $limit=null, $execute=true)
	{
		$attribute_list = new CMS_Catalog_ProductAttributeList($offset, $limit);
		$attribute_list->addCondition('product_id', $this->id);

		if($execute === true)
			$attribute_list->execute();

		return $attribute_list;
	}

	public function attributeExists(CMS_Catalog_AttributeDefinition $attribute)
	{
		$sql =<<<SQL
		SELECT
			COUNT(*)
		FROM
			`catalog_product_attributes`
		WHERE
			`attribute_definition_id` = {$attribute->getId()} AND
			`product_id` = {$this->id}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		return ($query->fetchValue() > 0);
	}

###################################################################################################
# attachments #####################################################################################

	public function addAttachment(CMS_Attachment $attachment)
	{
		$order = NULL;

		###########################################################################################

		$sql = <<<SQL
		SELECT
			MAX(`order`)
		FROM
			`attachments_bindings`
		WHERE
		`entity_id` = {$this->id} AND
		`entity_type` = {$this->type}

SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		$order = $query->fetchValue() + 1;

		###########################################################################################

		$sql =<<<SQL
		INSERT INTO
			`attachments_bindings`
			(
				`entity_id`,
				`entity_type`,
				`attachment_id`,
				`order`
			)
		VALUES
			(
				{$this->id},
				{$this->type},
				{$attachment->getId()},
				$order
			)
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}

	public function removeAttachment(CMS_Attachment $attachment)
	{
		$sql =<<<SQL
		DELETE
		FROM
			`attachments_bindings`
		WHERE
			`entity_id` = {$this->id} AND
			`entity_type` = {$this->type} AND
			`attachment_id` = {$attachment->getId()}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}

	public function getAttachments($offset=null, $limit=null, $execute=true)
	{
		$attachment_list = new CMS_AttachmentList($offset, $limit);
		$attachment_list->setTableName('attachments_bindings');
		$attachment_list->setIdColumnName('attachment_id');
		$attachment_list->addCondition('entity_id', $this->getId());
		$attachment_list->addCondition('entity_type', self::ENTITY_ID);

		if($execute === true)
			$attachment_list->execute();

		return $attachment_list;
	}

	public function attachmentExists(CMS_Attachment $attachment)
	{
		$sql =<<<SQL
		SELECT
			COUNT(*)
		FROM
			`attachments`
		WHERE
			(
				`entity_id` = {$this->id} AND
				`entity_type` = {$this->type}
			)
			AND
			(
				`attachment_id` = {$attachment->getId()} AND
				`attachment_type` = 255
			)
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		return ($query->fetchValue() > 0);
	}

###################################################################################################
# move methods ####################################################################################

	public function moveUp($category_id, $move_by=1) { return $this->moveUpInEntity($category_id, 'category_id', 'categories_bindings', $move_by); }
	public function moveDown($category_id, $move_by=1) { return $this->moveDownInEntity($category_id, 'category_id', 'categories_bindings', $move_by); }
	public function moveToTop($category_id) { return $this->moveToTopInEntity($category_id, 'category_id', 'categories_bindings'); }
	public function moveToBottom($category_id) { return $this->moveToBottomInEntity($category_id, 'category_id', 'categories_bindings'); }

###################################################################################################
# save and delete #################################################################################

	public function save()
	{
		if(is_null($this->id))
			$this->insertProduct();
		else
			$this->updateProduct();

		$this->updateLanguageVersions();
	}

	public function delete()
	{
		# gallery bindings ########################################################################

		if(CMS_ProjectConfig::getSingleton()->checkModuleAvailability('CMS_Gallery') === true)
		{
			$gallery_list = $this->getGalleries();

			foreach($gallery_list as $gallery)
				$this->removeGallery($gallery);
		}

		# price bindings ##########################################################################

		$query = new CN_SqlQuery("DELETE FROM `catalog_prices` WHERE `product_id` = {$this->id}");
		$query->execute();

		# attribute bindings ######################################################################

		$attribute_list = $this->getAttributes();

		foreach($attribute_list as $attribute)
			$attribute->delete();

		# branch bindings #########################################################################

		$query = new CN_SqlQuery("DELETE FROM `categories_bindings` WHERE `item_id` = {$this->id} AND `item_type` = {$this->type}");
		$query->execute();

		# main bindings ###########################################################################

		$query = new CN_SqlQuery("DELETE FROM `{$this->lang_table}` WHERE `product_id` = {$this->id}");
		$query->execute();

		$query = new CN_SqlQuery("DELETE FROM `{$this->main_table}` WHERE `id` = {$this->id}");
		$query->execute();
	}

###################################################################################################
# private
###################################################################################################

	private function insertProduct()
	{
		$catalog_id = 0;
		$author_id = 0;
		$is_published = (int)true;
		$code = "''";
		$valid_from = 'NULL';
		$valid_to = 'NULL';
		$access = CMS::ACCESS_PUBLIC;
		$access_groups = 'NULL';
		$image = 'NULL';
		$video = 'NULL';
		$is_news = (int)false;
		$is_sale = (int)false;
		$in_stock = 'NULL';

		###########################################################################################

		if(isset($this->new_data[$this->main_table]['catalog_id']))
			$catalog_id = $this->new_data[$this->main_table]['catalog_id'] === 'NULL' ? $catalog_id : $this->new_data[$this->main_table]['catalog_id'];

		if(isset($this->new_data[$this->main_table]['author_id']))
			$author_id = $this->new_data[$this->main_table]['author_id'] === 'NULL' ? $author_id : $this->new_data[$this->main_table]['author_id'];
		if(isset($this->new_data[$this->main_table]['is_published']))
			$is_published = $this->new_data[$this->main_table]['is_published'] === 'NULL' ? $is_published : (int)$this->new_data[$this->main_table]['is_published'];
		if(isset($this->new_data[$this->main_table]['code']))
			$code = $this->new_data[$this->main_table]['code'] === 'NULL' ? $code : "'{$this->new_data[$this->main_table]['code']}'";
		if(isset($this->new_data[$this->main_table]['valid_from']))
			$valid_from = $this->new_data[$this->main_table]['valid_from'] === 'NULL' ? $valid_from : "'{$this->new_data[$this->main_table]['valid_from']}'";
		if(isset($this->new_data[$this->main_table]['valid_to']))
			$valid_to = $this->new_data[$this->main_table]['valid_to'] === 'NULL' ? $valid_to : "'{$this->new_data[$this->main_table]['valid_to']}'";
		if(isset($this->new_data[$this->main_table]['access']))
			$access = $this->new_data[$this->main_table]['access'] === 'NULL' ? $access : $this->new_data[$this->main_table]['access'];
		if(isset($this->new_data[$this->main_table]['access_groups']))
			$access_groups = $this->new_data[$this->main_table]['access_groups'] === 'NULL' ? $access_groups : "'{$this->new_data[$this->main_table]['access_groups']}'";
		if(isset($this->new_data[$this->main_table]['image']))
			$image = $this->new_data[$this->main_table]['image'] === 'NULL' ? $image : "'{$this->new_data[$this->main_table]['image']}'";
		if(isset($this->new_data[$this->main_table]['video']))
			$video = $this->new_data[$this->main_table]['video'] === 'NULL' ? $video : "'{$this->new_data[$this->main_table]['video']}'";
		if(isset($this->new_data[$this->main_table]['is_news']))
			$is_news = $this->new_data[$this->main_table]['is_news'] === 'NULL' ? $is_news : $this->new_data[$this->main_table]['is_news'];
		if(isset($this->new_data[$this->main_table]['is_sale']))
			$is_sale = $this->new_data[$this->main_table]['is_sale'] === 'NULL' ? $is_sale : $this->new_data[$this->main_table]['is_sale'];
		if(isset($this->new_data[$this->main_table]['in_stock']))
			$in_stock = $this->new_data[$this->main_table]['in_stock'] === 'NULL' ? $in_stock : $this->new_data[$this->main_table]['in_stock'];

		###########################################################################################

		$sql =<<<SQL
		INSERT INTO
			`{$this->main_table}`
			(
				`creation`,
				`catalog_id`,
				`author_id`,
				`is_published`,
				`code`,
				`valid_from`,
				`valid_to`,
				`access`,
				`access_groups`,
				`image`,
				`video`,
				`is_news`,
				`is_sale`,
				`in_stock`
			)
		VALUES
			(
				NOW(),
				$catalog_id,
				$author_id,
				$is_published,
				$code,
				$valid_from,
				$valid_to,
				$access,
				$access_groups,
				$image,
				$video,
				$is_news,
				$is_sale,
				$in_stock
			)
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		$this->id = $query->getInsertId();

		###########################################################################################

		$this->readData(CMS::READ_MAIN_DATA);
	}

	private function updateProduct()
	{
		$catalog_id = 0;
		$author_id = 0;
		$is_published = true;
		$code = "''";
		$valid_from = 'NULL';
		$valid_to = 'NULL';
		$access = CMS::ACCESS_PUBLIC;
		$access_groups = 'NULL';
		$image = 'NULL';
		$video = 'NULL';
		$is_news = (int)false;
		$is_sale = (int)false;
		$in_stock = 'NULL';

		###########################################################################################

		if(isset($this->new_data[$this->main_table]['catalog_id']))
			$catalog_id = $this->new_data[$this->main_table]['catalog_id'] === 'NULL' ? $catalog_id : $this->new_data[$this->main_table]['catalog_id'];
		else
			$catalog_id = $this->current_data[$this->main_table]['catalog_id'] === 'NULL' ? $catalog_id : $this->current_data[$this->main_table]['catalog_id'];

		if(isset($this->new_data[$this->main_table]['author_id']))
			$author_id = $this->new_data[$this->main_table]['author_id'] === 'NULL' ? $author_id : $this->new_data[$this->main_table]['author_id'];
		else
			$author_id = $this->current_data[$this->main_table]['author_id'] === 'NULL' ? $author_id : $this->current_data[$this->main_table]['author_id'];

		if(isset($this->new_data[$this->main_table]['is_published']))
			$is_published = $this->new_data[$this->main_table]['is_published'] === 'NULL' ? (int)$is_published : (int)$this->new_data[$this->main_table]['is_published'];
		else
			$is_published = $this->current_data[$this->main_table]['is_published'] === 'NULL' ? (int)$is_published : (int)$this->current_data[$this->main_table]['is_published'];

		if(isset($this->new_data[$this->main_table]['code']))
			$code = $this->new_data[$this->main_table]['code'] === 'NULL' ? $code : "'{$this->new_data[$this->main_table]['code']}'";
		else
			$code = $this->current_data[$this->main_table]['code'] === 'NULL' ? $code : "'{$this->current_data[$this->main_table]['code']}'";

		if(isset($this->new_data[$this->main_table]['valid_from']))
			$valid_from = $this->new_data[$this->main_table]['valid_from'] === 'NULL' ? $valid_from : "'{$this->new_data[$this->main_table]['valid_from']}'";
		else
			$valid_from = $this->current_data[$this->main_table]['valid_from'] === 'NULL' ? $valid_from : "'{$this->current_data[$this->main_table]['valid_from']}'";

		if(isset($this->new_data[$this->main_table]['valid_to']))
			$valid_to = $this->new_data[$this->main_table]['valid_to'] === 'NULL' ? $valid_to : "'{$this->new_data[$this->main_table]['valid_to']}'";
		else
			$valid_to = $this->current_data[$this->main_table]['valid_to'] === 'NULL' ? $valid_to : "'{$this->current_data[$this->main_table]['valid_to']}'";

		if(isset($this->new_data[$this->main_table]['access']))
			$access = $this->new_data[$this->main_table]['access'] === 'NULL' ? $access : $this->new_data[$this->main_table]['access'];
		else
			$access = $this->current_data[$this->main_table]['access'] === 'NULL' ? $access : $this->current_data[$this->main_table]['access'];

		if(isset($this->new_data[$this->main_table]['access_groups']))
			$access_groups = $this->new_data[$this->main_table]['access_groups'] === 'NULL' ? $access_groups : "'{$this->new_data[$this->main_table]['access_groups']}'";
		else
			$access_groups = $this->current_data[$this->main_table]['access_groups'] === 'NULL' ? $access_groups : "'{$this->current_data[$this->main_table]['access_groups']}'";

		if(isset($this->new_data[$this->main_table]['image']))
			$image = $this->new_data[$this->main_table]['image'] === 'NULL' ? $image : "'{$this->new_data[$this->main_table]['image']}'";
		else
			$image = $this->current_data[$this->main_table]['image'] === 'NULL' ? $image : "'{$this->current_data[$this->main_table]['image']}'";

		if(isset($this->new_data[$this->main_table]['video']))
			$video = $this->new_data[$this->main_table]['video'] === 'NULL' ? $video : "'{$this->new_data[$this->main_table]['video']}'";
		else
			$video = $this->current_data[$this->main_table]['video'] === 'NULL' ? $video : "'{$this->current_data[$this->main_table]['video']}'";

		if(isset($this->new_data[$this->main_table]['is_news']))
			$is_news = $this->new_data[$this->main_table]['is_news'] === 'NULL' ? $is_news : $this->new_data[$this->main_table]['is_news'];
		else
			$is_news = $this->current_data[$this->main_table]['is_news'] === 'NULL' ? $is_news : $this->current_data[$this->main_table]['is_news'];

		if(isset($this->new_data[$this->main_table]['is_sale']))
			$is_sale = $this->new_data[$this->main_table]['is_sale'] === 'NULL' ? $is_sale : $this->new_data[$this->main_table]['is_sale'];
		else
			$is_sale = $this->current_data[$this->main_table]['is_sale'] === 'NULL' ? $is_sale : $this->current_data[$this->main_table]['is_sale'];

		if(isset($this->new_data[$this->main_table]['in_stock']))
			$in_stock = $this->new_data[$this->main_table]['in_stock'] === 'NULL' ? $in_stock : $this->new_data[$this->main_table]['in_stock'];
		else
			$in_stock = $this->current_data[$this->main_table]['in_stock'] === 'NULL' ? $in_stock : $this->current_data[$this->main_table]['in_stock'];


###########################################################################################

		$sql =<<<SQL
		UPDATE
			`{$this->main_table}`
		SET
			`catalog_id` = $catalog_id,
			`author_id` = $author_id,
			`is_published` = $is_published,
			`code` = $code,
			`valid_from` = $valid_from,
			`valid_to` = $valid_to,
			`access` = $access,
			`access_groups` = $access_groups,
			`image` = $image,
			`video` = $video,
			`is_news` = $is_news,
			`is_sale` = $is_sale,
			`in_stock` = $in_stock
		WHERE
			`id` = {$this->id}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		###########################################################################################

		$this->readData(CMS::READ_MAIN_DATA);
	}

	private function updateLanguageVersions()
	{
		$title = "''";
		$description = 'NULL';
		$description_extended = 'NULL';
		$language_is_visible = 1;
		$localized_image = 'NULL';

		foreach($this->new_data[$this->lang_table] as $language => $language_version)
		{
			if(isset($language_version['title']))
				$title = $language_version['title'] === 'NULL' ? $title : "'{$language_version['title']}'";
			elseif(isset($this->current_data[$this->lang_table][$language]['title']))
				$title = $this->current_data[$this->lang_table][$language]['title'] == 'NULL' ? $title : "'{$this->current_data[$this->lang_table][$language]['title']}'";

			if(isset($language_version['description']))
				$description = $language_version['description'] === 'NULL' ? 'NULL' : "'{$language_version['description']}'";
			elseif(isset($this->current_data[$this->lang_table][$language]['description']))
				$description = $this->current_data[$this->lang_table][$language]['description'] === 'NULL' ? $description : "'{$this->current_data[$this->lang_table][$language]['description']}'";

			if(isset($language_version['description_extended']))
				$description_extended = $language_version['description_extended'] === 'NULL' ? 'NULL' : "'{$language_version['description_extended']}'";
			elseif(isset($this->current_data[$this->lang_table][$language]['description_extended']))
				$description_extended = $this->current_data[$this->lang_table][$language]['description_extended'] === 'NULL' ? $description_extended : "'{$this->current_data[$this->lang_table][$language]['description_extended']}'";

			if(isset($language_version['language_is_visible']))
				$language_is_visible = $language_version['language_is_visible'] === 'NULL' ? $language_is_visible : (int)$language_version['language_is_visible'];
			elseif(isset($this->current_data[$this->lang_table][$language]['language_is_visible']))
				$language_is_visible = $this->current_data[$this->lang_table][$language]['language_is_visible'] === 'NULL' ? $language_is_visible : (int)$this->current_data[$this->lang_table][$language]['language_is_visible'];

			if(isset($language_version['localized_image']))
				$localized_image = $language_version['localized_image'] === 'NULL' ? 'NULL' : "'{$language_version['localized_image']}'";
			elseif(isset($this->current_data[$this->lang_table][$language]['localized_image']))
				$localized_image = $this->current_data[$this->lang_table][$language]['localized_image'] === 'NULL' ? $localized_image : "'{$this->current_data[$this->lang_table][$language]['localized_image']}'";

			#######################################################################################

			$sql =<<<SQL
			SELECT
				COUNT(*)
			FROM
				`{$this->lang_table}`
			WHERE
				`product_id` = {$this->id} AND
				`language` = '$language'
SQL;

			$query = new CN_SqlQuery($sql);
			$query->execute();

			$record_count = $query->fetchValue();

			#######################################################################################

			if($record_count == 0)
			{
				$sql =<<<SQL
				INSERT INTO
					`{$this->lang_table}`
					(
						`{$this->id_column_name}`,
						`language`,
						`title`,
						`description`,
						`description_extended`,
						`language_is_visible`,
						`localized_image`
					)
				VALUES
					(
						{$this->id},
						'$language',
						$title,
						$description,
						$description_extended,
						$language_is_visible,
						$localized_image
					)
SQL;
			}
			elseif($record_count == 1)
			{
				$sql =<<<SQL
				UPDATE
					`{$this->lang_table}`
				SET
					`title` = $title,
					`description` = $description,
					`description_extended` = $description_extended,
					`language_is_visible` = $language_is_visible,
					`localized_image` = $localized_image
				WHERE
					`product_id` = {$this->id} AND
					`language` = '$language'
SQL;
			}
			else
				throw new CN_Exception(sprintf(tr("There are loose data in table `%1\$s` for `id` %2\$s.", $this->lang_table, $this->id)), E_ERROR);

			$query = new CN_SqlQuery($sql);
			$query->execute();

			#######################################################################################

			$title = "''";
			$description = 'NULL';
			$description_extended = 'NULL';
			$language_is_visible = 1;
			$localized_image = 'NULL';
		}

		###########################################################################################

		$this->readData(CMS::READ_LANG_DATA);
	}
}

endif;

?>
