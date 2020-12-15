<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

$host="localhost";
$userName="root";
$password="hg0331";
$dbName="Bank";

$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');

try{
	$con = new PDO("mysql:host={$host};dbname={$dbName};charset=utf8",$userName,$password);
} catch(PDOException $e) {
	die("Failed to connect to the database: " . $e->getMessage());
}

$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$con->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

if(function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) {
	function undo_magic_quotes_gpc(&$array){
		foreach($array as &$value) {
			if(is_array($value)) undo_magic_quotes_gpc($value);
			else $value = stripslashes($value);
		}	
	}
	
	undo_magic_quotes_gpc($_POST);
	undo_magic_quotes_gpc($_GET);
	undo_magic_quotes_gpc($_COOKIE);
}
session_start();
 ?>
