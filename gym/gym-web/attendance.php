<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gym Attendance Tracker</title>
    <style>
        :root {
            --black: #121212;
            --white: #f5f5f5;
            --orange: #ff6b00;
            --light-orange: #ff8c33;
            --dark-gray: #333;
            --light-gray: #e0e0e0;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--black);
            color: var(--white);
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        header {
            background-color: var(--black);
            color: var(--white);
            text-align: center;
            padding: 1.5rem;
            border-bottom: 3px solid var(--orange);
        }
        
        h1 {
            margin: 0;
            font-size: 2rem;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1.5rem;
            flex: 1;
        }
        
        .calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 8px;
            margin-bottom: 2rem;
        }
        
        .month-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }
        
        .month-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--orange);
        }
        
        .nav-button {
            background-color: var(--dark-gray);
            color: var(--white);
            border: none;
            border-radius: 4px;
            padding: 8px 16px;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        
        .nav-button:hover {
            background-color: var(--orange);
        }
        
        .weekday {
            text-align: center;
            font-weight: bold;
            padding: 8px;
            background-color: var(--dark-gray);
            border-radius: 4px;
        }
        
        .day {
            border-radius: 4px;
            height: 80px;
            background-color: var(--dark-gray);
            padding: 4px;
            position: relative;
            cursor: pointer;
            transition: transform 0.1s;
        }
        
        .day:hover {
            transform: scale(1.03);
        }
        
        .day-number {
            font-size: 0.9rem;
            position: absolute;
            top: 4px;
            left: 8px;
        }
        
        .attended {
            background-color: var(--light-orange);
            color: var(--black);
        }
        
        .streak-display {
            margin: 1rem 0;
            padding: 1rem;
            background-color: var(--dark-gray);
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
        }
        
        .streak-box {
            text-align: center;
            flex: 1;
            padding: 1rem;
        }
        
        .streak-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: var(--orange);
        }
        
        .streak-label {
            font-size: 0.9rem;
            color: var(--light-gray);
        }
        
        .today {
            border: 2px solid var(--orange);
        }
        
        .other-month {
            opacity: 0.4;
        }
        
        footer {
            text-align: center;
            padding: 1rem;
            background-color: var(--black);
            border-top: 1px solid var(--dark-gray);
            font-size: 0.9rem;
            color: var(--light-gray);
        }
        
        @media (max-width: 768px) {
            .calendar {
                gap: 4px;
            }
            
            .day {
                height: 60px;
            }
        }
        
        @media (max-width: 480px) {
            .weekday {
                font-size: 0.8rem;
            }
            
            .day {
                height: 50px;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>GYM ATTENDANCE TRACKER</h1>
    </header>
    
    <div class="container">
        <div class="streak-display">
            <div class="streak-box">
                <div class="streak-number" id="current-streak">0</div>
                <div class="streak-label">CURRENT STREAK</div>
            </div>
            <div class="streak-box">
                <div class="streak-number" id="monthly-total">0</div>
                <div class="streak-label">MONTHLY TOTAL</div>
            </div>
            <div class="streak-box">
                <div class="streak-number" id="longest-streak">0</div>
                <div class="streak-label">LONGEST STREAK</div>
            </div>
        </div>
        
        <div class="month-header">
            <button class="nav-button" id="prev-month">&lt; Previous</button>
            <div class="month-title" id="month-year">March 2025</div>
            <button class="nav-button" id="next-month">Next &gt;</button>
        </div>
        
        <div class="calendar" id="calendar-grid">
            <!-- Calendar will be generated here by JavaScript -->
        </div>
    </div>
    
    <footer>
        Click on a day to mark your attendance. Keep up the good work!
    </footer>

    <script>
        // Store attendance data in localStorage
        let attendanceData = JSON.parse(localStorage.getItem('gymAttendance')) || {};
        
        // Variables to track current view
        let currentDate = new Date();
        let currentMonth = currentDate.getMonth();
        let currentYear = currentDate.getFullYear();
        
        // Initialize the calendar
        function initCalendar() {
            renderCalendar();
            updateStats();
            
            // Set up event listeners
            document.getElementById('prev-month').addEventListener('click', () => {
                currentMonth--;
                if (currentMonth < 0) {
                    currentMonth = 11;
                    currentYear--;
                }
                renderCalendar();
            });
            
            document.getElementById('next-month').addEventListener('click', () => {
                currentMonth++;
                if (currentMonth > 11) {
                    currentMonth = 0;
                    currentYear++;
                }
                renderCalendar();
            });
        }
        
        // Render the calendar grid
        function renderCalendar() {
            const calendarGrid = document.getElementById('calendar-grid');
            calendarGrid.innerHTML = '';
            
            // Add weekday headers
            const weekdays = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
            weekdays.forEach(day => {
                const weekdayEl = document.createElement('div');
                weekdayEl.className = 'weekday';
                weekdayEl.textContent = day;
                calendarGrid.appendChild(weekdayEl);
            });
            
            // Set month title
            const monthNames = [
                'January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'
            ];
            document.getElementById('month-year').textContent = `${monthNames[currentMonth]} ${currentYear}`;
            
            // Get first day of month and number of days
            const firstDayOfMonth = new Date(currentYear, currentMonth, 1).getDay();
            const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
            
            // Get last few days of previous month
            const daysInPrevMonth = new Date(currentYear, currentMonth, 0).getDate();
            
            // Add days from previous month
            for (let i = firstDayOfMonth - 1; i >= 0; i--) {
                const day = daysInPrevMonth - i;
                let prevMonth = currentMonth - 1;
                let prevYear = currentYear;
                
                if (prevMonth < 0) {
                    prevMonth = 11;
                    prevYear--;
                }
                
                const dateStr = `${prevYear}-${String(prevMonth + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                addDayElement(day, dateStr, true);
            }
            
            // Add days of current month
            for (let day = 1; day <= daysInMonth; day++) {
                const dateStr = `${currentYear}-${String(currentMonth + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                addDayElement(day, dateStr, false);
            }
            
            // Calculate needed days from next month
            const totalCells = Math.ceil((firstDayOfMonth + daysInMonth) / 7) * 7;
            const nextMonthDays = totalCells - (firstDayOfMonth + daysInMonth);
            
            // Add days from next month
            for (let day = 1; day <= nextMonthDays; day++) {
                let nextMonth = currentMonth + 1;
                let nextYear = currentYear;
                
                if (nextMonth > 11) {
                    nextMonth = 0;
                    nextYear++;
                }
                
                const dateStr = `${nextYear}-${String(nextMonth + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                addDayElement(day, dateStr, true);
            }
        }
        
        // Add a day element to the calendar
        function addDayElement(day, dateStr, isOtherMonth) {
            const calendarGrid = document.getElementById('calendar-grid');
            const dayEl = document.createElement('div');
            dayEl.className = 'day';
            
            if (isOtherMonth) {
                dayEl.classList.add('other-month');
            }
            
            // Check if this is today
            const today = new Date();
            const todayStr = `${today.getFullYear()}-${String(today.getMonth() + 1).padStart(2, '0')}-${String(today.getDate()).padStart(2, '0')}`;
            
            if (dateStr === todayStr) {
                dayEl.classList.add('today');
            }
            
            // Check if attended
            if (attendanceData[dateStr]) {
                dayEl.classList.add('attended');
            }
            
            const dayNumber = document.createElement('div');
            dayNumber.className = 'day-number';
            dayNumber.textContent = day;
            dayEl.appendChild(dayNumber);
            
            // Add click event
            dayEl.addEventListener('click', () => {
                toggleAttendance(dateStr, dayEl);
            });
            
            calendarGrid.appendChild(dayEl);
        }
        
        // Toggle attendance for a day
        function toggleAttendance(dateStr, dayEl) {
            if (attendanceData[dateStr]) {
                delete attendanceData[dateStr];
                dayEl.classList.remove('attended');
            } else {
                attendanceData[dateStr] = true;
                dayEl.classList.add('attended');
            }
            
            // Save to localStorage
            localStorage.setItem('gymAttendance', JSON.stringify(attendanceData));
            
            // Update statistics
            updateStats();
        }
        
        // Update attendance statistics
        function updateStats() {
            const today = new Date();
            
            // Calculate current streak
            let currentStreak = 0;
            let checkDate = new Date(today);
            
            // Check backwards from today
            while (true) {
                const dateStr = `${checkDate.getFullYear()}-${String(checkDate.getMonth() + 1).padStart(2, '0')}-${String(checkDate.getDate()).padStart(2, '0')}`;
                
                if (attendanceData[dateStr]) {
                    currentStreak++;
                    checkDate.setDate(checkDate.getDate() - 1);
                } else {
                    break;
                }
            }
            
            // Calculate longest streak
            let longestStreak = 0;
            let currentRun = 0;
            
            // Get all dates and sort them
            const dates = Object.keys(attendanceData).sort();
            
            if (dates.length > 0) {
                let prevDate = null;
                
                for (const dateStr of dates) {
                    const currentDate = new Date(dateStr);
                    
                    if (prevDate) {
                        const timeDiff = currentDate - prevDate;
                        const daysDiff = Math.floor(timeDiff / (1000 * 60 * 60 * 24));
                        
                        if (daysDiff === 1) {
                            currentRun++;
                        } else {
                            currentRun = 1;
                        }
                    } else {
                        currentRun = 1;
                    }
                    
                    if (currentRun > longestStreak) {
                        longestStreak = currentRun;
                    }
                    
                    prevDate = currentDate;
                }
            }
            
            // Calculate monthly total
            const currentViewMonthStart = new Date(currentYear, currentMonth, 1);
            const currentViewMonthEnd = new Date(currentYear, currentMonth + 1, 0);
            
            let monthlyTotal = 0;
            
            for (const dateStr in attendanceData) {
                const date = new Date(dateStr);
                if (date >= currentViewMonthStart && date <= currentViewMonthEnd) {
                    monthlyTotal++;
                }
            }
            
            // Update the display
            document.getElementById('current-streak').textContent = currentStreak;
            document.getElementById('longest-streak').textContent = longestStreak;
            document.getElementById('monthly-total').textContent = monthlyTotal;
        }
        
        // Initialize on page load
        document.addEventListener('DOMContentLoaded', initCalendar);
    </script>
</body>
</html>