document.getElementById('addCarForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const messageDiv = document.getElementById('message');

    messageDiv.textContent = 'Submitting...';
    messageDiv.className = 'message info';

    fetch('add_car_process.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            messageDiv.textContent = 'Car added successfully! Car ID: ' + data.car_id;
            messageDiv.className = 'message success';
            document.getElementById('addCarForm').reset();
        } else {
            messageDiv.innerHTML = 'Error:<br>' + data.errors.join('<br>');
            messageDiv.className = 'message error';
        }
    })
    .catch(error => {
        messageDiv.textContent = 'Network error: ' + error.message;
        messageDiv.className = 'message error';
    });
});