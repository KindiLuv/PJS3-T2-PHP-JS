<?php
session_start();
?>
<!DOCTYPE html>
<html lang ="en">

<head>
    <!-- Imports de bootstrap et de ses dependances JavaScript -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <!-- Imports de Chart.js -->
    <script src="node_modules\chart.js\dist\Chart.js"></script>
</head>

<body>
    
    <?php
    //appel de la comminucation vers la BD MySQL
    require('config.php');

    // Recuperer le max de l'ensemble des valeurs
    $query = "SELECT Max(`obesite_totale`.indiceTotal) AS ITmax
    FROM `obesite_totale`";
    $result = mysqli_query($conn,$query) or die(mysqli_error($conn));
    $rows = mysqli_num_rows($result);
    while($row = mysqli_fetch_array($result))
    {
        $valmax = $row[0];
    }

    // Recuperer la valeur moyenne de notre jeu de donnees
    $query = " SELECT Round(Avg(`obesite_totale`.indiceTotal),1) AS ITmoy FROM `obesite_totale`";
    $result = mysqli_query($conn,$query) or die(mysqli_error($conn));
    $rows = mysqli_num_rows($result);
    while($row = mysqli_fetch_array($result))
    {
        $valmoy = $row[0];
    } ?>

    <!-- Tableau responsive contenant les donnees de la question a)-->
    <div class="container">
        <div class="row">
            <div class="col-sm">
                <!-- Ici, on utilise une methode d'affichage simple, par appel de variable-->
                <center><h5>Valeur maximale de la prevalence d'obesite:</h5> <p><?= $valmax ?></p></center>
            </div>
            <div class="col-sm">
                <center><h5>Valeur moyenne de la prevalence d'obesite:</h5> <p><?= $valmoy ?></p></center>
            </div>
   
    <?php
    // Recuperer la valeur moyenne pour chaque sexe
    $query = "SELECT `obesite`.Sexe, Round(Avg(`obesite`.IndiceObesite),1) AS iSmoy
    FROM `obesite`
    GROUP BY `obesite`.Sexe";
    $result = mysqli_query($conn,$query) or die(mysqli_error($conn));
    $rows = mysqli_num_rows($result);
    // Ici on fait apparaitre 2 variables de 2 tableaux differents, variant en fonction du sexe.
    while($row = mysqli_fetch_array($result))
    {
        echo '<div class="col-sm">';
        echo "<center><h5>Valeur moyenne de la prevalence d'obesite chez les ";
        print_r($row[0]);
        echo ":</h5> <p>";
        print_r($row[1]);
        echo "</p></center></div>";
    } ?>
        </div>
    </div>

    <?php
    // Recuperer la liste des pays
    $query = "SELECT `pays`.codePAys FROM `pays`";
    $result = mysqli_query($conn,$query) or die(mysqli_error($conn));
    $rows = mysqli_num_rows($result);
    while($row = mysqli_fetch_array($result))
    {
        $pays[] = $row[0];
    }

    // Recuperer la liste des indices d'obesite par Pays en 2010
    $query = "SELECT `obesite_totale`.indiceTotal
    FROM `obesite_totale` WHERE `obesite_totale`.annee = 2010";
    $result = mysqli_query($conn,$query) or die(mysqli_error($conn));
    $rows = mysqli_num_rows($result);
    while($row = mysqli_fetch_array($result))
    {
        $ob2k10[] = $row[0];
    } 

    // Recuperer la liste des indices d'obesite par Pays en 2014
    $query = "SELECT `obesite_totale`.indiceTotal
    FROM `obesite_totale` WHERE `obesite_totale`.annee = 2014";
    $result = mysqli_query($conn,$query) or die(mysqli_error($conn));
    $rows = mysqli_num_rows($result);
    while($row = mysqli_fetch_array($result))
    {
        $ob2k14[] = $row[0];
    } 

    // Recuperer la liste des indices d'obesite par Pays en 2016
    $query = "SELECT `obesite_totale`.indiceTotal
    FROM `obesite_totale` WHERE `obesite_totale`.annee = 2016";
    $result = mysqli_query($conn,$query) or die(mysqli_error($conn));
    $rows = mysqli_num_rows($result);
    while($row = mysqli_fetch_array($result))
    {
        $ob2k16[] = $row[0];
    } 
?>
    </div>

    <!-- Initialisation de la zone ou est situee la Chart-->
    <canvas id = "spiderchart" width="400" height="400"></canvas>
    <script>
        // L'ensemble de nos valeurs, toutes des tableaux de taille 30
        var tpays = <?php echo json_encode($pays); ?>;
        var tab2k10 = <?php echo json_encode($ob2k10);?>;
        var tab2k14 = <?php echo json_encode($ob2k14);?>;
        var tab2k16 = <?php echo json_encode($ob2k16);?>;
        // Lien a la div ou l'on veut mettre la Chart
        var ctx = 'spiderchart';
        // Et la Chart, mise en radar pour une aisance de lisibilite et de comparaisons
        var myChart = new Chart(ctx, {
            type: 'radar',
            data: {
                labels: tpays,
                datasets: [{
                    label: "Taux d'obesite en Europe en 2010",
                    data: tab2k10,
                    backgroundColor: [
                    'rgba(255, 99, 132, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                    ],
                    borderWidth: 1
                },
                {
                    label: "Taux d'obesite en Europe en 2014",
                    data: tab2k14,
                    backgroundColor: [
                    'rgba(99, 255, 132, 0.2)'
                    ],
                    borderColor: [
                        'rgba(99, 255, 132, 1)',
                    ],
                    borderWidth: 1
                },
                {
                    label: "Taux d'obesite en Europe en 2016",
                    data: tab2k16,
                    backgroundColor: [
                    'rgba(99, 132, 255, 0.2)'
                    ],
                    borderColor: [
                        'rgba(99, 132, 255, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
            }
        });
    </script>

    <!-- Footer -->
<footer class="page-footer font-small purple pt-4">

<!-- Footer Links -->
<div class="container-fluid text-center text-md-left">

  <!-- Grid row -->
  <div class="row">

    <!-- Grid column -->
    <div class="col-md-6 mt-md-0 mt-3">

      <!-- Content -->
      <h5 class="text-uppercase">Prevalence de l'obesite en Europe au fil du temps.</h5>
      <p>Site cree pour le module de PJS3. Faisant requete sur base de donnees MySQL, back-end en php, front en Html, CSS et Javascript. Avec aide des librairies Chart.js et Bootstrap.</p>

    </div>
    <!-- Grid column -->

    <hr class="clearfix w-100 d-md-none pb-3">

    <!-- Grid column -->
    <div class="col-md-3 mb-md-0 mb-3">

      <!-- Links -->
      <h5 class="text-uppercase">Par:</h5>

      <ul class="list-unstyled">
        <li>
          <a href="#!">SERVAIN Lucas</a>
        </li>
        <li>
          <a href="#!">DA SILVA Sofia</a>
        </li>
        <li>
          <a href="#!">ABADI Amina</a>
        </li>
        <li>
          <a href="#!">GHARBI Roya</a>
        </li>
      </ul>

    </div>
    <!-- Grid column -->

  </div>
  <!-- Grid row -->

</div>
<!-- Footer Links -->

</footer>
<!-- Footer -->

</body>

</html>