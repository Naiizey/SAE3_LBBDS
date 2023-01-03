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
        # Copie des archives de man dans le dossier contenant les différents man de l'OS
        sudo cp lbbdp.1.gz /usr/share/man/man1/lbbdp.1.gz
        sudo cp lbbdp.3.gz /usr/share/man/man3/lbbdp.3.gz
        
        # Ajout du man pour l'utilisateur et non l'OS
        # sudo mkdir /usr/local/man/man1
        # sudo mkdir /usr/local/man/man3
        # sudo cp lbbdp.1.gz /usr/local/man/man1
        # sudo cp lbbdp.3.gz /usr/local/man/man3
        
        echo "La commande lbbdp été installée"
    fi
fi
