e:\xampp\mysql\bin\mysqladmin -u root drop xproject-magento1
e:\xampp\mysql\bin\mysqladmin -u root create xproject-magento1
e:\xampp\mysql\bin\mysql -u root xproject-magento1 < 1_schema.sql
e:\xampp\mysql\bin\mysql -u root xproject-magento1 < 2_init_data.sql