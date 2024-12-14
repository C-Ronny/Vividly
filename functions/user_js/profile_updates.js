document.addEventListener("DOMContentLoaded", function () {
    const editProfileLink = document.getElementById('edit-profile');
    const fileDropModal = document.querySelector('.flex.items-center.justify-center.p-3');
    const editProfileForm = document.getElementById('form');
    const closeButton = document.getElementById('close');

    // Fetch and populate current user details
    function fetchUserDetails() {
        fetch('../../db/user_db/profile_details_fetch.php')
            .then(response => response.json())
            .then(data => {
                // Populate form fields with current user data
                document.getElementById('fname').value = data.fname || '';
                document.getElementById('lname').value = data.lname || '';
                document.getElementById('email').value = data.email || '';
            })
            .catch(error => console.error('Error fetching user details:', error));
    }

    

    // Handle form submission
    editProfileForm.addEventListener('submit', function(e) {
        e.preventDefault();

        // Create FormData object to handle form data
        const formData = new FormData(this);

        fetch('../../db/user_db/profile_details_fetch.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Profile updated successfully');
                fileDropModal.style.display = 'none';
                location.reload();
            } else {
                alert('Error updating profile: ' + (data.error || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while updating the profile');
        });
    });
});





