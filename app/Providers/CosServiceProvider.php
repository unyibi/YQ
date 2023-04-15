<?php

namespace App\Providers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Filesystem;
use Qcloud\Cos\Client;
use App\Services\Tencent\CosAdapter;

/**
 * 腾讯云COS provider
 * Class CosServiceProvider
 * @author wang
 * @date 2022/6/27
 * @package App\Providers
 */
class CosServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Storage::extend("cos", function ($app, $config) {
            $client = new Client([
                'region' => $config['region'],
                'schema' => 'http', //协议头部，默认为http
                'credentials' => [
                    'secretId' => $config['secretId'],
                    'secretKey' => $config['secretKey']
                ]
            ]);
            return new Filesystem(new CosAdapter($client, $config), $config);
        });

        Storage::extend("pi", function ($app, $config) {
            $client = new Client([
                'region' => $config['region'],
                'schema' => 'http', //协议头部，默认为http
                'credentials' => [
                    'secretId' => $config['secretId'],
                    'secretKey' => $config['secretKey']
                ]
            ]);
            return new Filesystem(new CosAdapter($client, $config), $config);
        });
    }
}
