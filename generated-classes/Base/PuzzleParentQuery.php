<?php

namespace Base;

use \PuzzleParent as ChildPuzzleParent;
use \PuzzleParentQuery as ChildPuzzleParentQuery;
use \Exception;
use \PDO;
use Map\PuzzleParentTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'relationship' table.
 *
 *
 *
 * @method     ChildPuzzleParentQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildPuzzleParentQuery orderByPuzzleId($order = Criteria::ASC) Order by the puzzle_id column
 * @method     ChildPuzzleParentQuery orderByParentId($order = Criteria::ASC) Order by the parent_id column
 *
 * @method     ChildPuzzleParentQuery groupById() Group by the id column
 * @method     ChildPuzzleParentQuery groupByPuzzleId() Group by the puzzle_id column
 * @method     ChildPuzzleParentQuery groupByParentId() Group by the parent_id column
 *
 * @method     ChildPuzzleParentQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPuzzleParentQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPuzzleParentQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPuzzleParentQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildPuzzleParentQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildPuzzleParentQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildPuzzleParentQuery leftJoinPuzzle($relationAlias = null) Adds a LEFT JOIN clause to the query using the Puzzle relation
 * @method     ChildPuzzleParentQuery rightJoinPuzzle($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Puzzle relation
 * @method     ChildPuzzleParentQuery innerJoinPuzzle($relationAlias = null) Adds a INNER JOIN clause to the query using the Puzzle relation
 *
 * @method     ChildPuzzleParentQuery joinWithPuzzle($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Puzzle relation
 *
 * @method     ChildPuzzleParentQuery leftJoinWithPuzzle() Adds a LEFT JOIN clause and with to the query using the Puzzle relation
 * @method     ChildPuzzleParentQuery rightJoinWithPuzzle() Adds a RIGHT JOIN clause and with to the query using the Puzzle relation
 * @method     ChildPuzzleParentQuery innerJoinWithPuzzle() Adds a INNER JOIN clause and with to the query using the Puzzle relation
 *
 * @method     ChildPuzzleParentQuery leftJoinParent($relationAlias = null) Adds a LEFT JOIN clause to the query using the Parent relation
 * @method     ChildPuzzleParentQuery rightJoinParent($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Parent relation
 * @method     ChildPuzzleParentQuery innerJoinParent($relationAlias = null) Adds a INNER JOIN clause to the query using the Parent relation
 *
 * @method     ChildPuzzleParentQuery joinWithParent($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Parent relation
 *
 * @method     ChildPuzzleParentQuery leftJoinWithParent() Adds a LEFT JOIN clause and with to the query using the Parent relation
 * @method     ChildPuzzleParentQuery rightJoinWithParent() Adds a RIGHT JOIN clause and with to the query using the Parent relation
 * @method     ChildPuzzleParentQuery innerJoinWithParent() Adds a INNER JOIN clause and with to the query using the Parent relation
 *
 * @method     \PuzzleQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPuzzleParent findOne(ConnectionInterface $con = null) Return the first ChildPuzzleParent matching the query
 * @method     ChildPuzzleParent findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPuzzleParent matching the query, or a new ChildPuzzleParent object populated from the query conditions when no match is found
 *
 * @method     ChildPuzzleParent findOneById(int $id) Return the first ChildPuzzleParent filtered by the id column
 * @method     ChildPuzzleParent findOneByPuzzleId(int $puzzle_id) Return the first ChildPuzzleParent filtered by the puzzle_id column
 * @method     ChildPuzzleParent findOneByParentId(int $parent_id) Return the first ChildPuzzleParent filtered by the parent_id column *

 * @method     ChildPuzzleParent requirePk($key, ConnectionInterface $con = null) Return the ChildPuzzleParent by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPuzzleParent requireOne(ConnectionInterface $con = null) Return the first ChildPuzzleParent matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPuzzleParent requireOneById(int $id) Return the first ChildPuzzleParent filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPuzzleParent requireOneByPuzzleId(int $puzzle_id) Return the first ChildPuzzleParent filtered by the puzzle_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPuzzleParent requireOneByParentId(int $parent_id) Return the first ChildPuzzleParent filtered by the parent_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPuzzleParent[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPuzzleParent objects based on current ModelCriteria
 * @method     ChildPuzzleParent[]|ObjectCollection findById(int $id) Return ChildPuzzleParent objects filtered by the id column
 * @method     ChildPuzzleParent[]|ObjectCollection findByPuzzleId(int $puzzle_id) Return ChildPuzzleParent objects filtered by the puzzle_id column
 * @method     ChildPuzzleParent[]|ObjectCollection findByParentId(int $parent_id) Return ChildPuzzleParent objects filtered by the parent_id column
 * @method     ChildPuzzleParent[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PuzzleParentQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\PuzzleParentQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'palindrome', $modelName = '\\PuzzleParent', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPuzzleParentQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPuzzleParentQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPuzzleParentQuery) {
            return $criteria;
        }
        $query = new ChildPuzzleParentQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildPuzzleParent|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PuzzleParentTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = PuzzleParentTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
            // the object is already in the instance pool
            return $obj;
        }

        return $this->findPkSimple($key, $con);
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPuzzleParent A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, puzzle_id, parent_id FROM relationship WHERE id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildPuzzleParent $obj */
            $obj = new ChildPuzzleParent();
            $obj->hydrate($row);
            PuzzleParentTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildPuzzleParent|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildPuzzleParentQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PuzzleParentTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPuzzleParentQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PuzzleParentTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPuzzleParentQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(PuzzleParentTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(PuzzleParentTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PuzzleParentTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the puzzle_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPuzzleId(1234); // WHERE puzzle_id = 1234
     * $query->filterByPuzzleId(array(12, 34)); // WHERE puzzle_id IN (12, 34)
     * $query->filterByPuzzleId(array('min' => 12)); // WHERE puzzle_id > 12
     * </code>
     *
     * @see       filterByPuzzle()
     *
     * @param     mixed $puzzleId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPuzzleParentQuery The current query, for fluid interface
     */
    public function filterByPuzzleId($puzzleId = null, $comparison = null)
    {
        if (is_array($puzzleId)) {
            $useMinMax = false;
            if (isset($puzzleId['min'])) {
                $this->addUsingAlias(PuzzleParentTableMap::COL_PUZZLE_ID, $puzzleId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($puzzleId['max'])) {
                $this->addUsingAlias(PuzzleParentTableMap::COL_PUZZLE_ID, $puzzleId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PuzzleParentTableMap::COL_PUZZLE_ID, $puzzleId, $comparison);
    }

    /**
     * Filter the query on the parent_id column
     *
     * Example usage:
     * <code>
     * $query->filterByParentId(1234); // WHERE parent_id = 1234
     * $query->filterByParentId(array(12, 34)); // WHERE parent_id IN (12, 34)
     * $query->filterByParentId(array('min' => 12)); // WHERE parent_id > 12
     * </code>
     *
     * @see       filterByParent()
     *
     * @param     mixed $parentId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPuzzleParentQuery The current query, for fluid interface
     */
    public function filterByParentId($parentId = null, $comparison = null)
    {
        if (is_array($parentId)) {
            $useMinMax = false;
            if (isset($parentId['min'])) {
                $this->addUsingAlias(PuzzleParentTableMap::COL_PARENT_ID, $parentId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($parentId['max'])) {
                $this->addUsingAlias(PuzzleParentTableMap::COL_PARENT_ID, $parentId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PuzzleParentTableMap::COL_PARENT_ID, $parentId, $comparison);
    }

    /**
     * Filter the query by a related \Puzzle object
     *
     * @param \Puzzle|ObjectCollection $puzzle The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPuzzleParentQuery The current query, for fluid interface
     */
    public function filterByPuzzle($puzzle, $comparison = null)
    {
        if ($puzzle instanceof \Puzzle) {
            return $this
                ->addUsingAlias(PuzzleParentTableMap::COL_PUZZLE_ID, $puzzle->getId(), $comparison);
        } elseif ($puzzle instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PuzzleParentTableMap::COL_PUZZLE_ID, $puzzle->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByPuzzle() only accepts arguments of type \Puzzle or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Puzzle relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPuzzleParentQuery The current query, for fluid interface
     */
    public function joinPuzzle($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Puzzle');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Puzzle');
        }

        return $this;
    }

    /**
     * Use the Puzzle relation Puzzle object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PuzzleQuery A secondary query class using the current class as primary query
     */
    public function usePuzzleQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPuzzle($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Puzzle', '\PuzzleQuery');
    }

    /**
     * Filter the query by a related \Puzzle object
     *
     * @param \Puzzle|ObjectCollection $puzzle The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPuzzleParentQuery The current query, for fluid interface
     */
    public function filterByParent($puzzle, $comparison = null)
    {
        if ($puzzle instanceof \Puzzle) {
            return $this
                ->addUsingAlias(PuzzleParentTableMap::COL_PARENT_ID, $puzzle->getId(), $comparison);
        } elseif ($puzzle instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PuzzleParentTableMap::COL_PARENT_ID, $puzzle->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByParent() only accepts arguments of type \Puzzle or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Parent relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPuzzleParentQuery The current query, for fluid interface
     */
    public function joinParent($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Parent');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Parent');
        }

        return $this;
    }

    /**
     * Use the Parent relation Puzzle object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PuzzleQuery A secondary query class using the current class as primary query
     */
    public function useParentQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinParent($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Parent', '\PuzzleQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPuzzleParent $puzzleParent Object to remove from the list of results
     *
     * @return $this|ChildPuzzleParentQuery The current query, for fluid interface
     */
    public function prune($puzzleParent = null)
    {
        if ($puzzleParent) {
            $this->addUsingAlias(PuzzleParentTableMap::COL_ID, $puzzleParent->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the relationship table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PuzzleParentTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PuzzleParentTableMap::clearInstancePool();
            PuzzleParentTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PuzzleParentTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PuzzleParentTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PuzzleParentTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PuzzleParentTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PuzzleParentQuery
