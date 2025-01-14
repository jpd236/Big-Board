<?php

namespace Map;

use \Puzzle;
use \PuzzleQuery;
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
 * This class defines the structure of the 'puzzle' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class PuzzleTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    public const CLASS_NAME = '.Map.PuzzleTableMap';

    /**
     * The default database name for this class
     */
    public const DATABASE_NAME = 'palindrome';

    /**
     * The table name for this class
     */
    public const TABLE_NAME = 'puzzle';

    /**
     * The PHP name of this class (PascalCase)
     */
    public const TABLE_PHP_NAME = 'Puzzle';

    /**
     * The related Propel class for this table
     */
    public const OM_CLASS = '\\Puzzle';

    /**
     * A class that can be returned by this tableMap
     */
    public const CLASS_DEFAULT = 'Puzzle';

    /**
     * The total number of columns
     */
    public const NUM_COLUMNS = 15;

    /**
     * The number of lazy-loaded columns
     */
    public const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    public const NUM_HYDRATE_COLUMNS = 15;

    /**
     * the column name for the id field
     */
    public const COL_ID = 'puzzle.id';

    /**
     * the column name for the title field
     */
    public const COL_TITLE = 'puzzle.title';

    /**
     * the column name for the url field
     */
    public const COL_URL = 'puzzle.url';

    /**
     * the column name for the spreadsheet_id field
     */
    public const COL_SPREADSHEET_ID = 'puzzle.spreadsheet_id';

    /**
     * the column name for the solution field
     */
    public const COL_SOLUTION = 'puzzle.solution';

    /**
     * the column name for the status field
     */
    public const COL_STATUS = 'puzzle.status';

    /**
     * the column name for the slack_channel field
     */
    public const COL_SLACK_CHANNEL = 'puzzle.slack_channel';

    /**
     * the column name for the slack_channel_id field
     */
    public const COL_SLACK_CHANNEL_ID = 'puzzle.slack_channel_id';

    /**
     * the column name for the wrangler_id field
     */
    public const COL_WRANGLER_ID = 'puzzle.wrangler_id';

    /**
     * the column name for the sheet_mod_date field
     */
    public const COL_SHEET_MOD_DATE = 'puzzle.sheet_mod_date';

    /**
     * the column name for the sort_order field
     */
    public const COL_SORT_ORDER = 'puzzle.sort_order';

    /**
     * the column name for the note field
     */
    public const COL_NOTE = 'puzzle.note';

    /**
     * the column name for the solver_count field
     */
    public const COL_SOLVER_COUNT = 'puzzle.solver_count';

    /**
     * the column name for the created_at field
     */
    public const COL_CREATED_AT = 'puzzle.created_at';

    /**
     * the column name for the updated_at field
     */
    public const COL_UPDATED_AT = 'puzzle.updated_at';

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
        self::TYPE_PHPNAME       => ['Id', 'Title', 'Url', 'SpreadsheetId', 'Solution', 'Status', 'SlackChannel', 'SlackChannelId', 'WranglerId', 'SheetModDate', 'SortOrder', 'Note', 'SolverCount', 'CreatedAt', 'UpdatedAt', ],
        self::TYPE_CAMELNAME     => ['id', 'title', 'url', 'spreadsheetId', 'solution', 'status', 'slackChannel', 'slackChannelId', 'wranglerId', 'sheetModDate', 'sortOrder', 'note', 'solverCount', 'createdAt', 'updatedAt', ],
        self::TYPE_COLNAME       => [PuzzleTableMap::COL_ID, PuzzleTableMap::COL_TITLE, PuzzleTableMap::COL_URL, PuzzleTableMap::COL_SPREADSHEET_ID, PuzzleTableMap::COL_SOLUTION, PuzzleTableMap::COL_STATUS, PuzzleTableMap::COL_SLACK_CHANNEL, PuzzleTableMap::COL_SLACK_CHANNEL_ID, PuzzleTableMap::COL_WRANGLER_ID, PuzzleTableMap::COL_SHEET_MOD_DATE, PuzzleTableMap::COL_SORT_ORDER, PuzzleTableMap::COL_NOTE, PuzzleTableMap::COL_SOLVER_COUNT, PuzzleTableMap::COL_CREATED_AT, PuzzleTableMap::COL_UPDATED_AT, ],
        self::TYPE_FIELDNAME     => ['id', 'title', 'url', 'spreadsheet_id', 'solution', 'status', 'slack_channel', 'slack_channel_id', 'wrangler_id', 'sheet_mod_date', 'sort_order', 'note', 'solver_count', 'created_at', 'updated_at', ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, ]
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
        self::TYPE_PHPNAME       => ['Id' => 0, 'Title' => 1, 'Url' => 2, 'SpreadsheetId' => 3, 'Solution' => 4, 'Status' => 5, 'SlackChannel' => 6, 'SlackChannelId' => 7, 'WranglerId' => 8, 'SheetModDate' => 9, 'SortOrder' => 10, 'Note' => 11, 'SolverCount' => 12, 'CreatedAt' => 13, 'UpdatedAt' => 14, ],
        self::TYPE_CAMELNAME     => ['id' => 0, 'title' => 1, 'url' => 2, 'spreadsheetId' => 3, 'solution' => 4, 'status' => 5, 'slackChannel' => 6, 'slackChannelId' => 7, 'wranglerId' => 8, 'sheetModDate' => 9, 'sortOrder' => 10, 'note' => 11, 'solverCount' => 12, 'createdAt' => 13, 'updatedAt' => 14, ],
        self::TYPE_COLNAME       => [PuzzleTableMap::COL_ID => 0, PuzzleTableMap::COL_TITLE => 1, PuzzleTableMap::COL_URL => 2, PuzzleTableMap::COL_SPREADSHEET_ID => 3, PuzzleTableMap::COL_SOLUTION => 4, PuzzleTableMap::COL_STATUS => 5, PuzzleTableMap::COL_SLACK_CHANNEL => 6, PuzzleTableMap::COL_SLACK_CHANNEL_ID => 7, PuzzleTableMap::COL_WRANGLER_ID => 8, PuzzleTableMap::COL_SHEET_MOD_DATE => 9, PuzzleTableMap::COL_SORT_ORDER => 10, PuzzleTableMap::COL_NOTE => 11, PuzzleTableMap::COL_SOLVER_COUNT => 12, PuzzleTableMap::COL_CREATED_AT => 13, PuzzleTableMap::COL_UPDATED_AT => 14, ],
        self::TYPE_FIELDNAME     => ['id' => 0, 'title' => 1, 'url' => 2, 'spreadsheet_id' => 3, 'solution' => 4, 'status' => 5, 'slack_channel' => 6, 'slack_channel_id' => 7, 'wrangler_id' => 8, 'sheet_mod_date' => 9, 'sort_order' => 10, 'note' => 11, 'solver_count' => 12, 'created_at' => 13, 'updated_at' => 14, ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, ]
    ];

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var array<string>
     */
    protected $normalizedColumnNameMap = [
        'Id' => 'ID',
        'Puzzle.Id' => 'ID',
        'id' => 'ID',
        'puzzle.id' => 'ID',
        'PuzzleTableMap::COL_ID' => 'ID',
        'COL_ID' => 'ID',
        'Title' => 'TITLE',
        'Puzzle.Title' => 'TITLE',
        'title' => 'TITLE',
        'puzzle.title' => 'TITLE',
        'PuzzleTableMap::COL_TITLE' => 'TITLE',
        'COL_TITLE' => 'TITLE',
        'Url' => 'URL',
        'Puzzle.Url' => 'URL',
        'url' => 'URL',
        'puzzle.url' => 'URL',
        'PuzzleTableMap::COL_URL' => 'URL',
        'COL_URL' => 'URL',
        'SpreadsheetId' => 'SPREADSHEET_ID',
        'Puzzle.SpreadsheetId' => 'SPREADSHEET_ID',
        'spreadsheetId' => 'SPREADSHEET_ID',
        'puzzle.spreadsheetId' => 'SPREADSHEET_ID',
        'PuzzleTableMap::COL_SPREADSHEET_ID' => 'SPREADSHEET_ID',
        'COL_SPREADSHEET_ID' => 'SPREADSHEET_ID',
        'spreadsheet_id' => 'SPREADSHEET_ID',
        'puzzle.spreadsheet_id' => 'SPREADSHEET_ID',
        'Solution' => 'SOLUTION',
        'Puzzle.Solution' => 'SOLUTION',
        'solution' => 'SOLUTION',
        'puzzle.solution' => 'SOLUTION',
        'PuzzleTableMap::COL_SOLUTION' => 'SOLUTION',
        'COL_SOLUTION' => 'SOLUTION',
        'Status' => 'STATUS',
        'Puzzle.Status' => 'STATUS',
        'status' => 'STATUS',
        'puzzle.status' => 'STATUS',
        'PuzzleTableMap::COL_STATUS' => 'STATUS',
        'COL_STATUS' => 'STATUS',
        'SlackChannel' => 'SLACK_CHANNEL',
        'Puzzle.SlackChannel' => 'SLACK_CHANNEL',
        'slackChannel' => 'SLACK_CHANNEL',
        'puzzle.slackChannel' => 'SLACK_CHANNEL',
        'PuzzleTableMap::COL_SLACK_CHANNEL' => 'SLACK_CHANNEL',
        'COL_SLACK_CHANNEL' => 'SLACK_CHANNEL',
        'slack_channel' => 'SLACK_CHANNEL',
        'puzzle.slack_channel' => 'SLACK_CHANNEL',
        'SlackChannelId' => 'SLACK_CHANNEL_ID',
        'Puzzle.SlackChannelId' => 'SLACK_CHANNEL_ID',
        'slackChannelId' => 'SLACK_CHANNEL_ID',
        'puzzle.slackChannelId' => 'SLACK_CHANNEL_ID',
        'PuzzleTableMap::COL_SLACK_CHANNEL_ID' => 'SLACK_CHANNEL_ID',
        'COL_SLACK_CHANNEL_ID' => 'SLACK_CHANNEL_ID',
        'slack_channel_id' => 'SLACK_CHANNEL_ID',
        'puzzle.slack_channel_id' => 'SLACK_CHANNEL_ID',
        'WranglerId' => 'WRANGLER_ID',
        'Puzzle.WranglerId' => 'WRANGLER_ID',
        'wranglerId' => 'WRANGLER_ID',
        'puzzle.wranglerId' => 'WRANGLER_ID',
        'PuzzleTableMap::COL_WRANGLER_ID' => 'WRANGLER_ID',
        'COL_WRANGLER_ID' => 'WRANGLER_ID',
        'wrangler_id' => 'WRANGLER_ID',
        'puzzle.wrangler_id' => 'WRANGLER_ID',
        'SheetModDate' => 'SHEET_MOD_DATE',
        'Puzzle.SheetModDate' => 'SHEET_MOD_DATE',
        'sheetModDate' => 'SHEET_MOD_DATE',
        'puzzle.sheetModDate' => 'SHEET_MOD_DATE',
        'PuzzleTableMap::COL_SHEET_MOD_DATE' => 'SHEET_MOD_DATE',
        'COL_SHEET_MOD_DATE' => 'SHEET_MOD_DATE',
        'sheet_mod_date' => 'SHEET_MOD_DATE',
        'puzzle.sheet_mod_date' => 'SHEET_MOD_DATE',
        'SortOrder' => 'SORT_ORDER',
        'Puzzle.SortOrder' => 'SORT_ORDER',
        'sortOrder' => 'SORT_ORDER',
        'puzzle.sortOrder' => 'SORT_ORDER',
        'PuzzleTableMap::COL_SORT_ORDER' => 'SORT_ORDER',
        'COL_SORT_ORDER' => 'SORT_ORDER',
        'sort_order' => 'SORT_ORDER',
        'puzzle.sort_order' => 'SORT_ORDER',
        'Note' => 'NOTE',
        'Puzzle.Note' => 'NOTE',
        'note' => 'NOTE',
        'puzzle.note' => 'NOTE',
        'PuzzleTableMap::COL_NOTE' => 'NOTE',
        'COL_NOTE' => 'NOTE',
        'SolverCount' => 'SOLVER_COUNT',
        'Puzzle.SolverCount' => 'SOLVER_COUNT',
        'solverCount' => 'SOLVER_COUNT',
        'puzzle.solverCount' => 'SOLVER_COUNT',
        'PuzzleTableMap::COL_SOLVER_COUNT' => 'SOLVER_COUNT',
        'COL_SOLVER_COUNT' => 'SOLVER_COUNT',
        'solver_count' => 'SOLVER_COUNT',
        'puzzle.solver_count' => 'SOLVER_COUNT',
        'CreatedAt' => 'CREATED_AT',
        'Puzzle.CreatedAt' => 'CREATED_AT',
        'createdAt' => 'CREATED_AT',
        'puzzle.createdAt' => 'CREATED_AT',
        'PuzzleTableMap::COL_CREATED_AT' => 'CREATED_AT',
        'COL_CREATED_AT' => 'CREATED_AT',
        'created_at' => 'CREATED_AT',
        'puzzle.created_at' => 'CREATED_AT',
        'UpdatedAt' => 'UPDATED_AT',
        'Puzzle.UpdatedAt' => 'UPDATED_AT',
        'updatedAt' => 'UPDATED_AT',
        'puzzle.updatedAt' => 'UPDATED_AT',
        'PuzzleTableMap::COL_UPDATED_AT' => 'UPDATED_AT',
        'COL_UPDATED_AT' => 'UPDATED_AT',
        'updated_at' => 'UPDATED_AT',
        'puzzle.updated_at' => 'UPDATED_AT',
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
        $this->setName('puzzle');
        $this->setPhpName('Puzzle');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Puzzle');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('title', 'Title', 'VARCHAR', false, 128, null);
        $this->addColumn('url', 'Url', 'VARCHAR', false, 128, null);
        $this->addColumn('spreadsheet_id', 'SpreadsheetId', 'VARCHAR', false, 128, null);
        $this->addColumn('solution', 'Solution', 'VARCHAR', false, 128, null);
        $this->addColumn('status', 'Status', 'VARCHAR', false, 24, null);
        $this->addColumn('slack_channel', 'SlackChannel', 'VARCHAR', false, 48, null);
        $this->addColumn('slack_channel_id', 'SlackChannelId', 'VARCHAR', false, 24, null);
        $this->addForeignKey('wrangler_id', 'WranglerId', 'INTEGER', 'member', 'id', false, null, null);
        $this->addColumn('sheet_mod_date', 'SheetModDate', 'TIMESTAMP', false, null, null);
        $this->addColumn('sort_order', 'SortOrder', 'INTEGER', false, null, null);
        $this->addColumn('note', 'Note', 'VARCHAR', false, 255, null);
        $this->addColumn('solver_count', 'SolverCount', 'INTEGER', false, null, null);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('updated_at', 'UpdatedAt', 'TIMESTAMP', false, null, null);
    }

    /**
     * Build the RelationMap objects for this table relationships
     *
     * @return void
     */
    public function buildRelations(): void
    {
        $this->addRelation('Wrangler', '\\Member', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':wrangler_id',
    1 => ':id',
  ),
), 'SET NULL', null, null, false);
        $this->addRelation('PuzzleMember', '\\PuzzleMember', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':puzzle_id',
    1 => ':id',
  ),
), 'CASCADE', null, 'PuzzleMembers', false);
        $this->addRelation('PuzzleParent', '\\PuzzlePuzzle', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':puzzle_id',
    1 => ':id',
  ),
), 'CASCADE', null, 'PuzzleParents', false);
        $this->addRelation('PuzzleChild', '\\PuzzlePuzzle', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':parent_id',
    1 => ':id',
  ),
), 'CASCADE', null, 'Puzzlechildren', false);
        $this->addRelation('Member', '\\Member', RelationMap::MANY_TO_MANY, array(), 'CASCADE', null, 'Members');
        $this->addRelation('Parent', '\\Puzzle', RelationMap::MANY_TO_MANY, array(), 'CASCADE', null, 'Parents');
        $this->addRelation('Child', '\\Puzzle', RelationMap::MANY_TO_MANY, array(), 'CASCADE', null, 'Children');
    }

    /**
     *
     * Gets the list of behaviors registered for this table
     *
     * @return array<string, array> Associative array (name => parameters) of behaviors
     */
    public function getBehaviors(): array
    {
        return [
            'solver_count' => ['name' => 'solver_count', 'expression' => 'COUNT(member_id)', 'condition' => NULL, 'foreign_table' => 'solver', 'foreign_schema' => NULL],
            'timestampable' => ['create_column' => 'created_at', 'update_column' => 'updated_at', 'disable_created_at' => 'false', 'disable_updated_at' => 'false'],
            'archivable' => ['archive_table' => '', 'archive_phpname' => NULL, 'archive_class' => '', 'sync' => 'false', 'inherit_foreign_key_relations' => 'false', 'inherit_foreign_key_constraints' => 'false', 'foreign_keys' => NULL, 'log_archived_at' => 'true', 'archived_at_column' => 'archived_at', 'archive_on_insert' => 'false', 'archive_on_update' => 'false', 'archive_on_delete' => 'true'],
        ];
    }

    /**
     * Method to invalidate the instance pool of all tables related to puzzle     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool(): void
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        PuzzleMemberTableMap::clearInstancePool();
        PuzzlePuzzleTableMap::clearInstancePool();
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
        return $withPrefix ? PuzzleTableMap::CLASS_DEFAULT : PuzzleTableMap::OM_CLASS;
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
     * @return array (Puzzle object, last column rank)
     */
    public static function populateObject(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): array
    {
        $key = PuzzleTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = PuzzleTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + PuzzleTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PuzzleTableMap::OM_CLASS;
            /** @var Puzzle $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            PuzzleTableMap::addInstanceToPool($obj, $key);
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
            $key = PuzzleTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = PuzzleTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Puzzle $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                PuzzleTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(PuzzleTableMap::COL_ID);
            $criteria->addSelectColumn(PuzzleTableMap::COL_TITLE);
            $criteria->addSelectColumn(PuzzleTableMap::COL_URL);
            $criteria->addSelectColumn(PuzzleTableMap::COL_SPREADSHEET_ID);
            $criteria->addSelectColumn(PuzzleTableMap::COL_SOLUTION);
            $criteria->addSelectColumn(PuzzleTableMap::COL_STATUS);
            $criteria->addSelectColumn(PuzzleTableMap::COL_SLACK_CHANNEL);
            $criteria->addSelectColumn(PuzzleTableMap::COL_SLACK_CHANNEL_ID);
            $criteria->addSelectColumn(PuzzleTableMap::COL_WRANGLER_ID);
            $criteria->addSelectColumn(PuzzleTableMap::COL_SHEET_MOD_DATE);
            $criteria->addSelectColumn(PuzzleTableMap::COL_SORT_ORDER);
            $criteria->addSelectColumn(PuzzleTableMap::COL_NOTE);
            $criteria->addSelectColumn(PuzzleTableMap::COL_SOLVER_COUNT);
            $criteria->addSelectColumn(PuzzleTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(PuzzleTableMap::COL_UPDATED_AT);
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
            $criteria->removeSelectColumn(PuzzleTableMap::COL_ID);
            $criteria->removeSelectColumn(PuzzleTableMap::COL_TITLE);
            $criteria->removeSelectColumn(PuzzleTableMap::COL_URL);
            $criteria->removeSelectColumn(PuzzleTableMap::COL_SPREADSHEET_ID);
            $criteria->removeSelectColumn(PuzzleTableMap::COL_SOLUTION);
            $criteria->removeSelectColumn(PuzzleTableMap::COL_STATUS);
            $criteria->removeSelectColumn(PuzzleTableMap::COL_SLACK_CHANNEL);
            $criteria->removeSelectColumn(PuzzleTableMap::COL_SLACK_CHANNEL_ID);
            $criteria->removeSelectColumn(PuzzleTableMap::COL_WRANGLER_ID);
            $criteria->removeSelectColumn(PuzzleTableMap::COL_SHEET_MOD_DATE);
            $criteria->removeSelectColumn(PuzzleTableMap::COL_SORT_ORDER);
            $criteria->removeSelectColumn(PuzzleTableMap::COL_NOTE);
            $criteria->removeSelectColumn(PuzzleTableMap::COL_SOLVER_COUNT);
            $criteria->removeSelectColumn(PuzzleTableMap::COL_CREATED_AT);
            $criteria->removeSelectColumn(PuzzleTableMap::COL_UPDATED_AT);
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
        return Propel::getServiceContainer()->getDatabaseMap(PuzzleTableMap::DATABASE_NAME)->getTable(PuzzleTableMap::TABLE_NAME);
    }

    /**
     * Performs a DELETE on the database, given a Puzzle or Criteria object OR a primary key value.
     *
     * @param mixed $values Criteria or Puzzle object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(PuzzleTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Puzzle) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PuzzleTableMap::DATABASE_NAME);
            $criteria->add(PuzzleTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = PuzzleQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            PuzzleTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                PuzzleTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the puzzle table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(?ConnectionInterface $con = null): int
    {
        return PuzzleQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Puzzle or Criteria object.
     *
     * @param mixed $criteria Criteria or Puzzle object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed The new primary key.
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ?ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PuzzleTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Puzzle object
        }

        if ($criteria->containsKey(PuzzleTableMap::COL_ID) && $criteria->keyContainsValue(PuzzleTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.PuzzleTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = PuzzleQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

}
