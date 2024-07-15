<?php
require "connect.php";
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="image/admin.ico">
    <title>Calendar | Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
    <link rel="stylesheet" href="styles.css">
    <script src="scripts.js"></script>
</head>
<?php 
    $activePage = 'calendar'; 
    include 'nav.php';
    ?>
<body>
 
    <br />
    <br />
    <div class="container">
        <div id="calendar"></div>
    </div>
    <script>
    $(document).ready(function() {
        $('#calendar').fullCalendar({
            editable: true,
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            events: 'calendar_schedule.php',
            eventRender: function(event, element) {
                switch (event.title) {
                    case 'Wedding':
                        element.css('background-color', 'rgb(217 150 150)');
                        break;
                    case 'Baptism':
                        element.css('background-color', 'rgb(255 255 151)');
                        break;
                    case 'Sickcall':
                        element.css('background-color', 'rgb(246 135 235)');
                        break;
                    case 'Blessing':
                        element.css('background-color', 'rgb(184 184 246)');
                        break;
                    case 'Funeral':
                        element.css('background-color', '#f5daaabd');
                        break;
                    default:
                        element.css('background-color', 'rgb(148 230 148)');
                }
            }
        });
    });
    </script>
</body>

</html>

<style>
a.fc-day-grid-event.fc-h-event.fc-event.fc-start.fc-end.fc-draggable {
    border: none;
    font-size: 15px;
    border-radius: 20px;
    padding: 5px;
    margin: 3px 10px;
}

.container {
    width: 58%;
    height: 800px;
    background-color: white;
    margin: 2.2rem 6rem;
    box-shadow: 0 0 3rem rgba(0, 0, 0, 0.3);
    border-radius: 0.8rem;
    padding: 20px;
}
</style>

