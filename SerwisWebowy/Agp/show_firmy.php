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
                            <h2><br>Wyświetl</h2>
                            <h3>Firmy</h3>
						</div>

                            <?php
                                $date = date('Y-m-d');
                                if( isset($_SESSION['formstate']) ){
                                    unset($_SESSION['formstate']);
                                }
                                if ( isset($_POST['submit']) ){
                                    try {
                                    $sql = oci_parse($conn,"BEGIN GET_FIRMAF (:p_id, :PLOUG_CURSOR); END;");
                                        oci_bind_by_name($sql, ':p_id', $_POST['id']);
                                        oci_bind_by_name($sql, ':PLOUG_CURSOR',$cursor, -1, OCI_B_CURSOR);
                                        oci_execute($sql);
                                        oci_execute($cursor);
                                        $_SESSION['formstate'] = 'OK';
                                        $i = 0;

                                        echo '<table class="table"><thead>
                                                <tr>
                                                  <th>Nazwa</th>
                                                  <th>Miejscowość</th>
                                                  <th>Ulica</th>
                                                  <th>nr. Budynku</th>
                                                  <th>nr. Telefonu</th>
                                                </tr>
                                              </thead>
                                              <tbody>
                                              ';

                                        while ($result = oci_fetch_array($cursor, OCI_BOTH)) {
                                            echo '
                                                <tr>
                                                    <td>'.$result["NAZWA"].'</td>
                                                    <td>'.$result["MIEJSCOWOSC"].'</td>
                                                    <td>'.$result["ULICA"].'</td>
                                                    <td>'.$result["NR_BUDYNKU"].'</td>
                                                    <td>'.$result["NR_TEL"].'</td>
                                                </tr>
                                            ';
                                        }

                                        echo '</tbody></table>';

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

					</div>
					<div class="row">
                        <form action="show_firmy.php" method="post">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="list-group">
                                        <label></label><input class="list-group-item" type="text" name="id" placeholder="id Firmy">
                                    </div>
                                </div>
                                <!--<div class="col-md-4">
                                    <div class="list-group">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="list-group">
                                    </div>
                                </div>-->

                                    <div class="col align-self-center">
                                    </div>

                                <div class="col align-self-end">
                                    <button type="reset" class="primary-btn mx-auto mt-80">Reset</button>
                                    <button type="submit" name="submit" class="primary-btn mx-auto mt-80">Wyświetl</button>
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