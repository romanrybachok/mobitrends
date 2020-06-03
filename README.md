# Install

1. composer update

2. copy env.example to .env

3. Set GOOGLE_API_KEY in .env


## Run commute command

php artisan calculateCommute {homeCoords} {workCoords} {timeCalculation=1} {scoreTransformation=1}

where homeCoords, workCoords are GPS coordinates with latitude and longitude (separated by comma)

timeCalculation (optional) is one of algorithms choosen. Allowed values:

• 1 - take straight distance between home and work and assume 30 km/h speed. This is the default
way if none is specified.

• 2 - take distance returned by Google directions call and assume 30 km/h. Google distance will be
greater than straight distance.

• 3 - directly take time returned by Google directions call.



scoreTransformation (optional) is score calculation algorithm. Allowed values:

• 1 - no transformation (default) - the score is just duration of travel in minutes

• 2 - even distribution - the score is evenly distributed between 0 minutes - 0 points and 30 minutes -
100 points, above 30 minutes it is 100 points. e.g. 15 minutes - 50 points, 10 minutes - 33 points.

• 3- log with base 2 - the result is log(duration) with base 2 for duration >= 1 minute and 0 for
duration < 1 minute


Example run:

php artisan calculateCommute 49.5483334,25.5276294 49.5711916,25.5526451 1 1

php artisan calculateCommute 49.8386942,23.9071718 49.8326046,23.8721529 2


## Adding new time calculation algorithms

For this purpose you should extend abstact class AbstractCommuter and implement 
its getCommutingDuration method

## Adding new score transformation algorithms

For this purpose you should and new transformation score in getScore method.
