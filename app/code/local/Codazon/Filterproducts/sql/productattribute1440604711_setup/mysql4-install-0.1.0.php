<?php
$installer = $this;
$installer->startSetup();

/*$installer->addAttribute("catalog_category", "codazon_featured",  array(
    "type"     => "int",
    "backend"  => "",
    "frontend" => "",
    "label"    => "Featured",
    "input"    => "select",
    "class"    => "",
    "source"   => "eav/entity_attribute_source_boolean",
    "global"   => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    "visible"  => true,
    "required" => false,
    "user_defined"  => false,
    "default" => "",
    "searchable" => false,
    "filterable" => false,
    "comparable" => false,
	
    "visible_on_front"  => false,
    "unique"     => false,
    "note"       => ""

	));

$installer->addAttribute("catalog_category", "codazon_hot",  array(
    "type"     => "int",
    "backend"  => "",
    "frontend" => "",
    "label"    => "Hot",
    "input"    => "select",
    "class"    => "",
    "source"   => "eav/entity_attribute_source_boolean",
    "global"   => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    "visible"  => true,
    "required" => false,
    "user_defined"  => false,
    "default" => "",
    "searchable" => false,
    "filterable" => false,
    "comparable" => false,
	
    "visible_on_front"  => false,
    "unique"     => false,
    "note"       => ""

	));*/

$installer->addAttribute("catalog_product", "codazon_featured",  array(
    "type"     => "int",
    "backend"  => "",
    "frontend" => "",
    "label"    => "Featured",
    "input"=> "boolean",
    "class"    => "",
    "global"   => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    "visible"  => true,
    "required" => false,
    "user_defined"  => false,
    "default" => "",
    "searchable" => false,
    "filterable" => false,
    "comparable" => false,
	'user_defined'         => true,
    "visible_on_front"  => false,
    "unique"     => false,
    "note"       => ""

	));

$installer->addAttribute("catalog_product", "codazon_hot",  array(
    "type"     		=> "int",
    "backend"  		=> "",
    "frontend" 		=> "",
    "label"			=> "Hot",
    "input"			=> "boolean",
    "class"    		=> "",
    "global"   		=> Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    "visible"  		=> true,
    "required" 		=> false,
    "user_defined"  => false,
    "default" 		=> "",
    "searchable" 	=> false,
    "filterable" 	=> false,
    "comparable" 	=> false,
	'user_defined'  => true,
    "visible_on_front"  => false,
    "unique"     => false,
    "note"       => ""

	));
$entityTypeId = Mage::getModel('catalog/product')->getResource()->getEntityType()->getId();
$attributeSetId = $installer->getAttributeSetId($entityTypeId, 'Default');
$installer->addAttributeToSet($entityTypeId, $attributeSetId, 'General', 'codazon_featured', 10);
$installer->addAttributeToSet($entityTypeId, $attributeSetId, 'General', 'codazon_hot', 10);

$installer->endSetup();
	 