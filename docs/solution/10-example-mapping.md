# Portfolio – Spécifications (Gherkin)

## Feature: Conversion de devises

Permet de convertir un montant d'une devise vers une autre en utilisant une devise pivot et des taux de change.

---

## Background

```gherkin
Given une banque avec "EUR" comme devise pivot
```

---

## Scenario: Conversion sans taux de change défini

```gherkin
Given aucune configuration de taux de change
When je convertis 10 EUR en USD
Then une erreur est levée indiquant que les taux de change ne sont pas définis
```

---

## Scenario: Conversion de la devise pivot vers une autre devise

```gherkin
Given un taux de change EUR -> USD de 1.2
When je convertis 10 EUR en USD
Then je reçois 12 USD
```

---

## Scenario: Conversion d'une devise vers la devise pivot

```gherkin
Given un taux de change EUR -> USD de 1.2
When je convertis 10 USD en EUR
Then je reçois 8.2 EUR
```

---

## Scenario: Conversion avec devise non supportée

```gherkin
Given un taux de change EUR -> USD de 1.2
When je convertis 10 EUR en KRW
Then une erreur est levée indiquant que la devise n'est pas supportée
```

---

## Scenario: Conversion avec taux de change nul ou négatif

```gherkin
Given un taux de change EUR -> USD de 0
When je convertis 10 EUR en USD
Then une erreur est levée indiquant que le taux de change doit être strictement positif
```

---

## Scenario: Conversion avec montant négatif

```gherkin
Given un taux de change EUR -> USD de 1.2
When je convertis -10 EUR en USD
Then une erreur est levée indiquant que le montant doit être positif
```

---

## Scenario: Conversion vers la même devise

```gherkin
Given un taux de change EUR -> USD de 1.2
When je convertis 10 EUR en EUR
Then je reçois 10 EUR
```

---

## Scenario: Arrondi du résultat

```gherkin
Given un taux de change EUR -> USD de 1.2345
When je convertis 10 EUR en USD
Then le résultat est arrondi au dixième inférieur
And je reçois 12.3 USD
```

---

## Règles de gestion

- Une devise pivot doit être définie  
- Les taux de change sont exprimés par rapport à la devise pivot  
- Le taux de change doit être strictement positif  
- Le montant à convertir doit être strictement positif  
- Si la devise source et cible sont identiques, retourner le montant initial  
- Si aucun taux n'existe pour une devise, lever une erreur  
- L'arrondi se fait au dixième inférieur si plus de 3 décimales