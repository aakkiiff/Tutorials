sudo apt update && sudo apt install openssl
mkdir redis-ssl && cd redis-ssl
openssl genrsa -out redis.key 2048
openssl req -new -key redis.key -out redis.csr
openssl x509 -req -days 365 -in redis.csr -signkey redis.key -out redis.crt


mkdir -p ./data
sudo chown 1001:1001 ./data   
sudo chmod 777 ./data
