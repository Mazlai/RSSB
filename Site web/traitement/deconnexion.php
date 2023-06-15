<?php 
  
  session_start();
  
  if(isset($_POST['Deconnexion'])) {
    
    session_destroy();
    echo('<script language="JavaScript" type="text/javascript"> 
            alert("Déconnexion effectuée."); 
            location.href = "../intranet.php";
          </script>');  
    
  }
  
?>