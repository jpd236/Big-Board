<?php

namespace Map;

use \Member;
use \MemberQuery;
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
 * This class defines the structure of the 'member' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class MemberTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    public const CLASS_NAME = '.Map.MemberTableMap';

    /**
     * The default database name for this class
     */
    public const DATABASE_NAME = 'palindrome';

    /**
     * The table name for this class
     */
    public const TABLE_NAME = 'member';

    /**
     * The PHP name of this class (PascalCase)
     */
    public const TABLE_PHP_NAME = 'Member';

    /**
     * The related Propel class for this table
     */
    public const OM_CLASS = '\\Member';

    /**
     * A class that can be returned by this tableMap
     */
    public const CLASS_DEFAULT = 'Member';

    /**
     * The total number of columns
     */
    public const NUM_COLUMNS = 10;

    /**
     * The number of lazy-loaded columns
     */
    public const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    public const NUM_HYDRATE_COLUMNS = 10;

    /**
     * the column name for the id field
     */
    public const COL_ID = 'member.id';

    /**
     * the column name for the full_name field
     */
    public const COL_FULL_NAME = 'member.full_name';

    /**
     * the column name for the google_id field
     */
    public const COL_GOOGLE_ID = 'member.google_id';

    /**
     * the column name for the google_refresh field
     */
    public const COL_GOOGLE_REFRESH = 'member.google_refresh';

    /**
     * the column name for the slack_id field
     */
    public const COL_SLACK_ID = 'member.slack_id';

    /**
     * the column name for the slack_handle field
     */
    public const COL_SLACK_HANDLE = 'member.slack_handle';

    /**
     * the column name for the strengths field
     */
    public const COL_STRENGTHS = 'member.strengths';

    /**
     * the column name for the avatar field
     */
    public const COL_AVATAR = 'member.avatar';

    /**
     * the column name for the phone_number field
     */
    public const COL_PHONE_NUMBER = 'member.phone_number';

    /**
     * the column name for the location field
     */
    public const COL_LOCATION = 'member.location';

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
        self::TYPE_PHPNAME       => ['Id', 'FullName', 'GoogleId', 'GoogleRefresh', 'SlackId', 'SlackHandle', 'Strengths', 'Avatar', 'PhoneNumber', 'Location', ],
        self::TYPE_CAMELNAME     => ['id', 'fullName', 'googleId', 'googleRefresh', 'slackId', 'slackHandle', 'strengths', 'avatar', 'phoneNumber', 'location', ],
        self::TYPE_COLNAME       => [MemberTableMap::COL_ID, MemberTableMap::COL_FULL_NAME, MemberTableMap::COL_GOOGLE_ID, MemberTableMap::COL_GOOGLE_REFRESH, MemberTableMap::COL_SLACK_ID, MemberTableMap::COL_SLACK_HANDLE, MemberTableMap::COL_STRENGTHS, MemberTableMap::COL_AVATAR, MemberTableMap::COL_PHONE_NUMBER, MemberTableMap::COL_LOCATION, ],
        self::TYPE_FIELDNAME     => ['id', 'full_name', 'google_id', 'google_refresh', 'slack_id', 'slack_handle', 'strengths', 'avatar', 'phone_number', 'location', ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, ]
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
        self::TYPE_PHPNAME       => ['Id' => 0, 'FullName' => 1, 'GoogleId' => 2, 'GoogleRefresh' => 3, 'SlackId' => 4, 'SlackHandle' => 5, 'Strengths' => 6, 'Avatar' => 7, 'PhoneNumber' => 8, 'Location' => 9, ],
        self::TYPE_CAMELNAME     => ['id' => 0, 'fullName' => 1, 'googleId' => 2, 'googleRefresh' => 3, 'slackId' => 4, 'slackHandle' => 5, 'strengths' => 6, 'avatar' => 7, 'phoneNumber' => 8, 'location' => 9, ],
        self::TYPE_COLNAME       => [MemberTableMap::COL_ID => 0, MemberTableMap::COL_FULL_NAME => 1, MemberTableMap::COL_GOOGLE_ID => 2, MemberTableMap::COL_GOOGLE_REFRESH => 3, MemberTableMap::COL_SLACK_ID => 4, MemberTableMap::COL_SLACK_HANDLE => 5, MemberTableMap::COL_STRENGTHS => 6, MemberTableMap::COL_AVATAR => 7, MemberTableMap::COL_PHONE_NUMBER => 8, MemberTableMap::COL_LOCATION => 9, ],
        self::TYPE_FIELDNAME     => ['id' => 0, 'full_name' => 1, 'google_id' => 2, 'google_refresh' => 3, 'slack_id' => 4, 'slack_handle' => 5, 'strengths' => 6, 'avatar' => 7, 'phone_number' => 8, 'location' => 9, ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, ]
    ];

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var array<string>
     */
    protected $normalizedColumnNameMap = [
        'Id' => 'ID',
        'Member.Id' => 'ID',
        'id' => 'ID',
        'member.id' => 'ID',
        'MemberTableMap::COL_ID' => 'ID',
        'COL_ID' => 'ID',
        'FullName' => 'FULL_NAME',
        'Member.FullName' => 'FULL_NAME',
        'fullName' => 'FULL_NAME',
        'member.fullName' => 'FULL_NAME',
        'MemberTableMap::COL_FULL_NAME' => 'FULL_NAME',
        'COL_FULL_NAME' => 'FULL_NAME',
        'full_name' => 'FULL_NAME',
        'member.full_name' => 'FULL_NAME',
        'GoogleId' => 'GOOGLE_ID',
        'Member.GoogleId' => 'GOOGLE_ID',
        'googleId' => 'GOOGLE_ID',
        'member.googleId' => 'GOOGLE_ID',
        'MemberTableMap::COL_GOOGLE_ID' => 'GOOGLE_ID',
        'COL_GOOGLE_ID' => 'GOOGLE_ID',
        'google_id' => 'GOOGLE_ID',
        'member.google_id' => 'GOOGLE_ID',
        'GoogleRefresh' => 'GOOGLE_REFRESH',
        'Member.GoogleRefresh' => 'GOOGLE_REFRESH',
        'googleRefresh' => 'GOOGLE_REFRESH',
        'member.googleRefresh' => 'GOOGLE_REFRESH',
        'MemberTableMap::COL_GOOGLE_REFRESH' => 'GOOGLE_REFRESH',
        'COL_GOOGLE_REFRESH' => 'GOOGLE_REFRESH',
        'google_refresh' => 'GOOGLE_REFRESH',
        'member.google_refresh' => 'GOOGLE_REFRESH',
        'SlackId' => 'SLACK_ID',
        'Member.SlackId' => 'SLACK_ID',
        'slackId' => 'SLACK_ID',
        'member.slackId' => 'SLACK_ID',
        'MemberTableMap::COL_SLACK_ID' => 'SLACK_ID',
        'COL_SLACK_ID' => 'SLACK_ID',
        'slack_id' => 'SLACK_ID',
        'member.slack_id' => 'SLACK_ID',
        'SlackHandle' => 'SLACK_HANDLE',
        'Member.SlackHandle' => 'SLACK_HANDLE',
        'slackHandle' => 'SLACK_HANDLE',
        'member.slackHandle' => 'SLACK_HANDLE',
        'MemberTableMap::COL_SLACK_HANDLE' => 'SLACK_HANDLE',
        'COL_SLACK_HANDLE' => 'SLACK_HANDLE',
        'slack_handle' => 'SLACK_HANDLE',
        'member.slack_handle' => 'SLACK_HANDLE',
        'Strengths' => 'STRENGTHS',
        'Member.Strengths' => 'STRENGTHS',
        'strengths' => 'STRENGTHS',
        'member.strengths' => 'STRENGTHS',
        'MemberTableMap::COL_STRENGTHS' => 'STRENGTHS',
        'COL_STRENGTHS' => 'STRENGTHS',
        'Avatar' => 'AVATAR',
        'Member.Avatar' => 'AVATAR',
        'avatar' => 'AVATAR',
        'member.avatar' => 'AVATAR',
        'MemberTableMap::COL_AVATAR' => 'AVATAR',
        'COL_AVATAR' => 'AVATAR',
        'PhoneNumber' => 'PHONE_NUMBER',
        'Member.PhoneNumber' => 'PHONE_NUMBER',
        'phoneNumber' => 'PHONE_NUMBER',
        'member.phoneNumber' => 'PHONE_NUMBER',
        'MemberTableMap::COL_PHONE_NUMBER' => 'PHONE_NUMBER',
        'COL_PHONE_NUMBER' => 'PHONE_NUMBER',
        'phone_number' => 'PHONE_NUMBER',
        'member.phone_number' => 'PHONE_NUMBER',
        'Location' => 'LOCATION',
        'Member.Location' => 'LOCATION',
        'location' => 'LOCATION',
        'member.location' => 'LOCATION',
        'MemberTableMap::COL_LOCATION' => 'LOCATION',
        'COL_LOCATION' => 'LOCATION',
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
        $this->setName('member');
        $this->setPhpName('Member');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Member');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('full_name', 'FullName', 'VARCHAR', true, 64, null);
        $this->addColumn('google_id', 'GoogleId', 'VARCHAR', false, 64, null);
        $this->addColumn('google_refresh', 'GoogleRefresh', 'VARCHAR', false, 128, null);
        $this->addColumn('slack_id', 'SlackId', 'VARCHAR', false, 24, null);
        $this->addColumn('slack_handle', 'SlackHandle', 'VARCHAR', false, 48, null);
        $this->addColumn('strengths', 'Strengths', 'VARCHAR', false, 128, null);
        $this->addColumn('avatar', 'Avatar', 'VARCHAR', false, 200, null);
        $this->addColumn('phone_number', 'PhoneNumber', 'VARCHAR', false, 24, null);
        $this->addColumn('location', 'Location', 'VARCHAR', false, 24, null);
    }

    /**
     * Build the RelationMap objects for this table relationships
     *
     * @return void
     */
    public function buildRelations(): void
    {
        $this->addRelation('WrangledPuzzle', '\\Puzzle', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':wrangler_id',
    1 => ':id',
  ),
), 'SET NULL', null, 'WrangledPuzzles', false);
        $this->addRelation('PuzzleMember', '\\PuzzleMember', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':member_id',
    1 => ':id',
  ),
), 'CASCADE', null, 'PuzzleMembers', false);
        $this->addRelation('Puzzle', '\\Puzzle', RelationMap::MANY_TO_MANY, array(), 'CASCADE', null, 'Puzzles');
    }

    /**
     * Method to invalidate the instance pool of all tables related to member     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool(): void
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        PuzzleTableMap::clearInstancePool();
        PuzzleMemberTableMap::clearInstancePool();
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
        return $withPrefix ? MemberTableMap::CLASS_DEFAULT : MemberTableMap::OM_CLASS;
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
     * @return array (Member object, last column rank)
     */
    public static function populateObject(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): array
    {
        $key = MemberTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = MemberTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + MemberTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = MemberTableMap::OM_CLASS;
            /** @var Member $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            MemberTableMap::addInstanceToPool($obj, $key);
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
            $key = MemberTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = MemberTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Member $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                MemberTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(MemberTableMap::COL_ID);
            $criteria->addSelectColumn(MemberTableMap::COL_FULL_NAME);
            $criteria->addSelectColumn(MemberTableMap::COL_GOOGLE_ID);
            $criteria->addSelectColumn(MemberTableMap::COL_GOOGLE_REFRESH);
            $criteria->addSelectColumn(MemberTableMap::COL_SLACK_ID);
            $criteria->addSelectColumn(MemberTableMap::COL_SLACK_HANDLE);
            $criteria->addSelectColumn(MemberTableMap::COL_STRENGTHS);
            $criteria->addSelectColumn(MemberTableMap::COL_AVATAR);
            $criteria->addSelectColumn(MemberTableMap::COL_PHONE_NUMBER);
            $criteria->addSelectColumn(MemberTableMap::COL_LOCATION);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.full_name');
            $criteria->addSelectColumn($alias . '.google_id');
            $criteria->addSelectColumn($alias . '.google_refresh');
            $criteria->addSelectColumn($alias . '.slack_id');
            $criteria->addSelectColumn($alias . '.slack_handle');
            $criteria->addSelectColumn($alias . '.strengths');
            $criteria->addSelectColumn($alias . '.avatar');
            $criteria->addSelectColumn($alias . '.phone_number');
            $criteria->addSelectColumn($alias . '.location');
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
            $criteria->removeSelectColumn(MemberTableMap::COL_ID);
            $criteria->removeSelectColumn(MemberTableMap::COL_FULL_NAME);
            $criteria->removeSelectColumn(MemberTableMap::COL_GOOGLE_ID);
            $criteria->removeSelectColumn(MemberTableMap::COL_GOOGLE_REFRESH);
            $criteria->removeSelectColumn(MemberTableMap::COL_SLACK_ID);
            $criteria->removeSelectColumn(MemberTableMap::COL_SLACK_HANDLE);
            $criteria->removeSelectColumn(MemberTableMap::COL_STRENGTHS);
            $criteria->removeSelectColumn(MemberTableMap::COL_AVATAR);
            $criteria->removeSelectColumn(MemberTableMap::COL_PHONE_NUMBER);
            $criteria->removeSelectColumn(MemberTableMap::COL_LOCATION);
        } else {
            $criteria->removeSelectColumn($alias . '.id');
            $criteria->removeSelectColumn($alias . '.full_name');
            $criteria->removeSelectColumn($alias . '.google_id');
            $criteria->removeSelectColumn($alias . '.google_refresh');
            $criteria->removeSelectColumn($alias . '.slack_id');
            $criteria->removeSelectColumn($alias . '.slack_handle');
            $criteria->removeSelectColumn($alias . '.strengths');
            $criteria->removeSelectColumn($alias . '.avatar');
            $criteria->removeSelectColumn($alias . '.phone_number');
            $criteria->removeSelectColumn($alias . '.location');
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
        return Propel::getServiceContainer()->getDatabaseMap(MemberTableMap::DATABASE_NAME)->getTable(MemberTableMap::TABLE_NAME);
    }

    /**
     * Performs a DELETE on the database, given a Member or Criteria object OR a primary key value.
     *
     * @param mixed $values Criteria or Member object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(MemberTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Member) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(MemberTableMap::DATABASE_NAME);
            $criteria->add(MemberTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = MemberQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            MemberTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                MemberTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the member table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(?ConnectionInterface $con = null): int
    {
        return MemberQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Member or Criteria object.
     *
     * @param mixed $criteria Criteria or Member object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed The new primary key.
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ?ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MemberTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Member object
        }

        if ($criteria->containsKey(MemberTableMap::COL_ID) && $criteria->keyContainsValue(MemberTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.MemberTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = MemberQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

}
