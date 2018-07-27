<?php
require 'config.php';

$possible_url = array("get_list_concession", "get_concession"); //je définis les URLs valables
$value = "Une erreur est survenue"; //je mets le message d'erreur par défaut dans une variable
if (isset($_GET["action"]) && in_array($_GET["action"], $possible_url)) { //si l'URL est OK
    switch ($_GET["action"]) {
        case "get_list_concession": $value = get_list_concession($con); break; //Je récupère la liste des concession
        case "get_concession": if (isset($_GET["id"])) $value = get_concession_by_id($_GET["id"], $con); //si l'ID est spécifié alors je renvoie la concession en question
        else $value = "Argument manquant"; break; } //si l'ID n'est pas valable je change mon message d'erreur
}

function get_list_concession($con) { //je passe en paramètre mon objet PDO précédemment créé afin d'exécuter ma requête
    $sql = mysqli_query($con,"SELECT * FROM concession"); //création de la requête Sql pour aller chercher toutes les concessions
    $Liste_concession = array(); //création d'un tableau qui va contenir tous nos concession
    while($row = mysqli_fetch_assoc($sql)){
   		$Liste_concession[] = $row;
	}
    echo json_encode($Liste_concession);
	exit;
}

function get_concession_by_id($id, $con) { //je passe en paramètre de ma fonction l'id de la concession souhaitée et l'objet PDO pour exécuter la requête
    $sql = mysqli_query($con,"select * from concession where idConcession = ".$id); //création de la requête Sql pour aller chercher toutes les concessions
    $Liste_concession = array(); //création d'un tableau qui va contenir tous nos concession
    while($row = mysqli_fetch_assoc($sql)){
   		$Liste_concession[] = $row;
	}
    echo json_encode($Liste_concession);
	exit;
}

//Pour créer des requetes spécifiques sur certains éléments copier/coller la ligne ci-dessous en choisissant les éléments voulus
//$sql = mysqli_query($con,"SELECT idConcession, raisonSociale, adresse, codePostal, ville, pays, telephone, siteWeb, description, latitude, longitude, type FROM concession");
?>