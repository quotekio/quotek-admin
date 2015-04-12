#!/bin/bash

echo "* VISIBLE HAND QuickPos MODULE INSTALL*"
echo "Visible hand Install Directory:"

read INSTALL_DIR

if ! [ -d $INSTALL_DIR/vhmodules ]
then
  echo "visible hand not found in directory, aborting install"
  exit 1
fi

QUICKPOS_DIR=$INSTALL_DIR/vhmodules/quickpos

if ! [ -d $QUICKPOS_DIR ]
then
  mkdir $QUICKPOS_DIR
fi


if ! [ -d $INSTALL_DIR/pages/async/vhmodules/quickpos ]
then
  mkdir -p $INSTALL_DIR/pages/async/vhmodules/quickpos
fi

cp -rp vhmodule.php views lang $QUICKPOS_DIR/
#cp -rp classes/* $INSTALL_DIR/classes/



