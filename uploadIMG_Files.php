<!doctype html>
<html>
<head>
	<title>Images et Thumbnails</title>
    <meta charset="UTF-8">
	<meta name="viewport" content="initial-scale=1.0">
    <link rel="stylesheet" href="../Shared/bootstrap.css" type="text/css">
</head>

<body>   
    <pre>
        <?php print_r($_FILES); ?>
    </pre>
    
<!-- résultat du print_r($_FILES);
           Array
(
    [fichier] => Array
        (
            [name] => style.css
            [type] => text/css
            [tmp_name] => C:\xampp\tmp\php4DE7.tmp
            [error] => 0
            [size] => 5491
        )

)
    -->
<!--    Si [error] => 0 on a tout bon. L' attribut 'name' porte tout. tmp_name peut et doit être récupéré -->
<h1>Appelé par EnvoiFichier.php</h1>
<?php
$maxFileSize = 1048576; // 1Mb = 1 048 576bytes - 1Kb = 1024bytes - 1Gb = 1 073 741 824b 1Tbytes = 1 073 511 627 776 
$extAuto = array('jpg','JPG','jpeg','JPEG', 'png','PNG','ping','PING','gif','GIF');
// tester l' extension est impératif
//echo $maxFileSize ;
$fichierObjet = $_FILES['fichierAEnvoyer'];
    echo 'Size: ' . $fichierObjet['size'].'<br>';
    if ($_FILES['fichierAEnvoyer']['error'] === 0 && $fichierObjet['size'] < $maxFileSize) {
        echo 'file found <br> file size <strong>OK </strong> <br>';
    }
    else {
        echo 'Ca craint!';
    }
// tester l 'extension et pas simplement le mime-type 
$fichierInfo = pathinfo($_FILES['fichierAEnvoyer']['name']);
echo '<b>print_r : </b>' ;
    print_r($fichierInfo);
echo 'extension :<strong> '. $fichierInfo['extension'] . '<strong> <br> <hr> <br>';

$nom = 'toto';
$extension = $fichierInfo['extension'];

if (in_array($fichierInfo['extension'], $extAuto)) {
    echo $_FILES['fichierAEnvoyer']['name'].'<br>';
    $nomUnique = md5(uniqid(rand(), true));
    
    if (strtoupper($extension) == 'JPG') {
        // on déplace le fichier en le renommant pour ne rien écraser!
        // Création de la miniature
        // On crée une copie de l' image
        $fichierInfo = pathinfo($_FILES['fichierAEnvoyer']['name']);

        $newImage = imagecreatefromjpeg($_FILES['fichierAEnvoyer']['name']) ;
        echo 'newImage: '.$newImage ;
        $imageWidth= imagesx($newImage); 
        $imageHeight= imagesy($newImage);
        echo '$imageWidth= ' . $imageWidth . ' et $imageHeight =' . $imageHeight;
        $newWidth = 200;
    //    rapport largeur/hauteur quand on connaît la largeur :     //        largeur = (hauteur x nouvelle largeur) / largeur
        $newHeight = ($imageHeight * $newWidth)/$imageWidth;
        // On crée une nouvelle image. NE MARCHE QUE POUR LES JPEG, a priori
        $miniature = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($miniature, $newImage, 0, 0, 0, 0, $newWidth, $newHeight, $imageWidth, $imageHeight);
        imagejpeg($miniature, 'thumbnails/' . $nomUnique . '.' . $extension);
//        echo '<div class="col-lg-3"> <img src ="thumbnails/'.$nomUnique . '.' . $extension . '"></div>';
    }
    
    if (strtoupper($extension) =='PNG') {
        $fichierInfo = pathinfo($_FILES['fichierAEnvoyer']['name']);

        $newImage = imagecreatefrompng($_FILES['fichierAEnvoyer']['tmp_name']) ;
        $imageWidth= imagesx($newImage); 
        $imageHeight= imagesy($newImage);
        echo '$imageWidth= ' . $imageWidth . ' et $imageHeight =' . $imageHeight;
        $newWidth = 200;    //    rapport largeur/hauteur quand on connaît la largeur : //        largeur = (hauteur x nouvelle largeur) / largeur
        $newHeight = ($imageHeight * $newWidth)/$imageWidth;    // On crée une nouvelle image. NE MARCHE QUE POUR LES JPEG, a priori
        $miniature = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($miniature, $newImage, 0, 0, 0, 0, $newWidth, $newHeight, $imageWidth, $imageHeight);
        imagepng($miniature, 'thumbnails/' . $nomUnique . '.' . $extension);
//        echo '<div class="col-lg-3"> <img src ="thumbnails/'.$nom . '.' . $extension . '"></div>';
    }

        if (strtoupper($extension) =='GIF') {
        $fichierInfo = pathinfo($_FILES['fichierAEnvoyer']['name']);

        $newImage = imagecreatefromgif($_FILES['fichierAEnvoyer']['tmp_name']) ;
        $imageWidth= imagesx($newImage); 
        $imageHeight= imagesy($newImage);
        echo '$imageWidth= ' . $imageWidth . ' et $imageHeight =' . $imageHeight;
        $newWidth = 200;
    //    rapport largeur/hauteur quand on connaît la largeur :     //        largeur = (hauteur x nouvelle largeur) / largeur
        $newHeight = ($imageHeight * $newWidth)/$imageWidth;        // On crée une nouvelle image. NE MARCHE QUE POUR LES JPEG, a priori
        $miniature = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($miniature, $newImage, 0, 0, 0, 0, $newWidth, $newHeight, $imageWidth, $imageHeight);
        imagegif($miniature, 'thumbnails/' . $nomUnique . '.' . $extension);
//        echo '<div class="col-lg-3"> <img src ="thumbnails/'.$nomUnique . '.' . $extension . '"></div>';
        }
    
    move_uploaded_file($_FILES['fichierAEnvoyer']['tmp_name'], 'uploads/'.$nomUnique .'.' . $extension);
    $DBnom= 'uploads/'.$nomUnique .'.' . $extension; // $_FILES['fichierAEnvoyer']['tmp_name'];
    $DBtaille = $_FILES['fichierAEnvoyer']['size'];
    // mettre une requête d' insertion en base de données
//    _____________________________________ maintenant on insère ________________________________ 
    $Myurl = $_POST;
    if (isset($Myurl['fichierAEnvoyer'])) {
            echo 'ok';
        }
    try
        {
        $bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));    }
        catch (Exception $e)       { die('Erreur : ' . $e->getMessage());        }
    
    echo '<h2>' . $DBnom .' comme nom. Et comme taille :  ' .$DBtaille.'</h2><br><hr>';
    
    
     $reponse = $bdd->prepare ('INSERT INTO imageBank (nom, taille) VALUES (:DBnom , :DBtaille) ');
        $reponse->bindValue(':DBnom', $DBnom, PDO::PARAM_STR);
        $reponse->bindValue(':DBtaille', $DBtaille, PDO::PARAM_STR);
        $reponse->execute();
    // on logge ce qu' on a fait
    $monFichier = fopen('fOpen/LOG/log.txt', 'r+');
    fwrite($monFichier, 'Nom de fichier: ' . $DBnom .chr(8) . 'Taille :  ' .$DBtaille . chr(13));
    fclose($monFichier);
    $contenus = 'date : ' . date('Y-m-d') . '-- taille : ' . $_FILES['fichierAEnvoyer']['size'] .'-- nom : '.  $_FILES['fichierAEnvoyer']['name'];
    file_put_contents('fOpen/LOG/log-'.$nom.'.txt', $contenus);
    
    $requete = $bdd->prepare ('SELECT * FROM imageBank');
    $requete->execute();
    while($donnees = $requete->fetch()){
            ?>
            <div class="col-md-4">
                <?php
//        echo $donnees['nom'];
                ?>
                taille : <?php echo $donnees['taille']; ?> octets 
                <img src="<?php echo $donnees['nom'].'"></div>' ;?> 
                 
            
            <?php
        }

        //quand on a fini de traiter la réponse
        $reponse->closeCursor();
        ?>
        <?php
}
else{ echo 'pas bon';
    }
?>

//fonctions utiles
// tester l\'\existence d\'\un fichier
<?php   
    if (file_exists('fOpen/LOG/log.txt')){
        echo 'file found'; 
    }
        else{ echo 'file not found';
        }
                     
    if (is_dir('fOpen')){
        echo 'Folder found'; 
    }
        else{ echo 'Folder not found';
        }

    if (file_exists('fOpen/LOG/log.txt')){
        copy('fOpen/LOG/log.txt', 'fOpen/LOG/new_Log.txt');
        echo 'Copied OK'; 
        rename('fOpen/LOG/log.txt', 'uploads/renamed_Log.txt');
        // Sert aussi à déplacer un fichier ailleurs que dans le dossier d\' origine
    }
        else{ echo 'Copy FAILED';
        }

    //Récupérer le chemin et nom de fichier:
        echo __FILE__;             
    //Récupérer le nom du dossier courant                     
        echo __DIR__;                     

echo '</body> </html>';
?>