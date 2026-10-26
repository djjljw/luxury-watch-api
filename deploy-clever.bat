@echo off
echo ===================================================
echo   Deploying Luxury Watch API to Clever Cloud
echo ===================================================
echo.

echo [1/5] Membuat aplikasi PHP di Clever Cloud...
call clever.cmd create --type php luxury-watch-api
echo.

echo [2/5] Membuat Add-on Database MySQL & Menghubungkannya...
call clever.cmd addon create mysql-addon --plan dev luxury-watch-db --link luxury-watch-api
echo.

echo [3/5] Mengatur Environment Variables Laravel...
call clever.cmd env set CC_WEBROOT /public
call clever.cmd env set CC_PHP_VERSION 8.3
call clever.cmd env set CC_POST_BUILD_HOOK ./clevercloud/post_build.sh
call clever.cmd env set APP_KEY base64:SkKZjOJ5x2B4S5tlRX0oZ72CbGxfEJiHTCVf+7+u5YM=
call clever.cmd env set APP_ENV production
call clever.cmd env set APP_DEBUG false
echo.

echo [4/5] Memulai Proses Deploy ke Cloud...
call clever.cmd deploy
echo.

echo [5/5] Membuka Aplikasi Live...
call clever.cmd open
echo.
echo ===================================================
echo   Deployment Selesai!
echo ===================================================
pause
