<?php

namespace Map;

use \PuzzleArchive;
use \PuzzleArchiveQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'puzzle_archive' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class PuzzleArchiveTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    public const CLASS_NAME = '.Map.PuzzleArchiveTableMap';

    /**
     * The default database name for this class
     */
    public const DATABASE_NAME = 'palindrome';

    /**
     * The table name for this class
     */
    public const TABLE_NAME = 'puzzle_archive';

    /**
     * The PHP name of this class (PascalCase)
     */
    public const TABLE_PHP_NAME = 'PuzzleArchive';

    /**
     * The related Propel class for this table
     */
    public const OM_CLASS = '\\PuzzleArchive';

    /**
     * A class that can be returned by this tableMap
     */
    public const CLASS_DEFAULT = 'PuzzleArchive';

    /**
     * The total number of columns
     */
    public const NUM_COLUMNS = 16;

    /**
     * The number of lazy-loaded columns
     */
    public const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    public const NUM_HYDRATE_COLUMNS = 16;

    /**
     * the column name for the id field
     */
    public const COL_ID = 'puzzle_archive.id';

    /**
     * the column name for the title field
     */
    public const COL_TITLE = 'puzzle_archive.title';

    /**
     * the column name for the url field
     */
    public const COL_URL = 'puzzle_archive.url';

    /**
     * the column name for the spreadsheet_id field
     */
    public const COL_SPREADSHEET_ID = 'puzzle_archive.spreadsheet_id';

    /**
     * the column name for the solution field
     */
    public const COL_SOLUTION = 'puzzle_archive.solution';

    /**
     * the column name for the status field
     */
    public const COL_STATUS = 'puzzle_archive.status';

    /**
     * the column name for the slack_channel field
     */
    public const COL_SLACK_CHANNEL = 'puzzle_archive.slack_channel';

    /**
     * the column name for the slack_channel_id field
     */
    public const COL_SLACK_CHANNEL_ID = 'puzzle_archive.slack_channel_id';

    /**
     * the column name for the wrangler_id field
     */
    public const COL_WRANGLER_ID = 'puzzle_archive.wrangler_id';

    /**
     * the column name for the sheet_mod_date field
     */
    public const COL_SHEET_MOD_DATE = 'puzzle_archive.sheet_mod_date';

    /**
     * the column name for the sort_order field
     */
    public const COL_SORT_ORDER = 'puzzle_archive.sort_order';

    /**
     * the column name for the note field
     */
    public const COL_NOTE = 'puzzle_archive.note';

    /**
     * the column name for the solver_count field
     */
    public const COL_SOLVER_COUNT = 'puzzle_archive.solver_count';

    /**
     * the column name for the created_at field
     */
    public const COL_CREATED_AT = 'puzzle_archive.created_at';

    /**
     * the column name for the updated_at field
     */
    public const COL_UPDATED_AT = 'puzzle_archive.updated_at';

    /**
     * the column name for the archived_at field
     */
    public const COL_ARCHIVED_AT = 'puzzle_archive.archived_at';

    /**
     * The default string format for model objects of the related table
     */
    public const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     *
     * @var array<string, mixed>
     */
    protected static $fieldNames = [
        self::TYPE_PHPNAME       => ['Id', 'Title', 'Url', 'SpreadsheetId', 'Solution', 'Status', 'SlackChannel', 'SlackChannelId', 'WranglerId', 'SheetModDate', 'SortOrder', 'Note', 'SolverCount', 'CreatedAt', 'UpdatedAt', 'ArchivedAt', ],
        self::TYPE_CAMELNAME     => ['id', 'title', 'url', 'spreadsheetId', 'solution', 'status', 'slackChannel', 'slackChannelId', 'wranglerId', 'sheetModDate', 'sortOrder', 'note', 'solverCount', 'createdAt', 'updatedAt', 'archivedAt', ],
        self::TYPE_COLNAME       => [PuzzleArchiveTableMap::COL_ID, PuzzleArchiveTableMap::COL_TITLE, PuzzleArchiveTableMap::COL_URL, PuzzleArchiveTableMap::COL_SPREADSHEET_ID, PuzzleArchiveTableMap::COL_SOLUTION, PuzzleArchiveTableMap::COL_STATUS, PuzzleArchiveTableMap::COL_SLACK_CHANNEL, PuzzleArchiveTableMap::COL_SLACK_CHANNEL_ID, PuzzleArchiveTableMap::COL_WRANGLER_ID, PuzzleArchiveTableMap::COL_SHEET_MOD_DATE, PuzzleArchiveTableMap::COL_SORT_ORDER, PuzzleArchiveTableMap::COL_NOTE, PuzzleArchiveTableMap::COL_SOLVER_COUNT, PuzzleArchiveTableMap::COL_CREATED_AT, PuzzleArchiveTableMap::COL_UPDATED_AT, PuzzleArchiveTableMap::COL_ARCHIVED_AT, ],
        self::TYPE_FIELDNAME     => ['id', 'title', 'url', 'spreadsheet_id', 'solution', 'status', 'slack_channel', 'slack_channel_id', 'wrangler_id', 'sheet_mod_date', 'sort_order', 'note', 'solver_count', 'created_at', 'updated_at', 'archived_at', ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, ]
    ];

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     *
     * @var array<string, mixed>
     */
    protected static $fieldKeys = [
        self::TYPE_PHPNAME       => ['Id' => 0, 'Title' => 1, 'Url' => 2, 'SpreadsheetId' => 3, 'Solution' => 4, 'Status' => 5, 'SlackChannel' => 6, 'SlackChannelId' => 7, 'WranglerId' => 8, 'SheetModDate' => 9, 'SortOrder' => 10, 'Note' => 11, 'SolverCount' => 12, 'CreatedAt' => 13, 'UpdatedAt' => 14, 'ArchivedAt' => 15, ],
        self::TYPE_CAMELNAME     => ['id' => 0, 'title' => 1, 'url' => 2, 'spreadsheetId' => 3, 'solution' => 4, 'status' => 5, 'slackChannel' => 6, 'slackChannelId' => 7, 'wranglerId' => 8, 'sheetModDate' => 9, 'sortOrder' => 10, 'note' => 11, 'solverCount' => 12, 'createdAt' => 13, 'updatedAt' => 14, 'archivedAt' => 15, ],
        self::TYPE_COLNAME       => [PuzzleArchiveTableMap::COL_ID => 0, PuzzleArchiveTableMap::COL_TITLE => 1, PuzzleArchiveTableMap::COL_URL => 2, PuzzleArchiveTableMap::COL_SPREADSHEET_ID => 3, PuzzleArchiveTableMap::COL_SOLUTION => 4, PuzzleArchiveTableMap::COL_STATUS => 5, PuzzleArchiveTableMap::COL_SLACK_CHANNEL => 6, PuzzleArchiveTableMap::COL_SLACK_CHANNEL_ID => 7, PuzzleArchiveTableMap::COL_WRANGLER_ID => 8, PuzzleArchiveTableMap::COL_SHEET_MOD_DATE => 9, PuzzleArchiveTableMap::COL_SORT_ORDER => 10, PuzzleArchiveTableMap::COL_NOTE => 11, PuzzleArchiveTableMap::COL_SOLVER_COUNT => 12, PuzzleArchiveTableMap::COL_CREATED_AT => 13, PuzzleArchiveTableMap::COL_UPDATED_AT => 14, PuzzleArchiveTableMap::COL_ARCHIVED_AT => 15, ],
        self::TYPE_FIELDNAME     => ['id' => 0, 'title' => 1, 'url' => 2, 'spreadsheet_id' => 3, 'solution' => 4, 'status' => 5, 'slack_channel' => 6, 'slack_channel_id' => 7, 'wrangler_id' => 8, 'sheet_mod_date' => 9, 'sort_order' => 10, 'note' => 11, 'solver_count' => 12, 'created_at' => 13, 'updated_at' => 14, 'archived_at' => 15, ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, ]
    ];

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var array<string>
     */
    protected $normalizedColumnNameMap = [
        'Id' => 'ID',
        'PuzzleArchive.Id' => 'ID',
        'id' => 'ID',
        'puzzleArchive.id' => 'ID',
        'PuzzleArchiveTableMap::COL_ID' => 'ID',
        'COL_ID' => 'ID',
        'puzzle_archive.id' => 'ID',
        'Title' => 'TITLE',
        'PuzzleArchive.Title' => 'TITLE',
        'title' => 'TITLE',
        'puzzleArchive.title' => 'TITLE',
        'PuzzleArchiveTableMap::COL_TITLE' => 'TITLE',
        'COL_TITLE' => 'TITLE',
        'puzzle_archive.title' => 'TITLE',
        'Url' => 'URL',
        'PuzzleArchive.Url' => 'URL',
        'url' => 'URL',
        'puzzleArchive.url' => 'URL',
        'PuzzleArchiveTableMap::COL_URL' => 'URL',
        'COL_URL' => 'URL',
        'puzzle_archive.url' => 'URL',
        'SpreadsheetId' => 'SPREADSHEET_ID',
        'PuzzleArchive.SpreadsheetId' => 'SPREADSHEET_ID',
        'spreadsheetId' => 'SPREADSHEET_ID',
        'puzzleArchive.spreadsheetId' => 'SPREADSHEET_ID',
        'PuzzleArchiveTableMap::COL_SPREADSHEET_ID' => 'SPREADSHEET_ID',
        'COL_SPREADSHEET_ID' => 'SPREADSHEET_ID',
        'spreadsheet_id' => 'SPREADSHEET_ID',
        'puzzle_archive.spreadsheet_id' => 'SPREADSHEET_ID',
        'Solution' => 'SOLUTION',
        'PuzzleArchive.Solution' => 'SOLUTION',
        'solution' => 'SOLUTION',
        'puzzleArchive.solution' => 'SOLUTION',
        'PuzzleArchiveTableMap::COL_SOLUTION' => 'SOLUTION',
        'COL_SOLUTION' => 'SOLUTION',
        'puzzle_archive.solution' => 'SOLUTION',
        'Status' => 'STATUS',
        'PuzzleArchive.Status' => 'STATUS',
        'status' => 'STATUS',
        'puzzleArchive.status' => 'STATUS',
        'PuzzleArchiveTableMap::COL_STATUS' => 'STATUS',
        'COL_STATUS' => 'STATUS',
        'puzzle_archive.status' => 'STATUS',
        'SlackChannel' => 'SLACK_CHANNEL',
        'PuzzleArchive.SlackChannel' => 'SLACK_CHANNEL',
        'slackChannel' => 'SLACK_CHANNEL',
        'puzzleArchive.slackChannel' => 'SLACK_CHANNEL',
        'PuzzleArchiveTableMap::COL_SLACK_CHANNEL' => 'SLACK_CHANNEL',
        'COL_SLACK_CHANNEL' => 'SLACK_CHANNEL',
        'slack_channel' => 'SLACK_CHANNEL',
        'puzzle_archive.slack_channel' => 'SLACK_CHANNEL',
        'SlackChannelId' => 'SLACK_CHANNEL_ID',
        'PuzzleArchive.SlackChannelId' => 'SLACK_CHANNEL_ID',
        'slackChannelId' => 'SLACK_CHANNEL_ID',
        'puzzleArchive.slackChannelId' => 'SLACK_CHANNEL_ID',
        'PuzzleArchiveTableMap::COL_SLACK_CHANNEL_ID' => 'SLACK_CHANNEL_ID',
        'COL_SLACK_CHANNEL_ID' => 'SLACK_CHANNEL_ID',
        'slack_channel_id' => 'SLACK_CHANNEL_ID',
        'puzzle_archive.slack_channel_id' => 'SLACK_CHANNEL_ID',
        'WranglerId' => 'WRANGLER_ID',
        'PuzzleArchive.WranglerId' => 'WRANGLER_ID',
        'wranglerId' => 'WRANGLER_ID',
        'puzzleArchive.wranglerId' => 'WRANGLER_ID',
        'PuzzleArchiveTableMap::COL_WRANGLER_ID' => 'WRANGLER_ID',
        'COL_WRANGLER_ID' => 'WRANGLER_ID',
        'wrangler_id' => 'WRANGLER_ID',
        'puzzle_archive.wrangler_id' => 'WRANGLER_ID',
        'SheetModDate' => 'SHEET_MOD_DATE',
        'PuzzleArchive.SheetModDate' => 'SHEET_MOD_DATE',
        'sheetModDate' => 'SHEET_MOD_DATE',
        'puzzleArchive.sheetModDate' => 'SHEET_MOD_DATE',
        'PuzzleArchiveTableMap::COL_SHEET_MOD_DATE' => 'SHEET_MOD_DATE',
        'COL_SHEET_MOD_DATE' => 'SHEET_MOD_DATE',
        'sheet_mod_date' => 'SHEET_MOD_DATE',
        'puzzle_archive.sheet_mod_date' => 'SHEET_MOD_DATE',
        'SortOrder' => 'SORT_ORDER',
        'PuzzleArchive.SortOrder' => 'SORT_ORDER',
        'sortOrder' => 'SORT_ORDER',
        'puzzleArchive.sortOrder' => 'SORT_ORDER',
        'PuzzleArchiveTableMap::COL_SORT_ORDER' => 'SORT_ORDER',
        'COL_SORT_ORDER' => 'SORT_ORDER',
        'sort_order' => 'SORT_ORDER',
        'puzzle_archive.sort_order' => 'SORT_ORDER',
        'Note' => 'NOTE',
        'PuzzleArchive.Note' => 'NOTE',
        'note' => 'NOTE',
        'puzzleArchive.note' => 'NOTE',
        'PuzzleArchiveTableMap::COL_NOTE' => 'NOTE',
        'COL_NOTE' => 'NOTE',
        'puzzle_archive.note' => 'NOTE',
        'SolverCount' => 'SOLVER_COUNT',
        'PuzzleArchive.SolverCount' => 'SOLVER_COUNT',
        'solverCount' => 'SOLVER_COUNT',
        'puzzleArchive.solverCount' => 'SOLVER_COUNT',
        'PuzzleArchiveTableMap::COL_SOLVER_COUNT' => 'SOLVER_COUNT',
        'COL_SOLVER_COUNT' => 'SOLVER_COUNT',
        'solver_count' => 'SOLVER_COUNT',
        'puzzle_archive.solver_count' => 'SOLVER_COUNT',
        'CreatedAt' => 'CREATED_AT',
        'PuzzleArchive.CreatedAt' => 'CREATED_AT',
        'createdAt' => 'CREATED_AT',
        'puzzleArchive.createdAt' => 'CREATED_AT',
        'PuzzleArchiveTableMap::COL_CREATED_AT' => 'CREATED_AT',
        'COL_CREATED_AT' => 'CREATED_AT',
        'created_at' => 'CREATED_AT',
        'puzzle_archive.created_at' => 'CREATED_AT',
        'UpdatedAt' => 'UPDATED_AT',
        'PuzzleArchive.UpdatedAt' => 'UPDATED_AT',
        'updatedAt' => 'UPDATED_AT',
        'puzzleArchive.updatedAt' => 'UPDATED_AT',
        'PuzzleArchiveTableMap::COL_UPDATED_AT' => 'UPDATED_AT',
        'COL_UPDATED_AT' => 'UPDATED_AT',
        'updated_at' => 'UPDATED_AT',
        'puzzle_archive.updated_at' => 'UPDATED_AT',
        'ArchivedAt' => 'ARCHIVED_AT',
        'PuzzleArchive.ArchivedAt' => 'ARCHIVED_AT',
        'archivedAt' => 'ARCHIVED_AT',
        'puzzleArchive.archivedAt' => 'ARCHIVED_AT',
        'PuzzleArchiveTableMap::COL_ARCHIVED_AT' => 'ARCHIVED_AT',
        'COL_ARCHIVED_AT' => 'ARCHIVED_AT',
        'archived_at' => 'ARCHIVED_AT',
        'puzzle_archive.archived_at' => 'ARCHIVED_AT',
    ];

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function initialize(): void
    {
        // attributes
        $this->setName('puzzle_archive');
        $this->setPhpName('PuzzleArchive');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\PuzzleArchive');
        $this->setPackage('');
        $this->setUseIdGenerator(false);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('title', 'Title', 'VARCHAR', false, 128, null);
        $this->addColumn('url', 'Url', 'VARCHAR', false, 128, null);
        $this->addColumn('spreadsheet_id', 'SpreadsheetId', 'VARCHAR', false, 128, null);
        $this->addColumn('solution', 'Solution', 'VARCHAR', false, 128, null);
        $this->addColumn('status', 'Status', 'VARCHAR', false, 24, null);
        $this->addColumn('slack_channel', 'SlackChannel', 'VARCHAR', false, 48, null);
        $this->addColumn('slack_channel_id', 'SlackChannelId', 'VARCHAR', false, 24, null);
        $this->addColumn('wrangler_id', 'WranglerId', 'INTEGER', false, null, null);
        $this->addColumn('sheet_mod_date', 'SheetModDate', 'TIMESTAMP', false, null, null);
        $this->addColumn('sort_order', 'SortOrder', 'INTEGER', false, null, null);
        $this->addColumn('note', 'Note', 'VARCHAR', false, 255, null);
        $this->addColumn('solver_count', 'SolverCount', 'INTEGER', false, null, null);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('updated_at', 'UpdatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('archived_at', 'ArchivedAt', 'TIMESTAMP', false, null, null);
    }

    /**
     * Build the RelationMap objects for this table relationships
     *
     * @return void
     */
    public function buildRelations(): void
    {
    }

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array $row Resultset row.
     * @param int $offset The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string|null The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): ?string
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array $row Resultset row.
     * @param int $offset The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param bool $withPrefix Whether to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass(bool $withPrefix = true): string
    {
        return $withPrefix ? PuzzleArchiveTableMap::CLASS_DEFAULT : PuzzleArchiveTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array $row Row returned by DataFetcher->fetch().
     * @param int $offset The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array (PuzzleArchive object, last column rank)
     */
    public static function populateObject(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): array
    {
        $key = PuzzleArchiveTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = PuzzleArchiveTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + PuzzleArchiveTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PuzzleArchiveTableMap::OM_CLASS;
            /** @var PuzzleArchive $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            PuzzleArchiveTableMap::addInstanceToPool($obj, $key);
        }

        return [$obj, $col];
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array<object>
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher): array
    {
        $results = [];

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = PuzzleArchiveTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = PuzzleArchiveTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var PuzzleArchive $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                PuzzleArchiveTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria Object containing the columns to add.
     * @param string|null $alias Optional table alias
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return void
     */
    public static function addSelectColumns(Criteria $criteria, ?string $alias = null): void
    {
        if (null === $alias) {
            $criteria->addSelectColumn(PuzzleArchiveTableMap::COL_ID);
            $criteria->addSelectColumn(PuzzleArchiveTableMap::COL_TITLE);
            $criteria->addSelectColumn(PuzzleArchiveTableMap::COL_URL);
            $criteria->addSelectColumn(PuzzleArchiveTableMap::COL_SPREADSHEET_ID);
            $criteria->addSelectColumn(PuzzleArchiveTableMap::COL_SOLUTION);
            $criteria->addSelectColumn(PuzzleArchiveTableMap::COL_STATUS);
            $criteria->addSelectColumn(PuzzleArchiveTableMap::COL_SLACK_CHANNEL);
            $criteria->addSelectColumn(PuzzleArchiveTableMap::COL_SLACK_CHANNEL_ID);
            $criteria->addSelectColumn(PuzzleArchiveTableMap::COL_WRANGLER_ID);
            $criteria->addSelectColumn(PuzzleArchiveTableMap::COL_SHEET_MOD_DATE);
            $criteria->addSelectColumn(PuzzleArchiveTableMap::COL_SORT_ORDER);
            $criteria->addSelectColumn(PuzzleArchiveTableMap::COL_NOTE);
            $criteria->addSelectColumn(PuzzleArchiveTableMap::COL_SOLVER_COUNT);
            $criteria->addSelectColumn(PuzzleArchiveTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(PuzzleArchiveTableMap::COL_UPDATED_AT);
            $criteria->addSelectColumn(PuzzleArchiveTableMap::COL_ARCHIVED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.title');
            $criteria->addSelectColumn($alias . '.url');
            $criteria->addSelectColumn($alias . '.spreadsheet_id');
            $criteria->addSelectColumn($alias . '.solution');
            $criteria->addSelectColumn($alias . '.status');
            $criteria->addSelectColumn($alias . '.slack_channel');
            $criteria->addSelectColumn($alias . '.slack_channel_id');
            $criteria->addSelectColumn($alias . '.wrangler_id');
            $criteria->addSelectColumn($alias . '.sheet_mod_date');
            $criteria->addSelectColumn($alias . '.sort_order');
            $criteria->addSelectColumn($alias . '.note');
            $criteria->addSelectColumn($alias . '.solver_count');
            $criteria->addSelectColumn($alias . '.created_at');
            $criteria->addSelectColumn($alias . '.updated_at');
            $criteria->addSelectColumn($alias . '.archived_at');
        }
    }

    /**
     * Remove all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be removed as they are only loaded on demand.
     *
     * @param Criteria $criteria Object containing the columns to remove.
     * @param string|null $alias Optional table alias
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return void
     */
    public static function removeSelectColumns(Criteria $criteria, ?string $alias = null): void
    {
        if (null === $alias) {
            $criteria->removeSelectColumn(PuzzleArchiveTableMap::COL_ID);
            $criteria->removeSelectColumn(PuzzleArchiveTableMap::COL_TITLE);
            $criteria->removeSelectColumn(PuzzleArchiveTableMap::COL_URL);
            $criteria->removeSelectColumn(PuzzleArchiveTableMap::COL_SPREADSHEET_ID);
            $criteria->removeSelectColumn(PuzzleArchiveTableMap::COL_SOLUTION);
            $criteria->removeSelectColumn(PuzzleArchiveTableMap::COL_STATUS);
            $criteria->removeSelectColumn(PuzzleArchiveTableMap::COL_SLACK_CHANNEL);
            $criteria->removeSelectColumn(PuzzleArchiveTableMap::COL_SLACK_CHANNEL_ID);
            $criteria->removeSelectColumn(PuzzleArchiveTableMap::COL_WRANGLER_ID);
            $criteria->removeSelectColumn(PuzzleArchiveTableMap::COL_SHEET_MOD_DATE);
            $criteria->removeSelectColumn(PuzzleArchiveTableMap::COL_SORT_ORDER);
            $criteria->removeSelectColumn(PuzzleArchiveTableMap::COL_NOTE);
            $criteria->removeSelectColumn(PuzzleArchiveTableMap::COL_SOLVER_COUNT);
            $criteria->removeSelectColumn(PuzzleArchiveTableMap::COL_CREATED_AT);
            $criteria->removeSelectColumn(PuzzleArchiveTableMap::COL_UPDATED_AT);
            $criteria->removeSelectColumn(PuzzleArchiveTableMap::COL_ARCHIVED_AT);
        } else {
            $criteria->removeSelectColumn($alias . '.id');
            $criteria->removeSelectColumn($alias . '.title');
            $criteria->removeSelectColumn($alias . '.url');
            $criteria->removeSelectColumn($alias . '.spreadsheet_id');
            $criteria->removeSelectColumn($alias . '.solution');
            $criteria->removeSelectColumn($alias . '.status');
            $criteria->removeSelectColumn($alias . '.slack_channel');
            $criteria->removeSelectColumn($alias . '.slack_channel_id');
            $criteria->removeSelectColumn($alias . '.wrangler_id');
            $criteria->removeSelectColumn($alias . '.sheet_mod_date');
            $criteria->removeSelectColumn($alias . '.sort_order');
            $criteria->removeSelectColumn($alias . '.note');
            $criteria->removeSelectColumn($alias . '.solver_count');
            $criteria->removeSelectColumn($alias . '.created_at');
            $criteria->removeSelectColumn($alias . '.updated_at');
            $criteria->removeSelectColumn($alias . '.archived_at');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap(): TableMap
    {
        return Propel::getServiceContainer()->getDatabaseMap(PuzzleArchiveTableMap::DATABASE_NAME)->getTable(PuzzleArchiveTableMap::TABLE_NAME);
    }

    /**
     * Performs a DELETE on the database, given a PuzzleArchive or Criteria object OR a primary key value.
     *
     * @param mixed $values Criteria or PuzzleArchive object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ?ConnectionInterface $con = null): int
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PuzzleArchiveTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \PuzzleArchive) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PuzzleArchiveTableMap::DATABASE_NAME);
            $criteria->add(PuzzleArchiveTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = PuzzleArchiveQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            PuzzleArchiveTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                PuzzleArchiveTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the puzzle_archive table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(?ConnectionInterface $con = null): int
    {
        return PuzzleArchiveQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a PuzzleArchive or Criteria object.
     *
     * @param mixed $criteria Criteria or PuzzleArchive object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed The new primary key.
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ?ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PuzzleArchiveTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from PuzzleArchive object
        }


        // Set the correct dbName
        $query = PuzzleArchiveQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

}
