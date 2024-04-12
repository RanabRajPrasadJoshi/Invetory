 // Object to keep track of selected filters
 const selectedFilters = {};

 // Function to populate filter dropdowns with checkboxes
 function populateDropdowns() {
     const table = document.getElementById('itemTable');
     const rows = table.querySelectorAll('tbody tr');
     const dropdowns = table.querySelectorAll('.filter-dropdown');

     dropdowns.forEach((dropdown, index) => {
         const uniqueValues = new Set();

         rows.forEach(row => {
             const cellValue = row.cells[index].textContent.trim();
             uniqueValues.add(cellValue);
         });

         const dropdownContent = dropdown.querySelector('.dropdown-content');
         dropdownContent.innerHTML = '<label><input type="checkbox" value="">All</label>';
         uniqueValues.forEach(value => {
             const checkbox = document.createElement('input');
             checkbox.type = 'checkbox';
             checkbox.value = value;
             checkbox.addEventListener('change', (event) => handleCheckboxChange(event, index));
             const label = document.createElement('label');
             label.appendChild(checkbox);
             label.appendChild(document.createTextNode(value));
             dropdownContent.appendChild(label);
         });
     });
 }

 // Handle checkbox change event
 function handleCheckboxChange(event, columnIndex) {
     const checkbox = event.target;
     const value = checkbox.value;
     const isChecked = checkbox.checked;

     if (!selectedFilters[columnIndex]) {
         selectedFilters[columnIndex] = new Set();
     }

     if (isChecked) {
         selectedFilters[columnIndex].add(value);
     } else {
         selectedFilters[columnIndex].delete(value);
     }

     // Update the button placeholder
     updateButtonPlaceholder(columnIndex);

     // Filter the table based on the selected filters
     filterTable();
 }

 // Update the button placeholder based on selected filters
 function updateButtonPlaceholder(columnIndex) {
     const filterDropdown = document.querySelector(`.filter-dropdown[data-index="${columnIndex}"]`);
     const filterButton = filterDropdown.querySelector('.filter-button');
     const selectedValues = selectedFilters[columnIndex];

     if (selectedValues && selectedValues.size > 0) {
         // If filters are selected, change button color and update placeholder
         filterButton.classList.add('active');
         filterButton.textContent = 'Filter';
     } else {
         // Reset button color and placeholder if no filters are selected
         filterButton.classList.remove('active');
         filterButton.textContent = 'Filter';
     }
 }

 // Function to filter the table based on selected filters
 function filterTable() {
     const table = document.getElementById('itemTable');
     const rows = table.querySelectorAll('tbody tr');

     rows.forEach(row => {
         let shouldDisplay = true;

         // Iterate over each column
         for (let columnIndex = 0; columnIndex < 9; columnIndex++) {
             const filterValues = selectedFilters[columnIndex];
             const cellValue = row.cells[columnIndex].textContent.trim();

             // If there are no selected filters in the column, skip
             if (!filterValues || filterValues.size === 0) {
                 continue;
             }

             // Check if the cell value is in the selected filter values
             const filterValuesArray = Array.from(filterValues);
             if (filterValuesArray.length > 0 && !filterValuesArray.includes(cellValue)) {
                 shouldDisplay = false;
                 break;
             }
         }

         // Display or hide the row based on whether it matches the filters
         row.style.display = shouldDisplay ? '' : 'none';
     });

     // Calculate totals after filtering
     calculateTotals();
 }

 // Function to calculate totals and update the footer
 function calculateTotals() {
     const rows = document.querySelectorAll('#itemTable tbody tr');
     let totalNPRRate = 0;
     let totalUSDRate = 0;
     let totalQuantity = 0;
     let totalNPR = 0;
     let totalUSD = 0;

     rows.forEach(row => {
         if (row.style.display !== 'none') {
             const nprRate = parseFloat(row.cells[4].textContent);
             const usdRate = parseFloat(row.cells[5].textContent);
             const quantity = parseFloat(row.cells[6].textContent);
             const totalRowNPR = parseFloat(row.cells[7].textContent);
             const totalRowUSD = parseFloat(row.cells[8].textContent);

             totalNPRRate += nprRate;
             totalUSDRate += usdRate;
             totalQuantity += quantity;
             totalNPR += totalRowNPR;
             totalUSD += totalRowUSD;
         }
     });

     // Update footer totals
     document.getElementById('totalQuantity').textContent = totalNPRRate.toFixed(2);
     document.getElementById('totalNPRRate').textContent = totalUSDRate.toFixed(2);
     document.getElementById('totalUSDRate').textContent = totalQuantity.toFixed(2);
     document.getElementById('totalNPR').textContent = totalNPR.toFixed(2);
     document.getElementById('totalUSD').textContent = totalUSD.toFixed(2);
 }

 // Function to reset filters
 function resetFilters() {
     const dropdowns = document.querySelectorAll('.filter-dropdown');
     dropdowns.forEach(dropdown => {
         const checkboxes = dropdown.querySelectorAll('input[type="checkbox"]');
         checkboxes.forEach(checkbox => {
             checkbox.checked = false;
         });

         const columnIndex = dropdown.dataset.index;
         selectedFilters[columnIndex] = new Set();
     });

     // Reset filter button text
     dropdowns.forEach(dropdown => {
         const filterButton = dropdown.querySelector('.filter-button');
         filterButton.classList.remove('active');
         filterButton.textContent = 'Filter';
     });

     // Reset table rows visibility
     const rows = document.querySelectorAll('#itemTable tbody tr');
     rows.forEach(row => {
         row.style.display = '';
     });

     // Calculate totals
     calculateTotals();
 }

 // Function to toggle dropdown visibility
 function toggleDropdown(event) {
     event.preventDefault();
     const filterDropdown = event.currentTarget.parentElement;
     const dropdownContent = filterDropdown.querySelector('.dropdown-content');

     // Toggle visibility of the dropdown content
     dropdownContent.classList.toggle('show');

     // Hide other dropdowns when opening the current one
     const otherDropdowns = document.querySelectorAll('.dropdown-content');
     otherDropdowns.forEach(content => {
         if (content !== dropdownContent) {
             content.classList.remove('show');
         }
     });
 }

 // Hide dropdowns when clicking outside
 document.addEventListener('click', function (event) {
     const isFilterButtonClick = event.target.closest('.filter-dropdown button');
     const isCheckboxClick = event.target.closest('.dropdown-content');

     // Close dropdowns if click was outside of them
     if (!isFilterButtonClick && !isCheckboxClick) {
         const dropdowns = document.querySelectorAll('.dropdown-content');
         dropdowns.forEach(dropdown => {
             dropdown.classList.remove('show');
         });
     }
 });

 // Populate dropdowns and calculate totals on page load
 document.addEventListener('DOMContentLoaded', function () {
     populateDropdowns();
     calculateTotals();
 });
