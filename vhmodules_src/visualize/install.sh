#!/bin/bash

echo "* VISIBLE HAND visualiz MODULE INSTALL*"
echo "Visible hand Install Directory:"

read INSTALL_DIR

if ! [ -d $INSTALL_DIR/vhmodules ]
then
  echo "visible hand not found in directory, aborting install"
  exit 1
fi

VSTORE_DIR=$INSTALL_DIR/vhmodules/vstore

if ! [ -d $VSTORE_DIR ]
then
  mkdir $VSTORE_DIR
fi

if ! [ -d $INSTALL_DIR/pages/async/vhmodules/visualize ]
then
  mkdir -p $INSTALL_DIR/pages/async/vhmodules/visualize
fi

cp -rp vhmodule.php views lang $VSTORE_DIR/
cp -rp async/* $INSTALL_DIR/pages/async/vhmodules/visualize/
cp -rp classes/* $INSTALL_DIR/classes/
cp -rp jobs/* $INSTALL_DIR/jobs/


