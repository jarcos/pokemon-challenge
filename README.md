# The Pokémon Challenge

## How to start the environment

This project is based in the [WP-ENV](https://developer.wordpress.org/block-editor/reference-guides/packages/packages-env/) package. Install the npm package globally start docker on your computer and then run `wp-env start`. This command will create a new environment based in docker.

## Code explanation

The starter theme used for this project is [Understrap](https://understrap.com). We have also created some custom functionalities, here is a list of the followings:

- In the inc/cpt.php file there is the Pokémons CPT and Primary and Secondary Types taxonomies definitions. Besides those, the Attack feature has been created as a Taxonomy in order to use archives in the future.
- In the js/fetch-pokemon.js there is a generated code from the TypeScript file found at src/ts/fetch-pokemon.ts. In order to generate these files a tsconfig.json file has been created. You can run the `tsc` from the terminal when being placed in the themes/understrap folder to regenerate the file or check any terminal inputs.
- There is another new js file called fetch-old-pokedex-numb.js that makes the AJAX call for getting the Old Pokédex Number of the Pokemon.
- Instead of creating manually the Pokémons, you can use the Fetch Pokemon link that can be found on the WordPress Admin Dashboard, under Pokémons => Fetch Pokémons. This functionatliy gets three pokémons from the API and insert them with all the fields in the DB, it checks if the Pokémon already exists. The funcionality of this Pokémon can be found on the files `fetch-pokemon.js` and `inc/ajax-request.php`.
- The inc/enqueue.php file has been modified in order to enqueue new scripts and styles.

Regarding the optional steps, I couldn't complete some of them, but here is some feedback based on my experience about how to implement them:

5. Create a pokémon filter. The steps that I'd follow for having this functionality would be the followings:

    - Create a custom archive page for the Pokémons Post Type.
    - In the custom archive template, define the filters using HTML elements.
    - Catch the filters form functionality and modify the page using JS.
    - Use WP_Query for pagination returned from AJAX to JS.

6. Create a custom URL.

    - To do this functionality there are different options, I'd create a page called _random_ and catch it using the hook `template_redirect`.

7. Create a custom url.

    - Similar to the previous step, I'd reuse the code from the `fetch-pokemon.js` to get the Pokémons from the API. This functionality is almost done on the Fetch Pokemon functionality that I've implemented.

8. Using the WP REST API.

    - In order to create a custom endpoint I'd use the hook `rest_api_init` and the function `register_rest_route()` to extend the functionality.

9. Implement DAPI (or other similars API).

    - In order to implement differents APIs we would need to define different layes of the APP.
      - First we will need to define the common data structure for every characters, be a Pokemon, Digimon or any similar character.
      - Then we need to define agnostics methods to insert in the database after validate the information received.
      - We can re-use the Pokemon CPT but it would be needed to rename it to a more generic name, and then, define another Taxonomy to identify the type (Pokemon, Digimon, etc.).

10. Scalability.

    - In order to improve performance and ensure the application we can follow some steps:
      - Optimize the database, checking the queries that can be heavy, like `meta_queries` and caching the results or even creating another database table with this information to access the data quickly.
      - Use different cache systems, like Memcached or Redis for the DB and static cache for the different pages.
      - Use a CDN to deliver the assets (code and static files).
      - Implement Load Balancing using different server instances depending on demand.
