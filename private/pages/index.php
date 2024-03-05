<?php
namespace BluffingoUpdaterSite;

global $database;

use Site\Templating;

if (isset($_POST["addButton"])) {
    if ($_POST["addButton"] == "AddNewDownload") {
        $database->query("INSERT INTO versions (app_id, version, released, url) VALUES (?,?,?,?)",
            [$_POST["softwareInput"], $_POST["versionInput"], $_POST["releasedInput"], $_POST["downloadInput"]]);
    } elseif ($_POST["addButton"] == "AddNewApplication") {
        if ($database->fetch("SELECT * FROM software WHERE app_id = ?", [$_POST["internalIDInput"]]))
        {
            die("This ID has already been used.");
        }

        if ($database->fetch("SELECT * FROM software WHERE name = ?", [$_POST["appNameInput"]]))
        {
            die("This application has already been added.");
        }

        $database->query("INSERT INTO software (app_id, name, author) VALUES (?,?,?)",
            [$_POST["internalIDInput"], $_POST["appNameInput"], $_POST["publisherInput"]]);
    }
}

$twig = new Templating();

$software = $database->fetchArray($database->query("SELECT * FROM software ORDER BY int_id ASC"));
$versions = $database->fetchArray($database->query("SELECT * FROM versions inner join software on versions.app_id = software.app_id ORDER BY versions.int_id DESC"));

echo $twig->render('index.twig', [
    'software' => $software,
    'versions' => $versions,
]);