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