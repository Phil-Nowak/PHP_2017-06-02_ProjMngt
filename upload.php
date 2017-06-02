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
<?php
$maxFileSize = 1048576; // 1Mb = 1 048 576bytes - 1Kb = 1024bytes - 1Gb = 1 073 741 824b 1Tbytes = 1 073 511 627 776 
//echo $maxFileSize ;
$fichierObjet = $_FILES['fichierAEnvoyer'];

// 1 048 000 = 1 Mb
    if ($_FILES['fichierAEnvoyer']['error'] === 0 && $fichierObjet['size'] < $maxFileSize) {
        echo 'file found <br> file size <strong>OK </strong> <br>';
    }
    else {
        echo 'Ca craint!';
    }
// tester l 'extension et pas simplement le mime-type 
$fichierInfo = pathinfo($_FILES['fichierAEnvoyer']['name']);
print_r($fichierInfo);
echo 'extension :<strong> '. $fichierInfo['extension'] . '<strong> <br>';
?>


