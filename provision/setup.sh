#!/bin/bash

echo "Provisionamento da VM..."

echo "Atualizado apt-get"
apt-get update > /dev/null

echo "Instalando git"
apt-get install -y git > /dev/null

echo "Instalando nginx"
apt-get install -y nginx > /dev/null

echo "Instalando php5"
apt-get -y install php5-common php5-dev php5-cli php5-fpm > /dev/null

echo "Instalando php5 extensões"
apt-get -y install curl php5-curl php-apc php5-gd php5-xmlrpc php5-intl php5-mcrypt php5-pgsql > /dev/null

echo "Instalando postgresql"
apt-get install -y postgresql postgresql-contrib > /dev/null

echo "Configurando nginx"
systemctl stop nginx.service > /dev/null
rm -rf /etc/nginx/sites-available/default > /dev/null
cp /vagrant/provision/config/nginx_vhost /etc/nginx/sites-available/default > /dev/null
ln -s /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default > /dev/null
systemctl start nginx.service > /dev/null

echo "Instalando composer e atualizando dependências do ZF2"
cd /vagrant
curl -Ss https://getcomposer.org/installer | php > /dev/null
php composer.phar install --no-progress > /dev/null

echo "Configurando postgresql"
sudo -u postgres psql -c "CREATE USER zfbase WITH PASSWORD 'zfbase';" > /dev/null
sudo -u postgres psql -c "CREATE DATABASE zfbase;" > /dev/null
sudo -u postgres psql -c "GRANT ALL PRIVILEGES ON DATABASE zfbase to zfbase;" > /dev/null

echo "Aplicativo instalado, visite http://localhost:8085"
