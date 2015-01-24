#!/bin/bash

echo "* VISIBLE HAND Flashnews MODULE INSTALL*"
echo "Visible hand Install Directory:"

read INSTALL_DIR

if ! [ -d $INSTALL_DIR/vhmodules ]
then
  echo "visible hand not found in directory, aborting install"
  exit 1
fi

FLASHNEWS_DIR=$INSTALL_DIR/vhmodules/flashnews

if ! [ -d $FLASHNEWS_DIR ]
then
  mkdir $FLASHNEWS_DIR
fi


if ! [ -d $INSTALL_DIR/pages/async/vhmodules/flashnews ]
then
  mkdir -p $INSTALL_DIR/pages/async/vhmodules/flashnews
fi

cp -rp vhmodule.php views lang $FLASHNEWS_DIR/

cp -rp async/* $INSTALL_DIR/pages/async/vhmodules/flashnews/
cp -rp classes/* $INSTALL_DIR/classes/
cp -rp processes/* $INSTALL_DIR/processes/


#SQL
sqlite3 $INSTALL_DIR/data/vh.sqlite < ./install.sql



