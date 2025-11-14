# template-php-mysql-docker

A lightweight, ready-to-run PHP + MySQL Docker development template.
This repository provides a fully configured environment for learning PHP and SQL,
with Docker containers for Apache/PHP and MySQL.

---

### Why this exists

This template was created to simplify local PHP + MySQL development:

- No need to install PHP, Apache, or MySQL on your host machine.
- Containers are preconfigured for development and testing.
- Includes a health-check PHP script to validate database connectivity
  and basic SQL operations (DDL, DML, DQL).

It is designed for quick experimentation, learning, and sharing.

---

### Folder structure

.  
├── apache/  
├── mysql/  
├── web/  
├── docker-compose.yml  
└── LICENSE  

- web/ is mounted into the Apache container (/var/www/html) — place all your PHP scripts here.
- apache/ and mysql/ folders allow future customization of Docker images without touching the compose file.

---

### How to add PHP files

1. Place your .php files inside the web/ folder.
2. When the container is running (docker compose up -d --build),
   access your PHP scripts in the browser:

   http://localhost:8080/{filename}.php

- If port 8080 conflicts with another program, change the host port
  in docker-compose.yml (left side of 8080:80 mapping).
- The container port (right side, 80) must stay unchanged.

---

### Docker Compose documentation

The docker-compose.yml file is self-documented:

- Host ports: Only the host side may need adjustment if it conflicts
  with other software (Teams, local MySQL, etc.).
- Container ports: Always remain fixed (80 for Apache, 3306 for MySQL).
- Volumes: web/ and db_data ensure persistence and easy development.

---

### Connecting with a database client (e.g., DataGrip)

To connect to MySQL externally:

- Host: localhost
- Port: 3306 (or whatever host port you mapped)
- Database: app_db
- User: app_user
- Password: app_pass

Inside the Docker network (PHP container talking to MySQL container), connect using:

- Host: db
- Port: 3306
- Credentials remain the same
