#!/bin/bash

echo "* Quotek Admin visualiz module installer *"
echo "Quotek Admin Install Directory:"

read INSTALL_DIR

if ! [ -d $INSTALL_DIR/vhmodules ]
then
  echo "Admin not found in directory, aborting install"
  exit 1
fi

VISUAL_DIR=$INSTALL_DIR/vhmodules/visualize

if ! [ -d $VISUAL_DIR ]
then
  mkdir $VISUAL_DIR
fi

if ! [ -d $INSTALL_DIR/pages/async/vhmodules/visualize ]
then
  mkdir -p $INSTALL_DIR/pages/async/vhmodules/visualize
fi

cp -rp vhmodule.php views lang $VISUAL_DIR/
cp -rp async/* $INSTALL_DIR/pages/async/vhmodules/visualize/


