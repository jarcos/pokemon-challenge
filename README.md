# The Pokémon Challenge

## How to start the environment

This project is based in the [WP-ENV](https://developer.wordpress.org/block-editor/reference-guides/packages/packages-env/) package. Install the npm package globally start docker on your computer and then run `wp-env start`. This command will create a new environment based in docker.

## Code explanation

The starter theme used for this project is [Understrap](https://understrap.com). Also, as a dependency, we are using Advanced Custom Fields Pro, which is included into the repo. After deploying the environment for the first time, activate the Understrap theme and the ACF Pro plugin. Then go to Custom Fields and synchronise the Custom Fields added to the theme by json files. These files are stored in the acf-json folder.

We have also created some custom functionalities, here is a list of the followings:

- In the inc/cpt.php file there is the Pokémons CPT and Primary and Secondary Types taxonomies definitions.
- In the js/fetch-pokemon.js there is a generated code from the TypeScript file found at src/ts/fetch-pokemon.ts. In order to generate these files a tsconfig.json file has been created. You can run the `tsc` from the terminal when being placed in the themes/understrap folder to regenerate the file or check any terminal inputs.
- The inc/enqueue.php file has been modified in order to enqueue new scripts and styles.
