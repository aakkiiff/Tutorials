#!bin/bash
apt update -y
apt install nginx -y
systemctl start nginx
systemctl enable nginx