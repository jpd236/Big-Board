<?php

namespace Map;

use \PuzzlePuzzle;
use \PuzzlePuzzleQuery;
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
 * This class defines the structure of the 'relationship' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class PuzzlePuzzleTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    public const CLASS_NAME = '.Map.PuzzlePuzzleTableMap';

    /**
     * The default database name for this class
     */
    public const DATABASE_NAME = 'palindrome';

    /**
     * The table name for this class
     */
    public const TABLE_NAME = 'relationship';

    /**
     * The PHP name of this class (PascalCase)
     */
    public const TABLE_PHP_NAME = 'PuzzlePuzzle';

    /**
     * The related Propel class for this table
     */
    public const OM_CLASS = '\\PuzzlePuzzle';

    /**
     * A class that can be returned by this tableMap
     */
    public const CLASS_DEFAULT = 'PuzzlePuzzle';

    /**
     * The total number of columns
     */
    public const NUM_COLUMNS = 2;

    /**
     * The number of lazy-loaded columns
     */
    public const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    public const NUM_HYDRATE_COLUMNS = 2;

    /**
     * the column name for the puzzle_id field
     */
    public const COL_PUZZLE_ID = 'relationship.puzzle_id';

    /**
     * the column name for the parent_id field
     */
    public const COL_PARENT_ID = 'relationship.parent_id';

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
        self::TYPE_PHPNAME       => ['PuzzleId', 'ParentId', ],
        self::TYPE_CAMELNAME     => ['puzzleId', 'parentId', ],
        self::TYPE_COLNAME       => [PuzzlePuzzleTableMap::COL_PUZZLE_ID, PuzzlePuzzleTableMap::COL_PARENT_ID, ],
        self::TYPE_FIELDNAME     => ['puzzle_id', 'parent_id', ],
        self::TYPE_NUM           => [0, 1, ]
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
        self::TYPE_PHPNAME       => ['PuzzleId' => 0, 'ParentId' => 1, ],
        self::TYPE_CAMELNAME     => ['puzzleId' => 0, 'parentId' => 1, ],
        self::TYPE_COLNAME       => [PuzzlePuzzleTableMap::COL_PUZZLE_ID => 0, PuzzlePuzzleTableMap::COL_PARENT_ID => 1, ],
        self::TYPE_FIELDNAME     => ['puzzle_id' => 0, 'parent_id' => 1, ],
        self::TYPE_NUM           => [0, 1, ]
    ];

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var array<string>
     */
    protected $normalizedColumnNameMap = [
        'PuzzleId' => 'PUZZLE_ID',
        'PuzzlePuzzle.PuzzleId' => 'PUZZLE_ID',
        'puzzleId' => 'PUZZLE_ID',
        'puzzlePuzzle.puzzleId' => 'PUZZLE_ID',
        'PuzzlePuzzleTableMap::COL_PUZZLE_ID' => 'PUZZLE_ID',
        'COL_PUZZLE_ID' => 'PUZZLE_ID',
        'puzzle_id' => 'PUZZLE_ID',
        'relationship.puzzle_id' => 'PUZZLE_ID',
        'ParentId' => 'PARENT_ID',
        'PuzzlePuzzle.ParentId' => 'PARENT_ID',
        'parentId' => 'PARENT_ID',
        'puzzlePuzzle.parentId' => 'PARENT_ID',
        'PuzzlePuzzleTableMap::COL_PARENT_ID' => 'PARENT_ID',
        'COL_PARENT_ID' => 'PARENT_ID',
        'parent_id' => 'PARENT_ID',
        'relationship.parent_id' => 'PARENT_ID',
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
        $this->setName('relationship');
        $this->setPhpName('PuzzlePuzzle');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\PuzzlePuzzle');
        $this->setPackage('');
        $this->setUseIdGenerator(false);
        $this->setIsCrossRef(true);
        // columns
        $this->addForeignPrimaryKey('puzzle_id', 'PuzzleId', 'INTEGER' , 'puzzle', 'id', true, null, null);
        $this->addForeignPrimaryKey('parent_id', 'ParentId', 'INTEGER' , 'puzzle', 'id', true, null, null);
    }

    /**
     * Build the RelationMap objects for this table relationships
     *
     * @return void
     */
    public function buildRelations(): void
    {
        $this->addRelation('Child', '\\Puzzle', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':puzzle_id',
    1 => ':id',
  ),
), 'CASCADE', null, null, false);
        $this->addRelation('Parent', '\\Puzzle', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':parent_id',
    1 => ':id',
  ),
), 'CASCADE', null, null, false);
    }

    /**
     * Adds an object to the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database. In some cases you may need to explicitly add objects
     * to the cache in order to ensure that the same objects are always returned by find*()
     * and findPk*() calls.
     *
     * @param \PuzzlePuzzle $obj A \PuzzlePuzzle object.
     * @param string|null $key Key (optional) to use for instance map (for performance boost if key was already calculated externally).
     *
     * @return void
     */
    public static function addInstanceToPool(PuzzlePuzzle $obj, ?string $key = null): void
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (null === $key) {
                $key = serialize([(null === $obj->getPuzzleId() || is_scalar($obj->getPuzzleId()) || is_callable([$obj->getPuzzleId(), '__toString']) ? (string) $obj->getPuzzleId() : $obj->getPuzzleId()), (null === $obj->getParentId() || is_scalar($obj->getParentId()) || is_callable([$obj->getParentId(), '__toString']) ? (string) $obj->getParentId() : $obj->getParentId())]);
            } // if key === null
            self::$instances[$key] = $obj;
        }
    }

    /**
     * Removes an object from the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database.  In some cases -- especially when you override doDelete
     * methods in your stub classes -- you may need to explicitly remove objects
     * from the cache in order to prevent returning objects that no longer exist.
     *
     * @param mixed $value A \PuzzlePuzzle object or a primary key value.
     *
     * @return void
     */
    public static function removeInstanceFromPool($value): void
    {
        if (Propel::isInstancePoolingEnabled() && null !== $value) {
            if (is_object($value) && $value instanceof \PuzzlePuzzle) {
                $key = serialize([(null === $value->getPuzzleId() || is_scalar($value->getPuzzleId()) || is_callable([$value->getPuzzleId(), '__toString']) ? (string) $value->getPuzzleId() : $value->getPuzzleId()), (null === $value->getParentId() || is_scalar($value->getParentId()) || is_callable([$value->getParentId(), '__toString']) ? (string) $value->getParentId() : $value->getParentId())]);

            } elseif (is_array($value) && count($value) === 2) {
                // assume we've been passed a primary key";
                $key = serialize([(null === $value[0] || is_scalar($value[0]) || is_callable([$value[0], '__toString']) ? (string) $value[0] : $value[0]), (null === $value[1] || is_scalar($value[1]) || is_callable([$value[1], '__toString']) ? (string) $value[1] : $value[1])]);
            } elseif ($value instanceof Criteria) {
                self::$instances = [];

                return;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or \PuzzlePuzzle object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value, true)));
                throw $e;
            }

            unset(self::$instances[$key]);
        }
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PuzzleId', TableMap::TYPE_PHPNAME, $indexType)] === null && $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('ParentId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return serialize([(null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PuzzleId', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PuzzleId', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PuzzleId', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PuzzleId', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PuzzleId', TableMap::TYPE_PHPNAME, $indexType)]), (null === $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('ParentId', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('ParentId', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('ParentId', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('ParentId', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('ParentId', TableMap::TYPE_PHPNAME, $indexType)])]);
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
            $pks = [];

        $pks[] = (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('PuzzleId', TableMap::TYPE_PHPNAME, $indexType)
        ];
        $pks[] = (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 1 + $offset
                : self::translateFieldName('ParentId', TableMap::TYPE_PHPNAME, $indexType)
        ];

        return $pks;
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
        return $withPrefix ? PuzzlePuzzleTableMap::CLASS_DEFAULT : PuzzlePuzzleTableMap::OM_CLASS;
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
     * @return array (PuzzlePuzzle object, last column rank)
     */
    public static function populateObject(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): array
    {
        $key = PuzzlePuzzleTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = PuzzlePuzzleTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + PuzzlePuzzleTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PuzzlePuzzleTableMap::OM_CLASS;
            /** @var PuzzlePuzzle $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            PuzzlePuzzleTableMap::addInstanceToPool($obj, $key);
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
            $key = PuzzlePuzzleTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = PuzzlePuzzleTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var PuzzlePuzzle $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                PuzzlePuzzleTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(PuzzlePuzzleTableMap::COL_PUZZLE_ID);
            $criteria->addSelectColumn(PuzzlePuzzleTableMap::COL_PARENT_ID);
        } else {
            $criteria->addSelectColumn($alias . '.puzzle_id');
            $criteria->addSelectColumn($alias . '.parent_id');
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
            $criteria->removeSelectColumn(PuzzlePuzzleTableMap::COL_PUZZLE_ID);
            $criteria->removeSelectColumn(PuzzlePuzzleTableMap::COL_PARENT_ID);
        } else {
            $criteria->removeSelectColumn($alias . '.puzzle_id');
            $criteria->removeSelectColumn($alias . '.parent_id');
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
        return Propel::getServiceContainer()->getDatabaseMap(PuzzlePuzzleTableMap::DATABASE_NAME)->getTable(PuzzlePuzzleTableMap::TABLE_NAME);
    }

    /**
     * Performs a DELETE on the database, given a PuzzlePuzzle or Criteria object OR a primary key value.
     *
     * @param mixed $values Criteria or PuzzlePuzzle object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(PuzzlePuzzleTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \PuzzlePuzzle) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PuzzlePuzzleTableMap::DATABASE_NAME);
            // primary key is composite; we therefore, expect
            // the primary key passed to be an array of pkey values
            if (count($values) == count($values, COUNT_RECURSIVE)) {
                // array is not multi-dimensional
                $values = [$values];
            }
            foreach ($values as $value) {
                $criterion = $criteria->getNewCriterion(PuzzlePuzzleTableMap::COL_PUZZLE_ID, $value[0]);
                $criterion->addAnd($criteria->getNewCriterion(PuzzlePuzzleTableMap::COL_PARENT_ID, $value[1]));
                $criteria->addOr($criterion);
            }
        }

        $query = PuzzlePuzzleQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            PuzzlePuzzleTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                PuzzlePuzzleTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the relationship table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(?ConnectionInterface $con = null): int
    {
        return PuzzlePuzzleQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a PuzzlePuzzle or Criteria object.
     *
     * @param mixed $criteria Criteria or PuzzlePuzzle object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed The new primary key.
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ?ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PuzzlePuzzleTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from PuzzlePuzzle object
        }


        // Set the correct dbName
        $query = PuzzlePuzzleQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

}
