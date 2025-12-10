-- =====================================================
-- Parts Application - Performance Index Creation Script
-- Database: PartsProcessing (192.168.0.236)
-- Date: December 6, 2025
-- =====================================================

USE PartsProcessing;
GO

PRINT '========================================';
PRINT 'Starting Index Creation Process';
PRINT '========================================';
PRINT '';

-- =====================================================
-- SECTION 1: Critical Foreign Key Indexes
-- =====================================================

PRINT 'Creating Foreign Key Indexes on prt.PartsKitData...';

-- Check and create index on WorkCenterID
IF NOT EXISTS (SELECT 1 FROM sys.indexes WHERE object_id = OBJECT_ID('prt.PartsKitData') AND name = 'IX_PartsKitData_WorkCenterID')
BEGIN
    CREATE NONCLUSTERED INDEX IX_PartsKitData_WorkCenterID
        ON prt.PartsKitData(WorkCenterID);
    PRINT '  ✓ Created IX_PartsKitData_WorkCenterID';
END
ELSE
    PRINT '  - IX_PartsKitData_WorkCenterID already exists';

-- Check and create index on PartCategoryID
IF NOT EXISTS (SELECT 1 FROM sys.indexes WHERE object_id = OBJECT_ID('prt.PartsKitData') AND name = 'IX_PartsKitData_PartCategoryID')
BEGIN
    CREATE NONCLUSTERED INDEX IX_PartsKitData_PartCategoryID
        ON prt.PartsKitData(PartCategoryID);
    PRINT '  ✓ Created IX_PartsKitData_PartCategoryID';
END
ELSE
    PRINT '  - IX_PartsKitData_PartCategoryID already exists';

-- Check and create index on PartSubCategoryID
IF NOT EXISTS (SELECT 1 FROM sys.indexes WHERE object_id = OBJECT_ID('prt.PartsKitData') AND name = 'IX_PartsKitData_PartSubCategoryID')
BEGIN
    CREATE NONCLUSTERED INDEX IX_PartsKitData_PartSubCategoryID
        ON prt.PartsKitData(PartSubCategoryID);
    PRINT '  ✓ Created IX_PartsKitData_PartSubCategoryID';
END
ELSE
    PRINT '  - IX_PartsKitData_PartSubCategoryID already exists';

-- Check and create index on CountryID
IF NOT EXISTS (SELECT 1 FROM sys.indexes WHERE object_id = OBJECT_ID('prt.PartsKitData') AND name = 'IX_PartsKitData_CountryID')
BEGIN
    CREATE NONCLUSTERED INDEX IX_PartsKitData_CountryID
        ON prt.PartsKitData(CountryID);
    PRINT '  ✓ Created IX_PartsKitData_CountryID';
END
ELSE
    PRINT '  - IX_PartsKitData_CountryID already exists';

-- Check and create index on UserID
IF NOT EXISTS (SELECT 1 FROM sys.indexes WHERE object_id = OBJECT_ID('prt.PartsKitData') AND name = 'IX_PartsKitData_UserID')
BEGIN
    CREATE NONCLUSTERED INDEX IX_PartsKitData_UserID
        ON prt.PartsKitData(UserID);
    PRINT '  ✓ Created IX_PartsKitData_UserID';
END
ELSE
    PRINT '  - IX_PartsKitData_UserID already exists';

PRINT '';
PRINT 'Creating Foreign Key Index on prt.PartSubCategories...';

-- Check and create index on PartCategoryID in SubCategories
IF NOT EXISTS (SELECT 1 FROM sys.indexes WHERE object_id = OBJECT_ID('prt.PartSubCategories') AND name = 'IX_PartSubCategories_PartCategoryID')
BEGIN
    CREATE NONCLUSTERED INDEX IX_PartSubCategories_PartCategoryID
        ON prt.PartSubCategories(PartCategoryID);
    PRINT '  ✓ Created IX_PartSubCategories_PartCategoryID';
END
ELSE
    PRINT '  - IX_PartSubCategories_PartCategoryID already exists';

PRINT '';
PRINT 'Creating Foreign Key Index on prt.PartReferences...';

-- Check and create index on KitID in PartReferences
IF NOT EXISTS (SELECT 1 FROM sys.indexes WHERE object_id = OBJECT_ID('prt.PartReferences') AND name = 'IX_PartReferences_KitID')
BEGIN
    CREATE NONCLUSTERED INDEX IX_PartReferences_KitID
        ON prt.PartReferences(KitID);
    PRINT '  ✓ Created IX_PartReferences_KitID';
END
ELSE
    PRINT '  - IX_PartReferences_KitID already exists';

PRINT '';
PRINT 'Creating Foreign Key Indexes on bin schema tables...';

-- Check and create index on box_id in BoxContent
IF NOT EXISTS (SELECT 1 FROM sys.indexes WHERE object_id = OBJECT_ID('bin.BoxContent') AND name = 'IX_BoxContent_box_id')
BEGIN
    CREATE NONCLUSTERED INDEX IX_BoxContent_box_id
        ON bin.BoxContent(box_id);
    PRINT '  ✓ Created IX_BoxContent_box_id';
END
ELSE
    PRINT '  - IX_BoxContent_box_id already exists';

-- Check and create index on kit_id in BoxContent
IF NOT EXISTS (SELECT 1 FROM sys.indexes WHERE object_id = OBJECT_ID('bin.BoxContent') AND name = 'IX_BoxContent_kit_id')
BEGIN
    CREATE NONCLUSTERED INDEX IX_BoxContent_kit_id
        ON bin.BoxContent(kit_id);
    PRINT '  ✓ Created IX_BoxContent_kit_id';
END
ELSE
    PRINT '  - IX_BoxContent_kit_id already exists';

-- Check and create index on shelf_id in Boxes
IF NOT EXISTS (SELECT 1 FROM sys.indexes WHERE object_id = OBJECT_ID('bin.Boxes') AND name = 'IX_Boxes_shelf_id')
BEGIN
    CREATE NONCLUSTERED INDEX IX_Boxes_shelf_id
        ON bin.Boxes(shelf_id);
    PRINT '  ✓ Created IX_Boxes_shelf_id';
END
ELSE
    PRINT '  - IX_Boxes_shelf_id already exists';

-- =====================================================
-- SECTION 2: High Priority - Frequently Queried Columns
-- =====================================================

PRINT '';
PRINT 'Creating Indexes on Frequently Queried Columns...';

-- KitLCN is frequently used for lookups (FillBoxController)
IF NOT EXISTS (SELECT 1 FROM sys.indexes WHERE object_id = OBJECT_ID('prt.PartsKitData') AND name = 'IX_PartsKitData_KitLCN')
BEGIN
    CREATE NONCLUSTERED INDEX IX_PartsKitData_KitLCN
        ON prt.PartsKitData(KitLCN);
    PRINT '  ✓ Created IX_PartsKitData_KitLCN';
END
ELSE
    PRINT '  - IX_PartsKitData_KitLCN already exists';

-- Brand and Model are used for filtering (KitController index)
IF NOT EXISTS (SELECT 1 FROM sys.indexes WHERE object_id = OBJECT_ID('prt.PartsKitData') AND name = 'IX_PartsKitData_Brand_Model')
BEGIN
    CREATE NONCLUSTERED INDEX IX_PartsKitData_Brand_Model
        ON prt.PartsKitData(Brand, Model);
    PRINT '  ✓ Created IX_PartsKitData_Brand_Model';
END
ELSE
    PRINT '  - IX_PartsKitData_Brand_Model already exists';

-- Box name for lookups
IF NOT EXISTS (SELECT 1 FROM sys.indexes WHERE object_id = OBJECT_ID('bin.Boxes') AND name = 'IX_Boxes_box_name')
BEGIN
    CREATE NONCLUSTERED INDEX IX_Boxes_box_name
        ON bin.Boxes(box_name);
    PRINT '  ✓ Created IX_Boxes_box_name';
END
ELSE
    PRINT '  - IX_Boxes_box_name already exists';

-- Shelf name for lookups
IF NOT EXISTS (SELECT 1 FROM sys.indexes WHERE object_id = OBJECT_ID('bin.Shelves') AND name = 'IX_Shelves_shelf_name')
BEGIN
    CREATE NONCLUSTERED INDEX IX_Shelves_shelf_name
        ON bin.Shelves(shelf_name);
    PRINT '  ✓ Created IX_Shelves_shelf_name';
END
ELSE
    PRINT '  - IX_Shelves_shelf_name already exists';

-- =====================================================
-- SECTION 3: Medium Priority - Sorting & Timestamps
-- =====================================================

PRINT '';
PRINT 'Creating Indexes for DataTables Sorting...';

-- Created timestamps for sorting - PartsKitData
IF NOT EXISTS (SELECT 1 FROM sys.indexes WHERE object_id = OBJECT_ID('prt.PartsKitData') AND name = 'IX_PartsKitData_created_at')
BEGIN
    CREATE NONCLUSTERED INDEX IX_PartsKitData_created_at
        ON prt.PartsKitData(created_at);
    PRINT '  ✓ Created IX_PartsKitData_created_at';
END
ELSE
    PRINT '  - IX_PartsKitData_created_at already exists';

-- Created timestamps for sorting - Boxes
IF NOT EXISTS (SELECT 1 FROM sys.indexes WHERE object_id = OBJECT_ID('bin.Boxes') AND name = 'IX_Boxes_created_at')
BEGIN
    CREATE NONCLUSTERED INDEX IX_Boxes_created_at
        ON bin.Boxes(created_at);
    PRINT '  ✓ Created IX_Boxes_created_at';
END
ELSE
    PRINT '  - IX_Boxes_created_at already exists';

-- Created timestamps for sorting - Shelves
IF NOT EXISTS (SELECT 1 FROM sys.indexes WHERE object_id = OBJECT_ID('bin.Shelves') AND name = 'IX_Shelves_created_at')
BEGIN
    CREATE NONCLUSTERED INDEX IX_Shelves_created_at
        ON bin.Shelves(created_at);
    PRINT '  ✓ Created IX_Shelves_created_at';
END
ELSE
    PRINT '  - IX_Shelves_created_at already exists';

-- =====================================================
-- SECTION 4: Composite Indexes for Common Filters
-- =====================================================

PRINT '';
PRINT 'Creating Composite Indexes for Common Query Patterns...';

-- User-specific kit queries (employee role)
IF NOT EXISTS (SELECT 1 FROM sys.indexes WHERE object_id = OBJECT_ID('prt.PartsKitData') AND name = 'IX_PartsKitData_UserID_created_at')
BEGIN
    CREATE NONCLUSTERED INDEX IX_PartsKitData_UserID_created_at
        ON prt.PartsKitData(UserID, created_at DESC);
    PRINT '  ✓ Created IX_PartsKitData_UserID_created_at';
END
ELSE
    PRINT '  - IX_PartsKitData_UserID_created_at already exists';

-- Box active status filtering
IF NOT EXISTS (SELECT 1 FROM sys.indexes WHERE object_id = OBJECT_ID('bin.Boxes') AND name = 'IX_Boxes_is_active_created_at')
BEGIN
    CREATE NONCLUSTERED INDEX IX_Boxes_is_active_created_at
        ON bin.Boxes(is_active, created_at DESC);
    PRINT '  ✓ Created IX_Boxes_is_active_created_at';
END
ELSE
    PRINT '  - IX_Boxes_is_active_created_at already exists';

-- =====================================================
-- COMPLETION SUMMARY
-- =====================================================

PRINT '';
PRINT '========================================';
PRINT 'Index Creation Complete!';
PRINT '========================================';
PRINT '';
PRINT 'Generating Index Summary Report...';
PRINT '';

-- Show summary of all indexes created
SELECT
    OBJECT_SCHEMA_NAME(i.object_id) + '.' + OBJECT_NAME(i.object_id) AS TableName,
    i.name AS IndexName,
    i.type_desc AS IndexType,
    STUFF((
        SELECT ', ' + COL_NAME(ic.object_id, ic.column_id)
        FROM sys.index_columns ic
        WHERE ic.object_id = i.object_id
            AND ic.index_id = i.index_id
        ORDER BY ic.key_ordinal
        FOR XML PATH('')
    ), 1, 2, '') AS IndexedColumns
FROM sys.indexes i
WHERE i.object_id IN (
    OBJECT_ID('prt.PartsKitData'),
    OBJECT_ID('prt.PartReferences'),
    OBJECT_ID('prt.PartSubCategories'),
    OBJECT_ID('bin.Boxes'),
    OBJECT_ID('bin.Shelves'),
    OBJECT_ID('bin.BoxContent')
)
AND i.type_desc IN ('NONCLUSTERED', 'CLUSTERED')
AND i.name LIKE 'IX_%'
ORDER BY TableName, IndexName;

PRINT '';
PRINT 'Index creation script completed successfully!';
PRINT 'You can now test application performance improvements.';
GO
