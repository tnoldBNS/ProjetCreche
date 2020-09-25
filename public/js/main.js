
document.addEventListener('DOMContentLoaded', () => {
    var calendarEl = document.getElementById('calendar-holder');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        defaultView: 'dayGridMonth',
        editable: true,
        firstDay: 1,
        locale: 'local',
        timeZone: 'Europe/paris',
        buttonText: {
        today: 'aujourd\'hui',
        month: 'mois',
        week: 'semaine',
        day: 'jour'
        },
        eventSources: [
            {
                url: "/fc-load-events",
                method: "POST",
                extraParams: {
                    filters: JSON.stringify({})
                },
                failure: () => {
                    // alert("There was an error while fetching FullCalendar!");
                },
            },
        ],
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay',
        },
        plugins: ['interaction', 'dayGrid', 'timeGrid'], // https://fullcalendar.io/docs/plugin-index
        timeZone: 'UTC',

        eventRender: function (info) {
            info.el.style.color = "black"
            info.el.style.border = "none"
            if (info.event.title == "Vacance")
                info.el.style.backgroundColor = "#F0F4DA"
            else if (info.event.title == "Maladie")
                info.el.style.backgroundColor = "#faa498"
            else if (info.event.title == "Autre")
                info.el.style.backgroundColor = "#95b6bd"
            info.el.innerHTML = info.event.extendedProps.person + " -> " + info.event.title
        },
        lang: 'fr'

    });
    calendar.render();
});
UIkit.slider(element, options);
UIkit.slider(element).show(index);


