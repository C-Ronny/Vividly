document.addEventListener('DOMContentLoaded', function() {
  const masonryContainer = document.querySelector('.masonry');


async function getData() {
      const url = "../../db/user_db/board_images_fetch.php";
      try {
        const response = await fetch(url);
        if (!response.ok) {
          throw new Error(`Response status: ${response.status}`);
        }
    
        const json = await response.json();
        //console.log('json', json);

      for (let i = 0; i < json.length; i++) {

          console.log(json[i].image_url);
          const itemDiv = document.createElement('div');
          itemDiv.classList.add('item', `item${i + 1}`);
          // Create image element
          const img = document.createElement('img');
          img.src = `${json[i].image_url}`;
          img.alt = `Pin ${i + 1}`;

          // Determine grid row span dynamically or randomly
          const rowSpans = [10, 15, 20, 25, 30];
          const randomRowSpan = rowSpans[Math.floor(Math.random() * rowSpans.length)];
          itemDiv.style.gridRow = `span ${randomRowSpan}`;

          // Set background color dynamically
          const backgroundColors = [
              '#ff6f61', '#6b5b95', '#88b04b', '#d65076', 
              '#ffb347', '#45b8ac', '#e94b3c', '#6c5b7b', 
              '#00a86b', '#b565a7'
          ];
          itemDiv.style.backgroundColor = backgroundColors[i % backgroundColors.length];

          // Append image to item div
          itemDiv.appendChild(img);

          // Append item div to masonry container
          masonryContainer.appendChild(itemDiv);
          }
          }catch (error) {
          console.error(error.message);
          }
      }
  

  getData();
});



//     // Fetch images from PHP script
//     fetch('../../db/user_db/images_fetch.php')
//         .then(response => response.json())
//         .then(images => {
//             // Clear existing placeholder images
//             masonryContainer.innerHTML = '';

//             // Create and append new image elements dynamically
//             images.forEach((imageUrl, index) => {
//                 // Create item div
//                 const itemDiv = document.createElement('div');
//                 itemDiv.classList.add('item', `item${index + 1}`);

//                 // Create image element
//                 const img = document.createElement('img');
//                 img.src = `${imageUrl}`;
//                 img.alt = `Pin ${index + 1}`;

//                 // Determine grid row span dynamically or randomly
//                 const rowSpans = [10, 15, 20, 25, 30];
//                 const randomRowSpan = rowSpans[Math.floor(Math.random() * rowSpans.length)];
//                 itemDiv.style.gridRow = `span ${randomRowSpan}`;

//                 // Set background color dynamically
//                 const backgroundColors = [
//                     '#ff6f61', '#6b5b95', '#88b04b', '#d65076', 
//                     '#ffb347', '#45b8ac', '#e94b3c', '#6c5b7b', 
//                     '#00a86b', '#b565a7'
//                 ];
//                 itemDiv.style.backgroundColor = backgroundColors[index % backgroundColors.length];

//                 // Append image to item div
//                 itemDiv.appendChild(img);

//                 // Append item div to masonry container
//                 masonryContainer.appendChild(itemDiv);
//             });
//         })
//         .catch(error => {
//             console.error('Error fetching images:', error);
//         });
// });