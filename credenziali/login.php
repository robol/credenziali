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
   
  include_once("ldap-login.php");
   
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
        
        $data = ldap_login($user, $pass);

        if ($data != null) {
              /* Login ok */
              $_SESSION['user'] = $user;
              $_SESSION['name'] = $data['name'];
              $name = $data['name'];
        }
        else {
              $user = null;
              $login_failed = true;
        }
      }
  }
  
function login_form() {
  ?>
      <form action="./" method="POST">
      <div class="form-block">
          <label for="username" class="sr-only">Utente: </label>
          <input type="text" name="username" class="form-control" placeholder="Utente"></input>
      </div>
      <div class="form-block">
          <label for="password" class="sr-only">Password: </label>
          <input type="password" name="password" class="form-control" placeholder="Password"></input>
      </div>
      <div class="form-block">
          <input  class="btn btn-lg btn-primary btn-block" type="submit" value="Login">      
      </div>
    </form>
  <?php
}
     
 ?>
