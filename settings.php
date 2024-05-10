<?php

    session_start();

    error_reporting( 0 );

    if ( !( isset( $_SESSION['Name'] ) ) )
    {
       header( "Location: login.php" );
       exit;
    }
    
    function MakeFormChangePass() 
    {          
       $res = "<div align=\"center\">
                  <table border=\"0\" width=\"1200\" class=table cellspacing = \"0\" cellpadding=\"0\">
	             <tr>
		        <td>
                           &nbsp;<img src=\"images\ic_2.png\">&nbsp;Change login data:
                        </td>
	             </tr>
	
                     <tr>
		        <td>
                           <div align=\"center\">
                              <form action=\"" . basename( $_SERVER['SCRIPT_NAME'] ) . "\" method=\"post\" name=\"form\">
      
                                 <table border=\"0\" width=\"570\" height=\"118\" class=table_lig cellspacing=\"0\" cellpadding=\"0\">

	                            <tr>
		                       <td>New login:</td>

		                       <td>
		                          <input name=\"newlogin\" class=task value=\"root\" style=\"float: left\">
                                       </td>
		            
                                       <td>
                                          * Please enter new login name.
                                       </td>
	                            </tr>
	      
                                    <tr>
		                       <td>New password:</td>

		                       <td>
		                          <input name=\"newpass\" type=password class=task style=\"float: left\">
                                       </td>

		                       <td>
                                          * Please enter new password.
                                       </td>
	                            </tr>

	                            <tr>
		                       <td>Current password:</td>

		                       <td>
		                          <input name=\"oldpass\" type=password class=task style=\"float: left\">
                                       </td>

		                       <td>
                                          * Please enter current CP password.
                                       </td>
	                            </tr>
	
                                    <tr>
		                       <td>&nbsp;</td>
		                       <td>&nbsp;</td>		              
                                       <td>&nbsp;</td>
	                            </tr>
                                 </table>

                                 <table border=\"0\" width=\"1000\" cellspacing=\"0\" cellpadding=\"0\" height=\"5\">
	                            <tr>
		                       <td>
                                          <div align=\"center\">
                                             <input type=\"submit\" name=\"submit\" value=\"Save data\" class=\"button\">
                                          </div>
                                       </td>
	                            </tr>
                                 </table>

                              </form>
                           </div>
		        </td>
                     </tr>
                  </table>
               </div>";

       return $res;
    }       

    function MakeFormSQLsettings() 
    {          
       $res = "<div align=\"center\">
                  <table border=\"0\" width=\"1200\" class=table cellspacing = \"0\" cellpadding=\"0\">
	             <tr>
		        <td>
                           &nbsp;<img src=\"images\ic_2.png\">&nbsp;Change SQL base data:
                        </td>
	             </tr>
	
                     <tr>
		        <td>
                           <div align=\"center\">
                              <form action=\"" . basename( $_SERVER['SCRIPT_NAME'] ) . "\" method=\"post\" name=\"form\">
      
                                 <table border=\"0\" width=\"570\" height=\"180\" class=table_lig cellspacing=\"0\" cellpadding=\"0\">

	                            <tr>
		                       <td>SQL Host:</td>

		                       <td>
		                          <input name=\"sqlhost\" class=task value=\"localhost\" style=\"float: left\">
                                       </td>
		            
                                       <td>
                                          * Please enter SQL server IP or domain name .
                                       </td>
	                            </tr>
	      
                                    <tr>
		                       <td>DataBase Name:</td>

		                       <td>
		                          <input name=\"sqlname\" class=task style=\"float: left\">
                                       </td>

		                       <td>
                                          * Please enter SQL base name.
                                       </td>
	                            </tr>

	                            <tr>
		                       <td>DataBase user:</td>

		                       <td>
		                          <input name=\"sqluser\" class=task style=\"float: left\">
                                       </td>

		                       <td>
                                          * Please enter SQL base user name.
                                       </td>
	                            </tr>

	                            <tr>
		                       <td>DataBase password:</td>

		                       <td>
		                          <input name=\"sqlpass\" type=password class=task style=\"float: left\">
                                       </td>

		                       <td>
                                          * Please enter SQL base user password.
                                       </td>
	                            </tr>

	                            <tr>
		                       <td>Current password:</td>

		                       <td>
		                          <input name=\"oldpass\" type=password class=task style=\"float: left\">
                                       </td>

		                       <td>
                                          * Please enter current CP password.
                                       </td>
	                            </tr>
	
                                    <tr>
		                       <td>&nbsp;</td>
		                       <td>&nbsp;</td>		              
                                       <td>&nbsp;</td>
	                            </tr>
                                 </table>

                                 <table border=\"0\" width=\"1000\" cellspacing=\"0\" cellpadding=\"0\" height=\"5\">
	                            <tr>
		                       <td>
                                          <div align=\"center\">
                                             <input type=\"submit\" name=\"sql\" value=\"Save data\" class=\"button\">
                                          </div>
                                       </td>
	                            </tr>
                                 </table>

                              </form>
                           </div>
		        </td>
                     </tr>
                  </table>
               </div>";

       return $res;
    }         

    function MakeFormCleaningDB() 
    {              
       $res = "<div align=\"center\">
                  <table border=\"0\" width=\"1200\" class=table cellspacing = \"0\" cellpadding=\"0\">
	          
                     <tr>
		        <td>
                           &nbsp;<img src=\"images\ic_2.png\">&nbsp;Delete all units from DB:
                        </td>
	             </tr>
	
                     <tr>
		        <td>
                           <div align=\"center\">
                              <form action=\"" . basename( $_SERVER['SCRIPT_NAME'] ) . "\" method=\"post\" name=\"form\">
     
                                 <table border=\"0\" width=\"1000\" cellspacing=\"0\" cellpadding=\"0\">
	        	
                                    <tr>
		                       <td>&nbsp;</td>

		                       <td>
                                          <div align=\"center\">
                                             <input type=\"submit\" name=\"clear\" value=\"Clear\" class=\"button\">
                                          </div>
                                       </td>
		              
                                       <td>&nbsp;</td>
	                            </tr>
                                 </table>

                              </form>
                           
                           </div>
		        </td>
	             </tr>
                  </table>
              </div>";

       return $res;
    }        

    function MakeFormCleaningTask() 
    {              
       $res = "<div align=\"center\">
                  <table border=\"0\" width=\"1200\" class=table cellspacing = \"0\" cellpadding=\"0\">
	             <tr>
		        <td>
                           &nbsp;<img src=\"images\ic_2.png\">&nbsp;Delete all active tasks:
                        </td>
	             </tr>
	
                     <tr>
		        <td>
                           <div align=\"center\">
                              <form action=\"" . basename( $_SERVER['SCRIPT_NAME'] ) . "\" method=\"post\" name=\"form\">       
                                 <table border=\"0\" width=\"1000\" cellspacing=\"0\" cellpadding=\"0\">
                                    <tr>
		                       <td>&nbsp;</td>

		                       <td>
                                          <div align=\"center\">
                                             <input type=\"submit\" name=\"cleartasks\" value=\"Delete\" class=\"button\" style=\"float: center\">
                                          </div>
                                       </td>
		              
                                       <td>&nbsp;</td>
	                            </tr>
                                 </table>
                              </form>                           
                           </div>
		        </td>
                     </tr>
                  </table>
               </div>";

       return $res;
    } 

    function MakeFormCreateTable() 
    {              
       $res = "<div align=\"center\">
                  <table border=\"0\" width=\"1200\" class=table cellspacing = \"0\" cellpadding=\"0\">
	             <tr>
		        <td>
                           &nbsp;<img src=\"images\ic_2.png\">&nbsp;Create table in DataBase:
                        </td>
	             </tr>
	
                     <tr>
		        <td>
                           <div align=\"center\">
                              <form action=\"" . basename( $_SERVER['SCRIPT_NAME'] ) . "\" method=\"post\" name=\"form\">       
                                 <table border=\"0\" width=\"1000\" cellspacing=\"0\" cellpadding=\"0\">
                                    <tr>
		                       <td>&nbsp;</td>

		                       <td>
                                          <div align=\"center\">
                                             <input type=\"submit\" name=\"createtable\" value=\"Create\" class=\"button\" style=\"float: center\">
                                          </div>
                                       </td>
		              
                                       <td>&nbsp;</td>
	                            </tr>
                                 </table>
                              </form>                           
                           </div>
		        </td>
                     </tr>
                  </table>
               </div>";

       return $res;
    } 

    function SaveConfig( $newlogin, $newpass, $oldpass )
    {
       include( "config.php" );

       $clogin = $conf["login"];
       $cpass = $conf["password"];
       $cdbhost = $conf["dbhost"];
       $cdbname = $conf["dbname"];
       $cdbuser = $conf["dbuser"];
       $cdbpass = $conf["dbpass"];

       if ( $cpass == md5( $oldpass ) )
       {
          $pr = "    ";
          $cr = "\r\n";
          $rn = " = ";

          $content = $content . "<?php";

          $content = $content . $cr . $pr . "\$conf[\"login\"]" . $rn . "\"" . $newlogin . "\";";
          $content = $content . $cr . $pr . "\$conf[\"password\"]" . $rn . "\"" . md5( $newpass ) . "\";";
          $content = $content . $cr . $pr . "\$conf[\"dbhost\"]" . $rn . "\"" . $cdbhost . "\";";
          $content = $content . $cr . $pr . "\$conf[\"dbname\"]" . $rn . "\"" . $cdbname . "\";";
          $content = $content . $cr . $pr . "\$conf[\"dbuser\"]" . $rn . "\"" . $cdbuser . "\";";
          $content = $content . $cr . $pr . "\$conf[\"dbpass\"]" . $rn . "\"" . $cdbpass . "\";";
          $content = $content . $cr . "?>";

          file_put_contents( "config.php", $content );
          echo "<meta http-equiv=\"refresh\" content=\"1; url=settings.php\">"; 
       }
       else
       {
          echo "Incorrect password!";
       }
    }

    function SaveSQL( $newhost, $newname, $newuser, $newpass, $mainpass )
    {
       include( "config.php" );

       $clogin = $conf["login"];
       $cpass = $conf["password"];
       $cdbhost = $conf["dbhost"];
       $cdbname = $conf["dbname"];
       $cdbuser = $conf["dbuser"];
       $cdbpass = $conf["dbpass"];

       if ( $cpass == md5( $mainpass ) )
       {
          $pr = "    ";
          $cr = "\r\n";
          $rn = " = ";

          $content = $content . "<?php";

          $content = $content . $cr . $pr . "\$conf[\"login\"]" . $rn . "\"" . $clogin . "\";";
          $content = $content . $cr . $pr . "\$conf[\"password\"]" . $rn . "\"" . $cpass . "\";";
          $content = $content . $cr . $pr . "\$conf[\"dbhost\"]" . $rn . "\"" . $newhost . "\";";
          $content = $content . $cr . $pr . "\$conf[\"dbname\"]" . $rn . "\"" . $newname . "\";";
          $content = $content . $cr . $pr . "\$conf[\"dbuser\"]" . $rn . "\"" . $newuser . "\";";
          $content = $content . $cr . $pr . "\$conf[\"dbpass\"]" . $rn . "\"" . $newpass . "\";";
          $content = $content . $cr . "?>";

          file_put_contents( "config.php", $content );
          echo "<meta http-equiv=\"refresh\" content=\"1; url=settings.php\">"; 
       }
       else
       {
          echo "Incorrect password!";
       }
    }

    function DeleteUnits()
    {
       include( "config.php" );
       mysql_connect( $conf["dbhost"], $conf["dbuser"], $conf["dbpass"] );
       mysql_select_db( $conf["dbname"] );      
       mysql_query( 'DELETE FROM units' );   
       echo "<meta http-equiv=\"refresh\" content=\"1; url=settings.php\">";    
    }
    
    function DeleteTasks() 
    {
       $filelist = glob( "./tasks/*.tsk" );

       if ( $handle = opendir( "./tasks/" ) ) 
       {     
          while ( $entry = readdir( $handle ) ) 
          {
            if ( strpos( $entry, "*" ) === 0 ) 
            {
               $filelist[] = $entry;
            }
          }

          closedir( $handle );

          for ( $i = 0; $i < count( $filelist ); $i++ )
          {
             unlink( $filelist[$i] );
             unlink( "./tasks/" . basename( $filelist[$i], ".tsk" ) . ".n" );
             unlink( "./tasks/" . basename( $filelist[$i], ".tsk" ) . ".i" );
             unlink( "./tasks/" . basename( $filelist[$i], ".tsk" ) . ".l" );
             unlink( "./tasks/" . basename( $filelist[$i], ".tsk" ) . ".d0" );
             unlink( "./tasks/" . basename( $filelist[$i], ".tsk" ) . ".d1" );
             unlink( "./tasks/" . basename( $filelist[$i], ".tsk" ) . ".e0" );
             unlink( "./tasks/" . basename( $filelist[$i], ".tsk" ) . ".e1" );
             unlink( "./tasks/" . basename( $filelist[$i], ".tsk" ) . ".ct" );
          }
       }

       echo "<meta http-equiv=\"refresh\" content=\"1; url=settings.php\">"; 
    }

    function CreateTable()
    {
       include( "config.php" );
       mysql_connect( $conf["dbhost"], $conf["dbuser"], $conf["dbpass"] );
       mysql_select_db( $conf["dbname"] );   
  
       mysql_query( "CREATE TABLE IF NOT EXISTS units( id varchar(10) NOT NULL, ip varchar(15) NOT NULL, online int(10) NOT NULL, country varchar(12) NOT NULL, version varchar(6) NOT NULL, ar varchar(10) NOT NULL, arch varchar(10) NOT NULL, os varchar(20) NOT NULL, reg int(10) NOT NULL, av varchar(15) NOT NULL, PRIMARY KEY (id) ) ENGINE=MyISAM" );     
       echo "<meta http-equiv=\"refresh\" content=\"1; url=settings.php\">"; 
    }

    include( "header.php" );

    if( isset( $_POST["submit"] ) ) 
    {        
       SaveConfig( $_POST["newlogin"], $_POST["newpass"], $_POST["oldpass"] );
       die;
    }

    if( isset( $_POST["sql"] ) ) 
    {        
       SaveSQL( $_POST["sqlhost"], $_POST["sqlname"], $_POST["sqluser"], $_POST["sqlpass"], $_POST["oldpass"] ); 
       die;
    }

    if( isset( $_POST["clear"] ) ) 
    {  
       DeleteUnits();     
       die;
    }

    if( isset( $_POST["cleartasks"] ) ) 
    {  
       DeleteTasks();    
       die;
    }

    if( isset( $_POST["createtable"] ) ) 
    {  
       CreateTable();    
       die;
    }

    echo ( MakeFormChangePass() );

    echo "<table border=\"0\" width=\"1000\" cellspacing=\"0\" cellpadding=\"0\" height=\"5\">
	     <tr>
		<td></td>
	     </tr>
          </table>";

    echo MakeFormSQLsettings();

    echo "<table border=\"0\" width=\"1000\" cellspacing=\"0\" cellpadding=\"0\" height=\"5\">
	     <tr>
		<td></td>
	     </tr>
          </table>";

    echo ( MakeFormCleaningDB() ); 

    echo "<table border=\"0\" width=\"1000\" cellspacing=\"0\" cellpadding=\"0\" height=\"5\">
	     <tr>
		<td></td>
	     </tr>
          </table>";

    echo MakeFormCleaningTask();

    echo "<table border=\"0\" width=\"1000\" cellspacing=\"0\" cellpadding=\"0\" height=\"5\">
	     <tr>
		<td></td>
	     </tr>
          </table>";
    
    echo MakeFormCreateTable();

    echo "</html>";
?>