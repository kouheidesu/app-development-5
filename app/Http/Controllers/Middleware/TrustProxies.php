<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Http\Middleware\TrustProxies as Middleware;

class TrustProxies extends Middleware
{
    /**
     * 信頼するプロキシ
     *
     * @var array<int, string>|string|null
     */
    protected $proxies = '*'; // すべてのプロキシを信頼

    /**
     * プロキシ検出に使うヘッダー
     *
     * @var int
     */
    protected $headers =
    Request::HEADER_X_FORWARDED_FOR |
        Request::HEADER_X_FORWARDED_HOST |
        Request::HEADER_X_FORWARDED_PORT |
        Request::HEADER_X_FORWARDED_PROTO; // HTTPS 判定を有効化
}
