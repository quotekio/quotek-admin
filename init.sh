#!/bin/bash


function is_ip() {

  fip=`echo "$1" | grep -Eo '[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}'`
  iip=${fip:-"no"}

}


function config_host() {
  echo "================================================"
  echo "Please enter your server's public hostname or IP"
  echo "================================================"
  read host
  is_ip $host

  if [ $iip == "no" ]; then
	
	sed -i "s/##SERVER_NAME##/$host/" ./install/etc/nginx/qwc.conf
  
  # When ip is provided, things get a bit messy.
  else
        sed -i 's/server_name ##SERVER_NAME##//' ./install/etc/nginx/qwc.conf
        for i in `find -name *.php`; do
           sed -i "s/\$_SERVER['SERVER_NAME']/$host/" $i
        done
  fi 


}


function common() {
  echo 'www-data ALL=(ALL) NOPASSWD: /usr/bin/pkill, NOPASSWD: /usr/local/qate/bin/qate, NOPASSWD: /bin/kill, NOPASSWD: /bin/echo, NOPASSWD: /usr/bin/gdb, NOPASSWD: /usr/bin/screen, NOPASSWD: /etc/init.d/quotek, NOPASSWD: /bin/sh' >> /etc/sudoers

}


function nginx() {

  export DEBIAN_FRONTEND=noninteractive 
  export DEBCONF_NONINTERACTIVE_SEEN=true

  apt-get -y update
  apt-get -y install nginx sqlite3 php-fpm php-pgsql php-sqlite3 php-cli php-curl php-common

  cp ./install/etc/nginx/qwc.conf /etc/nginx/sites-available/
  ln -s /etc/nginx/sites-available/qwc.conf /etc/nginx/sites-enabled/qwc.conf

  unlink /etc/nginx/sites-enabled/default
  /etc/init.d/nginx restart
}



case $1 in

  nginx)
    common
    config_host
    nginx
  ;;

  common-only)
    common
  ;;

esac

