#!/bin/bash

echo "* VISIBLE HAND visualiz MODULE INSTALL*"
echo "Visible hand Install Directory:"

read INSTALL_DIR

if ! [ -d $INSTALL_DIR/vhmodules ]
then
  echo "visible hand not found in directory, aborting install"
  exit 1
fi

VISUAL_DIR=$INSTALL_DIR/vhmodules/coredumps

if ! [ -d $VISUAL_DIR ]
then
  mkdir $VISUAL_DIR
fi

if ! [ -d $INSTALL_DIR/pages/async/vhmodules/coredumps ]
then
  mkdir -p $INSTALL_DIR/pages/async/vhmodules/coredumps
fi

cp -rp vhmodule.php views lang $VISUAL_DIR/
cp -rp async/* $INSTALL_DIR/pages/async/vhmodules/coredumps/
cp -rp classes/* $INSTALL_DIR/classes/
cp -rp jobs/* $INSTALL_DIR/jobs/


