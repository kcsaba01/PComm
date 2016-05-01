<?php
/**
 * Created by PhpStorm.
 * User: Csaba Keresztessy <0811994@rgu.ac.uk>
 * Date: 01/05/2016
 * PHP script to sanitise input/output in order to prevent XSS
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
