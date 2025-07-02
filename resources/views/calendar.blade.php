<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Ügyfélfogadási Naptár</title>

    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/main.min.css" rel="stylesheet">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }
        #calendar {
            max-width: 900px;
            margin: 0 auto;
        }
    </style>
</head>
<body>

    <h1>Ügyfélfogadási Naptár</h1>

    <div id="calendar"></div>

    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/main.min.js"></script>
    <!-- Ha kell magyar nyelv -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/locales-all.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'hu',
                selectable: true,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                select: function(info) {
                    var nev = prompt("Kérem az ügyfél nevét:");
                    if (nev) {
                        // Ide jön majd az Ajax hívás
                        alert("Foglalás mentése: " + nev + " - " + info.startStr + " - " + info.endStr);
                    }
                },
                events: '/events'  // Ezt majd külön beállítjuk a backendben
            });

            calendar.render();
        });
    </script>

</body>
</html>