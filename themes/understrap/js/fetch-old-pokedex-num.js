if (document.querySelector('#getOldPokedexNumber')) {
    document.querySelector('#getOldPokedexNumber').addEventListener('click', async (event) => {
        const fetchBtn = event.currentTarget;
        const { ajax_url: endpointUrl, nonce, hook } = ajax_object;
        try {
            // Get the data-pokemon-id attribute from the button
            const pokemonId = fetchBtn.getAttribute('data-pokemon-id');
            const data = new FormData();
            data.append('action', hook);
            data.append('nonce', nonce);
            data.append('pokemonId', pokemonId);
            const response = await fetch(endpointUrl, {
                method: 'POST',
                credentials: 'same-origin',
                body: data
            });
            const dataJson = await response.json();
            if (dataJson.success) {
                const oldPokedexNumber = dataJson.data.pokemon_old_pokedex_number;
                // Add old pokedex number
                const oldPokedexNumberEl = document.createElement('span');
                if (oldPokedexNumber === "0") {
                    oldPokedexNumberEl.textContent = `This Pokémon does not exist in the Old version.`;
                }
                else {
                    oldPokedexNumberEl.textContent = `Old Pokédex Number: ${oldPokedexNumber}`;
                }
                fetchBtn.parentElement.appendChild(oldPokedexNumberEl);
                // Remove btn
                fetchBtn.remove();
            }
            else {
                console.error(dataJson.data);
            }
        }
        catch (error) {
            console.error(error);
        }
    });
}
