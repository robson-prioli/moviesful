## Descrição

Uma simples restful em 3 versões, baseada em um imagem de uma url que vi no instagram. A troca do output e o jwt foi incluido como extra, não tinha informações sobre no post.


```/api/v1/movies?filter=title&sort=desc&limit=10```


## /api/v1/

Normal.

```
/api/v1/movies?filter=title&sort=desc&limit=10
Authorization: Bearer YOUR_BEARER_TOKEN
```


## /api/v2/

Pode trocar o output, retorno default é xml.

```
/api/v2/movies?filter=title&sort=desc&limit=10&output=json
Authorization: Bearer YOUR_BEARER_TOKEN
```


## /api/v3/

Autenticação com jwt (Puro).

### Register

O token expirará em uma hora (3600 segundos).


```
/api/v3/register
form-data :[
    'username' => 'username',
    'password' => 'password'
]

```

### Movies

```
/api/v3/movies?filter=title&sort=desc&limit=10
Authorization: Bearer YOUR_JWT_TOKEN
```


