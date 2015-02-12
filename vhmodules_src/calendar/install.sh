#!/bin/bash

echo "* VISIBLE HAND Calendar MODULE INSTALL*"
echo "Visible hand Install Directory:"

read INSTALL_DIR

if ! [ -d $INSTALL_DIR/vhmodules ]
then
  echo "visible hand not found in directory, aborting install"
  exit 1
fi

CALENDAR_DIR=$INSTALL_DIR/vhmodules/calendar

if ! [ -d $CALENDAR_DIR ]
then
  mkdir $CALENDAR_DIR
fi


if ! [ -d $INSTALL_DIR/pages/async/vhmodules/calendar ]
then
  mkdir -p $INSTALL_DIR/pages/async/vhmodules/calendar
fi

cp -rp vhmodule.php views lang $CALENDAR_DIR/

cp -rp async/* $INSTALL_DIR/pages/async/vhmodules/calendar/
cp -rp classes/* $INSTALL_DIR/classes/

#SQL
sqlite3 $INSTALL_DIR/data/vh.sqlite < ./install.sql



