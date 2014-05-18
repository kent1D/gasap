#GASAP

*Un plugin pour [SPIP](http://www.spip.net) de gestion des Groupes d'Achat Solidaires de l'Agriculture Paysanne.*

Gère les groupes et l'inscription aux groupes.

[Voir en ligne](http://www.gasap.be/)


# Principaux changements depuis la version originale

## Statuts des GASAP

Les GASAP ont maintenant 4 statuts différents :

* ```contruction``` pour les GASAP "en construction"
* ```libre```pour les GASAP qui ont des places libres
* ```complet``` pour les GASAP sans place libre
* ```poubelle``` pour les GASAP à la poubelle, fermés, inactifs

L'ancien champ SQL ```complet``` et donc la balise SPIP ```#COMPLET``` ont été fusionnés avec le champ SQL ```statut``` et donc la balise SPIP ```#STATUT``` via les upgrades de base ```0.2.0``` et ```0.3.0```.

Au niveau de l'interface, on change le statut d'un GASAP via le formulaire de changement de statut habituel des objets SPIP.

## Changement de nom du champ pour les permanences

Les champs ```permanence``` des tables ```spip_gasap``` et ```spip_producteurs``` étaient nommés ```permanance``` avec un ```a```.

C'est corrigé. 


## Le formulaire de contact de GASAP

Le formulaire de contact de GASAP doit avoir un paramètre ```id_gasap```