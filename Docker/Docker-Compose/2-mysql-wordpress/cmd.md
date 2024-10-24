docker network create my_network

docker run -d --name mysql_container --network my_network -e MYSQL_ROOT_PASSWORD=root_password -e MYSQL_DATABASE=example_db -e MYSQL_USER=example_user -e MYSQL_PASSWORD=user_password -p 3306:3306 -v db_data:/var/lib/mysql --restart always mysql:8.0

docker run -d --name wordpress_container --network my_network -p 80:80 -e WORDPRESS_DB_HOST=mysql_container -e WORDPRESS_DB_USER=root -e WORDPRESS_DB_PASSWORD=root_password -e WORDPRESS_DB_NAME=example_db --restart always wordpress:latest
