<?php

if(!defined('CMS_CATALOG_ATTRIBUTEGROUP_PHP')):
	define('CMS_CATALOG_ATTRIBUTEGROUP_PHP', true);

class CMS_Catalog_AttributeGroup extends CMS_Category
{
	const ENTITY_ID = 106;

###################################################################################################
# public
###################################################################################################

	public function __construct($group_id=null)
	{
		parent::__construct($group_id);
		
		$this->type = self::ENTITY_ID;
		$this->setUsableBy(self::ENTITY_ID);
	}


	public function getAttributes($displayable_only=false, $offset=null, $limit=null, $execute=true, $sort_direction=null){
	
		return $this->getItems(CMS_Catalog_AttributeDefinition::ENTITY_ID, $displayable_only, $offset, $limit, $execute, $sort_direction);

	}

	# prida do skupiny novy atribut
	public function addAttribute(CMS_Catalog_AttributeDefinition $item){
		$this->addItem($item);
	}
	
	# odobere zo skupiny novy atribut
	public function removeAttribute(CMS_Catalog_AttributeDefinition $item){
		$this->removeItem($item);
	}


	public function attributeExists(CMS_Catalog_AttributeDefinition $item)
	{
		return $this->itemExists($item);
	}
	
	public function delete()
	{

		# attribute bindings ########################################################################

		$attribute_list = $this->getAttributes();

		foreach($attribute_list as $attribute){
				//$attribute->delete(); nebudem mazat atributy, iba väzby /zatial...
				$this->removeAttribute($attribute);
		}

		###########################################################################################

		parent::delete();
	}
	

}

endif;

?>
