document.addEventListener('DOMContentLoaded', function() {
    // Initialize calendars
    initCalendar('data_inizio', 'calendar-start');
    initCalendar('data_fine', 'calendar-end');
    
    // Function to initialize a calendar
    function initCalendar(inputId, calendarId) {
        const dateInput = document.getElementById(inputId);
        const calendarContainer = document.getElementById(calendarId);
        
        // Create calendar structure
        createCalendarStructure(calendarContainer);
        
        // Add event listeners
        dateInput.addEventListener('focus', function(e) {
            // Prevent default date picker from showing
            e.target.blur();
            calendarContainer.classList.add('active');
            updateCalendar(calendarContainer, dateInput.value);
        });
        
        // Add click event to the calendar icon
        const calendarIcon = dateInput.parentElement.querySelector('i');
        if (calendarIcon) {
            calendarIcon.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                calendarContainer.classList.add('active');
                updateCalendar(calendarContainer, dateInput.value);
            });
        }
        
        // Close calendar when clicking outside
        document.addEventListener('click', function(event) {
            if (!calendarContainer.contains(event.target) && 
                event.target !== dateInput && 
                event.target !== calendarIcon) {
                calendarContainer.classList.remove('active');
            }
        });
        
        // Prevent calendar from closing when clicking inside it
        calendarContainer.addEventListener('click', function(event) {
            event.stopPropagation();
        });
    }
    
    // Function to create calendar structure
    function createCalendarStructure(container) {
        // Clear container
        container.innerHTML = '';
        
        // Create header
        const header = document.createElement('div');
        header.className = 'calendar-header';
        
        const prevBtn = document.createElement('button');
        prevBtn.className = 'calendar-nav-btn';
        prevBtn.innerHTML = '<i class="fas fa-chevron-left"></i>';
        prevBtn.addEventListener('click', function() {
            navigateMonth(container, -1);
        });
        
        const nextBtn = document.createElement('button');
        nextBtn.className = 'calendar-nav-btn';
        nextBtn.innerHTML = '<i class="fas fa-chevron-right"></i>';
        nextBtn.addEventListener('click', function() {
            navigateMonth(container, 1);
        });
        
        const monthYear = document.createElement('div');
        monthYear.className = 'calendar-month-year';
        
        header.appendChild(prevBtn);
        header.appendChild(monthYear);
        header.appendChild(nextBtn);
        
        // Create days of week header
        const daysHeader = document.createElement('div');
        daysHeader.className = 'calendar-days-header';
        
        const days = ['Dom', 'Lun', 'Mar', 'Mer', 'Gio', 'Ven', 'Sab'];
        days.forEach(day => {
            const dayElement = document.createElement('div');
            dayElement.className = 'calendar-day-name';
            dayElement.textContent = day;
            daysHeader.appendChild(dayElement);
        });
        
        // Create days grid
        const daysGrid = document.createElement('div');
        daysGrid.className = 'calendar-days-grid';
        
        // Add all elements to container
        container.appendChild(header);
        container.appendChild(daysHeader);
        container.appendChild(daysGrid);
    }
    
    // Function to update calendar with current month
    function updateCalendar(container, dateString) {
        const monthYearElement = container.querySelector('.calendar-month-year');
        const daysGrid = container.querySelector('.calendar-days-grid');
        
        // Parse date or use current date
        let date;
        if (dateString) {
            date = new Date(dateString);
        } else {
            date = new Date();
        }
        
        // Update month and year display
        const monthNames = ['Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 
                           'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre'];
        monthYearElement.textContent = `${monthNames[date.getMonth()]} ${date.getFullYear()}`;
        
        // Store current month and year in container for navigation
        container.dataset.month = date.getMonth();
        container.dataset.year = date.getFullYear();
        
        // Clear days grid
        daysGrid.innerHTML = '';
        
        // Get first day of month and number of days
        const firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
        const lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
        const startingDay = firstDay.getDay();
        const totalDays = lastDay.getDate();
        
        // Add empty cells for days before the first day of the month
        for (let i = 0; i < startingDay; i++) {
            const emptyCell = document.createElement('div');
            emptyCell.className = 'calendar-day empty';
            daysGrid.appendChild(emptyCell);
        }
        
        // Add cells for each day of the month
        for (let i = 1; i <= totalDays; i++) {
            const dayCell = document.createElement('div');
            dayCell.className = 'calendar-day';
            dayCell.textContent = i;
            
            // Check if this is today
            const today = new Date();
            if (i === today.getDate() && 
                date.getMonth() === today.getMonth() && 
                date.getFullYear() === today.getFullYear()) {
                dayCell.classList.add('today');
            }
            
            // Add click event to select date
            dayCell.addEventListener('click', function() {
                const selectedDate = new Date(date.getFullYear(), date.getMonth(), i);
                const formattedDate = formatDate(selectedDate);
                
                // Find the associated input
                const inputId = container.id === 'calendar-start' ? 'data_inizio' : 'data_fine';
                const dateInput = document.getElementById(inputId);
                
                // Update input value
                dateInput.value = formattedDate;
                
                // Close calendar
                container.classList.remove('active');
                
                // Highlight selected date
                highlightSelectedDate(container, selectedDate);
            });
            
            daysGrid.appendChild(dayCell);
        }
    }
    
    // Function to navigate between months
    function navigateMonth(container, direction) {
        let month = parseInt(container.dataset.month);
        let year = parseInt(container.dataset.year);
        
        month += direction;
        
        if (month > 11) {
            month = 0;
            year++;
        } else if (month < 0) {
            month = 11;
            year--;
        }
        
        // Update container data
        container.dataset.month = month;
        container.dataset.year = year;
        
        // Create a date object with the new month and year
        const date = new Date(year, month, 1);
        
        // Update the calendar
        updateCalendar(container, date);
    }
    
    // Function to format date as YYYY-MM-DD
    function formatDate(date) {
        const year = date.getFullYear();
        let month = date.getMonth() + 1;
        let day = date.getDate();
        
        // Add leading zeros
        month = month < 10 ? '0' + month : month;
        day = day < 10 ? '0' + day : day;
        
        return `${year}-${month}-${day}`;
    }
    
    // Function to highlight selected date
    function highlightSelectedDate(container, selectedDate) {
        const days = container.querySelectorAll('.calendar-day');
        
        days.forEach(day => {
            day.classList.remove('selected');
            
            if (day.textContent == selectedDate.getDate()) {
                day.classList.add('selected');
            }
        });
    }
}); 