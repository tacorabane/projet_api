<?php
	require_once("cls-User_1n_130.php");
	session_start();
	
	$user = new Users();
	
	$mail = $_GET["mail"];
	$passwd = $_GET["passwd"];
	$pseudo = $_GET["pseudo"];
	$year = $_GET["year"];
	$month = $_GET["month"];
	$day = $_GET["day"];
	
	
	
	if(($f = fopen("../Logs/cu_1n_130.txt", "a+")) == NULL) {
		echo "Cannot open the file";
	}
	
	$output = array();
	
	if(isset($mail) and isset($passwd) and isset($pseudo) and isset($year) and isset($month) and isset($day)) {
		$output["code"] = 0;
		$output["result"] = "OK";
		createUser($mail, $passwd, $pseudo, $year, $month, $day, $output);	
	}
	else {
		$output["code"] = 1;
		$output["result"] = "Missing required parameter(s)";
		fputs($f, json_encode($output));
	}
	
	function createUser($mail, $passwd, $pseudo, $year, $month, $day, $output) {
	
		if($mail != NULL and $passwd != NULL and $pseudo != NULL and $year != NULL and $month != NULL and $day != NULL) {
			
			$date_birth = $year+"-"+$month+"-"+$day;
			$params = array(":mail"=>$mail, ":passwd"=>$passwd, ":pseudo"=>$pseudo, ":dob"=>$date_birth);
			
			if(!($pdo = new PDO("mysql:host=localhost;dbname=projetapi", "root", ""))) {
				$output["code"] = 5;
				$output["result"] = "Internal server error";
				return json_encode($output);
			}
			
			$query = "INSERT INTO user (mail, password, pseudo, date_birth) VALUES (:mail, :passwd, :pseudo, :dob)";
			
			if(verifMail($mail, $pdo, $state)) {
			
				if(verifPassword($passwd)) {
				
					if(verifPseudo($pseudo)) {
					
						if(verifDOB($date_birth) {
							
							$state = $pdo->prepare($query);
			
							if($state and $state->execute($params)) {
								echo "You're registered";
								$user->setMail($mail);
								$user->setPassword($passwd);
								$user->setPseudo($pseudo);
								$user->setDateOfBirth($date_birth);
								
								
							} else {
								$state = $pdo->prepare("SELECT * FROM users WHERE mail = :mail");
								
								if($state = $pdo->prepare($query)) {
									while($row = $state->fetch(PDO::FETCH_ASSOC)) {
										$_SESSION["id"] = $row["id_user"];
										$_SESSION["mail"] = $user->getMail();
										$_SESSION["passwd"] = $user->getPassword();
										$_SESSION["pseudo"] = $user->getPseudo();
										$_SESSION["data_birth"] = $user->getDateOfBirth();
										
										
									}
								}
								else echo "<br/>Insert failed!";
							}
							
							return json_encode($output);
							
							unset($state);
							unset($pdo);
						}
						else {
							$output["code"] = 9;
							$output["result"] = "Date format not fetching with the DB";
						}
					}
					else {
						$output["code"] = 3;
						$output["result"] = "Login failed check your credentials";
					}
				}else {
					$output["code"] = 8;
					$output["result"] = "Password failed check you credentials";
				}
			} else {
				$output["code"] = 2;
				$output["result"] = "Email already registered";
			}
		}
	}
	
	function verifMail($mail, $pdo, $state) {
		$params = array(":mail"=>$mail);
		$state = $pdo->prepare("SELECT * FROM users WHERE mail = :mail");
		
		if($state and $state->execute($params))
			return false;
		else {
			if(preg_match("#[a-z]+\@[a-z]+\.(com | fr | org)#", $mail)) {
				if(strlen($mail) < 256) {
					return true;
				}
			}
		}
	}
	
	function verifPassword($passwd) {
		if(strlen($passwd) > 3 and strlen($passwd) < 17)
			return true;
		else
			return false;
	}
	
	function verifPseudo($pseudo, $pdo, $passwd) {
		$params = array(":pseudo"=>$pseudo);
		$state = $pdo->prepare("SELECT * FROM users WHERE pseudo = :pseudo");
		
		if($state and $state->execute($params)) {
			return false;
		}
		else {
			if(strlen($pseudo) > 4 and strlen($pseudo) < 256) {
				return true;
			}
			return false
		}
	}
	
	function verifDOB($dob) {
		if("#([0-9]{4})\-([0-9]{2})\-([0-9]{2})#", $dob)
			return true;
		else return false;
	}
?>           