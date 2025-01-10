

Assureur;Canton;Territoire;Année fiscale;Année d'enquête;Région;Groupe d'âge;Inclusion accident;Tarif;Type de tarif;Sous-groupe d'âge;Niveau de franchise;Franchise;Prix;isBaseP;isBaseF;Nom du tarif



 HAM (médecin de famille)
 HMO (Health Maintenance Organization = organisation pour le maintien de la santé) // reseau de soins
 DIV = autre modèle
 BASE = assurance de base


# Setup 

ln -s docker-compose.standalone.yml docker-compose.yml


## import data

sail artisan app:import-insurers
sail artisan app:import-primes