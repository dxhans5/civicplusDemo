<?php

/** I would normally rely on an autoloader library to do this sort of thing **/
require_once('./vendor/autoload.php');
require_once('./CivicPlus/configuration.php');
require_once('./CivicPlus/Classes/authentication.class.php');
require_once('./CivicPlus/Classes/events.class.php');

use CivicPlus\Configuration;
use CivicPlus\Classes\Authentication;
use CivicPlus\Classes\Events;

$authenticationClass = Authentication::getInstance();
$authenticationClass->getAccessToken(Configuration::HcmsClientId, Configuration::HcmsClientSecret);
$eventClass = Events::getInstance();
$err = null;

if (!empty($_POST)) {
    try {
        $eventClass->addEvent($_POST['title'], $_POST['description'], $_POST['startDate'], $_POST['endDate']);
    } catch (Exception $e) {
        $err = $e->getMessage();
    }
}

$events = json_decode($eventClass->getEvents())->items;

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>CivicPlus Interview Demo</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
        crossorigin="anonymous">
</head>

<body>
    <div class='container'>
        <div class='row mt-4'>
            <div class='col-sm-12'>
                <h5>Events</h5>
                <hr/>
                <?php 
                    if(!empty($err)) {
                        echo "<div class='alert alert-danger' role='alert'>$err</div>";
                    }
                ?>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-sm-4">
                <form method="POST">

                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title" name="title">
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description" rows="3" name="description"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="startDate">Start Date</label>
                                <input type="text" class="form-control" id="startDate" placeholder="YYYY-MM-DD HH:MM:SS" name="startDate">
                            </div>
                            <div class="form-group">
                                <label for="endDate">End Date</label>
                                <input type="text" class="form-control" id="endDate" placeholder="YYYY-MM-DD HH:MM:SS" name="endDate">
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <div class="col-sm-8">
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Description</th>
                        <th scope="col">Start</th>
                        <th scope="col">End</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            foreach($events as $event) {
                                echo("<tr>");
                                echo("<th scope='row'>$event->id</th>");
                                echo("<td>$event->title</td>");
                                echo("<td>$event->description</td>");
                                echo("<td>$event->startDate</td>");
                                echo("<td>$event->endDate</td>");
                                echo("</tr>");
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- Scripts -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
</body>

</html>