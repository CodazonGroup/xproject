<?php
$installer = $this;

$installer->startSetup();
$pathFile = Mage::getBaseDir('var').DS.'install_slideshow.txt';
if(file_exists($pathFile)){
    echo 'Installing Revolution Slideshow, please wait for some minutes ...';
    exit;
}
file_put_contents($pathFile,'Installing Codazon Slideshow');
/**
 * Create table 'themeframework/area'
 */
if(!$installer->tableExists($installer->getTable('slideshow/slideshow'))){
$table = $installer->getConnection()
    ->newTable($installer->getTable('slideshow/slideshow'))
    ->addColumn('slideshow_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Slideshow ID')
    ->addColumn('title', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        ), 'Title')
    ->addColumn('identifier', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
            'unsigned'  => true,
            'nullable'  => false,
            'default'   => '',
        ), 'Identifier')
    ->addColumn('slider', Varien_Db_Ddl_Table::TYPE_TEXT, '2M', array(
        ), 'Slider')
    ->addColumn('parameters', Varien_Db_Ddl_Table::TYPE_TEXT, '2M', array(
        ), 'General Settings')		
    ->addColumn('creation_time', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        ), 'Date Created')
    ->addColumn('update_time', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        ), 'Last Modified')
    ->addColumn('is_active', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
        'default'   => '1',
        ), 'Status')
    ->setComment('CDZ Slideshow Table');
$installer->getConnection()->createTable($table);
}

unlink($pathFile);
$installer->endSetup();