mysqldump -d --comments=FALSE -u root --password=root fastest_magento1 > 1_schema.sql
mysqldump -t --order-by-primary --comments=FALSE -u root --password=root fastest_magento1 > 2_init_data.sql
