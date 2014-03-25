#!/bin/bash

echo "* VISIBLE HAND Reach MODULE INSTALL*"
echo "Visible hand Install Directory:"

read INSTALL_DIR

if ! [ -d $INSTALL_DIR/vhmodules ]
then
  echo "visible hand not found in directory, aborting install"
  exit 1
fi

REACH_DIR=$INSTALL_DIR/vhmodules/reach

if ! [ -d $REACH_DIR ]
then
  mkdir $REACH_DIR
fi


if ! [ -d $INSTALL_DIR/pages/async/vhmodules/reach ]
then
  mkdir -p $INSTALL_DIR/pages/async/vhmodules/reach
fi

cp -rp vhmodule.php views lang $REACH_DIR/

cp -rp async/* $INSTALL_DIR/pages/async/vhmodules/reach/
cp -rp classes/* $INSTALL_DIR/classes/


