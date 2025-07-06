document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'hu',
        selectable: true,
        displayEventTime: false,
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        select: function(info) {
            handleSelect(info, calendar);
        },
        events: '/customer/events'
    });

    calendar.render();
});

function handleSelect(info, calendar) {
    const clientName = prompt('Add meg az ügyfél nevét:');
    if (clientName) {

        if (document.getElementById('repeatTypeSelect')) {
            return;
        }

        const form = document.createElement('div');
        form.innerHTML = `
            <label>Ismétlődés:</label>
            <select id="repeatTypeSelect">
                <option value="none">Nincs</option>
                <option value="weekly">Minden héten</option>
                <option value="even_weeks">Páros hetek</option>
                <option value="odd_weeks">Páratlan hetek</option>
            </select>
            <br><br>
            <button id="saveBooking">Mentés</button>
            <button id="cancelBooking">Mégse</button>
        `;

        form.style.position = 'fixed';
        form.style.top = '50%';
        form.style.left = '50%';
        form.style.transform = 'translate(-50%, -50%)';
        form.style.background = '#fff';
        form.style.padding = '20px';
        form.style.boxShadow = '0 0 10px rgba(0,0,0,0.3)';
        form.style.zIndex = '9999';

        document.body.appendChild(form);

        document.getElementById('saveBooking').addEventListener('click', function() {
            const repeatType = document.getElementById('repeatTypeSelect').value;

            const startDate = new Date(info.startStr);
            const weekday = startDate.getDay();
            const time_of_day = startDate.toTimeString().slice(0, 8);

            fetch('/customer/store', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    name: clientName,
                    start_time: info.startStr,
                    end_time: info.endStr,
                    repeat_type: repeatType,
                    weekday: weekday,
                    time_of_day: time_of_day
                })
            })
            .then(response => {
                if (response.status === 409) {
                    alert('Már van foglalás ebben az időszakban!');
                    document.body.removeChild(form);
                    calendar.unselect();
                    return null;
                }
                return response.json();
            })
            .then(data => {
                if (!data) return;

                if (data.success) {
                    alert('Foglalás sikeresen mentve!');
                    calendar.refetchEvents();
                } else {
                    alert('Hiba történt, próbáld újra!');
                }

                document.body.removeChild(form);
                calendar.unselect();
            })
            .catch(error => {
                alert('Technikai hiba történt.');
                document.body.removeChild(form);
                calendar.unselect();
            });
        });

        document.getElementById('cancelBooking').addEventListener('click', function() {
            document.body.removeChild(form);
            calendar.unselect();
        });

    } else {
        calendar.unselect();
    }
}
