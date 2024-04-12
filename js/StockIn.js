function convertToUSD() {
    const nprRate = 130.50; // Conversion rate from NPR to USD
    const rateInput = document.getElementById('NPRrate').value;
    const convertedRateInput = document.getElementById('USDrate');

    if (!isNaN(rateInput) && rateInput.trim() !== '') {
        const convertedRate = parseFloat(rateInput) / nprRate;
        convertedRateInput.value = convertedRate.toFixed(2); // Convert to USD with 2 decimal places
        calculateTotalAmount();
    } else {
        convertedRateInput.value = '';
    }
}

function convertToNPR() {
    const nprRate = 130.50; // Conversion rate from NPR to USD
    const convertedRateInput = document.getElementById('USDrate').value;
    const rateInput = document.getElementById('rate');

    if (!isNaN(convertedRateInput) && convertedRateInput.trim() !== '') {
        const rate = parseFloat(convertedRateInput) * nprRate;
        rateInput.value = rate.toFixed(2); // Convert to NPR with 2 decimal places
        calculateTotalAmount();
    } else {
        rateInput.value = '';
    }
}

function calculateTotalAmount() {
    const rateInput = parseFloat(document.getElementById('NPRrate').value);
    const convertedRateInput = (document.getElementById('USDrate').value);
    const quantity = parseFloat(document.getElementById('quantity').value);
    const displayNPR = document.getElementById('totalNPR');
    const displayUSD = document.getElementById('totalUSD');

    if (!isNaN(rateInput) && !isNaN(quantity)) {
        const totalNPR = rateInput.toFixed(2) * quantity;
        const totalUSD = convertedRateInput * quantity;
        displayNPR.textContent = `Total amount is NPR ${totalNPR.toFixed(2)}`;
        displayUSD.textContent = `Total amount is USD ${totalUSD.toFixed(2)}`;
    } else {
        displayNPR.textContent = '';
        displayUSD.textContent = '';
    }
}



// Add event listeners
document.getElementById('NPRrate').addEventListener('input', convertToUSD);
document.getElementById('USDrate').addEventListener('input', convertToNPR);
document.getElementById('NPRrate').addEventListener('input', calculateTotalAmount);
document.getElementById('quantity').addEventListener('input', calculateTotalAmount);
