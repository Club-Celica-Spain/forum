<?php 
    session_start(); 
    if($enviar) { 
        $Message = ""; 
        $Captcha = (string) $_POST["CAPTCHA_CODE"]; 
        if($_POST['Nom_cognoms'] == '') { 
						echo "<p style='color: #ff0000;'><strong>No has puesto tu nombre.</strong></p>"; 
        }elseif($_POST['Comentari'] == '') { 
            echo "<p style='color: #ff0000;'><strong>No has escrito el comentario.</strong></p>"; 
				        }elseif(sha1($Captcha) != $_SESSION["CAPTCHA_CODE"]) { 
            $Message = "<p style='color: #ff0000;'><strong>El código de validación no es correcto.</strong></p>"; 
        }else { 
            mail ("info@clubcelica.es", "$asunto", "Nombre: $Nom_cognoms \n Comentario: $Comentari", "From: $Nom_cognoms <$E_mail>");
            Header("Location: $redirect");
        } 
    } 
    if(!empty($Message)) { 

        echo "$Message"; 
    } 
?> 
<html>
<head>
<title>Club Celica España</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="Themes/MegaPolis/style.css" type="text/css">
</head>
<form method="post" action="formulario.php"> 
<font color="white"><p>Nombre:<br>
          <input type="text" size="30" class="campo" name="Nom_cognoms" value="<?php if (isset($_POST['Nom_cognoms'])) echo $_POST['Nom_cognoms'];?>">
          <br>
          <br />
          E-mail:<br />
          <input type="text" size="30" class="campo" name="E_mail" value="<?php if (isset($_POST['E_mail'])) echo $_POST['E_mail'];?>">
          <br />
          <br>
          </p>
        <p><span class="txt">Comentario:</span><br></font>
          <textarea cols="40" rows="6" class="campo" name="Comentari"><?php if (isset($_POST['Comentari'])) echo $_POST['Comentari'];?></textarea>
        </p>
    <input name="asunto" type="hidden" size="60" value="Contacto con Club Celica España"/> 
    <label>Código de seguridad:</label>
	<img src="code.php" alt="Casilla de Seguridad" border="1" class="campo"/><br><input type="text" class="campo" name="CAPTCHA_CODE"/><br>
	<i><font size="1">Introduce los caracteres que hay dentro de la casilla de seguridad</font></i>
    <p style="padding-top: 5px;"> 
	<p><input type="submit" name="enviar" value="Enviar Comentario" />
    <input type="reset" name="enviar" value="Borrar los datos" /> 
    <input type = "hidden" name="redirect" value="http://www.clubcelica.es/foro/ok.php">
      <br></td>
  </tr>
    </p> 
</form>
</table>
</body>
</html>