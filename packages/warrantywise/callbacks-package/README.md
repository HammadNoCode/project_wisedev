## Installation

To install add Github as a repository in composer.json
```json
...
"repositories": {
    "warrantywise/callbacks-package": {
        "type": "git",
        "url": "https://github.com/warrantywise/callbacks-package"
    }
},
...
```
You will need to generate a Github personal access token (https://docs.github.com/en/free-pro-team@latest/github/authenticating-to-github/creating-a-personal-access-token) if you haven't already.

Require the packages like normal:
```
composer require warrantywise/callbacks-package
```

To update use:
```
composer update warrantywise/callbacks-package
```

For local development include the repositories as symlinks instead:
```json
...
"repositories": {
    "warrantywise/callbacks-package": {
        "type": "path",
        "url": "packages/warrantywise/callbacks-package",
        "options": {
            "symlink": true
        }
    }
},
```
