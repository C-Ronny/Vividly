// '.tbl-content' consumed little space for vertical scrollbar, scrollbar width depend on browser/os/platform. Here calculate the scrollbar width .

// scroll within the users table

// $(window).on("load resize ", function() {
// var scrollWidth = $('.tbl-content').width() - $('.tbl-content table').width();
// $('.tbl-header').css({'padding-right':scrollWidth});
// }).resize();


document.addEventListener("DOMContentLoaded", function () {
    // Add modal HTML to the document
    document.body.innerHTML += `
        <div id="editModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Edit User</h2>
                <form id="editForm" method="POST">
                    <input type="hidden" name="editUserId" id="editUserId">
                    <div>
                        <label for="editFname">First Name</label>
                        <input type="text" name="editFname" id="editFname" required>
                        <span class="error-message" id="fnameError"></span>
                    </div>
                    <div>
                        <label for="editLname">Last Name</label>
                        <input type="text" name="editLname" id="editLname" required>
                        <span class="error-message" id="lnameError"></span>
                    </div>
                    <div>
                        <label for="editEmail">Email Address</label>
                        <input type="email" name="editEmail" id="editEmail" required>
                        <span class="error-message" id="emailError"></span>
                    </div>
                    <div>
                        <label for="editRole">User Role</label>
                        <select name="editRole" id="editRole">
                            <option value="1">Admin</option>
                            <option value="2">Regular</option>
                        </select>
                    </div>
                    <div class="button-group">
                        <button type="submit">Save Changes</button>
                        <button type="button" class="delete-btn" onclick="openDeleteConfirmation()">Delete User</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="deleteModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Delete User</h2>
                <p>Are you sure you want to delete this user? This action cannot be undone.</p>
                <p>Type DELETE to confirm:</p>
                <input type="text" id="deleteConfirmation" placeholder="Type DELETE">
                <div class="button-group">
                    <button id="confirmDeleteBtn" class="delete-btn">Delete User</button>
                    <button onclick="closeDeleteModal()" class="cancel-btn">Cancel</button>
                </div>
            </div>
        </div>
    `;

    fetch('../../db/admin_db/user_table_details_fetch.php')
        .then(response => response.json())
        .then(data => {
            const tableBody = document.querySelector('.tbl-content .content-table tbody');
            tableBody.innerHTML = '';

            document.querySelector('.tbl-header table thead tr').innerHTML = `
                <th class="col-fname">First Name</th>
                <th class="col-lname">Last Name</th>
                <th class="col-email">Email</th>
                <th class="col-role">Role</th>
                <th class="col-date">Date Joined</th>
                <th class="col-pins">Pins</th>
                <th class="col-actions">Actions</th>
            `;

            data.forEach(user => {
                const row = document.createElement('tr');
                
                row.innerHTML = `
                    <td class="col-fname">${user.fname}</td>
                    <td class="col-lname">${user.lname}</td>
                    <td class="col-email">
                        <div class="email-cell" title="${user.email}">${user.email}</div>
                    </td>
                    <td class="col-role">${user.role === '1' ? 'Admin' : 'User'}</td>
                    <td class="col-date">${new Date(user.created_at).toLocaleDateString()}</td>
                    <td class="col-pins">${user.pins_count || '0'}</td>
                    <td class="col-actions">
                        <div class="action-buttons">
                            <button class="action-btn edit-btn" onclick='openEditModal(${JSON.stringify(user)})'>
                                Edit
                            </button>
                            
                        </div>
                    </td>
                `;

                tableBody.appendChild(row);
            });
        })
        .catch(error => console.error('Error fetching user data:', error));

    // Modal functionality
    let currentUserId = null;

    // In the openEditModal function
    window.openEditModal = function(user) {
        currentUserId = user.user_id;
        const modal = document.getElementById('editModal');
        const form = document.getElementById('editForm');
        
        // Reset form and errors
        form.reset();
        clearErrors();
        
        // Populate form
        document.getElementById('editUserId').value = user.user_id;
        document.getElementById('editFname').value = user.fname;
        document.getElementById('editLname').value = user.lname;
        document.getElementById('editEmail').value = user.email;
        document.getElementById('editRole').value = user.role;
        
        modal.style.display = "block";
        document.getElementById('editFname').focus();
    }

    window.openDeleteConfirmation = function() {
        document.getElementById('editModal').style.display = "none";
        document.getElementById('deleteModal').style.display = "block";
        document.getElementById('deleteConfirmation').value = '';
        document.getElementById('deleteConfirmation').focus();
    }

    window.closeDeleteModal = function() {
        document.getElementById('deleteModal').style.display = "none";
        document.getElementById('editModal').style.display = "block";
    }

    // Close modals when clicking (x)
    document.querySelectorAll('.close').forEach(closeBtn => {
        closeBtn.onclick = function() {
            this.closest('.modal').style.display = "none";
        }
    });

    // Handle edit form submission
    document.getElementById('editForm').onsubmit = function(e) {
        e.preventDefault();
        
        // Clear previous errors
        clearErrors();
        
        // Create FormData object
        const formData = new FormData(this);
        
        // Validate form
        let isValid = true;
        
        if (formData.get('editFname').length < 2) {
            showError('fnameError', 'First name must be at least 2 characters');
            isValid = false;
        }
        
        if (formData.get('editLname').length < 2) {
            showError('lnameError', 'Last name must be at least 2 characters');
            isValid = false;
        }
        
        if (!isValidEmail(formData.get('editEmail'))) {
            showError('emailError', 'Please enter a valid email address');
            isValid = false;
        }
        
        if (isValid) {
            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.textContent = 'Saving...';
            submitBtn.disabled = true;
            
            fetch('../../db/admin_db/update_user.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    document.getElementById('editModal').style.display = 'none';
                    refreshUserTable();
                } else {
                    showError('emailError', data.message || 'Error updating user');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showError('emailError', 'Network error. Please try again.');
            })
            .finally(() => {
                submitBtn.textContent = 'Save Changes';
                submitBtn.disabled = false;
            });
        }
    };
    
    // Add a function to refresh the user table
    function refreshUserTable() {
        fetch('../../db/admin_db/user_table_details_fetch.php')
            .then(response => response.json())
            .then(data => {
                const tableBody = document.querySelector('.tbl-content .content-table tbody');
                tableBody.innerHTML = '';
    
                data.forEach(user => {
                    const row = document.createElement('tr');
                    
                    row.innerHTML = `
                        <td class="col-fname">${user.fname}</td>
                        <td class="col-lname">${user.lname}</td>
                        <td class="col-email">
                            <div class="email-cell" title="${user.email}">${user.email}</div>
                        </td>
                        <td class="col-role">${user.role === '1' ? 'Admin' : 'User'}</td>
                        <td class="col-date">${new Date(user.created_at).toLocaleDateString()}</td>
                        <td class="col-pins">${user.pins_count || '0'}</td>
                        <td class="col-actions">
                            <div class="action-buttons">
                                <button class="action-btn edit-btn" onclick='openEditModal(${JSON.stringify(user)})'>
                                    Edit
                                </button>
                            </div>
                        </td>
                    `;
    
                    tableBody.appendChild(row);
                });
            })
            .catch(error => console.error('Error fetching user data:', error));
    }
    
    // Handle delete confirmation
    document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
        const confirmationInput = document.getElementById('deleteConfirmation');
        const userId = document.getElementById('editUserId').value;
    
        if (confirmationInput.value !== 'DELETE') {
            alert('Please type DELETE to confirm');
            return;
        }
    
        const formData = new FormData();
        formData.append('user_id', userId);
    
        fetch('../../db/admin_db/delete_user.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('deleteModal').style.display = 'none';
                document.getElementById('editModal').style.display = 'none';
                refreshUserTable();
                alert(data.message);
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An unexpected error occurred');
        });
    });

    // Helper functions
    function clearErrors() {
        document.querySelectorAll('.error-message').forEach(error => error.textContent = '');
        document.querySelectorAll('input').forEach(input => input.classList.remove('input-error'));
    }

    function showError(elementId, message) {
        const errorElement = document.getElementById(elementId);
        if (errorElement) {
            errorElement.textContent = message;
            const inputElement = errorElement.previousElementSibling;
            if (inputElement) {
                inputElement.classList.add('input-error');
            }
        }
    }

    function isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('editModal');
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
});
