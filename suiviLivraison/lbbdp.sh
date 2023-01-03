#!/bin/bash
#Si vous utilisez ./lbbdp.sh pour lancer le script ne pas oublier de chmod +x lbbdp.sh 
if [ $(id -u) -ne 0 ]; then
    echo "Vous devez lancer ce script avec sudo"
    exit 1
else
    #On sauvegarde le chemin de l'exécutable avant de se déplacer
    cheminLbbdp=$(dirname $0)/lbbdp

    cd /usr/bin
    if [ -L lbbdp ]; then
        echo "La commande lbbdp existe déjà"
        exit 1
    else
        #On crée un lien symbolique vers l'exécutable
        ln -s $cheminLbbdp lbbdp
        sudo cp lbbdp.1.gz /usr/share/man/man1/lbbdp.1.gz
        sudo cp lbbdp.3.gz /usr/share/man/man3/lbbdp.3.gz
        echo "La commande lbbdp été installée"
    fi
fi
