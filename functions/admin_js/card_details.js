document.addEventListener("DOMContentLoaded", function () {
  // Fetch data from the server
  fetch('../../db/admin_db/cards_details_fetch.php')
  .then(response => response.json())
  .then(data => {
      // Update total users
      const totalUsersElement = document.getElementById('total_users');
      totalUsersElement.textContent = data.totalUsers;
      // Update new users
      const newUsersElement = document.getElementById('new_users');
      newUsersElement.textContent = data.newUsers;



      // Update total boards
      const totalBoards = document.getElementById('total_boards');
      totalBoards.textContent = data.totalBoards; 
      // Update avg pins
      const avgPins = document.getElementById('avg_pins');
      avgPins.textContent = data.avgPins;



      // Update total pins
      const totalPins = document.getElementById('total_pins');
      totalPins.textContent = data.totalPins;
      // Update most active category
      const mostActiveCategory = document.getElementById('most_active_category');
      mostActiveCategory.textContent = data.mostActiveCategory;

      
      // Update total categories
      const totalCategories = document.getElementById('total_categories');
      totalCategories.textContent = data.totalCategories;st

  })
  .catch(error => console.error('Error fetching data:', error));
});
