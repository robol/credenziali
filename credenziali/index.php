<?php
  include_once("login.php");
  
  /* Determinazione del path delle credenziali, nel caso il login sia valido */
  $path_credenziali = "/credenziali/$user.pdf";
  $path_credenziali_phc = "/credenziali/$user-phc.pdf";
  
  if ($user != null && $_GET['action'] == 'download') {
    /* Logghiamo che l'utente ha scaricato il file */
    $h = fopen('/credenziali/downloads.log', 'a');
    if (! $h) {
      echo "Errore nella creazioni del registro dei download.";
      exit;
    }
    
    fwrite($h, date(DATE_RFC2822) . " - Download di $user.pdf da parte dell'utente $user\n");
    fclose($h);
  
    /* Forniamo direttamente il file */
    header('Content-Description: File Transfer');
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="'. $user .'.pdf"');
    readfile($path_credenziali);
    exit;
  }
  
  if ($user != null && $_GET['action'] == 'download-phc') {
    /* Logghiamo che l'utente ha scaricato il file */
    $h = fopen('/credenziali/downloads.log', 'a');
    if (! $h) {
      echo "Errore nella creazioni del registro dei download.";
      exit;
    }
    
    fwrite($h, date(DATE_RFC2822) . " - Download di $user-phc.pdf da parte dell'utente $user\n");
    fclose($h);
  
    /* Forniamo direttamente il file */
    header('Content-Description: File Transfer');
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="'. $user .'-phc.pdf"');
    readfile($path_credenziali_phc);
    exit;
  }
?>
<!DOCTYPE html>
<html>
<head>
  <title>Download credenziali</title>
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
  <link rel="stylesheet" type="text/css" href="css/style.css?v=2" />
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
      <?php if (file_exists($path_credenziali_phc)): ?>
        <div class="cred-block">
          Le credenziali per il <a href="https://poisson.phc.dm.unipi.it/">PHC</a> 
          sono disponibili per il download. Per maggiori
          informazioni contattare i <a href="mailto:macchinisti@poisson.phc.dm.unipi.it">Macchinisti</a>.
          <ul>
            <li><a href="./?action=download-phc">Download credenziali PHC</a></li>
          </ul>
        </div>
      <?php endif; ?>
    
      <?php if (file_exists($path_credenziali)): ?>
        <div class="cred-block">
          Le credenziali per l'account in Dipartimento (Aula 3, Aula 4, ecc.) 
          sono disponibili per il download.
          <ul>
            <li><a href="./?action=download">Download credenziali Dipartimento</a></li>
          </ul>
          
          <p>Nello scaricare il file
          con le credenziali, l'utente accetta le condizioni d'uso per l'account
          sul sistema di Calcolatori dei Laboratori Computazionali (Aula 3, Aula 4 e
          servizi collegati) riportate qui sotto:</p>
          <div class="condizioni">
            <h4>Condizioni di affido</h4>
            <p>Al primo login l'utente deve cambiare la password.</p>
	    <p>L'account può essere usato dall'utente esclusivamente per gli scopi di didattica, 
	    ricerca e studio istituzionali del Dipartimento.</p>
	     <p>L'account è strettamente personale e non può essere affidato o ceduto ad altri.
		Nell'utilizzo dell'account l'utente deve attenersi, oltre alle leggi vigenti tra cui quelle sulla pro-
		tezione del copyright e del diritto d'autore, e alle norme sulla privacy, anche alle 
		<a href="https://www.garr.it/it/regole-di-utilizzo-della-rete-aup">regole del GARR</a>
		per quanto concerne l'uso delle reti della ricerca: </p>
		
		<p>L'account non deve essere utilizzato per nessuna operazione che metta a repentaglio il buon nome
		del Dipartimento.
		Il Dipartimento non si assume nessuna responsabilità per la perdita di files o per il mancato 
		funzionamento del servizio, o per qualsiasi danno che possa essere causato da malfunzionamenti di
		ogni origine dei calcolatori del Dipartimento.</p>
		<p>
		Sui calcolatori è presente un sistema di logging: l'utente acconsente al trattamento di tali log.
		L'utente deve segnalare immediatamente ogni malfunzionamento, anomalia, sospetta intrusione,
		furto o smarrimento delle credenziali al Direttore del Centro di Calcolo Scientifico e nei casi più
		gravi al Direttore del Dipartimento (oltre che &mdash; se è il caso &mdash; alle competenti autorità).</p>
		<p>L'utente deve trattare con cura i locali e le attrezzature messe a disposizione del Dipartimento per
		utilizzare l'account, con rispetto per lo studio e il lavoro degli altri.
		L'account ha di norma validità nel periodo del rapporto tra l'utente e il Dipartimento, ma può
		essere revocato o sospeso in qualsiasi momento dal Dipartimento senza preavviso all'utente .
		L'utente può rinunciare quando vuole all'uso dell'account, ma deve notificarlo al Direttore del
		Centro di Calcolo Scientifico.</p>
		
		<h4>Assunzione di responsabilità e consenso al trattamento dati personali</h4>
		<p>Il/la sottoscritto/a <?php echo $name ?>, scaricando il file contenente le credenziali
		dichiara implicitamente di accettare integralmente le Condizioni di Affido suddette per l'account 
		sul sistema di Calcolatori dei Laboratori Computazionali. Dichiara inoltre
		di dare il suo consenso alla trattazione dei dati personali e alla tenuta dei log relativi agli accessi
		al sistema. Il Titolare del Trattamento di tali dati a norma dell'art. 41f del D.Lgs. 196/2003 è il
		Dipartimento di Matematica dell'Università di Pisa.</p>
          </div>
        </div>
      <?php else: ?>
        <p>Non è disponibile alcun file per il download.</p>
      <?php endif; ?>
    <?php endif; ?>
    
    </div>

</div>
</body>
</html>
