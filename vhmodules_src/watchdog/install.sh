#!/bin/bash

echo "* VISIBLE HAND WATCHDOG MODULE INSTALL*"
echo "Visible hand Install Directory:"
read INSTALL_DIR

if ! [ -d $INSTALL_DIR/vhmodules ]
then
  echo "visible hand not found in directory, aborting install"
  exit 1
fi

WD_DIR=$INSTALL_DIR/vhmodules/watchdog

if ! [ -d $WD_DIR ]
then
  mkdir $WD_DIR
fi

if ! [ -d $INSTALL_DIR/pages/async/vhmodules/watchdog ]
then
  mkdir -p $INSTALL_DIR/pages/async/vhmodules/watchdog
fi

cp -rp vhmodule.php views $WD_DIR/
cp -rp jobs/* $INSTALL_DIR/jobs

cp -rp async/* $INSTALL_DIR/pages/async/vhmodules/watchdog/
