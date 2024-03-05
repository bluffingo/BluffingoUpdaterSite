<?php
namespace BluffingoUpdaterSite;

global $database;

use Site\Templating;

//array(5) {
//  ["softwareInput"]=>
//  string(7) "firefox"
//  ["versionInput"]=>
//  string(7) "5345345"
//  ["downloadInput"]=>
//  string(6) "453543"
//  ["releasedInput"]=>
//  string(10) "0555-05-05"
//  ["addButton"]=>
//  string(14) "AddNewDownload"
//}

//INSERT INTO versions (int_id, app_id, version, released, url) VALUES ('2', '3', '534534', '534543', '543345435');

if (isset($_POST["addButton"])) {
    if ($_POST["addButton"] == "AddNewDownload") {
        $database->query("INSERT INTO versions (app_id, version, released, url) VALUES (?,?,?,?)",
            [$_POST["softwareInput"], $_POST["versionInput"], $_POST["releasedInput"], $_POST["downloadInput"]]);
    }
}

$twig = new Templating();

$software = $database->fetchArray($database->query("SELECT * FROM software ORDER BY int_id ASC"));
$versions = $database->fetchArray($database->query("SELECT * FROM versions inner join software on versions.app_id = software.app_id ORDER BY versions.int_id DESC"));

echo $twig->render('index.twig', [
    'software' => $software,
    'versions' => $versions,
]);