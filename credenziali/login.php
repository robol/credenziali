<?php
  /* Questo file gestisce la procedura di login, e l'inizializzazione
   * della sessione. Se è stato fatto un login valido, imposta la variabile
   * $user al nome dell'utente. Altrimenti, questa è null. 
   *  
   * Se il login è fallito, viene impostata la variabile login_failed a true; 
   * altrimenti è false.
   *
   * La funzione login_form() stampa la form per effettuare il login. 
   */
   
  $user = null;
  $login_failed = false;
   
  session_start();
  
  if ($_GET['action'] == 'logout') {
    $_SESSION['user'] = null;
  }
  
  if ($_SESSION['user'] != null) {
      $user = $_SESSION['user'];
      $name = $_SESSION['name'];
  }
  else {      
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        /* Proviamo a fare il login con i dati forniti dallo studente */
        $user = $_POST['username'];
        $pass = $_POST['password'];
        
        putenv("LDAPTLS_REQCERT=never");
        
        $ds = ldap_connect("ldap://idmauth.unipi.it");
        
        if (! $ds) {
          $err = "Impossibile contattare il server LDAP";
          echo $err;
          $user = null;
        }
        else {
            ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);  
            if (ldap_start_tls($ds)) {
                $r = ldap_bind($ds, "uid=" . $user . ",dc=studenti,ou=people,dc=unipi,dc=it", $pass);
                
                if ($r) {
                   $results = ldap_search($ds, "dc=unipi,dc=it", "uid=" . $user);
                   $matches = ldap_get_entries($ds, $results);
                   $name = $matches[0]['cn'][0];
                }
            }
            else {
                $r = false;
            }

            if ($r) {
              /* Login ok */
              $_SESSION['user'] = $user;
              $_SESSION['name'] = $name;
            }
            else {
              $user = null;
              $login_failed = true;
            }
        }
      }
  }
  
function login_form() {
  ?>
      <form action="./" method="POST">
      <div class="form-block">
          <label>Utente: </label>
          <input type="text" name="username"></input>
      </div>
      <div class="form-block">
          <label>Password: </label>
          <input type="password" name="password"></input>
      </div>
      <div class="form-block">
          <input type="submit" value="Login">      
      </div>
    </form>
  <?php
}
     
 ?>
