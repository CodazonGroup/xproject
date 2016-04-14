<?php
$installer = $this;
$installer->startSetup();

$blogTable = $installer->getTable('blog/blog');
$sql="ALTER TABLE `{$blogTable}` ADD `post_image` VARCHAR(255) NULL";
$installer->run($sql);

$catTable = $installer->getTable('blog/cat');
$sql="ALTER TABLE `{$catTable}` ADD `cat_image` VARCHAR(255) NULL";
$installer->run($sql);
//demo 
//Mage::getModel('core/url_rewrite')->setId(null);
//demo 
$installer->endSetup();
	 