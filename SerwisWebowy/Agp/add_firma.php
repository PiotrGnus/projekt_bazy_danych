<?php
session_start();
$dbconnect = require_once 'dbconnect.php';

if( isset($_SESSION['dbconnect']) ){
    if( $_SESSION['dbconnect'] == 'OK' ){
        //echo '';
    }else{
        $no_db_conn = 'brak połączenia z bazą';
    }
}

if( isset($_SESSION['formstate']) ){
    if( $_SESSION['formstate'] == 'OK' ){
        $query = 'Polecenie wykonane pomyślnie';
    }else{
        $query = 'Coś poszło nie tak';
    }
}
?>
	<!DOCTYPE html>
	<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="author" content="">
		<meta name="description" content="">
		<meta name="keywords" content="">
		<meta charset="UTF-8">
		<title>HRstudio - Agencja Pracy</title>

            <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet">
            <link rel="stylesheet" href="css/linearicons.css">
            <link rel="stylesheet" href="css/font-awesome.min.css">
            <link rel="stylesheet" href="css/bootstrap.css">
            <link rel="stylesheet" href="css/magnific-popup.css">
            <link rel="stylesheet" href="css/nice-select.css">
            <link rel="stylesheet" href="css/animate.min.css">
            <link rel="stylesheet" href="css/jquery-ui.css">
            <link rel="stylesheet" href="css/owl.carousel.css">
            <link rel="stylesheet" href="css/main.css">
		</head>

		<body>	
			  <header id="header" id="home">
                  <?php require_once 'navbar.html'?>
			  </header>

			<section class="item-category-area section-gap">
				<div class="container">
					<div class="row d-flex justify-content-center">
						<div class="col-md-12 pb-80 header-text text-center">
                            <h2><br>Dodaj</h2>
                            <h3>Firmę</h3>
						</div>
                        <h2 style="text-align: center; color: red;">
                            <?php
                                $date = date('Y-m-d');
                                if( isset($_SESSION['formstate']) ){
                                    unset($_SESSION['formstate']);
                                }
                                if ( isset($_POST['submit']) ){
                                    try {
                                        $nazwa = ucwords($_POST['nazwa']);
                                        $miejscowosc = ucwords($_POST['miejscowosc']);
                                        $ulica = ucwords($_POST['ulica']);
                                        $poczta = ucwords($_POST['poczta']);
                                        $wojewodztwo = ucwords($_POST['wojewodztwo']);
                                        $mail = strtolower($_POST['mail']);
                                    $sql = oci_parse($conn,"BEGIN CREATE_FIRMA0 (:NAZWA, :MIEJSCOWOSC, :ULICA, :NR_BUDYNKU, :NR_LOKALU, :KOD_POCZTOWY, :POCZTA, :WOJEWODZTWO, :E_MAIL, :NR_TEL, :FAX, :NIP, to_date(:DODANO,'RR/MM/DD'), :ID_BIURA, :ID_STATUS); END;");
                                        oci_bind_by_name($sql, ':NAZWA', $nazwa);
                                        oci_bind_by_name($sql, ':MIEJSCOWOSC', $miejscowosc);
                                        oci_bind_by_name($sql, ':ULICA', $ulica);
                                        oci_bind_by_name($sql, ':NR_BUDYNKU', $_POST['nr_budynku']);
                                        oci_bind_by_name($sql, ':NR_LOKALU', $_POST['nr_lokalu']);
                                        oci_bind_by_name($sql, ':KOD_POCZTOWY', $_POST['kod_pocztowy']);
                                        oci_bind_by_name($sql, ':POCZTA', $poczta);
                                        oci_bind_by_name($sql, ':WOJEWODZTWO', $wojewodztwo);
                                        oci_bind_by_name($sql, ':E_MAIL', $mail);
                                        oci_bind_by_name($sql, ':NR_TEL', $_POST['nr_tel']);
                                        oci_bind_by_name($sql, ':FAX', $_POST['fax']);
                                        oci_bind_by_name($sql, ':NIP', $_POST['nip']);
                                        oci_bind_by_name($sql, ':DODANO', $date);
                                        oci_bind_by_name($sql, ':ID_BIURA', $_POST['id_biura']);
                                        oci_bind_by_name($sql, ':ID_STATUS', $_POST['id_statusu']);
                                        oci_execute($sql);
                                        $_SESSION['formstate'] = 'OK';
                                    }catch(Exception $exp){
                                        $_SESSION['formstate'] = 'Something went wrong';
                                    }
                                    if( isset($_SESSION['formstate']) ){
                                        if( $_SESSION['formstate'] == 'OK' ){
                                            $query = 'Polecenie wykonane pomyślnie';
                                        }else{
                                            $query = 'Coś poszło nie tak';
                                        }
                                    }
                                }
                                if( isset($_SESSION['formstate'])){if($_SESSION['formstate'] == 'OK'){echo $query;}}
                                if( isset($_SESSION['dbconnect']) != 'OK' ) {echo 'Brak połączenia z bazą<br>';}

                            ?>
                        </h2>
					</div>
					<div class="row">
                        <form action="add_firma.php" method="post">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="list-group">
                                        <label>*Firma</label><input class="list-group-item" type="text" name="nazwa" placeholder="Nazwa" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="list-group">
                                        <label>*Miejscowość</label><input class="list-group-item" type="text" name="miejscowosc" placeholder="Warszawa" required>
                                        <label>Ulica</label><input class="list-group-item" type="text" name="ulica" placeholder="Narodowa">
                                        <label>*Numer budynku</label><input class="list-group-item" type="number" min="1" name="nr_budynku" placeholder="50" required>
                                        <label>Numer lokalu</label><input class="list-group-item" type="number" min="1" name="nr_lokalu" placeholder="123">
                                        <label>*Kod pocztowy</label><input class="list-group-item" type="number" min="10000" name="kod_pocztowy" placeholder="35400" required>
                                        <label>Poczta</label><input class="list-group-item" type="text" name="poczta" placeholder="Miejscowość">
                                        <label>Województwo</label><input class="list-group-item" type="text" name="wojewodztwo" placeholder="Mazowieckie">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="list-group">
                                        <label>Adres e-mail</label><input class="list-group-item" type="email" name="mail" placeholder="e@mail.com">
                                        <label>*Numer telefonu</label><input class="list-group-item" type="number" min="1" minlength="9" name="nr_tel" placeholder="048505505505" required>
                                        <label>Fax</label><input class="list-group-item" type="number" min="1" minlength="9" name="fax" placeholder="22012345678">
                                        <label>NIP</label><input class="list-group-item" type="number" min="1" minlength="9" name="nip" placeholder="987654321">
                                    </div>
                                </div>

                                    <div class="col align-self-center">
                                        <label>Numer biura agencji</label><input class="list-group-item" type="number" min="1" name="id_biura" placeholder="id Biura">
                                        <label>Numer statusu</label><input class="list-group-item" type="number" min="1" name="id_statusu" placeholder="id Statusu">
                                    </div>

                                <div class="col align-self-end">
                                    <button type="reset" class="primary-btn mx-auto mt-80">Reset</button>
                                    <button type="submit" name="submit" class="primary-btn mx-auto mt-80">Dodaj</button>
                                </div>
                            </div>
                        </form>
					</div>
				</div>
			</section>

			<footer class="footer-area section-gap">
				<div class="container">
					<div class="row">
						<div class="col-lg-12">
							<p class="footer-text">
                                Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | Borek Kamil
                            </p>
						</div>						
					</div>
				</div>
			</footer>

              <script src="js/vendor/jquery-3.4.1.min.js"></script>
              <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
              <script src="js/vendor/bootstrap.min.js"></script>
              <script src="js/easing.min.js"></script>
              <script src="js/hoverIntent.js"></script>
              <script src="js/superfish.min.js"></script>
              <script src="js/jquery.ajaxchimp.min.js"></script>
              <script src="js/jquery.magnific-popup.min.js"></script>
              <script src="js/jquery-ui.js"></script>
              <script src="js/owl.carousel.min.js"></script>
              <script src="js/jquery.nice-select.min.js"></script>
              <script src="js/mail-script.js"></script>
              <script src="js/main.js"></script>
		</body>
	</html>
<!--<script type="text/javascript">setTimeout("location.href='index.php'",1000)</script>-->