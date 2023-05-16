// Check if #fetchPokemonsBtn exists
if (document.querySelector('#fetchPokemonsBtn')) {
    document.querySelector('#fetchPokemonsBtn').addEventListener('click', async (event) => {
        const fetchBtn = event.currentTarget;
        const { ajax_url: endpointUrl, nonce, hook } = ajax_object;
        document.querySelector('.spinner').classList.add('is-active');
        // Hide fetch button while fetching
        fetchBtn.style.display = "none";
        try {
            const pokemonList = await fetchPokemons();
            console.log(pokemonList);
            // Remove class is-active to the spinner
            document.querySelector('.spinner').classList.remove('is-active');
            fetchBtn.style.display = "block";
            // Draws the pokemon list inside the wrap div
            document.querySelector('#pokemonList').style.display = "table";
            const pokemonListDiv = document.querySelector('#pokemonList tbody');
            pokemonListDiv.innerHTML = '';
            pokemonList.forEach((pokemon) => {
                let pokemonRow = document.createElement('tr');
                pokemonRow.innerHTML = `
        <tr>
          <td>${pokemon.id}</td>
          <td><h3>${pokemon.name}</h3></td>
          <td><img src="${pokemon.url}" alt="${pokemon.name}" /></td>
          <td>${pokemon.description}</td>
          <td>${pokemon.primaryType}</td>
          <td>${pokemon.secondaryType}</td>
          <td>${pokemon.attacks}</td>
          <td>${pokemon.weight}</td>
          <td>${pokemon.oldVersionPokedexNumber}</td>
          <td>${pokemon.newVersionPokedexNumber}</td>
        </tr>
        `;
                pokemonListDiv.appendChild(pokemonRow);
            });
            const pokemonListJson = JSON.stringify(pokemonList);
            const data = new FormData();
            data.append('action', hook);
            data.append('nonce', nonce);
            data.append('pokemonList', pokemonListJson);
            // Send the pokemon list to the server
            fetch(endpointUrl, {
                method: 'POST',
                credentials: 'same-origin',
                body: data,
            })
                .then((response) => response.json())
                .catch((error) => {
                console.error(error);
            });
        }
        catch (error) {
            console.error(error);
        }
    });
}
async function fetchPokemons() {
    const response = await fetch('https://pokeapi.co/api/v2/pokemon?limit=1118');
    const data = await response.json();
    // Shuffle the array of pokemons to get 3 random ones
    const shuffledPokemons = data.results.sort(() => Math.random() - 0.5);
    // Get the first 3 shuffled pokemons
    const selectedPokemons = shuffledPokemons.slice(0, 3);
    // Fetch the details for each selected pokemon
    const pokemonPromises = selectedPokemons.map(async (pokemon) => {
        const pokemonResponse = await fetch(pokemon.url);
        const pokemonData = await pokemonResponse.json();
        const description = await fetchPokemonDescription(pokemonData.id);
        const attacks = await fetchPokemonAttacks(pokemonData.id);
        const pokedexNumbers = await getPokedexNumbers(pokemonData.id);
        return {
            id: pokemonData.id,
            name: pokemonData.name,
            url: pokemonData.sprites.front_default,
            description,
            primaryType: pokemonData.types[0].type.name,
            secondaryType: pokemonData.types[1]?.type.name,
            attacks: attacks.map((attack) => [attack.name, attack.description]),
            weight: pokemonData.weight,
            oldVersionPokedexNumber: pokedexNumbers.oldPokedexNumber,
            newVersionPokedexNumber: pokedexNumbers.newPokedexNumber,
        };
    });
    // Wait for all the details to be fetched
    const formattedPokemons = await Promise.all(pokemonPromises);
    return formattedPokemons;
}
async function fetchPokemonDescription(pokemonId) {
    const response = await fetch(`https://pokeapi.co/api/v2/pokemon-species/${pokemonId}`);
    const data = await response.json();
    const description = data.flavor_text_entries.find((entry) => entry.language.name === "en");
    return description.flavor_text ? description.flavor_text : '';
}
async function fetchPokemonAttacks(pokemonId) {
    const response = await fetch(`https://pokeapi.co/api/v2/pokemon/${pokemonId}`);
    const data = await response.json();
    const attackPromises = data.moves.map(async (move) => {
        const attackResponse = await fetch(move.move.url);
        const attackData = await attackResponse.json();
        const name = attackData.name;
        const description = attackData.effect_entries.find((entry) => entry.language.name === 'en')?.short_effect || '';
        return {
            name,
            description,
        };
    });
    const attacks = await Promise.all(attackPromises);
    return attacks;
}
async function getPokedexNumbers(pokemonId) {
    const response = await fetch(`https://pokeapi.co/api/v2/pokemon-species/${pokemonId}`);
    const data = await response.json();
    const pokedexEntries = data.pokedex_numbers;
    // Find the entry for the older version
    const oldVersionEntry = pokedexEntries.find((entry) => entry.pokedex.name === "kanto");
    const oldPokedexNumber = oldVersionEntry ? oldVersionEntry.entry_number : 0;
    // Find the entry for the most recent version
    const newVersionEntry = pokedexEntries.find((entry) => entry.pokedex.name === "national");
    const newPokedexNumber = newVersionEntry ? newVersionEntry.entry_number : 0;
    return {
        oldPokedexNumber,
        newPokedexNumber,
    };
}
