<?php
/**
 * Date: 08/01/2017
 */
require_once("connexionBD.php");

try {
	$resultats = $connexion->query("SELECT * FROM produit WHERE caId='".$_POST['caId']."'");
	$resultats->setFetchMode(PDO::FETCH_OBJ);

	echo' <h1>'.$_POST['caLibelle'].'</h1>';

	if ($resultats->rowCount() == 0) {
        echo '<img id="travauxImg" src="images/travaux.png">';
	} else {
        while ($ligne = $resultats->fetch()) {
            echo'<div class="fiche ficheProduit">' .
                    '<a href="#" onclick="requestProduit(' . $ligne->prId . ')">' .
                        '<img class="imgFiche" src="' . $ligne->prImage . '">' .
                        '<h5>' . $ligne->prLibelle . '</h5>' .
                    '</a>' .
                    '<p>' . $ligne->prPrixUnitaireHT . ' €</p>' .
                    '<i>' . $ligne->prPortion . '<br>prix/kg : ' . $ligne->prPrixHT . ' €</i>';
            if ($ligne->prQuantiteStock == 0) echo '<span><img class="imgSpan" src="images/warning.png"><i>En rupture !</i></span>';
            else if ($ligne->prQuantiteStock <= 5) echo '<span><img class="imgSpan" src="images/caution.png"><i>' . $ligne->prQuantiteStock . ' restants.</i></span>';
            echo    '<div id="ajout">' .
                        '<input type="button" value="-" onclick="moins(' . $ligne->prId . ')">' .
                        '<input id="' . $ligne->prId . '" type="text" name="txtRechch" value="0" maxlength="2">' .
                        '<input type="button" value="+" onclick="plus(' . $ligne->prId . ', ' . $ligne->prQuantiteStock . ')">' .
                        '<input style="margin-left: 20px;" type="submit" value="Ajouter" onclick="ajouterPanier(\'' . $ligne->prId . '\');">' .
                    '</div>' .
                '</div>';
        }
    }
	$resultats->closeCursor();
}
catch (PDOException $e) {
    echo 'Erreur liste produit : ' . $e->getMessage();
}
?>

