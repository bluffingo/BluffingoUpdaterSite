<?php

namespace BluffingoUpdaterSite;

header('Content-Type: application/json');

global $database;

$software = $database->fetchArray($database->query("SELECT * FROM software ORDER BY int_id ASC"));

$application = [];

foreach($software as $ware) {
    $application[$ware["app_id"]] = [
        "id" => $ware["app_id"],
        "name" => $ware["name"],
        "author" => $ware["author"]
    ];
}

echo json_encode($application);