<<<<<<< HEAD


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
sail artisan app:import-regions


php-8.3 artisan app:import-insurers; php-8.3 artisan app:import-primes; php-8.3 artisan app:import-regions



## replace regions code

update primes set region_code=REPLACE(region_code,'PR-REG CH','')



## 
=======
# lamal
api lamal
Liste des end points,

## Tarifs type,
GET /api/tarif_type

```json 
    {
        "data":[

        ],
        "metadata":{

        }
    }
```

## Tranches d'age,
GET /api/age

## Franchise,
Récupérer la franchise,
GET /api/franchises
GET /api/franchises/{age_id}



## Primes,
Listes des primes,
GET /api/primes/{profile_id}
POST /api/primes

*body* 
```json 
    {
        "filter":{},
    }
```


## Comparaison des primes sélectionnées,
GET /api/selection
POST /api/selection/{profile_id}/{prime_card_id}
DELETE /api/selection/{profile_id}/{prime_card_id}

## Regions,
POST /api/regions

*body* 
```json 
    {
        "filter":{},
    }
```

## Users,

Récupérer un nouveau token pour créer un ou plusieurs profil,
POST /api/register
*body*
```json
    {
    "name" : "", //required
    "email" : "", //required
    "password" : "", //required
    "password_confirmation" : "" //required
    }
```


*response* 
```json 
    {
        "user": {
        "name": "",
        "email": "",
        "updated_at": "",
        "created_at": "",
        "id": ""
    },
        "token":"uuid" // uuid
    }
```
Récupérer un token pour créer un ou plusieurs profil,
POST /api/login
*body*
```json
    {
    "name" : "", //required
    "email" : "", //required
    "password" : "", //required    
    }
```

*response* 
```json 
    {
        "user": {
        "id": "",
        "name": "",
        "email": "",
        "email_verified_at": null,
        "created_at": "",
        "updated_at": ""
    },
        "token":"uuid" // uuid
    }
```
Se déconnecter,
POST /api/logout

Créer un profil
POST /api/profile
*header*

X-ANONYMOUS-TOKEN: blab

*body* 
```json 
    {
      //  "uid":"", // optionnel, si vide créé un nouvel util anonyme
        "name":"",
        "region_code":"", // optional
        "canton_id":"", // optional 
        "age_range_id":"", // optional
        "franchise_id":"", // optional
        
    }
```

```json 
    {
        "uid":"", 
        "profile_id"
        
    }
```

Récupérer un profil,
GET  /api/profile/{profile_id}

Supprimer un profil,
DELETE /api/profile/{profile_id}

Modifier un profil
PUT /api/profile/{profile_id}

*body* 
```json 
    {
        "name":"",
        "region_code":"", // optional
        "canton_id":"", // optional 
        "age_range_id":"", // optional
        "franchise_id":"", // optional
        
    }
```
>>>>>>> b409c177592fe6b7894c7af985030c1bd38c52d5
