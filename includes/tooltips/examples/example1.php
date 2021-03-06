<?php

// include the JavaScript tooltip generator class
require "../class.tooltips.php";

// instantiate the class
$tt = new tooltips();

?>
<html>
    <head>
        <title>PHP JavaScript Tooltip Generator Class</title>
    </head>
    <body>
    <?php

    // set some properties for the tooltip
    // THIS MUST BE DONE BEFORE CALLING THE init() METHOD!

    // tell the tooltips to start fading in only after it have waited for one second
    $tt->fadeInDelay = 1000;

    // fade out instantly when mouseout
    $tt->fadeOutDelay = 0;

    // the speed to which to fade in (1-100)
    $tt->fadeInSpeed = 20;

    // the speed to which to fade out (1-100)
    $tt->fadeOutSpeed = 20;

    // see the manual for what other properties can be set!

    // notice that we init the tooltips in the <BODY> !
    // AND AFTER WE SET THE DESIRED PROPERTIES
    $tt->init();

    ?>
    
        <table style="width:100%;height:100%">            
        	<tr>
                <td><input type="button" value="hover me (event is onmousemove)" onmousemove="<?=$tt->show("Hello World!")?>"></td>
            </tr>
        </table>
    
    </body>
</html>
