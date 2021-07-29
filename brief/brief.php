BRIEF APRES LE CONFINEMENT

Étape 1
Créez une structure de site complete (dossier inc et asset, header.php, footer.php, styles.css avec reset)
Créez la table MySQL qui contiendra vos rêves. nommez la reves
Elle doit contenir des colonnes pour l'auteur, le rêve, la date, et bien sûr, une colonne d'id. (id, author, reve, created_at)
Ajoutez une dizaine de rêves dans PHPMyAdmin

Étape 2
Affichez les 10 rêves les plus récentes en page d'accueil (index.php).
L'affichage de chaque rêve comprend :
- Le rêve en tant que telle
- Le nom de son auteur
- La date de création
Il est conseillé d'afficher chaque rêve à l'intérieur d'une balise de mise-en-page.

Étape 3
Ajoutez 2 colonnes à votre table MySQL d'rêves : likes et dislikes. Ces colonnes serviront à comptabiliser le nombre de votes d'appréciation ou de non-appréciation des rêves. Elles doivent donc être en nombre entier. Assurez-vous que la valeur par défaut est à 0.

Étape 4
Ajoutez deux liens sous chaque rêve, sur la page index.php.
Le premier de ces liens doit mener vers une page "likes.php", le second, vers "dislikes.php".
Ces liens doivent également comprendre en paramètre d'URL l'id de l'rêve correspondante (sous la forme : ?id=999)

Étape 5
Sur les pages likes.php et dislikes.php, faite le nécessaire pour incrémenter d'un vote la colonne de likes ou dislikes. En d'autres mots, ces pages sont responsables de comptabiliser les votes pour chaque rêves, et de les sauvegarder en base de données.
Une syntaxe simple pour incrémenter directement la valeur d'une colonne en MySQL est la suivante : col_name = col_name + 1

Étape 6
Une fois la requête effectuée, affichez un lien de retour vers la page d'accueil.

Étape 7
Affichez maintenant le nombre de likes et dislikes sous chaque rêve.

Étape 8
Au lieu du bouton retour sur les pages likes et dislikes, faites une redirection automatique avec la fonction PHP header().

Étape 9
Assurez-vous que la date de création de chaque rêve soit affichée dans un format français : dd/mm/yyyy à hh:ii, sans les secondes. Utilisez les fonctions date() et strtotime() pour cette opération.

Étape 10
Dans votre page index.php, ajoutez un lien menant vers une nouvelle page, "add.php". Dans cette page, vous devez intégrer tout le contenu HTML habituel, ainsi qu'un formulaire d'ajout d'rêves, et finalement, un bouton retour (vers l'accueil).

Étape 11
Au haut de votre page add.php, traitez le formulaire en PHP. Si le formulaire est valide (la longueur des textes est bonnes, et les champs requis sont tous renseignées, etc.), faites une insertion en base de données. N'oubliez pas que les nombres de votes sont à 0 par défaut, et que vous pouvez utiliser la fonction NOW() de MySQL pour obtenir la date actuelle.

Étape 12
Si le formulaire n'est pas valide, affichez un message d'erreur. Assurez-vous également que les données entrées par l'internaute sont restituées dans le formulaire, afin qu'il n'ait pas à tout retaper.

Étape 13
Créez un système de pagination qui permettra de voir les rêves suivantes ou précédentes.
Vous devez donc, pour commencer, créer 2 liens (rêves suivantes et rêves précédentes) qui mèneront vers cette même page index.php, mais en y incluant un nouveau paramètre d'url : page. Les liens ressembleront donc à index.php?page=3

Étape 14
Modifiez votre requête SQL Select afin qu'elle prenne en compte le numéro de page présent dans les paramètres d'URL. Utilisez la clause LIMIT de MySQL pour ce faire (la clause LIMIT peut prendre 2 paramètres).

Étape 15
Faites une seconde requête SQL sur cette page index.php afin de sélectionner le nombre total de rêves présentes dans votre table. Affichez ce nombre en haut de la page.

Étape 16
Faites en sorte que les liens "rêves précédentes" et "rêves suivantes" ne s'affichent que s'il y a bien des rêves suivantes et/ou précédentes à afficher.

Étape 17
Faire une fonction de la pagination pour pouvoir l'afficher au dessus des rêves, mais aussi en dessous!

Étape 18
Fusionnez likes.php et dislikes.php en un seul fichier.