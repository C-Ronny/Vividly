document.addEventListener("DOMContentLoaded", function () {
  // Fetch data from the server
  fetch('../../db/admin_db/cards_details_fetch.php')
  .then(response => response.json())
  .then(data => {
      // Update total users
      const totalUsersElement = document.getElementById('total_users');
      totalUsersElement.textContent = data.totalUsers;

      // Update total boards
      const totalBoards = document.getElementById('total_boards');
      totalBoards.textContent = data.totalBoards; 

      // Update total pins
      const totalPins = document.getElementById('total_pins');
      totalPins.textContent = data.totalPins;
      
  })
  .catch(error => console.error('Error fetching data:', error));
});
