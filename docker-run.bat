@echo off
echo ========================================================
echo   EduLearn English Learning Platform - Docker Builder
echo ========================================================
echo.

if not exist .env (
    echo [INFO] Creating .env from .env.docker.example...
    copy .env.docker.example .env
)

echo [INFO] Building and starting Docker containers...
docker compose up --build -d

echo.
echo ========================================================
echo   EduLearn is running successfully!
echo   Web Application: http://localhost
echo   Default Admin:   admin@edulearn.vn / password123
echo   Default Student: student@edulearn.vn / password123
echo ========================================================
echo.
pause
