create database app_slave default character set utf8mb4 default collate utf8mb4_general_ci;
create database test_app default character set utf8mb4 default collate utf8mb4_general_ci;
create database test_app_slave default character set utf8mb4 default collate utf8mb4_general_ci;
grant all on app_slave.* to app;
grant all on test_app.* to app;
grant all on test_app_slave.* to app;
