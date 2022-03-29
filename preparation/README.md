# Projet_BDD_S4_2022

# Préparation aux séances 5 et 6

---

## Q1

À l'aide de la méthode `json_encode($obj)` il est possible de transformer l'objet PHP en une chaîne sous le format JSON.

Cependant celui-ci peut être retourné sous 2 formes :

- Sous la forme d'un tableau si l'objet donné est un tableau sans ajout de clés personnalisées.
- Sous la forme d'un objet si l'objet donné est un tableau contenant des clés personnalisées ou que le paramètre `JSON_FORCE_OBJECT` y est ajouté.

---

## Q2

Avec Slim, il est possible de récuperer les paramètres d'une requête HTTP avec ces méthodes :

**[GET] : QueryString**

- `getQueryParams()` || `getParams()` -> Tableau contenant les arguments de la requête HTTP.
- `getQueryParam($param)` -> Valeur d'un paramètre du querystring de le requête.

**[POST] : Corps de requête**

- `getParsedBody()` -> Tableau ou objet contenant le corps de la requête HTTP.
- `getParsedBodyParam($param)` -> Valeur d'un paramètre du corps de le requête.

**[Any]**

- `getParam($param)` -> Valeur d'un paramètre de la requête HTTP, peu importe sa provenance.

---

## Q3

Pour positionner un code de réponse, on utilise la méthode `$response->withStatus($code, $message)`.

Exemple :

```php
$newResponse = $response->withStatus(302);
$newResponse = $response->withStatus(404, 'Not Found');
```
---

Pour positionner un header dans la réponse, on utilise la méthode `$response->withHeader($name, $value)`.

Exemple :

```php
$newResponse = $oldResponse->withHeader('Content-type', 'application/json');
```
---

