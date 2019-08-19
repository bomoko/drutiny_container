# Drutiny Runner

This is, right now, a POC for ALGM that will connect to sites/branches listed in the lagoonprojects.yml file and run the stated drutiny policy on them.

To run locally
- clone the repo
- copy the .env.example to .env and fill in the values
- copy the lagoonprojects.yml.example to lagoonprojects.yml and fill in the values
- run `docker-compose up -d`
- run `docker-compose exec cli ./audit.php app:run`