#!/bin/bash

echo "* VISIBLE HAND Graph-It MODULE INSTALL*"
echo "Visible hand Install Directory:"

read INSTALL_DIR

if ! [ -d $INSTALL_DIR/vhmodules ]
then
  echo "visible hand not found in directory, aborting install"
  exit 1
fi

VISUAL_DIR=$INSTALL_DIR/vhmodules/graphit

if ! [ -d $VISUAL_DIR ]
then
  mkdir $VISUAL_DIR
fi

if ! [ -d $INSTALL_DIR/pages/async/vhmodules/graphit ]
then
  mkdir -p $INSTALL_DIR/pages/async/vhmodules/graphit
fi

cp -rp vhmodule.php views lang $VISUAL_DIR/
cp -rp async/* $INSTALL_DIR/pages/async/vhmodules/graphit/
cp -rp classes/* $INSTALL_DIR/classes/

#SQL
sqlite3 $INSTALL_DIR/data/quotek.sqlite < ./install.sql
