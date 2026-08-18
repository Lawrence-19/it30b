1. CREATE DATABASE <database_name>;
2. SHOW DATABASES;
3. CONNECT <database_name>
4. CREATE TABLE <table_name_in_plural> ()
5. INSERT INTO <table_name_in_plural>
    (columns) VALUES
    (values);



# Utility Commands
\! cls
mysqldump -u root -p --databases <tabel_name_in_plural> > <date_dbname.sql>
mysqldump -u root -p --databases library_db > C:\xampp\htdocs\it30b\backups\0818206_library_db.sql