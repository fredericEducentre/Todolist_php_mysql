# Require :
php 8.3.15 installed
mysql 9.1.0 or docker installed

# Install MySQL with Docker
```
docker run --name some-mysql -e MYSQL_ROOT_PASSWORD=root -p 3307:3306 -d mysql
```

# Start MySQL
```
mysql -h 127.0.0.1 -P 3307 -u root -p
```

# Create the database php-project
```
CREATE DATABASE php_project;
```

# Create the todo list table :
```
USE php_project;
CREATE TABLE todo_list (
    id INT AUTO_INCREMENT PRIMARY KEY,
    task VARCHAR(255) NOT NULL,
    status ENUM('pending', 'completed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

OR

# Make migration (create database and table todo list)
```
php migration_up.php
```

# To clean the database
```
php migration_down.php
```# Todolist_php_mysql
