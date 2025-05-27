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

Récupérer un token pour créer un ou plusieurs profil,
GET /api/anonymous_user

*response* 
```json 
    {
        "token":"uuid" // uuid
    }
```


Créer un profil
POST /api/profile/{uid}

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