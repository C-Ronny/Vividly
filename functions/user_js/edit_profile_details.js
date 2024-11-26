document.addEventListener("DOMContentLoaded", function () {
  // Fetch user data from the server
  fetch('../../db/user_db/profile_details_fetch.php')
      .then(response => response.json())
      .then(data => {
          const tableBody = document.querySelector('.content-table tbody');

          // Clear existing rows
          // tableBody.innerHTML = '';

          // Populate the form with the specific user data
          data.forEach(user => {
              const row = document.createElement('tr');

              // Create table cells
              const fullNameCell = document.createElement('td');
              fullNameCell.textContent = user.fullname;

              const emailCell = document.createElement('td');
              emailCell.textContent = user.email;

              const roleCell = document.createElement('td');
              roleCell.textContent = user.role;

              const registrationDateCell = document.createElement('td');
              registrationDateCell.textContent = new Date(user.created_at).toLocaleDateString();

              // Edit Button
              const editCell = document.createElement('td');
              const editButton = document.createElement('button');
              editButton.textContent = 'Edit';
              editButton.className = 'btn btn-primary';
              editButton.onclick = function () {
                  openEditModal(user);
              };
              editCell.appendChild(editButton);

              // Delete Button
              const deleteCell = document.createElement('td');
              const deleteButton = document.createElement('button');
              deleteButton.textContent = 'Delete';
              deleteButton.className = 'btn btn-danger';
              deleteButton.onclick = function () {
                  confirmDelete(user.email);
              };
              deleteCell.appendChild(deleteButton);

              // Append cells to the row
              row.appendChild(fullNameCell);
              row.appendChild(emailCell);
              row.appendChild(roleCell);
              row.appendChild(registrationDateCell);
              row.appendChild(editCell);
              row.appendChild(deleteCell);

              // Append the row to the table body
              tableBody.appendChild(row);
          });
      })
      .catch(error => console.error('Error fetching user data:', error));
});

// Open Edit Modal
function openEditModal(user) {
  const editModal = new bootstrap.Modal(document.getElementById('editUserModal'));
  document.getElementById('userName').value = user.fullname;
  document.getElementById('userEmail').value = user.email;
  document.getElementById('userRole').value = user.role;
  editModal.show();

  // Save changes on form submit
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