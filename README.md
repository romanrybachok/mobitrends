# Install

1. composer update

2. copy env.example to .env

3. Set GOOGLE_API_KEY in .env


## Run commute command

php artisan calculateCommute {homeCoords} {workCoords} {timeCalculation=1} {scoreTransformation=1}

where homeCoords, workCoords are GPS coordinates with latitude and longitude (separated by comma)

timeCalculation (optional) is one of algorithms choosen [1,2,3]
scoreTransformation (optional) is score calculation algorithm [1,2,3]


Example run:

php artisan calculateCommute 49.5483334,25.5276294 49.5711916,25.5526451 1 1

php artisan calculateCommute 49.8386942,23.9071718 49.8326046,23.8721529 2


## Adding new time calculation algorithms

For this purpose you should extend abstact class AbstractCommuter and implement 
its getCommutingDuration method

## Adding new score transformation algorithms

For this purpose you should and new transformation score in getScore method.
