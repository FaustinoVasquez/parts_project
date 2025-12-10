#!/bin/bash

# =====================================================
# Parts Application - Performance Optimization Deployment
# Date: December 6, 2025
# =====================================================

set -e

SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
cd "$SCRIPT_DIR"

echo "========================================="
echo "Parts Application Performance Deployment"
echo "========================================="
echo ""

# Step 1: Create SQL Server indexes
echo "Step 1: Creating SQL Server Indexes"
echo "-----------------------------------"
echo ""
echo "Please choose how to run the SQL Server index script:"
echo ""
echo "  1. Run automatically from PHP container (recommended)"
echo "  2. I'll run it manually in SQL Server Management Studio"
echo ""
read -p "Enter choice (1 or 2): " choice
echo ""

if [ "$choice" = "1" ]; then
    echo "Running SQL Server index creation script..."
    echo ""

    # Run the SQL script via PHP container
    docker exec parts_project-php-1 php -r "
        \$sql = file_get_contents('/var/www/database/sql_server_indexes.sql');

        // Remove GO statements and split into batches
        \$batches = preg_split('/^GO\s*$/mi', \$sql);

        try {
            \$conn = new PDO('sqlsrv:Server=192.168.0.236,1433;Database=PartsProcessing;TrustServerCertificate=true', 'tempuser', 'pLa13t1B');
            \$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            foreach (\$batches as \$batch) {
                \$batch = trim(\$batch);
                if (empty(\$batch)) continue;

                // For PRINT statements, we need to handle them separately
                if (stripos(\$batch, 'PRINT') !== false) {
                    // Execute but don't fetch results for PRINT
                    \$conn->exec(\$batch);
                } else {
                    \$stmt = \$conn->query(\$batch);

                    // If it's a SELECT, show results
                    if (stripos(\$batch, 'SELECT') === 0) {
                        while (\$row = \$stmt->fetch(PDO::FETCH_ASSOC)) {
                            foreach (\$row as \$key => \$value) {
                                echo str_pad(\$key, 30) . ': ' . \$value . PHP_EOL;
                            }
                            echo str_repeat('-', 60) . PHP_EOL;
                        }
                    }
                }
            }

            echo PHP_EOL;
            echo '✓ SQL Server indexes created successfully!' . PHP_EOL;

        } catch (Exception \$e) {
            echo 'Error: ' . \$e->getMessage() . PHP_EOL;
            exit(1);
        }
    "

    if [ $? -eq 0 ]; then
        echo ""
        echo "✓ Indexes created successfully!"
    else
        echo ""
        echo "✗ Error creating indexes. Please check the error messages above."
        exit 1
    fi
elif [ "$choice" = "2" ]; then
    echo "Please run the following SQL script manually:"
    echo ""
    echo "  File: /home/fvasquez/parts_project/database/sql_server_indexes.sql"
    echo "  Server: 192.168.0.236"
    echo "  Database: PartsProcessing"
    echo ""
    read -p "Press Enter when you've completed the SQL script execution..."
else
    echo "Invalid choice. Exiting."
    exit 1
fi

echo ""
echo "Step 2: Warming Reference Data Cache"
echo "------------------------------------"
echo ""

# Warm up the cache
docker exec parts_project-php-1 php artisan cache:warm-reference-data

if [ $? -eq 0 ]; then
    echo ""
    echo "✓ Cache warmed successfully!"
else
    echo ""
    echo "✗ Error warming cache."
    exit 1
fi

echo ""
echo "========================================="
echo "Deployment Complete!"
echo "========================================="
echo ""
echo "Performance optimizations have been deployed:"
echo "  ✓ SQL Server indexes created"
echo "  ✓ Reference data cache warmed"
echo "  ✓ Application ready for improved performance"
echo ""
echo "Recommended next steps:"
echo "  1. Test the application at https://parts.mitechnologiesinc.com"
echo "  2. Monitor performance improvements"
echo "  3. Check /home/fvasquez/parts_project/PERFORMANCE_OPTIMIZATION_REPORT.md"
echo ""
echo "To clear cache if needed:"
echo "  docker exec parts_project-php-1 php artisan cache:clear"
echo ""
