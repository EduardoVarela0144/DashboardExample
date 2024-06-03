<?php
$con  = mysqli_connect('localhost','root','','ordinario','3306');
if(mysqli_connect_errno())
{
    echo 'Database Connection Error';
}