<html>
<head>
<meta charset="utf-8">
</meta>
</head>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $keywords = $_POST['keywords'];
    $path = "";

    if (isset($_FILES['doc']) && $_FILES['doc']['error'] == 0) {
        // Test if the file extension is allowed
        $infosfichier = pathinfo($_FILES['doc']['name']); //extract file info
        $extension_upload = strtolower($infosfichier['extension']); //get extensions
        $extensions_autorisees = array('txt', 'pdf', 'doc');
        if (in_array($extension_upload, $extensions_autorisees)) {
            $path = 'C:/IRpdf/' . basename($_FILES['doc']['name']); //new file path
            if (!empty($title)) {
              if(!empty($keywords)){
                move_uploaded_file($_FILES['doc']['tmp_name'], $path); //move to new file path
                //connexion a bd
                $connexion = mysqli_connect("localhost", "root", "", "indexation");
                if ($connexion) {
                    //connexion: taamlt
                    $requete = 'INSERT INTO documents(title, path, keywords) VALUES ("'.$title.'", "'.$path.'", "'.$keywords.'")';
                    $resultat = mysqli_query($connexion, $requete);
                    if ($resultat) {
                        // Query executed successfully
                        echo "<p>Document uploaded and metadata inserted into the database.</p>";
                    } else {
                        echo "<p>Error: Unable to execute the query.</p>";
                    }
                    mysqli_close($connexion);
                } else {
                    echo "<p>Error: Unable to establish database connection.</p>";
                }
              }else{
                echo "<p>Error: Keywords are required.</p>";
              }
            } else {
                echo "<p>Error: Title is required.</p>";
            }
        } else {
            echo "<p>Error: Invalid file extension. Only txt, pdf, and doc files are allowed.</p>";
        }
    } else {
        echo "<p>Error: No file selected or error occurred during file upload.</p>";
    }
}
?>
</html>
