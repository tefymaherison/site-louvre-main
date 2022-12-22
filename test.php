<?php
// ANDRIANIRAISANTSOA, BIBAL et RACERLYN
?>
<center>
<fieldset>
<legend><b>Récapitulatif de vos informations personnelles et de votre réservation</b></legend>
<br>
<br>
<table>
<?php
// On requiert les données contenues dans le fichier data.php 
require("data.php");
// On check si la date de naissance existe bien (exemple : le 29/02/2001 n'existe pas (2001 n'est pas une année bissextile donc une erreur sera renvoyée)
if (!checkdate($mdn,$jdn,$adn)){
	// Si ce n'est pas le cas, on créé la variable $a contenant le message suivant
	$a = "La date de naissance renseignée n'est pas valide ! Vous pouvez retourner à la page précédente pour modifier vos informations.";
}
// On check si le client a bien moins de 18 ans pour bénécier du tarif "Jeunes de moins de 18 ans (Gratuit)" 
else if ($billet == "G1" and $age >= "18"){
	// Si ce n'est pas le cas, on créé la variable $a contenant le message suivant
	$a = "Vous ne pouvez pas bénéficier de ce tarif, vous avez ou vous aurez plus de 18 ans le jour de la visite. Vous pouvez retourner à la page précédente pour modifier vos informations.";
}
// On check si le client a bien entre 18 et 25 ans pour bénécier du tarif "Visiteurs de 18-25 ans résidents dans l'UE (Gratuit)" 
else if (($billet == "G2" and $age < "18")||($billet == "G2" and $age > "25")){
	// Si ce n'est pas le cas, on créé la variable $a contenant le message suivant
	$a = "Vous ne pouvez pas bénéficier de ce tarif, vous n'avez ou vous n'aurez pas entre 18 et 25 ans le jour de la visite. Vous pouvez retourner à la page précédente pour modifier vos informations.";
}
// On check si le client réside bien dans l'Union Européenne pour bénécier du tarif "Visiteurs de 18-25 ans résidents dans l'UE (Gratuit)" 
else if (($billet == "G2" and $pays == "NOTUE")){
	// Si ce n'est pas le cas, on créé la variable $a contenant le message suivant
	$a = "Vous ne pouvez pas bénéficier de ce tarif, vous ne résidez pas dans l'Union Européenne. Vous pouvez retourner à la page précédente pour modifier vos informations.";
}
// On teste si, dans l'un des quatre cas précédents, la variable $a a été créée
if (isset($a)){
	// Si c'est le cas, on l'affiche
	echo $a;
}
// Si la variable $a n'a pas été créée, tout est ok du côté des informations qu'il fallait vérifier, on poursuit alors notre programme
else{
	// Si le client a séléctionné "Plein Tarif Musée (17€)", on affecte à la variable $prix la chaîne "17,00€"
	if ($billet == "PTM"){
		$prix = "17,00€";
	}
	// Dans le cas contraire, le client a séléctionné un des cas de gratuité, on affecte alors à la variable $prix la chaîne "00,00€"
	else{
		$prix = "00,00€";
	}
	// On affiche ensuite un récapitulatif des informations que le client a saisi
	echo "<tr><td>Prénom du visiteur </td><td>: </td><td>".$prenom."</td></tr>";
	echo "<tr><td>Nom du visiteur </td><td>: </td><td>".$nom."</td></tr>";
	echo "<tr><td>Date de naissance </td><td>: </td><td>".$ddn."</td></tr>";
	echo "<tr><td>Âge </td><td>: </td><td>".$age."</td></tr>";
	echo "<tr><td>E-Mail </td><td>: </td><td>".$mail."</td></tr>";
	echo "<tr><td>Téléphone </td><td>: </td><td>".$tel."</td></tr>";
	echo "<tr><td>Adresse </td><td>: </td><td>".$adresse."</td></tr>";
	echo "<tr><td>Date de réservation </td><td>:</td><td>".$today."</td></tr>";
	echo "<tr><td>Date de visite </td><td>: </td><td>".$datevisite."</td></tr>";
	echo "<tr><td>Prix à payer le jour de la visite </td><td>: </td><td>".$prix."</td></tr>";
}
?>
</table>
<br><br>
</fieldset>
<br><br>
<?php
// Si la variable $a n'a pas été créée, tout est ok du côté des informations qu'il fallait vérifier, on peut alors procéder à la transmission des informations à la base de données
if (!(isset($a))){
	// On créé le pseudo du client, constitué de la première lettre de son prénom, de l'entiereté de son nom ainsi que de la date de sa visite. Le pseudo est mis en minuscule pour plus de lisibilité
	$pseudo = strtolower($prenom[0].$nom.$datevisite);
	// On établit la connexion à la base de données via les informations obtenues dans le fichier data.php (à modifier dans ce fichier si nécessaire)
	$idcon = new mysqli ($host, $user, $mdp, $bdd); 
	// On créé une requête $req1 qui va séléctionner tous les éventuels pseudos commençant comme le pseudo que l'on vient de créer pour le client donné
	$req1 = "SELECT * FROM `reservation` WHERE (`idR` LIKE '$pseudo%')";
	// On exécute la requête $req1 dont le résultat est affecté à la variable $result1
	$result1 = $idcon -> query($req1);
	// On compte le nombre de lignes trouvées pour la requête $req1 dont le résultat est affecté à la variable $nblignes
	$nblignes = $result1 ->num_rows;
	// Si la variable $nblignes est différente de zéro, on concatène la variable $pseudo créée précédamment à un "-" et au nombre de pseudos similaires existants
	if ($nblignes != 0){
		$pseudo = $pseudo."-".$nblignes;
	}
	// Dans tous les cas, on met fin à la connexion à la base de données
	$idcon->close();
	echo "<fieldset>";
	echo "<legend><b>Prise en compte de votre réservation</b></legend>";
	echo "<br>";
	// On établit la connexion à la base de données via les informations obtenues dans le fichier data.php (à modifier dans ce fichier si nécessaire)
	$idcon = new mysqli ($host, $user, $mdp, $bdd); 
	// On exécute la requête 'SET NAMES UTF8' pour considére les caractères spéciaux dans la base de données
	$idcon-> query ('SET NAMES UTF8'); 
	// On créé une requête $req2 qui va transmettre, à la table 'reservation', toutes les informations nécessaires à propos du client donné 
	$req2 = "INSERT INTO `reservation` (`idR`, `nom`, `prenom`, `date_naissance`, `age_jour_visite`, `mail`, `tel`, `adresse`, `pays`, `billet`, `date_reservation`, `date_visite`, `prix`) VALUES ('$pseudo', '$nom','$prenom','$ddn','$age','$mail','$tel','$adresse','$pays','$billet','$today','$datevisite','$prix')";
	// On exécute la requête $req2 dont le résultat est affecté à la variable $result2 (elle peut notamment servir, cette variable, pour tester si la requête a bien été effectuée
	$result2 = $idcon->query($req2);
	// On met fin à la connexion à la base de données
	$idcon->close();
	// On informe le client que sa réservation a bien été enregistrée
	echo "Votre réservation a bien été enregistrée, à très bientôt !";
	echo "<br> <br>";
	echo "</fieldset>";
	echo "<br><br>";
}
?>
</center>
<fieldset>
<legend align="center"><b>Informations pratiques concernant votre visite</b></legend>
<p>Conformément aux annonces du gouvernement, la présentation du passe vaccinal n’est plus nécessaire à compter du 14 mars 2022 pour visiter le musée du Louvre (et donc l'exposition <i>Musées de Paris</i>). Comme dans tout espace ouvert au public, il est demandé à nos visiteurs de respecter les gestes barrières ainsi que l’utilisation du gel hydro-alcoolique mis à leur disposition à cet effet à l’entrée du musée. Le port du masque demeure recommandé.</p>
<p><b>La réservation effectuée en ligne est nominative, un document d’identité peut être demandé.</b> Elle est valable exclusivement pour la visite de l'exposition <i>Musées de Paris</i> à la date mentionnée. Elle constitue un coupe file afin de bénéficier de la priorité d'accès à l'entrée du musée. Néanmoins, il est préférable de venir en début de journée afin d'avoir de bonnes conditions de visite.</p>
<p><b>JUSTIFICATIS :</b></p>
<p><b>Tarifs exonérés hors Cartes Louvre :</b><br>
-  les moins de 18 ans sur présentation d'une pièce d'identité officielle.<br>
-  les jeunes de 18 à 25 ans résidant dans l'un des pays de l'Union Européenne sur présentation d'un justificatif de résidence dans l'un des pays membres et pièce d'identité officielle.<br>
<br><b>Porteurs de cartes professionnelles :</b><br>
- les enseignants sur présentation du Pass Éducation en cours de validité et portant le cachet de l'établissement.<br>
- les enseignants en histoire des arts, histoire de l'art, arts plastiques, arts appliqués, en activité, sur présentation d'un justificatif  mentionnant la matière enseignée.<br>
- les artistes plasticiens affiliés à la Maison des Artistes et à l'AIAP (Association internationale des arts plastiques) sur présentation de la carte d'adhérent à la Maison des Artistes comportant la vignette de l'année en cours ou de l'attestation d'affiliation à la sécurité sociale des artistes plasticiens et l'AIAP, ou document URSAFF portant la mention «artiste-auteur».<br>
- les membres de l'ICOM et de l'ICOMOS sur présentation de la carte portant la pastille de l'année en cours.<br>
<br><b>Autres visiteurs exonérés :</b><br>
- les demandeurs d'emploi sur présentation d'un justificatif de moins d'un an ou indiquant une période de validité accompagné d'une pièce d'identité avec photographie.<br>
- les bénéficiaires des minima sociaux sur présentation d'une attestation annuelle de perception de l'allocation supplémentaire du Fonds national de solidarité.<br>
- les visiteurs handicapés et leur accompagnateur.<br>
- les personnels hospitaliers partenaires (hôpitaux publics et privés d’Ile de France, EHPAD et ARS d’Ile de France).<br>
</p>
</fieldset>