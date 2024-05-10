<?php

    session_start();

    error_reporting( 0 );

    if ( !( isset( $_SESSION['Name'] ) ) )
    {
       header( "Location: login.php" );
       exit;
    }

    unlink( "./tasks/" . $_GET["id"] . ".tsk" );
    unlink( "./tasks/" . $_GET["id"] . ".i" );
    unlink( "./tasks/" . $_GET["id"] . ".l" );
    unlink( "./tasks/" . $_GET["id"] . ".n" );
    unlink( "./tasks/" . $_GET["id"] . ".d0" );
    unlink( "./tasks/" . $_GET["id"] . ".d1" );
    unlink( "./tasks/" . $_GET["id"] . ".e0" );
    unlink( "./tasks/" . $_GET["id"] . ".e1" );
    unlink( "./tasks/" . $_GET["id"] . ".ct" );

    header( "Refresh: 1; url = show_task.php" );
?>
