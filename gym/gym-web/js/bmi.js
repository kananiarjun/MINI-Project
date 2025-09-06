<script>
        document.getElementById('bmiform').addEventListener('submit', function (event) {
    event.preventDefault(); // Prevent form submission

    // Clear previous highlights
    document.querySelectorAll('tr').forEach(row => row.classList.remove('highlight'));

    // Get form data
    const height = document.getElementById('height').value;
    const weight = document.getElementById('weight').value;

    // Validate inputs
    if (!height || !weight || height <= 0 || weight <= 0) {
        document.getElementById('bmiResult').innerHTML = "Please enter valid values.";
        return;
    }

    // Show the preloader
    document.getElementById('preloder').style.display = 'block';

    // Send data to PHP using fetch
    fetch('bmi.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `height=${height}&weight=${weight}`
    })
        .then(response => {
            document.getElementById('preloder').style.display = 'none'; // Hide preloader
            return response.json();
        })
        .then(data => {
            if (data.error) {
                document.getElementById('bmiResult').innerHTML = data.error;
            } else {
                // Display BMI result
                document.getElementById('bmiResult').innerHTML = `Your BMI is: ${data.bmi} (${data.category})`;

                // Highlight appropriate row
                if (data.category === 'Underweight') {
                    document.getElementById('underweight').classList.add('highlight');
                } else if (data.category === 'Normal') {
                    document.getElementById('normal').classList.add('highlight');
                } else if (data.category === 'Overweight') {
                    document.getElementById('overweight').classList.add('highlight');
                } else if (data.category === 'Obese') {
                    document.getElementById('obese').classList.add('highlight');
                }
            }
        })
        .catch(error => {
            document.getElementById('preloder').style.display = 'none'; // Hide preloader
            document.getElementById('bmiResult').innerHTML = "An error occurred. Please try again.";
            console.error("Fetch request failed:", error);
        });
});

    </script>