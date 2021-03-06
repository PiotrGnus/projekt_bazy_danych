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
                            <h2><br>Aktualizuj</h2>
                            <h3>Biuro Agencji</h3>
						</div>
                        <h2 style="text-align: center; color: red;">
                            <?php
                                $date = date('Y-m-d');
                                if( isset($_SESSION['formstate']) ){
                                    unset($_SESSION['formstate']);
                                }
                                if ( isset($_POST['submit']) ){
                                    try {
                                        $miejscowosc = ucwords($_POST['miejscowosc']);
                                        $ulica = ucwords($_POST['ulica']);
                                        $mail = strtolower($_POST['mail']);

                                    $sql = oci_parse($conn,"BEGIN UPDATE_BIUROAGENCJI (:BIURO_E_MAIL, :BIURO_NR_TEL, :BIURO_FAX, :BIURO_MIEJSCOWOSC, :BIURO_ULICA, :BIURO_NR_BUDYNKU); END;");
                                        oci_bind_by_name($sql, ':BIURO_E_MAIL', $mail);
                                        oci_bind_by_name($sql, ':BIURO_NR_TEL', $_POST['tel']);
                                        oci_bind_by_name($sql, ':BIURO_FAX', $_POST['fax']);
                                        oci_bind_by_name($sql, ':BIURO_MIEJSCOWOSC', $miejscowosc);
                                        oci_bind_by_name($sql, ':BIURO_ULICA', $ulica);
                                        oci_bind_by_name($sql, ':BIURO_NR_BUDYNKU', $_POST['budynek']);
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
                        <form action="update_biuro.php" method="post">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="list-group">
                                        <h3 style="text-align: center;">Aktualizuj</h3>
                                        <label>Adres e-mail</label><input class="list-group-item" type="email" name="mail" placeholder="e@mail.com">
                                        <label>*Numer telefonu</label><input class="list-group-item" type="number" min="1" minlength="9" name="tel" placeholder="048123456789" required>
                                        <label>Fax</label><input class="list-group-item" type="number" name="fax" min="1" minlength="9" placeholder="220123456">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="list-group">
                                        <h3 style="text-align: center;">Gdzie</h3>
                                        <label>*Miejscowość</label><input class="list-group-item" type="text" name="miejscowosc" placeholder="Miejscowość" required>
                                        <label>*Ulica</label><input class="list-group-item" type="text" name="ulica" placeholder="Ulica" required>
                                        <label>*Numer budynku</label><input class="list-group-item" type="number" min="1" name="budynek" placeholder="nr. budynku" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="list-group">
                                        <button type="reset" class="primary-btn mx-auto mt-80">Reset</button>
                                        <button type="submit" name="submit" class="primary-btn mx-auto mt-80">Aktualizuj</button>
                                    </div>
                                </div>

                                    <div class="col align-self-center">
                                    </div>

                                <div class="col align-self-end">
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
<?php
if( isset($_SESSION['formstate']) ){
    unset($_SESSION['formstate']);
}
?>