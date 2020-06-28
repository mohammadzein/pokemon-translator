# Pokemon Translator

This application translate english pokemon names to english shakespeare. 
It uses the api of [PokéAPI website](https://pokeapi.co/) to get the pokemon description, and the api of [Funtranslation website](https://funtranslations.com/) to translate it.
It is built with Lumen and can be served with Docker.

### Requirements using Docker
- Docker **19.03.8**
- Docker Compose **1.25.5**
- Port **5000** should be available

### Requirements without Docker
- Nginx **1.18.0** or Apache **2.4.43**
- PHP **^7.2.5** with extensions required by Lumen
- Composer **1.10.5**

### Docker Official Documentation

Documentation for Docker can be found on [Docker website](https://docs.docker.com/)

### Lumen Official Documentation

Documentation for the framework can be found on the [Lumen website](https://lumen.laravel.com/docs).


## Installation

```bash
git clone https://github.com/mohammadzein/pokemon-translator
```

### Start the application with Docker Compose

```bash
docker-compose up
```

### Stop the application with Docker Compose

```bash
docker-compose down
```

### For developers to run test
```
docker exec -it <container_id_or_name> ./vendor/bin/phpunit 
```
