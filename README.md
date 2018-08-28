# Core
The SHT Core is a placeholder for all my web projects based on a PHP backend along with an HTML/CSS/JS frontend.
It provides an easy way to deploy new projects and maintain a core path in their development, allowing faster bug fixes and easier maintainability.

## Structure
The main components of the Core are the Core class itself and the Shell.

The Core contains the main class definition along with some methods that load all the modules and then initialize the Shell.

The Core modules are needed by every project, for example for logging or form handling.

The Shell can be modified to meet a project's requirements. Modules from the Core can be selectively loaded on the Shell class, so can Shell modules by using the traits that correspond to a specific module.
The Shell class contains the initialization of the datamembers that control how the page is rendered and how the handling of each request is performed.

Because each page can't have the same title and URL (for example index can be / or /index.php or /index or /home), a blueprint rendering system is used in order to include the basic components and render the page based on a specific blueprint. The core contains methods for handling how the blueprints are rendered.

In order to keep the root organized, the .htaccess file redirects all requests to index.php, unless they point to a static file, and then the contents of the page that was requested are rendered.

## Changelogs
Changelogs for each and every release can be found [here](https://github.com/ShtHappens796/Core/releases).

## Copyright
Any reproductions of my work **must** include a link to this repository and the following copyright notice, along with the project's license.

© 2018 Tasos Papalyras - All Rights Reserved
