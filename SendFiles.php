<!doctype html>

<html>
	<head>
		<title>Page Title</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="initial-scale=1.0">
		<a></a>
	</head>

	<body>
       Formulaire d' envoi de fichier(s)
        <form method="POST" action="upload.php" enctype="multipart/form-data">
            <!--indispensable de mettre le enctype-->
            <input type="file" name="fichierAEnvoyer"> 
            <!--on ne met pas de 'value' dans la balise-->
            <button type ="submit">Envoyer</button>
            <!--Et on envoit-->            
            
            
            
            
        </form>
	</body>
</html>