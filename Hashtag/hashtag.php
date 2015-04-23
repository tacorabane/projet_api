<?php

class hashtag
{
	//attributs
	private $hashtag;
	private $comment;
	private $word;

	//constructeur
	public function __construct(/*$id_hashtag,*/$keyWord/*,$id_comment*/)
	{
		//$this->hashtag = $id_hashtag;
		//$this->comment = $id_comment;
		$this->word = $keyWord;
		$this->createHashtag($keyWord);
	}

	public function createHashtag($mot_cle)
	{

		$this->word = $mot_cle;
		//on crée des hashtag dans la bdd
		try
		{
			//ON établi une connexion avec la base de données
			$pdo = new PDO("mysql:host=localhost;dbname=projetapi", 'root','');
	        $insertHashtag = "INSERT INTO hashtag VALUES(:id_hashtag,:mot)";  
	        $this->hashtag = $pdo->lastInsertId();
	        $req = $pdo->prepare($insertHashtag);
	        $req->execute(array(':id_hashtag' => $this->hashtag++,':mot' => $mot_cle));

	        echo "ça passe, tu viens de rajouter un hashtag dans ta bdd ";
		
		}
		catch (Exception $e){
	        die('Erreur : ' . $e->getMessage());
	        echo "ça passe pas";
		}
	}


}

//$h = new hashtag("#kinda");


?>