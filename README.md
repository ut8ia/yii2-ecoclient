# yii2-ecoclient
client library for ecotower service.

according to swagger api :
https://app.swaggerhub.com/apis/ut8ia/ecoTower/1.0.0


For installation add in composer json :
-
```
    "ut8ia/yii2-ecoclient": "*",
```

set in params.php or params-local.php your prefix for tables names and credentials:
-

```
'ecoclient' => [
    'dbTablesPrefix' => 'ecoclient_',
    'apikey' => 'kjS0h234o14SwN6go1ssr6P22nP3PMd4',
    'hashkey'=>'luef786642gg523465',
    'apihost' => 'https://api.ecotower-aggregator.org'    
]
```

apply migrations :
-
./yii migrate --migrationPath=vendor/ut8ia/yii2-ecoclient/migrations

config module in main.php :
-
```
'modules' => [
...
        'ecoclient' => [
            'class' => 'ut8ia\ecoclient\modules\ecoclient\Ecoclient'
        ]
    ]

```

try to fetch reports from city by cron console call {city id}:
-
```
./yii ecoclient/retrieve/cityreport 1

```

also you can use web view example of your reports :
-
 https://yoursite.com/ecoclient/display
