<?php


namespace App\Services\Tencent;


use Illuminate\Support\Arr;
use League\Flysystem\AdapterInterface;
use League\Flysystem\Config;
use Qcloud\Cos\Client;

class CosAdapter implements AdapterInterface
{

    protected $client;

    protected $config;

    public function __construct(Client $client, Array $config)
    {
        $this->client = $client;
        $this->config = $config;
    }

    public function write($path, $contents, Config $config)
    {
        try {
            return $this->client->PutObject([
                'Bucket' => $config->get('bucket'), //格式：BucketName-APPID
                'Key' => $this->getObjectName($path),
                'Body' => $contents
            ]);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function writeStream($path, $resource, Config $config)
    {
        try {
            return $this->client->Upload($config->get('bucket'), $this->getObjectName($path), $resource);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function update($path, $contents, Config $config)
    {
        try {
            return $this->client->PutObject([
                'Bucket' => $config->get('bucket'), //格式：BucketName-APPID
                'Key' => $this->getObjectName($path),
                'Body' => $contents
            ]);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function updateStream($path, $resource, Config $config)
    {
        try {
            return $this->client->Upload($config->get('bucket'), $this->getObjectName($path), $resource);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function rename($path, $newpath): bool
    {
        return false;
    }

    public function copy($path, $newpath)
    {
        try {
            return $this->client->copy($this->config['bucket'], $this->getObjectName($newpath), $this->getObjectName($path));
        } catch (\Exception $e) {
            return false;
        }
    }

    public function delete($path)
    {
        try {
            return $this->client->DeleteObject([
                'Bucket' => $this->config['bucket'],
                'Key' => $this->getObjectName($path)
            ]);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function deleteDir($dirname): bool
    {
        return false;
    }

    public function createDir($dirname, Config $config): bool
    {
        return false;
    }

    public function setVisibility($path, $visibility): bool
    {
        return false;
    }

    public function has($path)
    {
        return $this->client->doesObjectExist($this->config['bucket'], $this->getObjectName($path));
    }

    public function read($path): bool
    {
        return false;
    }

    public function readStream($path): bool
    {
        return false;
    }

    public function listContents($directory = '', $recursive = false): array
    {
        $isTruncated = true;
        $marker = '';
        $filePath = [];
        while ($isTruncated) {
            $result = $this->client->listObjects([
                'Bucket' => $this->config['bucket'], //存储桶名称，由BucketName-Appid 组成，可以在COS控制台查看 https://console.cloud.tencent.com/cos5/bucket
                'Delimiter' => '/', //Delimiter表示分隔符, 设置为/表示列出当前目录下的object, 设置为空表示列出所有的object
                'Marker' => $marker,//起始对象键标记
                'Prefix' => $this->getObjectName($directory), //Prefix表示列出的object的key以prefix开始
                'MaxKeys' => 1000, // 设置最大遍历出多少个对象, 一次listObjects最大支持1000
            ]);

            $isTruncated = $result['IsTruncated'];

            if (empty($result['Contents'])) {
                break;
            }

            foreach ( $result['Contents'] as $content ) {
                $filePath[] = $content['Key'];
            }
        }
        return $filePath;
    }

    public function getMetadata($path)
    {
        return $this->client->HeadObject([
            'Bucket' => $this->config['bucket'],
            'Key' => $this->getObjectName($path)
        ]);
    }

    public function getSize($path): array
    {
        $metaData = $this->getMetadata($path);
        $size['size'] = Arr::get($metaData, 'Content-Length', 0);
        return $size;
    }

    public function getMimetype($path): array
    {
        $metaData = $this->getMetadata($path);
        $mimeType['mimetype'] = Arr::get($metaData, 'Content-Type', '');
        return $mimeType;
    }

    public function getTimestamp($path): array
    {
        $metaData = $this->getMetadata($path);
        $lastModified = Arr::get($metaData, 'Last-Modified', '');
        $modified['timestamp'] = strtotime($lastModified);
        return $modified;
    }

    public function getVisibility($path): bool
    {
        return false;
    }

    public function getUrl($path): string
    {
        return sprintf("%s%s", $this->config['url'], $this->getObjectName($path));
    }

    /**
     * @param $path
     * @return string
     */
    private function getObjectName($path): string
    {
        return ltrim($path, '/');
    }
}
