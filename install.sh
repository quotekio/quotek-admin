#!/bin/bash

FY=0
if [ "$1" == "-y" ];then
  FY=1
fi

INSTALL_DIR=""
if [ "$2" == "-i" ];then
  INSTALL_DIR=$3
fi

HAS_PREV_INST=0

echo "* QWC INSTALLER *"

if [ "$INSTALL_DIR" == "" ];then
  echo "Install Directory:"
  read INSTALL_DIR
fi

if [ -d $INSTALL_DIR ]
then
  echo "A Previous version of QWC has been found. Do you want to back it up?"
  
  if [ $FY == 0 ]; then 
    read BACKUP_ANS
  else
    BACKUP_ANS="y"
  fi


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
cp -rv classes lib vendor conf data include jobs processes lang pages templates web tools $INSTALL_DIR/

if [ $HAS_PREV_INST -eq 1 ]
then
  echo "Do you want to reimport data from previous install ?"

  if [ $FY == 0 ]; then 
    read REIMPORT_DATA
  else
    REIMPORT_DATA="y"
  fi

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

  if [ $FY == 0 ]; then 
    read MINSTALL
  else
    MINSTALL="y"
  fi

  if [ $MINSTALL == "Y" ] || [ $MINSTALL == "y" ]
  then
    cd $i
    echo $INSTALL_DIR | ./install.sh
    cd ..
  fi
done

cd ..

echo "copying init scripts.."
cp ./init.d/* /etc/init.d/

echo "setting directory rights.."
chown -R www-data $INSTALL_DIR


