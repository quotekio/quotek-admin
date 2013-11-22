<?php
 
 $errors = array(

   new chilimessage(000,
                    'ERR_UNKNOWN_ERROR',
                    'Erreur inconnue.'),

   new chilimessage(300,
                    'ERR_INVALID_LOGIN',
                    'Votre email ou mot de passe est incorrecte.'),

   new chilimessage(310,
                    'ERR_INVALID_TOKEN', 
                    'Votre clé beta est invalide.'),

   new chilimessage(311,
                    'ERR_USED_TOKEN', 
                    'Votre clé beta a déjà été utilisée.'),

   new chilimessage(320,
                    'ERR_INVALID_EMAIL' , 
                     "L'email entré est invalide"),
   new chilimessage(321,
                    'ERR_USED_EMAIL', 
                    "L'email fourni est déjà enregistré."),

   new chilimessage(322,
                   'ERR_UNKNOWN_EMAIL',
                   "l'adresse email fournie ne correspond à aucun compte utilisateur."),

   new chilimessage(400,
                    'ERR_SHORTPASS',
                    'Le mot de passe choisi est trop court (8 caractères min).'),

   new chilimessage(410,
                    'ERR_PASSWD_MISMATCH',
                    'Le mot de passe et sa confirmation ne correspondent pas.'),
   
   new chilimessage(420,
                    'ERR_INVALID_PASSWD',
                    'Le mot de passe de compte fourni est invalide.'),

   new chilimessage(500,
                   'ERR_MISSING_FIELD', 
                   "Vous n'avez pas saisi tous les champs obligatoires."),

   new chilimessage(510,
                   'ERR_MISSING_REQDATA',
                   'La requete comporte des données manquantes.'),

   new chilimessage(600,
                   'ERR_MISSING_SUBJECT',
                   "Le sujet de votre message est vide, veuillez le remplir."),

   new chilimessage(610,
                   'ERR_MISSING_MESSAGE', 
                   "Le message que vous voulez envoyer est vide, veuillez le remplir."),


   new chilimessage(700,
                    'ERR_APP_NOPARAM',
                    "Le paremêtre '%s' à tester n'existe pas."),

   new chilimessage(701,
                    'ERR_APP_NOTYPE',
                    "Le type '%s' n'existe pas."),

   new chilimessage(710,
                    'ERR_APP_STR2LONG',
                    "La chaine '%s' est trop longue (%d caractères max)."),

  new chilimessage(711,
                   'ERR_APP_STR2SHORT',
                   "La chaine '%s' est trop courte (%d caractères min)."),

  new chilimessage(720,
                   'ERR_APP_NOINT',
                   "La valeur '%s' n'est pas un entier."),
  new chilimessage(721,
                   'ERR_APP_INT2LARGE',
                   "La valeur '%d' est trop grande ! (ne doit pas dépasser %d)."),

  new chilimessage(722,
                   'ERR_APP_INT2SHORT',
                   "La valeur '%d' est trop petite (ne de pas être en dessous de %d)."),

  new chilimessage(723,
                   'ERR_APP_INTBOUNDS',
                   "L'entier '%d' est en dehors des limites (doit être compris entre %d et %d)."),

  new chilimessage(730,
                  'ERR_APP_PORTBOUNDS',
                  "Le numéro de port doit être compris entre 1 et 65535."),

  new chilimessage(740,
                  'ERR_APP_NOPATH',
                  "'%s' n'est pas un chemin de fichier %s valide."),  

  new chilimessage(750,
                  'ERR_APP_NOIP',
                  "'%s' n'est pas une adresse IP valide."),
  
  new chilimessage(751,
                  'ERR_APP_NOHOST',
                  "'%s' n'est pas un nom d'hôte valide."),

  new chilimessage(752,
                  'ERR_APP_NOFQDN',
                  "'%s' n'est pas un nom d'hote complet valide."),

  new chilimessage(753,
                  'ERR_APP_NODOMAIN',
                  "'%s' n'est pas un nom de domaine valide.")

  );  
?>