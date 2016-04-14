J:\xampp\mysql\bin\mysqladmin -u root drop xproject-magento1
J:\xampp\mysql\bin\mysqladmin -u root create xproject-magento1
J:\xampp\mysql\bin\mysql -u root xproject-magento1 < 1_schema.sql
J:\xampp\mysql\bin\mysql -u root xproject-magento1 < 2_init_data.sql