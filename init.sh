#!/bin/bash


function common() {
  echo 'www-data ALL=(ALL) NOPASSWD: /usr/bin/pkill, NOPASSWD: /usr/local/qate/bin/qate, NOPASSWD: /bin/kill, NOPASSWD: /bin/echo, NOPASSWD: /usr/bin/gdb, NOPASSWD: /usr/bin/screen, NOPASSWD: /etc/init.d/qate, NOPASSWD: /bin/sh' >> /etc/sudoers

  tar -xvzf  quotek_gitinit.tgz -C/
  chown -R www-data /quotek
}


function nginx() {

  export DEBIAN_FRONTEND=noninteractive 
  export DEBCONF_NONINTERACTIVE_SEEN=true

  apt-get -y update
  apt-get -y install nginx php-fpm php-sqlite3 php-cli php-curl php-common

  cp ./install/etc/nginx/qwc.conf /etc/nginx/sites-available/
  ln -s /etc/nginx/sites-available/qwc.conf /etc/nginx/sites-enabled/qwc.conf

  unlink /etc/nginx/sites-enabled/default
  /etc/init.d/nginx restart
}



case $1 in

  nginx)
    common
    nginx
  ;;

  common-only)
    common
  ;;

esac

