<?php

/**
 * @brief Try to login with the given credentials. 
 *
 * This function tries to login with the given $user / $pass
 * combination. On success, a dictionary with the details of
 * the user is returned. 
 *
 * Otherwise, the function returns null. 
 */
function ldap_login($user, $pass) {
  putenv("LDAPTLS_REQCERT=never");

  $ds = ldap_connect("ldap://idmauth.unipi.it");

  if (! $ds) {
    return null;
  }
  else {
    ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
    
    /* Start the TLS security layer -- if that does not work, 
     * abort the authentication. */
    if (! ldap_start_tls($ds)) {
      return null;
    }
    
    if (ldap_start_tls($ds)) {
      $r = ldap_bind($ds, "uid=" . $user . ",dc=studenti,ou=people,dc=unipi,dc=it", $pass);
        
      if ($r) {
        $results = ldap_search($ds, "dc=unipi,dc=it", "uid=" . $user);
        $matches = ldap_get_entries($ds, $results);
        $name = $matches[0]['cn'][0];
      }
    }
    else {
      return null;
    }
  }
    
  return [ 'user' => $user, 'name' => $name ];
}

?>
