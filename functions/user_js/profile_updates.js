// Get references to the profile photo link and the modal
const editProfileLink = document.getElementById('edit-profile');
const fileDropModal = document.querySelector('.flex.items-center.justify-center.p-3');
const fileDropModalClose = document.getElementById('close');

// Initially hide the modal
fileDropModal.style.display = 'none';

// Add click event listener to the "Update Profile Photo" link
editProfileLink.addEventListener('click', (e) => {
    e.preventDefault(); // Prevent default link behavior
    fileDropModal.style.display = 'flex'; // Show the modal
});

// Add click event listener to the close button
fileDropModalClose.addEventListener('click', (e) => {
    fileDropModal.style.display = 'none'; // Hide the modal
});


// Add functionality to close the modal (optional but recommended)
fileDropModal.addEventListener('click', (e) => {
    // Close modal if clicking outside the modal content
    if (e.target === fileDropModal) {
        fileDropModal.style.display = 'none';
    }
});

// Existing dropzone code (keeping the previous handleFiles logic)
const dropzone = document.getElementById('dropzone');
const fileInput = document.getElementById('fileInput');
const fileList = document.getElementById('fileList');

dropzone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropzone.classList.add('border-blue-500', 'border-2');
});

dropzone.addEventListener('dragleave', () => {
    dropzone.classList.remove('border-blue-500', 'border-2');
});

dropzone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropzone.classList.remove('border-blue-500', 'border-2');

    const files = e.dataTransfer.files;
    handleFiles(files);
});

fileInput.addEventListener('change', (e) => {
    const files = e.target.files;
    handleFiles(files);
});

function handleFiles(files) {
    fileList.innerHTML = '';

    for (const file of files) {
        const listItem = document.createElement('div');
        listItem.textContent = `${file.name} (${formatBytes(file.size)})`;
        fileList.appendChild(listItem);
    }
}

function formatBytes(bytes) {
    if (bytes === 0) return '0 Bytes';

    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));

    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

function previewImage(event) {
  const file = event.target.files[0]; // Get the selected file
  const reader = new FileReader();
  
  reader.onload = function(e) {
      const preview = document.getElementById('preview');
      preview.src = e.target.result; // Set the preview image source to the uploaded file
      preview.classList.remove('hidden'); // Show the preview image
  };
  
  if (file) {
      reader.readAsDataURL(file); // Read the file as a data URL
  } else {
      // If no file is selected, hide the preview
      const preview = document.getElementById('preview');
      preview.classList.add('hidden');
  }
}

// Open Edit Modal
function openEditModal(user) {
  const editModal = new bootstrap.Modal(document.getElementById('editUserModal'));
  document.getElementById('fname').value = user.fname;
  document.getElementById('lname').value = user.lname;
  document.getElementById('email').value = user.email;
  editModal.show();

  // Save changes on form submits
  document.getElementById('editUserForm').onsubmit = function (e) {
      e.preventDefault();
      saveChanges(user.email);
      editModal.hide();
  };
}

// Save Changes (AJAX)
function saveChanges(email) {
  const updatedName = document.getElementById('userName').value;
  const updatedRole = document.getElementById('userRole').value;

  fetch('../db/user_edit.php', {
      method: 'POST',
      headers: {
          'Content-Type': 'application/json',
      },
      body: JSON.stringify({
          email: email,
          fullname: updatedName,
          role: updatedRole,
      }),
  })
      .then(response => response.json())
      .then(data => {
          if (data.success) {
              alert('User updated successfully');
              location.reload(); // Reload the table
          } else {
              alert('Error updating user: ' + data.error);
          }
      })
      .catch(error => console.error('Error updating user:', error));
}