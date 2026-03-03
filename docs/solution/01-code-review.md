# Backlog

## What can be improved in the codebase ?

- La documentation des fonctions: Il est nécessaire de dire clairement ce que fait chaque fonction, à quoi sert chaque paramètre et à quoi correspond la valeur de retour
- Le nom des fonctions de test ne sont pas cohérents, car ce qui est testé n'est pas reflété dans le nom de la fonction
- La documentation du projet n'explique en rien comment initialiser le projet, le lancer ou lancer les tests
- Les tests sont réalisés en une seule longue ligne et sont peu lisible. Il serait plus simple de les faire sur plusieurs lignes
- Certains morceaux de code sont un mélange de français et d'anglais
- Les tests ne semblent pas couvrir tous les cas possibles
- Dans MoneyCalculator, la Currency ne sert pas mais est quand même requise
- Les conditions de Bank::Convert sont à revoir + currency1 => from & currency2 => to
