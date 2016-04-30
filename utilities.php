<?php
/**
 * Created by PhpStorm.
 * User: Csaba
 */

function xsssafe($data,$encoding='UTF-8') //function to clear user input
{
    return htmlspecialchars($data, ENT_QUOTES | ENT_HTML401, $encoding);
}


function xecho($data) //function to clear output
{
    echo(xsssafe($data));
}


?>
