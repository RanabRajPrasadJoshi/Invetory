function convertToUSD() {
    const nprRate = 130.50; // Conversion rate from NPR to USD
    const rateInput = document.getElementById('NPRrate').value;
    const convertedRateInput = document.getElementById('USDrate');

    if (!isNaN(rateInput) && rateInput.trim() !== '') {
        const convertedRate = parseFloat(rateInput) / nprRate;
        convertedRateInput.value = (-1 * Math.abs(convertedRate)).toFixed(2); // Convert to USD with 2 decimal places and make negative
        calculateTotalAmount();
    } else {
        convertedRateInput.value = '';
    }
}

function convertToNPR() {
    const nprRate = 130.50; // Conversion rate from NPR to USD
    const convertedRateInput = document.getElementById('USDrate').value;
    const rateInput = document.getElementById('NPRrate');

    if (!isNaN(convertedRateInput) && convertedRateInput.trim() !== '') {
        const rate = parseFloat(convertedRateInput) * nprRate;
        rateInput.value = (-1 * Math.abs(rate)).toFixed(2); // Convert to NPR with 2 decimal places and make negative
        calculateTotalAmount();
    } else {
        rateInput.value = '';
    }
}

function handleQuantityChange() {
    const quantityInput = document.getElementById('quantity');
    if (quantityInput.value > 0) {
        quantityInput.value = -1 * Math.abs(quantityInput.value);
    }
    calculateTotalAmount();
}

function handleRateChange() {
    const rateInput = document.getElementById('NPRrate');
    if (rateInput.value > 0) {
        rateInput.value = -1 * Math.abs(rateInput.value);
    }
    calculateTotalAmount();
}

function calculateTotalAmount() {
const rateInput = parseFloat(document.getElementById('NPRrate').value);
const convertedRateInput = parseFloat(document.getElementById('USDrate').value);
const quantity = parseFloat(document.getElementById('quantity').value);
const displayNPR = document.getElementById('totalNPR');
const displayUSD = document.getElementById('totalUSD');

if (!isNaN(rateInput) && !isNaN(convertedRateInput) && !isNaN(quantity)) {
    const totalNPR =  Math.abs(rateInput.toFixed(2)) * quantity;
    const totalUSD =  Math.abs(convertedRateInput.toFixed(2)) * quantity;
    displayNPR.textContent = `Total amount is NPR ${totalNPR.toFixed(2)}`;
    displayUSD.textContent = `Total amount is USD ${totalUSD.toFixed(2)}`;
} else {
    displayNPR.textContent = '';
    displayUSD.textContent = '';
}
}

function removeItem() {
    // Add your logic to insert the item into the database or perform any other action here
    alert('Item Removed successfully!');
}

// Add event listeners
document.getElementById('NPRrate').addEventListener('input', convertToUSD);
document.getElementById('USDrate').addEventListener('input', convertToNPR);
document.getElementById('NPRrate').addEventListener('input', handleRateChange);
document.getElementById('quantity').addEventListener('input', handleQuantityChange);
