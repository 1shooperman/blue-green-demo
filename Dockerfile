# Lightweight, simple: use PHP built-in server on port 80
FROM php:8.3-cli-alpine

# Optional: curl for container-level HEALTHCHECKs
RUN apk add --no-cache curl

WORKDIR /app
COPY public/ public/
COPY router.php .

EXPOSE 80

# Container healthcheck (optional but useful)
HEALTHCHECK --interval=10s --timeout=3s --retries=3 \
  CMD curl -fsS http://127.0.0.1/health || exit 1

# Serve the app on port 80
CMD ["php", "-S", "0.0.0.0:80", "-t", "public", "router.php"]
