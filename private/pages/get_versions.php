<?php

namespace BluffingoUpdaterSite;

global $path, $database;
$parsed_date = strtotime($path[3]);

header('Content-Type: application/json');

$date = date('Y-m-d', $parsed_date);

$version = $database->fetchArray($database->query(
    "SELECT * 
FROM versions v1
INNER JOIN software s ON v1.app_id = s.app_id 
WHERE v1.released <= ?
AND v1.released = (
    SELECT MAX(v2.released) 
    FROM versions v2 
    WHERE v2.app_id = v1.app_id
    AND v2.released <= ?
)
ORDER BY v1.released DESC;
", [$date, $date]));

$application = [];

foreach($version as $ware) {
    $application[$ware["app_id"]] = [
        "id" => $ware["app_id"],
        "name" => $ware["name"],
        "version" => $ware["version"],
        "released" => $ware["released"],
        "download" => $ware["url"],
    ];
}

echo json_encode($application);