<?php

class comment
{

	private $text;
	private $post;

/*
1. Créer un commentaire
Créer un commentaire sur un post.
Il doit être possible :
- d’identifier des amis,
- d’intégrer des « hashtags » dans le contenu du commentaire.
Il faudra ensuite prévoir d’extraire les « hashtags » pour les associer au
commentaire et ainsi permettre une recherche par « hashtag »
*/

public function __construct($statut,$commentaire)
{
	$this->text = $commentaire;
	$this->post = $statut;
	$this->createComment($statut,$commentaire);

}

public function createComment()
{
	try
	{		
			//ON établi une connexion avec la base de données
			$pdo = new PDO("mysql:host=localhost;dbname=projetapi", 'root','');
	        echo "ça passe, tu es connecté à la bdd ";

	        //On fait un insert du commentaire dans la table commentaire

	        //on crée une requete sql
	        $query = "INSERT INTO comment VALUES(:id_comms, :texte,:id_posts)";

		//on réupère le dernière id de commentaire et on l'augmente à chaque commentaire
	        $LastIdValue = $pdo->lastInsertId();

	        echo " <br/><br/> <h3>la dernière valeur est ".$LastIdValue."</h3>";
	       /* $statement = $pdo->execute($query);*/

	         //$statement = $pdo->query("INSERT INTO comment VALUES(1,".$com.",".$publication.")");
	         $req = $pdo->prepare($query);
	         $req->execute(array(
	         	':id_comms' => $LastIdValue++,
	         	':texte' => $this->text,
	         	':id_posts' => $this->post
	         ));

	        echo "ça passe, tu viens de rajouter un commentaire dans ta bdd ";
		
	}
	catch (Exception $e)
	{
	        die('Erreur : ' . $e->getMessage());
	        echo "ça passe pas";
	}


}

	/*
2. Modifier un commentaire
Modifie un commentaire existant à partir des informations fournies.
!7
*/

public function alterComment($id_comm,$modifTexte)
{
	try
	{		
			//ON établi une connexion avec la base de données
			$pdo = new PDO("mysql:host=localhost;dbname=projetapi", 'root','');
	        echo "ça passe, tu es connecté à la bdd ";

	        //On fait un insert du commentaire dans la table commentaire

	        //on met à jour 
	        $updateQuery = "UPDATE comment SET texte = :texte WHERE id_comms =:id_comms";

	         $req = $pdo->prepare($updateQuery);
	         $req->execute(array(':texte' => $modifTexte,':id_comms' => $id_comm));

	        echo "ça passe, tu viens de modifier un commentaire dans ta bdd ";
	}
	catch (Exception $e)
	{
	        die('Erreur : ' . $e->getMessage());
	        echo "ça passe pas";
	}


}

/*
3. Supprimer un commentaire
Supprime un commentaire à partir de son identifiant. Il faudra penser à
supprimer tous les éléments associés à ce commentaire.
*/

public function DeleteComment($id_com)
{
	try
	{		
			//ON établi une connexion avec la base de données
			$pdo = new PDO("mysql:host=localhost;dbname=projetapi", 'root','');
	        echo "ça passe, tu es connecté à la bdd ";

	        //On fait un delete du commentaire dont l'id est passé en paramètre
	        echo "ça passe, tu viens de rajouter un commentaire dans ta bdd ";

	        //on crée une requete sql
	        $deleteQuery = "DELETE FROM comment WHERE id_comms=:id_comms";
		 	$req = $pdo->prepare($deleteQuery);
	        $req->execute(array(':id_comms' => $id_com));
	        echo " <br/><br/> <h3>tu viens de supprimer un commentaire </h3>";
	}
	catch (Exception $e)
	{
	        die('Erreur : ' . $e->getMessage());
	        echo "ça passe pas";
	}
}

}


$co = new comment(1,"ca y essssssstt \o/ ");
//$co->DeleteComment(14);
$co->alterComment(30,"Putain je suis trop bon");

?>
