Notre application effectuer lors de ce projet vise à simplifier la recherche de stage des étudiants. Notre application adaptée aux differents profils d'utilisateur (administrateur, étudiant, pilote).


# Partie Utilisateur

Dans un premier temps, l'utilisateur arrive sur une interface. Cette interface présente alors notre site, et sa fonctionnalité à savoir faciliter la recherche de stage.
Sur cette interface, nous pouvons retrouver un bouton afin de s'authentifier.
Sur cette interface, nous retrouverons également les mentions légales (informations légales, CGU, politique de confidentialité et Aide et contact), nous retrouvons également des offres d'emploies à consulter en fonction du secteur, de la ville, des entreprises ou même par mor clés. Les contacts ainsi que les réseau sociaux sont également indiqué.


## Connexion

Sur notre interface, nous pouvons retrouver un bouton "connexion". Ce bouton permettra donc à l'utilisateur de s'identifier, afin de rentré dans son compte. 
L'utilisateur entre alors son adresse mail ainsi que son mot de passe. 
Un bouton "mot de passe oublié" est également disponible, afin de pouvoir réinitialisé celui-ci.

Un bouton d'accueil est également présent dans la partie supérieur.

## Page d'acceuil (étudiant)

Une fois connecter, nous arrivons sur une nouvelles interface utilisateur. Sur cette nouvelle interface, nous pouvons consulter les offres de stage, et ainsi consulter nos précédentes candidature.

## Offre de stage 

Une fois sur la page "offre de stage", nous pouvons consultez de nombreuses offres de stages, proposé par différentes entreprises.
Sur ces offres de stages, nous retrouverons le nom de l'entreprise, la fonction du stage, la rémunération, les dates de début et de fin, ainsi que la date de publication de l'anonce.
Un boutons détail sous chaque offre est présent. En cliquant sur ce bouton, nous pouvons alors postuler à l'offre de stage, en rentrant un cv ainsi qu'une lettre de motivation

## Partie d'acceuil (pilote)

Lorsque nous nous connectons en tant que pilote, nous arrivons sur une interface différente que celle de l'interface étudiante.
En effet sur l'interface pilote, nous retrouvons deux pages : Une page afin de gérer nos offres, et une autre page afin de consulter les candidatures.

# Partie administrateur 

## Fonctionnalité 

1. Gestion des utilisateurs 
2. Gestion des entreprises
3. Gestion des offres de stages
4. Gestion des candidatures 
5. Sécurité et conformité
6. Suivi

## Structure du projet 

├───fastintern-site
│   ├───public
│   ├───src
│   │   ├───Controllers
│   │   │   ├───Admin
│   │   │   ├───Auth
│   │   │   └───Invite
│   │   ├───Database
│   │   ├───Models
│   │   └───Views
│   │       ├───Admin
│   │       ├───Auth
│   │       ├───Etudiant
│   │       ├───Invite
│   │       └───Pilote
│   └───vendor
│       ├───composer
│       ├───symfony
│       │   ├───deprecation-contracts
│       │   ├───polyfill-ctype
│       │   ├───polyfill-mbstring
│       │   │   └───Resources
│       │   │       └───unidata
│       │   └───polyfill-php81
│       │       └───Resources
│       │           └───stubs
│       └───twig
│           └───twig
│               └───src
│                   ├───Attribute
│                   ├───Cache
│                   ├───Error
│                   ├───Extension
│                   ├───Loader
│                   ├───Node
│                   │   └───Expression
│                   │       ├───Binary
│                   │       ├───Filter
│                   │       ├───FunctionNode
│                   │       ├───Test
│                   │       ├───Unary
│                   │       └───Variable
│                   ├───NodeVisitor
│                   ├───Profiler
│                   │   ├───Dumper
│                   │   ├───Node
│                   │   └───NodeVisitor
│                   ├───Resources
│                   ├───Runtime
│                   ├───RuntimeLoader
│                   ├───Sandbox
│                   ├───Test
│                   ├───TokenParser
│                   └───Util
└───fastintern-static
    └───static
        ├───assets
        ├───css
        │   ├───Admin
        │   ├───Auth
        │   ├───Invite
        │   └───layout
        └───JS
            ├───Admin
            ├───Auth
            ├───Invite
            └───layout

Voici notre structure de projet. 

Comme nous pouvons le voir, nous retrouvons notre site fastintern, qui est le coeur de notre application web. Nous retrouvons entre autre nos controllers, qui nous permettrons de gerer nos requetes HTTP. Nous trouvons également nos views, qui contiennent nos templates (twig)pour l'affichage.
Nous avons chaques dossiers correpondant à un rôle specifique de l'application.
Nous pouvons également voir "Vendor", correpondant à toutes les bibliothèque PHP utilisé pour ce projet.

Nous retrouvons également notre fastintern static, comprenant nos assets (images, police...)
Nous retrouvons nos feuiles de styles (css), ainsi que nos JS (script javascript)


## Requis 

Pour réaliser ce projet, nous avions eu besoin de PHP bien évidemment.
Nous avions également eu besoin de MYSQL, de composer. Nous avons également utiliser Apache, et également XAMPP.

## Trello

Voici ci-joint notre trello utiliser pour notre projet :
https://trello.com/invite/b/67a5dce636de430210ca2efe/ATTI30912b0a6b1f29210e270eafe86032af10E5244C/web4all


            

