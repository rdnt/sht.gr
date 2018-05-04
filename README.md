# Core
The SHT Core is a placeholder for all my web projects based on a PHP backend along with an HTML/CSS/JS frontend.

## Structure
The main components of the SHT Core is the Core itself and the Shell.

The Core contains the main class definition along with some methods that load all the modules and then initialize the Shell.

The Core modules are needed by every project, like a form handling mechanism and the authentication framework.

The Shell can be modified to meet a project's requirements. Modules from the Core can be selectively loaded on the Shell class, so can Shell modules by using the traits that correspond to a specific module.
The Shell class can and should be modified. It contains the initialization of some variables that control how the Shell appears and what pages it offers.

Because each page can't have the same title and URL (for example index can be / or /index.php or /index or /home), a blueprints rendering system is used in order to include the basic components and render the page based on a specific blueprint. The core contains methods for deciding how the blueprints are rendered.

In order to keep the root organized, the index.php parses all requests and renders the contents of the page that was requested. No other .php files are on the root folder and the .htaccess redirects all requests to the index file.



## Changelogs
Changelogs for each and every release can be found [here](https://github.com/ShtHappens796/Core/releases).

## Copyright
Any reproductions of my work **must** include a link to this repository and the following copyright notice, along with the project's license.

© 2018 Tasos Papalyras - All Rights Reserved
