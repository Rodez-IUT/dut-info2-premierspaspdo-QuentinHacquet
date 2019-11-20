<!DOCTYPE html>
<html>
	<head>
		<title>All users</title>
		<meta charset="utf-8 /">
		<link rel="stylesheet" href="bootstrap/css/bootstrap.css">
	<body>
		<?php
			$host = 'localhost';
			$db   = 'my_activities';
			$user = 'root';
			$pass = 'root';
			$charset = 'utf8mb4';
			$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
			$options = [
				PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
				PDO::ATTR_EMULATE_PREPARES   => false,
			];
			try {
				 $pdo = new PDO($dsn, $user, $pass, $options);
			} catch (PDOException $e) {
				 throw new PDOException($e->getMessage(), (int)$e->getCode());
			}
		?>
		
		<h1>All users</h1>
		<form method="post" action="all_users.php">
			Start with letter :
			<input type="text" name="start_letter" />
			and status is :
			<select name="account_status">
				<option value="active">Active account</option>
				<option value="waiting">Waiting for account validation</option>
			</select>
			<input type="submit" value="OK" />
		</form>
		<br /><br />
		<table class="table">
		<tr>
			<th>ID</th>
			<th>Username</th>
			<th>Email</th>
			<th>Status</th>
		</tr>
		<?php	
			if (isset($_GET['start_letter']) && isset($_GET['account_status'])) {
				if (strlen($_GET['start_letter']) == 1) {
					$start_letter = $_GET['start_letter'];
				} else {
					$start_letter = "";
				}
				if (strcmp($_GET['account_status'], "active") == 0) {
					$account_status = 2;
				} else {
					$account_status = 1;
				}
				$stmt = $pdo->query("SELECT users.id, username, email, name FROM users JOIN status ON status.id = users.status_id WHERE status_id = $account_status AND username LIKE '$start_letter%' ORDER BY username");
			} else {
				$stmt = $pdo->query("SELECT users.id, username, email, name FROM users JOIN status ON status.id = users.status_id ORDER BY username");
			}
			while ($row = $stmt->fetch()) {
				echo '<tr>';
				echo '<td>' . $row['id'] . '</td>';
				echo '<td>' . $row['username'] . '</td>';
				echo '<td>' . $row['email'] . '</td>';
				echo '<td>' . $row['name'] . '</td>';
				echo '</tr>';
			}
		?>
		</table>
	</body>
</html>