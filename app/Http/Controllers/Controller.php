<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

/**
 * Class Controller
 * @author yee
 * @date 2023/4/12
 * @package App\Http\Controllers
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param mixed $data
     * @param string $message
     * @return JsonResponse
     */
    public function success($data = [], string $message = 'ok'): JsonResponse
    {
        $res = !collect($data)->get('list') ? ['list' => $data] : $data;
        return response()->json([
            'code' => 200,
            'message' => $message,
            'data' => $res,
        ]);
    }
}
