<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Les excuses du lundi matin</title>
	  
		<link href="css/monStyle.css" rel="stylesheet">
		
		<!-- Bootstrap CSS -->
		<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
		<link href="fontawesome-free-5.10.2-web/css/all.css" rel="stylesheet">
	</head>
	<body>
		<?php 
			$var="e%";
			$statut="Active account";

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
			$stmt = $pdo->query('SELECT users.id, users.username, users.email, status.name FROM users JOIN status on users.status_id=status.id where status.name="'.$statut.'" AND users.username like "'.$var.'" ');
			echo "<div class=\"container\">";
			echo "<div class=\"row\">
				<div class=\"col-md-6\">
					<label>Type de médicament :</label> 
							<select ID="Type" name="Type" class="form-control">
								echo "<option>"Active account"</option>";
								echo "<option>"Active account"</option>";
								echo "<option>"Active account"</option>";
							</select>
				</div>";	
			echo "<div class=\"row\">";
				echo "<div class=\"col-md-3\"><strong>ID</strong></div>";
				echo "<div class=\"col-md-3\"><strong>Username</strong></div>";
				echo "<div class=\"col-md-3\"><strong>Email</strong></div>";
				echo "<div class=\"col-md-3\"><strong>Status</strong></div>";
			while($row = $stmt->fetch()){
				echo "<div class=\"col-md-3\">".$row['id']."</div>";
				echo "<div class=\"col-md-3\">".$row['username']."</div>";
				echo "<div class=\"col-md-3\">".$row['email']."</div>";
				echo "<div class=\"col-md-3\">".$row['name']."</div>";
			}
			echo "</div>";
		?>
	</body>
</html>