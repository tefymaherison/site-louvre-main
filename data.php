<?php
// ANDRIANIRAISANTSOA, BIBAL et RACERLYN
?>
<?php
// Les variables suivantes, servant à l'appel de la base de données, seront importées dans le fichier test.php pour leur utilisation
$host = "localhost"; 
$user = "root";
$mdp = "";
$bdd = "reservation";
$nom = $_POST["Nom"];
// Les variables suivantes, servant à la récupération des données fournies dans le formulaire, seront importées dans le fichier test.php pour leur utilisation
$prenom = $_POST["Prénom"];
$jdn = strval($_POST["JDN"]); // Bien que PHP soit un langage faiblement typé, les données concernant le jour, le mois et l'année de naissance ont été converties d'entiers en chaînes de caractères pour permettra la concaténation suivante
$mdn = strval($_POST["MDN"]);
$adn = strval($_POST["ADN"]);
$ddn = $jdn."-".$mdn."-".$adn; // Ceci est la concaténation du jour, du mois et de l'année de naissance fournis par le client dans le formualaire. Cette solution a été choisie du fait que l'élément <input> dont l'attribut type vaut date n'est pas pris en charge par le localhost, ce dernier étant nécessaire à la mise en oeuvre du PHP
date_default_timezone_set('Europe/Paris'); // Ceci permet de se placer selon le fuseau horaire de la France
$today = date("d-m-Y"); // Ceci permet de récupérer la date du jour, jour où est exécuté le programme (ce jour informera donc sur la date de réservation)
$mail = $_POST["Mail"];
$tel = $_POST["Téléphone"];
$ad = $_POST["Adresse"];
$cp = $_POST["CP"];
$ville = $_POST["Ville"];
$adresse = $ad." ".$cp." ".$ville; //Ceci est la concaténation du numéro et du nom de rue, du code postal éventuel (pour la France notamment) et de la ville de résidence fournis par le client dans le formualaire.
$pays = $_POST["Pays"];
$billet = $_POST["Billet"];
$visite = strval($_POST["JourVisite"]); 
$datevisite = date("d-m-Y", strtotime("+$visite days")); // Ceci permet d'ajouter à la date de réservation (la date du jour où le programme est exécuté), le nombre de jour jusqu'à atteindre le jour de visite souhaité (exemple : si l'on réserve le 27/04/2022 et que l'on souhaite visiter l'exposition trois jours après, la date de la visite sera fixée au 30/04/2022), la visite pouvant s'effectuer jusqu'à 7 jours après la réservation
$diff = date_diff(date_create($ddn), date_create($datevisite)); 
$age = $diff->format("%Y"); // Ces deux dernières instructions permettent de récupérer l'âge que le client aura le jour de la visite, en effectuant une différence (exprimée en années) entre la date prévue de la visite et la date de naissance
?>