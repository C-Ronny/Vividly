// '.tbl-content' consumed little space for vertical scrollbar, scrollbar width depend on browser/os/platfrom. Here calculate the scollbar width .
$(window).on("load resize ", function() {
var scrollWidth = $('.tbl-content').width() - $('.tbl-content table').width();
$('.tbl-header').css({'padding-right':scrollWidth});
}).resize();


document.addEventListener("DOMContentLoaded", function () {
// Fetch user data from the server
fetch('../../db/admin_db/user_table_details_fetch.js')
    .then(response => response.json())
    .then(data => {
        const tableBody = document.querySelector('.content-table tbody');

        // Clear existing rows
        tableBody.innerHTML = '';

        // Populate the table with user data
        data.forEach(user => {
            const row = document.createElement('tr');

            // Create table cells
            const firstNameCell = document.createElement('td');
            firstNameCell.textContent = user.fname;

            const lastNameCell = document.createElement('td');
            lastNameCell.textContent = user.lname;

            const emailCell = document.createElement('td');
            emailCell.textContent = user.email;

            const roleCell = document.createElement('td');
            roleCell.textContent = user.role;

            const registrationDateCell = document.createElement('td');
            registrationDateCell.textContent = new Date(user.created_at).toLocaleDateString();

            const numberOfPins = document.createElement('td');
            numberOfPins.textContent = `empty_for_now`;

            ////////////////////////////////////////////////////////////
            ////////////////////////////////////////////////////////////
            ////////////////////////////////////////////////////////////

            // Edit Button

            // const editCell = document.createElement('td');
            // const editButton = document.createElement('button');
            // editButton.textContent = 'Edit';
            // editButton.className = 'btn btn-primary';
            // editButton.onclick = function () {
            //     openEditModal(user);
            // };
            // editCell.appendChild(editButton);

            // Delete Button

            // const deleteCell = document.createElement('td');
            // const deleteButton = document.createElement('button');
            // deleteButton.textContent = 'Delete';
            // deleteButton.className = 'btn btn-danger';
            // deleteButton.onclick = function () {
            //     confirmDelete(user.email);
            // };
            // deleteCell.appendChild(deleteButton);

            ////////////////////////////////////////////////////////////
            ////////////////////////////////////////////////////////////
            ////////////////////////////////////////////////////////////

            // Append cells to the row
            row.appendChild(firstNameCell);
            row.appendChild(lastNameCell);
            row.appendChild(emailCell);
            row.appendChild(roleCell);
            row.appendChild(registrationDateCell);
            row.appendChild(numberOfPins);

            // Append the row to the table body
            tableBody.appendChild(row);

            

        });
    })
    .catch(error => console.error('Error fetching user data:', error));
});