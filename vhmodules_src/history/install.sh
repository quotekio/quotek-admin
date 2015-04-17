#!/bin/bash

echo "* VISIBLE HAND History MODULE INSTALL*"
echo "Visible hand Install Directory:"

read INSTALL_DIR

if ! [ -d $INSTALL_DIR/vhmodules ]
then
  echo "visible hand not found in directory, aborting install"
  exit 1
fi

VISUAL_DIR=$INSTALL_DIR/vhmodules/history

if ! [ -d $VISUAL_DIR ]
then
  mkdir $VISUAL_DIR
fi

if ! [ -d $INSTALL_DIR/pages/async/vhmodules/history ]
then
  mkdir -p $INSTALL_DIR/pages/async/vhmodules/history
fi

cp -rp vhmodule.php views lang $VISUAL_DIR/
cp -rp async/* $INSTALL_DIR/pages/async/vhmodules/history/
cp -r jobs/* $INSTALL_DIR/jobs/

