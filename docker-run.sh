#!/bin/bash
set -e

echo "========================================================"
echo "  EduLearn English Learning Platform - Docker Builder"
echo "========================================================"
echo ""

if [ ! -f .env ]; then
    echo "[INFO] Creating .env from .env.docker.example..."
    cp .env.docker.example .env
fi

echo "[INFO] Building and starting Docker containers..."
docker compose up --build -d

echo ""
echo "========================================================"
echo "  EduLearn is running successfully!"
echo "  Web Application: http://localhost"
echo "  Default Admin:   admin@edulearn.vn / password123"
echo "  Default Student: student@edulearn.vn / password123"
echo "========================================================"
