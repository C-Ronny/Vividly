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

    // Show modal when edit profile is clicked
    editProfileLink.addEventListener('click', (e) => {
        e.preventDefault();
        fetchUserDetails(); // Fetch and populate user details
        fileDropModal.style.display = 'flex';
    });

    // Close modal when close button is clicked
    closeButton.addEventListener('click', (e) => {
        e.preventDefault();
        fileDropModal.style.display = 'none';
    });

    // Close modal when clicking outside the modal content
    fileDropModal.addEventListener('click', (e) => {
        if (e.target === fileDropModal) {
            fileDropModal.style.display = 'none';
        }
    });

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

function previewImage(event) {
    const file = event.target.files[0];
    const reader = new FileReader();
    
    reader.onload = function(e) {
        const preview = document.getElementById('preview');
        preview.src = e.target.result;
        preview.classList.remove('hidden');
    };
    
    if (file) {
        reader.readAsDataURL(file);
    } else {
        const preview = document.getElementById('preview');
        preview.classList.add('hidden');
    }
}

