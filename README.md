Hephaestus
======

A terminal toolbox for Phramework

---

> *Hephaestus (/hɪˈfiːstəs/, /həˈfɛstəs/ or /hɨˈfɛstəs/; eight spellings; Ancient Greek: Ἥφαιστος Hēphaistos) is the Greek god of blacksmiths, craftsmen, artisans, sculptors, metals, metallurgy, fire and volcanoes. [[source]](https://en.wikipedia.org/wiki/Hephaestus)*


## Requirements
- php >= 5.6
- [composer](https://getcomposer.org/)

## Installation
Edit your `~/.composer/composer.json` file to include Hephaestus repository
```json
{
  "repositories": [{
    "type": "vcs",
    "url": "git@gitlab.mathlogic.eu:Phramework/Hephaestus.git"
  }],
  "require-dev": {
    "phramework/hephaestus": "dev-master"
  }
}
```

You can require Hephaestus from terminal using
```bash
composer global require --dev phramework/hephaestus:dev-master
```

Make sure you have ~/.composer/vendor/bin/ in your path.

### Update
```bash
composer global update
```

## Development notes

Tip: Create a symbolic link of binary file, to allow editor highlight PHP code
```lang=bash
ln -s /var/www/Hephaestus/bin/hephaestus /var/www/Hephaestus/bin/hephaestus.symbolic.php
```

License
=======
Copyright 2015 Spafaridis Xenofon

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

    http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
