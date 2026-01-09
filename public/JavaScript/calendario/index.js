document.addEventListener("DOMContentLoaded", function () {
    const calendarDays = document.getElementById("calendarDays");
    const currentMonthDisplay = document.getElementById("currentMonthDisplay");
    const prevMonthBtn = document.getElementById("prevMonth");
    const nextMonthBtn = document.getElementById("nextMonth");
    const btnNewEvent = document.getElementById("btnNewEvent");

    let date = new Date();
    let currentYear = date.getFullYear();
    let currentMonth = date.getMonth();

    const months = [
        "Enero",
        "Febrero",
        "Marzo",
        "Abril",
        "Mayo",
        "Junio",
        "Julio",
        "Agosto",
        "Septiembre",
        "Octubre",
        "Noviembre",
        "Diciembre",
    ];

    const monthSelect = document.getElementById("monthSelect");
    const yearSelect = document.getElementById("yearSelect");

    function renderCalendar() {
        date.setDate(1);
        const firstDayIndex = date.getDay();
        const lastDay = new Date(currentYear, currentMonth + 1, 0).getDate();
        const lastDayIndex = new Date(
            currentYear,
            currentMonth + 1,
            0
        ).getDay();
        // const nextDays = 7 - lastDayIndex - 1;

        // Fix for Sunday start (0) or Monday start adaptation if needed.
        // Current Grid headers are Dom, Lun, Mar... so Sunday=0 is correct for 1st column.

        // Sync Dropdowns
        currentMonthDisplay.innerText = `${months[currentMonth]} ${currentYear}`;
        monthSelect.value = currentMonth;
        yearSelect.value = currentYear;

        let days = "";

        // Previous Month Days
        const prevLastDay = new Date(currentYear, currentMonth, 0).getDate();
        for (let x = firstDayIndex; x > 0; x--) {
            days += `<div class="day-cell prev-date"><span class="day-number">${
                prevLastDay - x + 1
            }</span></div>`;
        }

        // Current Month Days
        for (let i = 1; i <= lastDay; i++) {
            const isToday =
                i === new Date().getDate() &&
                currentMonth === new Date().getMonth() &&
                currentYear === new Date().getFullYear();

            // Mock random events visual
            let dots = "";
            if (i === 15)
                dots = `<div class="event-dots"><span class="dot academic"></span></div>`;
            if (i === 18)
                dots = `<div class="event-dots"><span class="dot meeting"></span></div>`;
            if (i === 20)
                dots = `<div class="event-dots"><span class="dot holiday"></span></div>`;
            if (i === 22)
                dots = `<div class="event-dots"><span class="dot exam"></span></div>`;
            if (i === 24)
                dots = `<div class="event-dots"><span class="dot holiday"></span></div>`;
            if (i === 26)
                dots = `<div class="event-dots"><span class="dot exam"></span></div>`;
            if (i === 30)
                dots = `<div class="event-dots"><span class="dot meeting"></span></div>`;

            days += `<div class="day-cell ${
                isToday ? "today" : ""
            }">${dots}<span class="day-number">${i}</span></div>`;
        }

        // Next Month Days
        // Fill remaining grid to ensure 6 rows (total 42 cells typically used in calendars) or just square it off
        const totalCellsSoFar = firstDayIndex + lastDay;
        const nextDays = 42 - totalCellsSoFar;

        for (let j = 1; j <= nextDays; j++) {
            days += `<div class="day-cell next-date"><span class="day-number">${j}</span></div>`;
        }

        calendarDays.innerHTML = days;
    }

    renderCalendar();

    // Dropdown Listeners
    monthSelect.addEventListener("change", (e) => {
        currentMonth = parseInt(e.target.value);
        date.setMonth(currentMonth);
        renderCalendar();
    });

    yearSelect.addEventListener("change", (e) => {
        currentYear = parseInt(e.target.value);
        date.setFullYear(currentYear);
        renderCalendar();
    });

    prevMonthBtn.addEventListener("click", () => {
        currentMonth--;
        if (currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
        }
        date.setFullYear(currentYear, currentMonth);
        renderCalendar();
    });

    nextMonthBtn.addEventListener("click", () => {
        currentMonth++;
        if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        }
        date.setFullYear(currentYear, currentMonth);
        renderCalendar();
    });

    btnNewEvent.addEventListener("click", () => {
        Swal.fire({
            title: "Nuevo Evento",
            text: "Funcionalidad de registro de evento en desarrollo",
            icon: "info",
            confirmButtonColor: "#e11d48",
        });
    });
});
