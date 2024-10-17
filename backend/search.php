<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Search Results</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
    }

    .container {
      width:1000px;
      background-color: #fff;
      border: 1px solid #ccc;
      border-radius: 10px;
      padding: 20px;
      margin: 0 auto;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th, td {
      border: 1px solid #ccc;
      padding: 8px;
      text-align: left;
    }

    th {
      background-color: #f2f2f2;
    }
  </style>
</head>
<body>
  <div class="container">
    <center>
      <?php
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
          $keywords = $_POST['keyword'];
          $keywordArray = explode(',', $keywords);

          if (!empty($keywords)) {
              //connexion a bd
              $connexion = mysqli_connect("localhost", "root", "", "indexation");
              if ($connexion) {
                $requete = "SELECT title, keywords, path FROM documents WHERE ";
                foreach ($keywordArray as $keyword) {
                  $requete .= "keywords LIKE '%$keyword%' AND ";
                }

                // Remove the last three characters ("AND ")
                $requete = substr($requete, 0, -4);
                  $resultat = mysqli_query($connexion,$requete);
                  if ($resultat){
                    // On accède aux valeurs de la ligne par l’attribut (nom du champ) dans la table de
                    //données.

                    echo "<table>";
                    echo "<tr>";
                    echo "<th>N°</th>";
                    echo "<th>Title</th>";
                    echo "<th>Path</th>";
                    echo "</tr>";
                    $num = 0;
                    while($ligne = mysqli_fetch_array($resultat)){
                      $num = $num+1;
                      $title = $ligne["title"];
                      $keywords = $ligne["keywords"];
                      $path = $ligne["path"];
                      echo "<tr>";
                      echo "<td>$num</td>";
                      echo "<td>$title</td>";
                      echo "<td>$path</td>";
                      echo "</tr>";
                    }
                    echo "</table>";
                  }else{
                      echo "<p>Error: Unable to execute the query.</p>";
                  }
                  mysqli_close($connexion);
              } else {
                  echo "<p>Error: Unable to establish database connection.</p>";
              }
          } else {
              echo "<p>Error: keywords are required.</p>";
          }
      }
      ?>
    </center>
  </div>
</body>
</html>
