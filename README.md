# yii2-ecoclient
client library for ecotower service


apply migrations :
-
./yii migrate --migrationPath=vendor/ut8ia/yii2-ecoclient/migrations

set in params-local.php your credentials :
-

```
 'ecoclient' => [
        'apikey' => 'Bearer kjS0h234o14SwN6go1ssr6P22nP3PMd4',
        'hashkey'=>'luef786642gg523465',
        'apihost' => 'https://api.ecotower-aggregator.org'
    ]
```

config module in main.php :

```
'modules' => [
...
        'ecoclient' => [
            'class' => 'ut8ia\ecoclient\modules\ecoclient\Ecoclient'
        ]
    ]

```