#!/bin/bash

HAS_PREV_INST=0

echo "* VISIBLE HAND INSTALLER *"
echo "Install Directory:"
read INSTALL_DIR

if [ -d $INSTALL_DIR ]
then
  echo "A Previous version of Visible Hand has been found. Do you want to back it up?"
  read BACKUP_ANS

  if [ $BACKUP_ANS == "Y" ] || [ $BACKUP_ANS == "y" ]
  then
    HAS_PREV_INST=1
    echo "Backing up previous version.."
    if [ -d $INSTALL_DIR.bak  ]
    then
      rm -rf $INSTALL_DIR.bak
    fi
    mv $INSTALL_DIR $INSTALL_DIR.bak
  fi
fi

mkdir $INSTALL_DIR
cp -rv classes lib conf data include jobs lang pages templates web tools $INSTALL_DIR/

if [ $HAS_PREV_INST -eq 1 ]
then
  echo "Do you want to reimport data from previous install ?"
  read REIMPORT_DATA

  if [ $REIMPORT_DATA == "Y" ] || [ $REIMPORT_DATA == "y" ]
  then
    rm -rf $INSTALL_DIR/data
    cp -rp $INSTALL_DIR.bak/data $INSTALL_DIR/
  fi
fi

mkdir $INSTALL_DIR/vhmodules

echo "Probbing modules.."
cd vhmodules_src

for i in `ls -1`
do 
  echo "Do you want to install $i ?" 
  read MINSTALL
  if [ $MINSTALL == "Y" ] || [ $MINSTALL == "y" ]
  then
    cd $i
    echo $INSTALL_DIR | ./install.sh
    cd ..
  fi
done

echo "setting directory rights.."
chown -R www-data $INSTALL_DIR

