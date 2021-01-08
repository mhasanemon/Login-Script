<?php
/**
 * Created by PhpStorm.
 * User: emon
 * Date: 11/22/19
 * Time: 10:27 PM
 */

//show error reporting
error_reporting(E_ALL);

//start php session
session_start();

//set default time zone
date_default_timezone_set('Asia/Dhaka');

//home page url
$home_url = "http://localhost/loginscript/";

// page given in URL parameter, default page is one
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// set number of records per page
$records_per_page = 5;

// calculate for the query LIMIT clause
$from_record_num = ($records_per_page * $page) - $records_per_page;