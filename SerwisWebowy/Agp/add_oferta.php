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
                            <h3>Ofertę</h3>
						</div>
                        <h2 style="text-align: center; color: red;">
                            <?php
                                $date = date('Y-m-d');
                                if( isset($_SESSION['formstate']) ){
                                    unset($_SESSION['formstate']);
                                }
                                if ( isset($_POST['submit']) ){
                                    try {
                                        $wymiar = ucwords($_POST['wymiar']);
                                    $sql = oci_parse($conn,"BEGIN CREATE_OFERTA0 (:WYMIAR_PRACY, :STAWKA_DZIEN, :STAWKA_NOC, :STAWKA_ND_SW, :ILOSC_OFERT, :OPIS, to_date(:DODANO,'RR/MM/DD'), :ID_STANOWISKA, :ID_FIRMY); END;");
                                        oci_bind_by_name($sql, ':WYMIAR_PRACY', $wymiar);
                                        oci_bind_by_name($sql, ':STAWKA_DZIEN', $_POST['dzien']);
                                        oci_bind_by_name($sql, ':STAWKA_NOC', $_POST['noc']);
                                        oci_bind_by_name($sql, ':STAWKA_ND_SW', $_POST['nd_sw']);
                                        oci_bind_by_name($sql, ':ILOSC_OFERT', $_POST['ilosc']);
                                        oci_bind_by_name($sql, ':OPIS', $_POST['opis']);
                                        oci_bind_by_name($sql, ':DODANO', $date);
                                        oci_bind_by_name($sql, ':ID_STANOWISKA', $_POST['id_stanowiska']);
                                        oci_bind_by_name($sql, ':ID_FIRMY', $_POST['id_firmy']);
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
                        <form action="add_oferta.php" method="post">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="list-group">
                                        <label>*Wymiar pracy</label><input class="list-group-item" type="text" name="wymiar" placeholder="pełny   1/2   2/3" required>
                                        <label>*Stawka dzień</label><input class="list-group-item" type="number" min="1" step="0.01" name="dzien" placeholder="13.00" required>
                                        <label>Stawka noc</label><input class="list-group-item" type="number" min="1" step="0.01" name="noc" placeholder="15.00">
                                        <label>Stawka niedziele/święta</label><input class="list-group-item" min="1" step="0.01" type="number" name="nd_sw" placeholder="16.00">
                                        <label>*Ilość ofert</label><input class="list-group-item" type="number" min="1" name="ilosc" placeholder="5" required>
                                        <label>Opis oferty</label><textarea class="list-group-item" type="text" name="opis" rows="3" cols="50" placeholder="Oferta pracy"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="list-group">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="list-group">
                                        <label>Stanowisko</label><input class="list-group-item" type="number" name="id_stanowiska" placeholder="id Stanowiska">
                                        <label>Firma</label><input class="list-group-item" type="number" name="id_firmy" placeholder="id Firmy">
                                    </div>
                                </div>

                                    <div class="col align-self-center">
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