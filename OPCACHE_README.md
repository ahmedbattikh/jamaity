# OPcache Configuration for Jamaity Symfony Application

This document explains the OPcache configuration implemented to improve the performance of the Jamaity Symfony application.

## What is OPcache?

OPcache is a PHP extension that improves performance by storing precompiled script bytecode in shared memory, eliminating the need for PHP to load and parse scripts on each request.

## Performance Benefits

- **Faster Page Load Times**: Reduces PHP compilation overhead
- **Lower CPU Usage**: Eliminates repeated script parsing
- **Better Memory Efficiency**: Shared bytecode cache across processes
- **Improved Throughput**: Can handle more concurrent requests

## Configuration Files

### Development Environment (`docker/php/opcache-dev.ini`)
- Moderate memory allocation (128MB)
- Timestamp validation enabled for development flexibility
- Revalidation every 2 seconds
- Preloading disabled for easier debugging

### Production Environment (`docker/php/opcache-prod.ini`)
- Higher memory allocation (256MB)
- Timestamp validation disabled for maximum performance
- Preloading enabled with Symfony container preloading
- File cache enabled for persistence

## Usage

### Development (Default)
```bash
docker-compose up -d
```
This uses the development OPcache configuration automatically.

### Production
```bash
docker-compose -f compose.yaml -f compose.prod.yaml up -d
```
This enables production OPcache settings with maximum optimization.

## Monitoring OPcache

### Check OPcache Status
You can check OPcache status by creating a PHP info page or using the following command in the container:

```bash
docker exec jamaity-backend-1 php -r "print_r(opcache_get_status());"
```

### View OPcache Configuration
```bash
docker exec jamaity-backend-1 php -r "print_r(opcache_get_configuration());"
```

### Reset OPcache (if needed)
```bash
docker exec jamaity-backend-1 php -r "opcache_reset();"
```

## Key Configuration Parameters

| Parameter | Development | Production | Description |
|-----------|-------------|------------|--------------|
| `opcache.memory_consumption` | 128MB | 256MB | Memory allocated for bytecode cache |
| `opcache.validate_timestamps` | 1 | 0 | Check file modifications |
| `opcache.max_accelerated_files` | 10000 | 20000 | Maximum cached files |
| `opcache.preload` | Disabled | Enabled | Preload Symfony container |
| `opcache.file_cache` | Disabled | Enabled | Persistent file cache |

## Preloading

The `config/preload.php` file is configured to:
1. Load Symfony container preload files
2. Precompile core Symfony components
3. Precompile application source files

This significantly reduces the bootstrap time for each request.

## Troubleshooting

### OPcache Not Working
1. Check if the extension is loaded: `php -m | grep -i opcache`
2. Verify configuration: `php --ini`
3. Check logs: `docker logs jamaity-backend-1`

### Performance Issues
1. Monitor memory usage: Check `opcache.memory_consumption`
2. Check hit ratio: Should be > 95% in production
3. Verify preloading: Check if preload files exist

### Cache Issues in Development
If you're experiencing caching issues during development:
```bash
# Reset OPcache
docker exec jamaity-backend-1 php -r "opcache_reset();"

# Or restart the container
docker-compose restart backend
```

## Expected Performance Improvements

With OPcache properly configured, you should see:
- **20-50% faster page load times**
- **Reduced server response times**
- **Lower CPU usage**
- **Better handling of concurrent requests**

The exact improvement depends on your application complexity and server resources.