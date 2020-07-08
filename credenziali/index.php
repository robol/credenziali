<?php
  include_once("login.php");
  
  /* Determinazione del path delle credenziali, nel caso il login sia valido */
  $path_credenziali = "/credenziali/$user.pdf";
  
  if ($user != null && $_GET['action'] == 'download') {
    /* Forniamo direttamente il file */
    header('Content-Description: File Transfer');
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="'. $user .'.pdf"');
    readfile($path_credenziali);
    exit;
  }
?>
<!DOCTYPE html>
<html>
<head>
  <title>Download credenziali</title>
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
  <link rel="stylesheet" type="text/css" href="css/style.css" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

  <div id="main-container" class="container">
    <h1 class="h3 mb-3">Laboratorio di Comunicazione mediante Calcolatore</h1>
    
    <div class="login-details">
      <?php if ($user == null): ?>
        &nbsp;
      <?php else: ?>
        Sei loggato come <?php echo $name; ?> (<strong><?php echo $user; ?></strong>). &nbsp; 
        <a href="./?action=logout"><button class="btn-primary btn btn-sm">Logout</button></a>
      <?php endif; ?>
    </div>
    
    <div class="content">
    
    <?php if ($user == null): ?>
      <p>È necessario effettuare il login (con le credenziali di Ateneo) per
      ottenere le credenziali del laboratorio.</p>
      
      <?php if ($login_failed): ?>
        <p class="warning">Le credenziali inserite non sono corrette.</p>
      <?php endif; ?>
      
      <div class="login-form"><?php login_form(); ?></div>
    <?php else: ?>
      <?php if (file_exists($path_credenziali)): ?>
        <p>
          Le credenziali sono disponibili per il download. 
          <ul>
            <li><a href="./?action=download">Download credenziali</a></li>
          </ul>
        </p>
      <?php else: ?>
        <p>Non è disponibile alcun file per il download.</p>
      <?php endif; ?>
    <?php endif; ?>
    
    </div>

</div>
</body>
</html>
