<?php

$installer = $this;

$installer->startSetup();

$installer->getConnection()->addColumn(
    $installer->getTable('newsletter_subscriber'), 'subscriber_firstname', 'varchar(50)'
);

$installer->getConnection()->addColumn(
    $installer->getTable('newsletter_subscriber'), 'subscriber_lastname', 'varchar(50)'
);
$eav = new Mage_Eav_Model_Entity_Setup('core_setup');

$eav->addAttribute('customer', 'mailchimp_sync_delta', array(
    'label'     => 'MailChimp last sync timestamp',
    'type'      => 'datetime',
    'input'     => 'text',
    'visible'   => true,
    'required'  => false,
    'position'  => 1,
));
$eav->addAttribute('customer', 'mailchimp_sync_error', array(
    'label'     => 'MailChimp Error Description',
    'type'      => 'varchar',
    'input'     => 'text',
    'visible'   => true,
    'required'  => false,
    'position'  => 1,
));

$eav->addAttribute('catalog_product', 'mailchimp_sync_delta', array(
    'label'     => 'MailChimp last sync timestamp',
    'type'      => 'datetime',
    'input'     => 'text',
    'visible'   => true,
    'required'  => false,
    'position'  => 1,
));

$eav->addAttribute('catalog_product', 'mailchimp_sync_error', array(
    'label'     => 'MailChimp Error Description',
    'type'      => 'varchar',
    'input'     => 'text',
    'visible'   => true,
    'required'  => false,
    'position'  => 1,
));

$installer->run("
 ALTER TABLE `{$this->getTable('sales_flat_quote')}` ADD column `mailchimp_sync_delta` datetime NOT NULL;
 ALTER TABLE `{$this->getTable('sales_flat_order')}` ADD column `mailchimp_sync_delta` datetime NOT NULL;
");

$installer->run("
	CREATE TABLE IF NOT EXISTS `{$this->getTable('mailchimp_sync_batches')}` (
	  `id` int(10) unsigned NOT NULL auto_increment,
	  `store_id` int(11) NOT NULL,
	  `batch_id` varchar(24) NOT NULL,
	  `status` varchar(10) NOT NULL,
	  PRIMARY KEY  (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$baseDir = Mage::getBaseDir();

mkdir($baseDir.DS.'var'.DS.'mailchimp');

$installer->endSetup();

