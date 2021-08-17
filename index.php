<!DOCTYPE html>
<html>
	<head> 
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="style.css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<title>Książka telefoniczna</title>
	</head>
<body>

		<div class="main">
		<div id="middleBOX">
		 <form action="index.php" method="post">
            <input type="text" name="fname" placeholder="Imie" style="color:black; padding: 5px; width: 205px;" ><br><br>
            <input type="text" name="lname" placeholder="Nazwisko" style="color:black; padding: 5px; width: 205px;"><br><br>
            <input type="text" name="tele" placeholder="Telefon" style="color:black; padding: 5px; width: 205px;"><br><br>
			
			<input type="submit" name="add" value="Dodaj">
            <input type="submit" name="delete" value="Usuń">
            <input type="submit" name="display" value="Wyświetl">
            <input type="submit" name="search" value="Wyszukaj">
        </form>
		</div>
		</div>

		<?php
		
		$servername = "localhost";
		$username = "root";
		$password = "";
		$baza = "adresy";

		$conn = new mysqli($servername, $username, $password, $baza);

		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		
		//dodawanie
		
		if(isset($_POST['add'])){
			
			$imie = $_POST["fname"];
			$nazwisko = $_POST["lname"];
			$telefon = $_POST["tele"];
			
			if( empty($imie) || empty($nazwisko) || empty($telefon) ){
				echo "<i class='fa fa-warning' style='font-size:18px;color:yellow'></i> Podaj wszystkie dane!";
			}
			else{
				$wynik = "INSERT INTO dane (firstname, lastname, tel)
						VALUES ('$imie', '$nazwisko', '$telefon')";

				if ($conn->query($wynik) === TRUE) {
					echo "<i class='fa fa-check' style='font-size:18px;color:lime'></i> Dodano nową osobe :)";
				} else {
					echo "<i class='fa fa-warning' style='font-size:18px;color:yellow'></i> BŁĄD: " . $wynik . "<br>" . $conn->error;
				}
			}
			
		// wyświetlanie	
			
		}else if (isset($_POST['display'])) {
    
		$wynik = $conn->query("SELECT * FROM dane");
			
			
			if($wynik->num_rows > 0){
				
				echo "<table>";
				echo "<tr>";
				echo "<th>imie</th>";
				echo "<th>nazwisko</th>";
				echo "<th>telefon</th>";
				echo "</tr>";
				
				while( $wiersz = $wynik->fetch_assoc() ){
					echo "<tr>";
					
					echo "<td>" . $wiersz["firstname"]    . "</td>";
					echo "<td>" . $wiersz["lastname"] . "</td>";
					echo "<td>" . $wiersz["tel"] . "</td>";
					
					echo "</tr>";
				}
				
				echo "</table>";
				
			}else {
				echo "<i class='fa fa-warning' style='font-size:18px;color:yellow'></i> Nie ma żadnych osób w bazie danych";
			}
			
		// usuwanie
			
		}else if(isset($_POST['delete'])){
			
			$imie = $_POST["fname"];
			$nazwisko = $_POST["lname"];
			$telefon = $_POST["tele"];
			
			if( !empty($imie) && !empty($nazwisko) && !empty($telefon) ){
				$wynik = "DELETE FROM dane WHERE firstname='$imie'";

				if ($conn->query($wynik) === TRUE) {
					echo "<i class='fa fa-check' style='font-size:18px;color:lime'></i> Osoba usunięta z rejestru.";
				} else {
					echo "<i class='fa fa-warning' style='font-size:18px;color:yellow'></i> BŁĄD PRZY USUWANIU: " . $conn->error;
				}
			}
			else{
				echo "<i class='fa fa-question' style='font-size:18px;color:lightskyblue'></i> Kogo mam usunąć?";
			}
		
		// wyszukiwanie
		
		}else if(isset($_POST['search'])){
			
			$imie = $_POST["fname"];
			$nazwisko = $_POST["lname"];
			$telefon = $_POST["tele"];
			
			if( empty($imie) && empty($nazwisko) && empty($telefon)){
				
				echo "<i class='fa fa-warning' style='font-size:18px;color:yellow'></i> Nie podałeś żadnych danych!";
				
			} else if( empty($imie) && !empty($nazwisko) ){
				
				$wynik = $conn->query("SELECT * FROM dane WHERE lastname='$nazwisko'");
			
				if($wynik->num_rows > 0){
				
					echo "<table>";
					echo "<tr>";
					echo "<th>imie</th>";
					echo "<th>nazwisko</th>";
					echo "<th>telefon</th>";
					echo "</tr>";
				
					while( $wiersz = $wynik->fetch_assoc() ){
						echo "<tr>";
						
						echo "<td>" . $wiersz["firstname"]    . "</td>";
						echo "<td>" . $wiersz["lastname"] . "</td>";
						echo "<td>" . $wiersz["tel"] . "</td>";
					
						echo "</tr>";
					}
				
					echo "</table>";
				
				}else {
					echo "<i class='fa fa-warning' style='font-size:18px;color:yellow'></i> Nie ma osób o takim nazwisku";
				}
	
			}else if( !empty($imie) && empty($nazwisko) ){
				
				$wynik = $conn->query("SELECT * FROM dane WHERE firstname='$imie'");
			
				if($wynik->num_rows > 0){
				
					echo "<table>";
					echo "<tr>";
					echo "<th>imie</th>";
					echo "<th>nazwisko</th>";
					echo "<th>telefon</th>";
					echo "</tr>";
				
					while( $wiersz = $wynik->fetch_assoc() ){
						echo "<tr>";
						
						echo "<td>" . $wiersz["firstname"]    . "</td>";
						echo "<td>" . $wiersz["lastname"] . "</td>";
						echo "<td>" . $wiersz["tel"] . "</td>";
					
						echo "</tr>";
					}
				
					echo "</table>";
					}else {
						echo "<i class='fa fa-warning' style='font-size:18px;color:yellow'></i> Nie ma osób o takim imieniu";
					}
				
			}else if( !empty($imie) && !empty($nazwisko)){
				
				$wynik = $conn->query("SELECT * FROM dane WHERE firstname='$imie' AND lastname='$nazwisko'");
			
				if($wynik->num_rows > 0){
				
					echo "<table>";
					echo "<tr>";
					echo "<th>imie</th>";
					echo "<th>nazwisko</th>";
					echo "<th>telefon</th>";
					echo "</tr>";
				
					while( $wiersz = $wynik->fetch_assoc() ){
						echo "<tr>";
						
						echo "<td>" . $wiersz["firstname"]    . "</td>";
						echo "<td>" . $wiersz["lastname"] . "</td>";
						echo "<td>" . $wiersz["tel"] . "</td>";
					
						echo "</tr>";
					}
				
					echo "</table>";
					}else {
						echo "<i class='fa fa-warning' style='font-size:18px;color:yellow'></i> Nie ma nikogo takiego";
					}
				
			}else if( empty($imie) && empty($nazwisko ) && !empty($telefon)){
				
				$wynik = $conn->query("SELECT * FROM dane WHERE tel='$telefon'");
			
				if($wynik->num_rows > 0){
				
					echo "<table>";
					echo "<tr>";
					echo "<th>imie</th>";
					echo "<th>nazwisko</th>";
					echo "<th>telefon</th>";
					echo "</tr>";
				
					while( $wiersz = $wynik->fetch_assoc() ){
						echo "<tr>";
						
						echo "<td>" . $wiersz["firstname"]    . "</td>";
						echo "<td>" . $wiersz["lastname"] . "</td>";
						echo "<td>" . $wiersz["tel"] . "</td>";
					
						echo "</tr>";
					}
				
					echo "</table>";
					}else {
						echo "<i class='fa fa-warning' style='font-size:18px;color:yellow'></i> Nie ma osoby z takim numerem telefonu";
					}
				
			}else {
				echo "<i class='fa fa-warning' style='font-size:18px;color:yellow'></i> Nie ma nikogo takiego :(";
			}
		}


		$conn->close();
		
		?>

</body>
</html>
