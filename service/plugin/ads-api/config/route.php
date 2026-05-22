<?php
/**
 * Copyright (c) 2026 erik <erik@erik.xyz> — https://erik.xyz
 *
 * API 路由配置（简化版）
 */

use plugin\ads_api\middleware\AuthMiddleware;
use plugin\ads_api\controller\v1\AuthController;
use plugin\ads_api\controller\v1\CaptchaController;
use plugin\ads_api\controller\v1\HealthController;
use plugin\ads_api\controller\v1\PlatformController;
use plugin\ads_api\controller\v1\AccountController;
use plugin\ads_api\controller\v1\CampaignController;
use plugin\ads_api\controller\v1\DashboardController;
use plugin\ads_api\controller\v1\ReportController;
use plugin\ads_api\controller\v1\ExportController;
use plugin\ads_api\controller\v1\DocController;

require_once __DIR__ . '/../route_helpers.php';

// Public routes
Webman\Route::get('/health', [HealthController::class, 'health']);
Webman\Route::get('/ping', [HealthController::class, 'ping']);
Webman\Route::get('/docs', [DocController::class, 'index']);

Webman\Route::get('/api/captcha/generate', versioned(CaptchaController::class, 'generate'));
Webman\Route::post('/api/captcha/verify', versioned(CaptchaController::class, 'verify'));
Webman\Route::post('/api/auth/login', versioned(AuthController::class, 'login'));
Webman\Route::get('/api/platforms', versioned(PlatformController::class, 'index'));

// Authenticated routes
Webman\Route::group('/api', function () {
    // Auth
    Webman\Route::get('/auth/me', versioned(AuthController::class, 'me'));
    Webman\Route::post('/auth/refresh', versioned(AuthController::class, 'refreshToken'));

    // Platforms & Accounts
    Webman\Route::get('/platforms/{code}/oauth-url', versioned(PlatformController::class, 'oauthUrl'));
    Webman\Route::post('/platforms/{code}/callback', versioned(PlatformController::class, 'callback'));

    Webman\Route::get('/accounts', versioned(AccountController::class, 'index'));
    Webman\Route::get('/accounts/{id}', versioned(AccountController::class, 'show'));
    Webman\Route::delete('/accounts/{id}', versioned(AccountController::class, 'destroy'));
    Webman\Route::post('/accounts/{id:\d+}/sync', versioned(AccountController::class, 'sync'));

    // Campaigns
    Webman\Route::get('/campaigns', versioned(CampaignController::class, 'index'));
    Webman\Route::post('/campaigns', versioned(CampaignController::class, 'store'));
    Webman\Route::get('/campaigns/{id}', versioned(CampaignController::class, 'show'));
    Webman\Route::put('/campaigns/{id}', versioned(CampaignController::class, 'update'));
    Webman\Route::post('/campaigns/{id:\d+}/toggle', versioned(CampaignController::class, 'toggle'));
    Webman\Route::post('/campaigns/batch/toggle', versioned(CampaignController::class, 'batchToggle'));

    // Reports
    Webman\Route::get('/reports/summary', versioned(DashboardController::class, 'summary'));
    Webman\Route::get('/reports/custom', versioned(ReportController::class, 'custom'));
    Webman\Route::get('/reports/export', versioned(ExportController::class, 'export'));
    Webman\Route::get('/reports/export-dashboard', versioned(ExportController::class, 'exportDashboard'));
})->middleware([AuthMiddleware::class]);
