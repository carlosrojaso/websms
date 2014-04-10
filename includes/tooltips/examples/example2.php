<?php

    // include the JavaScript tooltip generator class
    require "../class.tooltips.php";

    // instantiate the class
    $tt = new tooltips();
    
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <title>PHP JavaScript Tooltip Generator Class</title>
    </head>
    <body >
    <?php

        // set some properties for the tooltip
        // THIS MUST BE DONE BEFORE CALLING THE init() METHOD!
        
        // tell the tooltips to start fading in only after it have waited for 100 milliseconds
        $tt->fadeInDelay = 100;
        // tell the tooltips to start fading out only after 3 seconds
        // this is to show how more than just one tooltip can be visible on the screen at the same time!
        $tt->fadeOutDelay = 500;
        
        $tt->offsetX=0;
        
        $tt->offsetY=0;

        // see the manual for what other properties can be set!

        // notice that we init the tooltips in the <BODY> !
        $tt->init();
    ?>
    <br><br>
    <br><br>
    <br><br>
    <br><br>
    <br><br>
    <br><br>
    <br><br>
    <br><br>
    <br><br>
    <br><br>
    <br><br>
        <table>
            <tr>
                <td><br />
                    <!--
                        notice that we're not setting the onmouseout event!
                        the script automatically takes care of it
                    -->
                    <input type="button" value="hover me! (event is onmousemove)" onmousemove="<?=$tt->show("Hello World<br />from button 1!")?>"><br /><br />
                    <select>
                        <option>in internet explorer the tooltips stay over select boxes</option>
                    </select>
                    <input type="button" value="hover me also! (event is onmouseover)" onmouseover="<?=$tt->show("Hello World!<br />from button 2!")?>"><br /><br />
                    <br /><br />
                    notice how tooltips overlap and dissappear slowly in the order they appeared
                </td>
            </tr>
            <tr>
            	<td><input type="button" value="and hover me, too, please! (event is onmouseover)" onmouseover="<?=$tt->show("Hello World!<br/>from button 3!")?>"></td>
            </tr>
        </table>
    
    </body>
</html>
