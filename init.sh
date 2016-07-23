#!/bin/bash


function common() {
  php composer.phar install
}


function nginx() {

  apt-get -y update
  apt-get -y install nginx php-fpm php7.0-sqlite php-cli php-curl
  common
  tar -xvzf  quotek_gitinit.tgz -C/
  chown -R www-data /quotek

  cp ./install/etc/nginx/qwc.conf /etc/nginx/sites-available/
  ln -s /etc/nginx/sites-available/qwc.conf /etc/nginx/sites-enabled/qwc.conf

  unlink /etc/nginx/sites-enabled/default
  /etc/init.d/nginx restart

}



case $1 in

  nginx)
    nginx
  ;;

esac

