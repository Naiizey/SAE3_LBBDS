#!/bin/bash
if [ $(id -u) -ne 0 ]; then
echo "Vous devez lancer ce script avec sudo"
exit 1
else
cd /usr/bin
ln -s ~/SAE3_LBBDS/suiviLivraison/lbbdp lbbdp
echo "La commande lbbdp été installée"
fi