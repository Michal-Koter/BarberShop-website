<?php
include_once "../../Service.php";
Service::delete($_COOKIE['delete_id']);
header("Location: services_list.php");