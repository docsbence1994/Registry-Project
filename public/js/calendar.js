document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'hu',
        selectable: true,
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        select: function(info) {
            const clientName = prompt('Add meg az ügyfél nevét:');
            if (clientName) {
                fetch('/customer/store', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        name: clientName,
                        start: info.startStr,
                        end: info.endStr
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        alert('Foglalás sikeresen mentve!');
                        calendar.refetchEvents();
                    } else {
                        alert('Hiba történt, próbáld újra!');
                    }
                });
            }
            calendar.unselect();
        },
        events: '/customer/events'
    });

    calendar.render();
});
