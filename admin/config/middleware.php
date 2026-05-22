<?php
/**
 * Copyright (c) 2026 erik <erik@erik.xyz> — https://erik.xyz
 *
 * 管理后台全局中间件配置（简化版）
 */

return [
    'global' => [
        admin\middleware\VersionMiddleware::class,
    ],
];
