<?php
include "database.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login2.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Gym Timetable">
    <meta name="keywords" content="Gym, fitness, timetable, schedule">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gym | Timetable</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,500,600,700,800,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Oswald:300,400,500,600,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- Css Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/flaticon.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/barfiller.css" type="text/css">
    <link rel="stylesheet" href="css/magnific-popup.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <style>
        :root {
            --primary-color: #ff6600;
            --accent-color: #ff6600;
            --dark-bg: #000000;
            --card-bg: #111111;
            --text-color: #ffffff;
            --border-color: #333;
            --hover-color: #ff8533;
            --light-text: #f5f5f5;
        }

        body {
            background-color: var(--dark-bg);
            color: var(--text-color);
        }

        .header-section {
            background-color: rgba(0, 0, 0, 0.95);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .logo img {
            max-height: 60px;
        }

        .nav-menu ul li a {
            font-family: 'Oswald', sans-serif;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            color: var(--light-text);
        }

        .nav-menu ul li a:hover {
            color: var(--primary-color);
        }

        .nav-menu ul li.active a {
            color: var(--primary-color);
            font-weight: 600;
        }

        .section-title {
            margin-bottom: 40px;
            text-align: center;
        }

        .section-title span {
            color: var(--primary-color);
            font-size: 18px;
            font-weight: 600;
            display: block;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .section-title h2 {
            font-size: 42px;
            font-weight: 700;
            color: var(--text-color);
            font-family: 'Oswald', sans-serif;
            margin-bottom: 15px;
            position: relative;
            display: inline-block;
        }

        .section-title h2:after {
            content: '';
            position: absolute;
            left: 50%;
            bottom: -10px;
            width: 80px;
            height: 3px;
            background: var(--accent-color);
            transform: translateX(-50%);
        }

        .class-timetable-section {
            padding: 100px 0;
            background: var(--dark-bg);
        }

        .class-timetable {
            position: relative;
            padding: 30px;
            background: var(--card-bg);
            border-radius: 15px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.3);
        }

        .class-timetable table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 10px;
            overflow: hidden;
        }

        .class-timetable th, 
        .class-timetable td {
            padding: 15px;
            text-align: center;
            border: 1px solid var(--border-color);
            position: relative;
        }

        .class-timetable th {
            background: #111;
            color: var(--primary-color);
            font-family: 'Oswald', sans-serif;
            text-transform: uppercase;
            font-size: 16px;
            font-weight: 600;
            letter-spacing: 1px;
        }

        .class-timetable tr:nth-child(even) {
            background-color: rgba(34, 34, 34, 0.4);
        }

        .class-timetable td select, 
        .class-timetable td input {
            width: 100%;
            padding: 12px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            background-color: rgba(0, 0, 0, 0.3);
            color: var(--text-color);
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .class-timetable td select:focus, 
        .class-timetable td input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 5px rgba(255, 102, 0, 0.3);
        }

        .class-timetable td select option {
            background-color: #222;
            color: white;
        }

        .button-container {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 30px;
        }

        .btn-custom {
            padding: 14px 24px;
            background: var(--accent-color);
            color: var(--text-color);
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-custom i {
            margin-right: 8px;
        }

        .btn-custom:hover {
            background: var(--hover-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(255, 102, 0, 0.3);
        }

        .btn-save {
            background: #ffffff;
            color: #000000;
        }

        .btn-save:hover {
            background: #f0f0f0;
            box-shadow: 0 4px 15px rgba(255, 255, 255, 0.2);
        }

        .btn-delete {
            margin-top: 10px;
            padding: 8px;
            background: #ff3333;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            opacity: 0.7;
            transition: opacity 0.3s;
        }

        .btn-delete:hover {
            opacity: 1;
        }

        .workout-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            margin-top: 8px;
            background-color: var(--primary-color);
            color: white;
        }

        @media only screen and (max-width: 768px) {
            .class-timetable {
                padding: 15px;
                overflow-x: auto;
            }
            
            .class-timetable table {
                min-width: 800px;
            }
            
            .section-title h2 {
                font-size: 32px;
            }
            
            .btn-custom {
                padding: 12px 20px;
                font-size: 14px;
            }
        }

        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        tr {
            animation: fadeIn 0.3s ease-in-out;
        }

        /* Tips Section */
        .tips-section {
            margin-top: 50px;
            padding: 30px;
            background: var(--card-bg);
            border-radius: 15px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.3);
        }

        .tips-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .tips-header i {
            font-size: 24px;
            color: var(--primary-color);
            margin-right: 10px;
        }

        .tips-header h3 {
            font-family: 'Oswald', sans-serif;
            font-size: 24px;
            color: var(--text-color);
            margin: 0;
        }

        .tips-content {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .tip-card {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            padding: 20px;
            transition: all 0.3s ease;
            border: 1px solid #222;
        }

        .tip-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            border-color: var(--primary-color);
        }

        .tip-card h4 {
            color: var(--primary-color);
            font-size: 18px;
            margin-bottom: 10px;
        }

        .tip-card p {
            color: #ccc;
            font-size: 14px;
            line-height: 1.6;
        }
    </style>
</head>

<body>
    <!-- Header Section Begin -->
    <header class="header-section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3">
                    <div class="logo">
                        <a href="./index.php">
                            <img src="img/logo.png" alt="Gym Logo">
                        </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <nav class="nav-menu">
                        <ul>
                            <li><a href="./index.php">Home</a></li>
                            <li class="active"><a href="./timetable.html">Timetable</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
            <div class="canvas-open">
                <i class="fa fa-bars"></i>
            </div>
        </div>
    </header>
    <!-- Header End -->

    <!-- Timetable Section Begin -->
    <section class="class-timetable-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <span>Plan Your Week</span>
                        <h2>Customize Your Workout Schedule</h2>
                        <p>Create a balanced fitness routine tailored to your goals and availability.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="class-timetable">
                        <table>
                            <thead>
                                <tr>
                                    <th>Time</th>
                                    <th>Monday</th>
                                    <th>Tuesday</th>
                                    <th>Wednesday</th>
                                    <th>Thursday</th>
                                    <th>Friday</th>
                                    <th>Saturday</th>
                                    <th>Sunday</th>
                                </tr>
                            </thead>
                            <tbody id="timetable-body">
                                <!-- Default first row -->
                                <tr>
                                    <td class="class-time"><input type="time" value="06:00"></td>
                                    <td><select>
                                        <option value="">Select</option>
                                        <option value="boxing">Boxing</option>
                                        <option value="yoga">Yoga</option>
                                        <option value="cardio">Cardio</option>
                                        <option value="fitness">Fitness</option>
                                        <option value="weight_loss">Weight Loss</option>
                                        <option value="Rest Day">Rest Day</option>
                                    </select></td>
                                    <td><select>
                                        <option value="">Select</option>
                                        <option value="boxing">Boxing</option>
                                        <option value="yoga">Yoga</option>
                                        <option value="cardio">Cardio</option>
                                        <option value="fitness">Fitness</option>
                                        <option value="weight_loss">Weight Loss</option>
                                        <option value="Rest Day">Rest Day</option>
                                    </select></td>
                                    <td><select>
                                        <option value="">Select</option>
                                        <option value="boxing">Boxing</option>
                                        <option value="yoga">Yoga</option>
                                        <option value="cardio">Cardio</option>
                                        <option value="fitness">Fitness</option>
                                        <option value="weight_loss">Weight Loss</option>
                                        <option value="Rest Day">Rest Day</option>
                                    </select></td>
                                    <td><select>
                                        <option value="">Select</option>
                                        <option value="boxing">Boxing</option>
                                        <option value="yoga">Yoga</option>
                                        <option value="cardio">Cardio</option>
                                        <option value="fitness">Fitness</option>
                                        <option value="weight_loss">Weight Loss</option>
                                        <option value="Rest Day">Rest Day</option>
                                    </select></td>
                                    <td><select>
                                        <option value="">Select</option>
                                        <option value="boxing">Boxing</option>
                                        <option value="yoga">Yoga</option>
                                        <option value="cardio">Cardio</option>
                                        <option value="fitness">Fitness</option>
                                        <option value="weight_loss">Weight Loss</option>
                                        <option value="Rest Day">Rest Day</option>
                                    </select></td>
                                    <td><select>
                                        <option value="">Select</option>
                                        <option value="boxing">Boxing</option>
                                        <option value="yoga">Yoga</option>
                                        <option value="cardio">Cardio</option>
                                        <option value="fitness">Fitness</option>
                                        <option value="weight_loss">Weight Loss</option>
                                        <option value="Rest Day">Rest Day</option>
                                    </select></td>
                                    <td><select>
                                        <option value="">Select</option>
                                        <option value="boxing">Boxing</option>
                                        <option value="yoga">Yoga</option>
                                        <option value="cardio">Cardio</option>
                                        <option value="fitness">Fitness</option>
                                        <option value="weight_loss">Weight Loss</option>
                                        <option value="Rest Day">Rest Day</option>
                                    </select></td>
                                    <input type="hidden" id="uname" value="<?php echo htmlspecialchars($_SESSION['username']); ?>">
                                </tr>
                            </tbody>
                        </table>
                        <div class="button-container">
                            <button onclick="addRow()" class="btn-custom">
                                <i class="fas fa-plus"></i> Add Time Slot
                            </button>
                            <button onclick="saveSchedule()" class="btn-custom btn-save">
                                <i class="fas fa-save"></i> Save Schedule
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tips Section -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="tips-section">
                        <div class="tips-header">
                            <i class="fas fa-lightbulb"></i>
                            <h3>Workout Planning Tips</h3>
                        </div>
                        <div class="tips-content">
                            <div class="tip-card">
                                <h4>Balanced Training</h4>
                                <p>Mix strength, cardio, and flexibility training throughout your week for optimal results. Allow 48 hours of recovery between training the same muscle groups.</p>
                            </div>
                            <div class="tip-card">
                                <h4>Strategic Timing</h4>
                                <p>Schedule high-intensity workouts when your energy levels are naturally higher. Most people perform better in the late afternoon when body temperature is optimal.</p>
                            </div>
                            <div class="tip-card">
                                <h4>Recovery Days</h4>
                                <p>Include at least 1-2 rest days per week. Consider active recovery like yoga or light walking on these days to maintain mobility.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Timetable Section End -->

    <!-- Js Plugins -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/masonry.pkgd.min.js"></script>
    <script src="js/jquery.barfiller.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>
    <script>
        function addRow() {
            const tbody = document.getElementById('timetable-body');
            const row = document.createElement('tr');
            
            // Create time cell with delete button
            const timeCell = document.createElement('td');
            timeCell.className = 'class-time';
            
            const timeInput = document.createElement('input');
            timeInput.type = 'time';
            
            const deleteBtn = document.createElement('button');
            deleteBtn.className = 'btn-delete';
            deleteBtn.innerHTML = '<i class="fas fa-trash"></i>';
            deleteBtn.onclick = function() {
                tbody.removeChild(row);
            };
            
            timeCell.appendChild(timeInput);
            timeCell.appendChild(deleteBtn);
            row.appendChild(timeCell);
            
            // Create day cells with select dropdowns
            for (let i = 0; i < 7; i++) {
                const cell = document.createElement('td');
                const select = document.createElement('select');
                
                select.innerHTML = `
                    <option value="">Select</option>
                    <option value="boxing">Boxing</option>
                    <option value="yoga">Yoga</option>
                    <option value="cardio">Cardio</option>
                    <option value="fitness">Fitness</option>
                    <option value="weight_loss">Weight Loss</option>
                    <option value="Rest Day">Rest Day</option>
                `;
                
                select.onchange = function() {
                    updateWorkoutBadge(this);
                };
                
                cell.appendChild(select);
                row.appendChild(cell);
            }
            
            tbody.appendChild(row);
        }
        
        function updateWorkoutBadge(select) {
            // Remove existing badge if any
            const parentCell = select.parentElement;
            const existingBadge = parentCell.querySelector('.workout-badge');
            if (existingBadge) {
                parentCell.removeChild(existingBadge);
            }
            
            // Add new badge if a workout is selected
            if (select.value) {
                const badge = document.createElement('div');
                badge.className = 'workout-badge';
                badge.textContent = select.options[select.selectedIndex].text;
                parentCell.appendChild(badge);
            }
        }
        
        function saveSchedule() {
            const tbody = document.getElementById('timetable-body');
            const rows = tbody.getElementsByTagName('tr');
            const scheduleData = [];

            const uname = document.getElementById('uname').value;
        
            for (let row of rows) {
                const time = row.querySelector('.class-time input[type="time"]').value;
                const dayData = Array.from(row.querySelectorAll('td:not(.class-time) select')).map(select => select.value);
                
                scheduleData.push({
                    uname: uname, 
                    time: time,
                    monday: dayData[0],
                    tuesday: dayData[1],
                    wednesday: dayData[2],
                    thursday: dayData[3],
                    friday: dayData[4],
                    saturday: dayData[5],
                    sunday: dayData[6]
                });
            }
        
            // Send the data to the PHP script
            fetch('save_schedule.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(scheduleData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert('Schedule saved successfully!');
                } else {
                    alert('Error saving schedule: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
        
        // Initialize the workout badges for any pre-selected options
        document.addEventListener('DOMContentLoaded', function() {
            const selects = document.querySelectorAll('.class-timetable select');
            selects.forEach(select => {
                if (select.value) {
                    updateWorkoutBadge(select);
                }
                
                // Add change event listener
                select.addEventListener('change', function() {
                    updateWorkoutBadge(this);
                });
            });
        });
    </script>
</body>

</html>