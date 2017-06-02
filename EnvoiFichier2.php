<!doctype html>

<html>
	<head>
		<title>Page Title</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="initial-scale=1.0">
		<link rel="stylesheet" href="../Shared/bootstrap.css" type="text/css">
	</head>

	<body>
       <h1>Formulaire d' envoi de fichier(s)</h1>
        <form method="POST" action="uploadIMG_Files.php" enctype="multipart/form-data">
            <!--indispensable de mettre le enctype-->
            <input type="file" name="fichierAEnvoyer">
            JPG, PNG, GIF 
            <!--on ne met pas de 'value' dans la balise-->
            <button type ="submit">Envoyer</button>
        </form>
	</body>
</html>