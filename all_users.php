<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Les excuses du lundi matin</title>
	  
		<link href="css/monStyle.css" rel="stylesheet">
	</head>
	<body>
		<?php 
			$host='localhost';
			$db='my_activities';
			$user='root';
			$pass='root';
			$charset='utf8mb4';
			$dsn="mysql:host=$host;dbname=$db;charset=$charset";
			$options=[
				PDO::ATTR_ERRMODE				=>PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE	=>PDO::FETCH_ASSOC,
				PDO::ATTR_EMULATE_PREPARES		=>false,];
			try{
				$pdo=new PDO($dsn,$user,$pass,$options);
			}catch(PDOException$e){
				throw new PDOException($e->getMessage(),(int)$e->getCode());
			}

			if (isset($_GET['action'])) {
				
				$stmt = $pdo->prepare("INSERT INTO action_log (action_name,user_id) VALUES (':action',':userid')");
				$stmt->bindValue(':action', $_GET['action'], PDO::PARAM_STR);
				$stmt->bindValue(':userid', (int)$_GET['user_id'], PDO::PARAM_INT);
				$stmt->execute();
			}

			echo "<form method=\"post\">";
			echo "<h1>All Users</h1>";
			echo "<label>start with : </label>  <input type=\"text\" id=\"lettre\" name=\"lettreP\"> 	  </input>";
			echo "<label> status :	</label>";
			echo "<select id=\"status\" name=\"statusP\">  ";
			echo "<option value=\"1\"> Waiting for account validation</option>";
			echo "<option value=\"2\"> Active Account</option>";
			echo "<option value=\"3\"> Waiting for account deletion</option>";
			echo "</select>";
			echo "<input type=\"submit\" id=\"bouton\" name=\"Chercher\"></input>";
			echo "</form>";
			
			if (isset($_POST['statusP'])) {
				if(isset($_POST['lettreP']) && $_POST['lettreP'] != "") {
					$Premlettre = $_POST['lettreP'];
				} else {
					$Premlettre = "";
				}
				$statusPris = $_POST['statusP'];
				$stmt = $pdo->prepare("SELECT users.id,username,email,status.name,status_id 
								 FROM users 
								 JOIN status 
								 ON users.status_id = status.id 
								 WHERE status.id = :statusPris  
								 AND username 
								 LIKE :Premlettre
								 ORDER BY username");
				$stmt->bindValue(':statusPris', $statusPris, PDO::PARAM_INT);
				$stmt->bindValue(':Premlettre', $Premlettre.'%', PDO::PARAM_STR);
				$stmt->execute();
				
			} else {
				$stmt = $pdo->query("SELECT users.id,username,email,status.name ,status_id 
								 FROM users 
								 JOIN status 
								 ON users.status_id = status.id 
								 ORDER BY username");
			}
			
			
			echo "<table border=\"1px\">";
			echo "<tr>";
				echo "<td>Id</td>";
				echo "<td>Username</td>";
				echo "<td>Email</td>";
				echo "<td>Status</td>";
				echo "<td></td>";
				echo "</tr>";
			while($row = $stmt->fetch()){
				echo "<tr>";
				echo "<td>".$row['id']."</td>";
				echo "<td>".$row['username']."</td>";
				echo "<td>".$row['email']."</td>";
				echo "<td>".$row['name']."</td>";
				if ($row['status_id'] != 3) {
					echo "<td>";
					echo "<form method=\"get\" action=\"askDeletion\">";
					echo "<a href=\"all_users.php?action=askDeletion&status_id=3&user_id=".$row['id']."\">Ask Deletion</a>";
					echo "</form>";
					echo "</td>";
				}
				echo "</tr>";
			}
			echo "</table>";
		?>
	</body>
</html>