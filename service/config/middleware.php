<?php
/**
 * Copyright (c) 2026 erik <erik@erik.xyz> — https://erik.xyz
 *
 * 全局中间件配置（简化版）
 *
 * 请求流：Request → CORS → SecurityHeaders → Version → RateLimit → SQLGuard → Validation → Encryption → Controller
 */

return [
    'global' => [
        plugin\ads_api\middleware\CorsMiddleware::class,
        plugin\ads_api\middleware\SecurityHeadersMiddleware::class,
        plugin\ads_api\middleware\VersionMiddleware::class,
        plugin\ads_api\middleware\RateLimitMiddleware::class,
        plugin\ads_api\middleware\SqlGuardMiddleware::class,
        plugin\ads_api\middleware\ValidationMiddleware::class,
        plugin\ads_api\middleware\EncryptionMiddleware::class,
    ],
];
