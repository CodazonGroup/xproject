mysqladmin -u root --password=root drop fastest_magento1
mysqladmin -u root --password=root create fastest_magento1
mysql -u root --password=root fastest_magento1 < 1_schema.sql
mysql -u root --password=root fastest_magento1 < 2_init_data.sql
