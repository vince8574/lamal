const franchiseOptions = {
    mineur: ["Sans franchise", "100", "200", "300", "400", "500", "600"],
    jeune: ["300", "500", "1000", "1500", "2000", "2500"],
    adulte: ["300", "500", "1000", "1500", "2000", "2500"]
};

const ageSelect = document.getElementById('age');
const franchiseSelect = document.getElementById('franchise');

function updateFranchiseOptions() {
    const selectedAge = ageSelect.value;
    const options = franchiseOptions[selectedAge];
    franchiseSelect.innerHTML = '';
    options.forEach(option => {
        const opt = document.createElement('option');
        opt.value = option;
        opt.textContent = option;
        franchiseSelect.appendChild(opt);
    });
}

ageSelect.addEventListener('change', updateFranchiseOptions);
updateFranchiseOptions();