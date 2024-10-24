mysql -h127.0.0.1 -P3306 -u root -proot_password
mysql -h containerip -P3306 -u root -proot_password
docker exec -it mysql_container mysql -u root -proot_password