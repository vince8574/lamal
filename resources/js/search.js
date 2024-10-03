const ageSelect = document.getElementById('age');
const franchiseSelect = document.getElementById('franchise');
const cantonSelect = document.getElementById('canton');
const searchButton = document.querySelector('.btn');

function handleSearch() {
    const canton = cantonSelect.value;
    const age = ageSelect.value;
    const franchise = franchiseSelect.value;


    const url = `/api/get-prime`;

    fetch(url, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            canton: canton,
            age: age,
            franchise: franchise
        })
    })
        .then(response => response.json())
        .then(data => {
            // Traitez la réponse de votre backend ici
            console.log('Tarif:', data.rate); // Remplacez par votre logique
        })
        .catch(error => {
            console.error('Erreur:', error);
        });
}

ageSelect.addEventListener('change', updateFranchiseOptions);
searchButton.addEventListener('click', (event) => {
    event.preventDefault(); // Empêche le rechargement de la page
    handleSearch();
});

updateFranchiseOptions();