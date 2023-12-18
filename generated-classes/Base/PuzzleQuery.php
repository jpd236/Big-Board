<?php

namespace Base;

use \Puzzle as ChildPuzzle;
use \PuzzleArchive as ChildPuzzleArchive;
use \PuzzleQuery as ChildPuzzleQuery;
use \Exception;
use \PDO;
use Map\PuzzleTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the `puzzle` table.
 *
 * @method     ChildPuzzleQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildPuzzleQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method     ChildPuzzleQuery orderByUrl($order = Criteria::ASC) Order by the url column
 * @method     ChildPuzzleQuery orderBySpreadsheetId($order = Criteria::ASC) Order by the spreadsheet_id column
 * @method     ChildPuzzleQuery orderBySolution($order = Criteria::ASC) Order by the solution column
 * @method     ChildPuzzleQuery orderByStatus($order = Criteria::ASC) Order by the status column
 * @method     ChildPuzzleQuery orderBySlackChannel($order = Criteria::ASC) Order by the slack_channel column
 * @method     ChildPuzzleQuery orderBySlackChannelId($order = Criteria::ASC) Order by the slack_channel_id column
 * @method     ChildPuzzleQuery orderByWranglerId($order = Criteria::ASC) Order by the wrangler_id column
 * @method     ChildPuzzleQuery orderBySheetModDate($order = Criteria::ASC) Order by the sheet_mod_date column
 * @method     ChildPuzzleQuery orderBySortOrder($order = Criteria::ASC) Order by the sort_order column
 * @method     ChildPuzzleQuery orderByNote($order = Criteria::ASC) Order by the note column
 * @method     ChildPuzzleQuery orderBySolverCount($order = Criteria::ASC) Order by the solver_count column
 * @method     ChildPuzzleQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildPuzzleQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildPuzzleQuery groupById() Group by the id column
 * @method     ChildPuzzleQuery groupByTitle() Group by the title column
 * @method     ChildPuzzleQuery groupByUrl() Group by the url column
 * @method     ChildPuzzleQuery groupBySpreadsheetId() Group by the spreadsheet_id column
 * @method     ChildPuzzleQuery groupBySolution() Group by the solution column
 * @method     ChildPuzzleQuery groupByStatus() Group by the status column
 * @method     ChildPuzzleQuery groupBySlackChannel() Group by the slack_channel column
 * @method     ChildPuzzleQuery groupBySlackChannelId() Group by the slack_channel_id column
 * @method     ChildPuzzleQuery groupByWranglerId() Group by the wrangler_id column
 * @method     ChildPuzzleQuery groupBySheetModDate() Group by the sheet_mod_date column
 * @method     ChildPuzzleQuery groupBySortOrder() Group by the sort_order column
 * @method     ChildPuzzleQuery groupByNote() Group by the note column
 * @method     ChildPuzzleQuery groupBySolverCount() Group by the solver_count column
 * @method     ChildPuzzleQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildPuzzleQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildPuzzleQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPuzzleQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPuzzleQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPuzzleQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildPuzzleQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildPuzzleQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildPuzzleQuery leftJoinWrangler($relationAlias = null) Adds a LEFT JOIN clause to the query using the Wrangler relation
 * @method     ChildPuzzleQuery rightJoinWrangler($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Wrangler relation
 * @method     ChildPuzzleQuery innerJoinWrangler($relationAlias = null) Adds a INNER JOIN clause to the query using the Wrangler relation
 *
 * @method     ChildPuzzleQuery joinWithWrangler($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Wrangler relation
 *
 * @method     ChildPuzzleQuery leftJoinWithWrangler() Adds a LEFT JOIN clause and with to the query using the Wrangler relation
 * @method     ChildPuzzleQuery rightJoinWithWrangler() Adds a RIGHT JOIN clause and with to the query using the Wrangler relation
 * @method     ChildPuzzleQuery innerJoinWithWrangler() Adds a INNER JOIN clause and with to the query using the Wrangler relation
 *
 * @method     ChildPuzzleQuery leftJoinPuzzleMember($relationAlias = null) Adds a LEFT JOIN clause to the query using the PuzzleMember relation
 * @method     ChildPuzzleQuery rightJoinPuzzleMember($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PuzzleMember relation
 * @method     ChildPuzzleQuery innerJoinPuzzleMember($relationAlias = null) Adds a INNER JOIN clause to the query using the PuzzleMember relation
 *
 * @method     ChildPuzzleQuery joinWithPuzzleMember($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the PuzzleMember relation
 *
 * @method     ChildPuzzleQuery leftJoinWithPuzzleMember() Adds a LEFT JOIN clause and with to the query using the PuzzleMember relation
 * @method     ChildPuzzleQuery rightJoinWithPuzzleMember() Adds a RIGHT JOIN clause and with to the query using the PuzzleMember relation
 * @method     ChildPuzzleQuery innerJoinWithPuzzleMember() Adds a INNER JOIN clause and with to the query using the PuzzleMember relation
 *
 * @method     ChildPuzzleQuery leftJoinPuzzleParent($relationAlias = null) Adds a LEFT JOIN clause to the query using the PuzzleParent relation
 * @method     ChildPuzzleQuery rightJoinPuzzleParent($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PuzzleParent relation
 * @method     ChildPuzzleQuery innerJoinPuzzleParent($relationAlias = null) Adds a INNER JOIN clause to the query using the PuzzleParent relation
 *
 * @method     ChildPuzzleQuery joinWithPuzzleParent($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the PuzzleParent relation
 *
 * @method     ChildPuzzleQuery leftJoinWithPuzzleParent() Adds a LEFT JOIN clause and with to the query using the PuzzleParent relation
 * @method     ChildPuzzleQuery rightJoinWithPuzzleParent() Adds a RIGHT JOIN clause and with to the query using the PuzzleParent relation
 * @method     ChildPuzzleQuery innerJoinWithPuzzleParent() Adds a INNER JOIN clause and with to the query using the PuzzleParent relation
 *
 * @method     ChildPuzzleQuery leftJoinPuzzleChild($relationAlias = null) Adds a LEFT JOIN clause to the query using the PuzzleChild relation
 * @method     ChildPuzzleQuery rightJoinPuzzleChild($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PuzzleChild relation
 * @method     ChildPuzzleQuery innerJoinPuzzleChild($relationAlias = null) Adds a INNER JOIN clause to the query using the PuzzleChild relation
 *
 * @method     ChildPuzzleQuery joinWithPuzzleChild($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the PuzzleChild relation
 *
 * @method     ChildPuzzleQuery leftJoinWithPuzzleChild() Adds a LEFT JOIN clause and with to the query using the PuzzleChild relation
 * @method     ChildPuzzleQuery rightJoinWithPuzzleChild() Adds a RIGHT JOIN clause and with to the query using the PuzzleChild relation
 * @method     ChildPuzzleQuery innerJoinWithPuzzleChild() Adds a INNER JOIN clause and with to the query using the PuzzleChild relation
 *
 * @method     \MemberQuery|\PuzzleMemberQuery|\PuzzlePuzzleQuery|\PuzzlePuzzleQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPuzzle|null findOne(?ConnectionInterface $con = null) Return the first ChildPuzzle matching the query
 * @method     ChildPuzzle findOneOrCreate(?ConnectionInterface $con = null) Return the first ChildPuzzle matching the query, or a new ChildPuzzle object populated from the query conditions when no match is found
 *
 * @method     ChildPuzzle|null findOneById(int $id) Return the first ChildPuzzle filtered by the id column
 * @method     ChildPuzzle|null findOneByTitle(string $title) Return the first ChildPuzzle filtered by the title column
 * @method     ChildPuzzle|null findOneByUrl(string $url) Return the first ChildPuzzle filtered by the url column
 * @method     ChildPuzzle|null findOneBySpreadsheetId(string $spreadsheet_id) Return the first ChildPuzzle filtered by the spreadsheet_id column
 * @method     ChildPuzzle|null findOneBySolution(string $solution) Return the first ChildPuzzle filtered by the solution column
 * @method     ChildPuzzle|null findOneByStatus(string $status) Return the first ChildPuzzle filtered by the status column
 * @method     ChildPuzzle|null findOneBySlackChannel(string $slack_channel) Return the first ChildPuzzle filtered by the slack_channel column
 * @method     ChildPuzzle|null findOneBySlackChannelId(string $slack_channel_id) Return the first ChildPuzzle filtered by the slack_channel_id column
 * @method     ChildPuzzle|null findOneByWranglerId(int $wrangler_id) Return the first ChildPuzzle filtered by the wrangler_id column
 * @method     ChildPuzzle|null findOneBySheetModDate(string $sheet_mod_date) Return the first ChildPuzzle filtered by the sheet_mod_date column
 * @method     ChildPuzzle|null findOneBySortOrder(int $sort_order) Return the first ChildPuzzle filtered by the sort_order column
 * @method     ChildPuzzle|null findOneByNote(string $note) Return the first ChildPuzzle filtered by the note column
 * @method     ChildPuzzle|null findOneBySolverCount(int $solver_count) Return the first ChildPuzzle filtered by the solver_count column
 * @method     ChildPuzzle|null findOneByCreatedAt(string $created_at) Return the first ChildPuzzle filtered by the created_at column
 * @method     ChildPuzzle|null findOneByUpdatedAt(string $updated_at) Return the first ChildPuzzle filtered by the updated_at column
 *
 * @method     ChildPuzzle requirePk($key, ?ConnectionInterface $con = null) Return the ChildPuzzle by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPuzzle requireOne(?ConnectionInterface $con = null) Return the first ChildPuzzle matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPuzzle requireOneById(int $id) Return the first ChildPuzzle filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPuzzle requireOneByTitle(string $title) Return the first ChildPuzzle filtered by the title column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPuzzle requireOneByUrl(string $url) Return the first ChildPuzzle filtered by the url column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPuzzle requireOneBySpreadsheetId(string $spreadsheet_id) Return the first ChildPuzzle filtered by the spreadsheet_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPuzzle requireOneBySolution(string $solution) Return the first ChildPuzzle filtered by the solution column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPuzzle requireOneByStatus(string $status) Return the first ChildPuzzle filtered by the status column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPuzzle requireOneBySlackChannel(string $slack_channel) Return the first ChildPuzzle filtered by the slack_channel column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPuzzle requireOneBySlackChannelId(string $slack_channel_id) Return the first ChildPuzzle filtered by the slack_channel_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPuzzle requireOneByWranglerId(int $wrangler_id) Return the first ChildPuzzle filtered by the wrangler_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPuzzle requireOneBySheetModDate(string $sheet_mod_date) Return the first ChildPuzzle filtered by the sheet_mod_date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPuzzle requireOneBySortOrder(int $sort_order) Return the first ChildPuzzle filtered by the sort_order column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPuzzle requireOneByNote(string $note) Return the first ChildPuzzle filtered by the note column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPuzzle requireOneBySolverCount(int $solver_count) Return the first ChildPuzzle filtered by the solver_count column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPuzzle requireOneByCreatedAt(string $created_at) Return the first ChildPuzzle filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPuzzle requireOneByUpdatedAt(string $updated_at) Return the first ChildPuzzle filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPuzzle[]|Collection find(?ConnectionInterface $con = null) Return ChildPuzzle objects based on current ModelCriteria
 * @psalm-method Collection&\Traversable<ChildPuzzle> find(?ConnectionInterface $con = null) Return ChildPuzzle objects based on current ModelCriteria
 *
 * @method     ChildPuzzle[]|Collection findById(int|array<int> $id) Return ChildPuzzle objects filtered by the id column
 * @psalm-method Collection&\Traversable<ChildPuzzle> findById(int|array<int> $id) Return ChildPuzzle objects filtered by the id column
 * @method     ChildPuzzle[]|Collection findByTitle(string|array<string> $title) Return ChildPuzzle objects filtered by the title column
 * @psalm-method Collection&\Traversable<ChildPuzzle> findByTitle(string|array<string> $title) Return ChildPuzzle objects filtered by the title column
 * @method     ChildPuzzle[]|Collection findByUrl(string|array<string> $url) Return ChildPuzzle objects filtered by the url column
 * @psalm-method Collection&\Traversable<ChildPuzzle> findByUrl(string|array<string> $url) Return ChildPuzzle objects filtered by the url column
 * @method     ChildPuzzle[]|Collection findBySpreadsheetId(string|array<string> $spreadsheet_id) Return ChildPuzzle objects filtered by the spreadsheet_id column
 * @psalm-method Collection&\Traversable<ChildPuzzle> findBySpreadsheetId(string|array<string> $spreadsheet_id) Return ChildPuzzle objects filtered by the spreadsheet_id column
 * @method     ChildPuzzle[]|Collection findBySolution(string|array<string> $solution) Return ChildPuzzle objects filtered by the solution column
 * @psalm-method Collection&\Traversable<ChildPuzzle> findBySolution(string|array<string> $solution) Return ChildPuzzle objects filtered by the solution column
 * @method     ChildPuzzle[]|Collection findByStatus(string|array<string> $status) Return ChildPuzzle objects filtered by the status column
 * @psalm-method Collection&\Traversable<ChildPuzzle> findByStatus(string|array<string> $status) Return ChildPuzzle objects filtered by the status column
 * @method     ChildPuzzle[]|Collection findBySlackChannel(string|array<string> $slack_channel) Return ChildPuzzle objects filtered by the slack_channel column
 * @psalm-method Collection&\Traversable<ChildPuzzle> findBySlackChannel(string|array<string> $slack_channel) Return ChildPuzzle objects filtered by the slack_channel column
 * @method     ChildPuzzle[]|Collection findBySlackChannelId(string|array<string> $slack_channel_id) Return ChildPuzzle objects filtered by the slack_channel_id column
 * @psalm-method Collection&\Traversable<ChildPuzzle> findBySlackChannelId(string|array<string> $slack_channel_id) Return ChildPuzzle objects filtered by the slack_channel_id column
 * @method     ChildPuzzle[]|Collection findByWranglerId(int|array<int> $wrangler_id) Return ChildPuzzle objects filtered by the wrangler_id column
 * @psalm-method Collection&\Traversable<ChildPuzzle> findByWranglerId(int|array<int> $wrangler_id) Return ChildPuzzle objects filtered by the wrangler_id column
 * @method     ChildPuzzle[]|Collection findBySheetModDate(string|array<string> $sheet_mod_date) Return ChildPuzzle objects filtered by the sheet_mod_date column
 * @psalm-method Collection&\Traversable<ChildPuzzle> findBySheetModDate(string|array<string> $sheet_mod_date) Return ChildPuzzle objects filtered by the sheet_mod_date column
 * @method     ChildPuzzle[]|Collection findBySortOrder(int|array<int> $sort_order) Return ChildPuzzle objects filtered by the sort_order column
 * @psalm-method Collection&\Traversable<ChildPuzzle> findBySortOrder(int|array<int> $sort_order) Return ChildPuzzle objects filtered by the sort_order column
 * @method     ChildPuzzle[]|Collection findByNote(string|array<string> $note) Return ChildPuzzle objects filtered by the note column
 * @psalm-method Collection&\Traversable<ChildPuzzle> findByNote(string|array<string> $note) Return ChildPuzzle objects filtered by the note column
 * @method     ChildPuzzle[]|Collection findBySolverCount(int|array<int> $solver_count) Return ChildPuzzle objects filtered by the solver_count column
 * @psalm-method Collection&\Traversable<ChildPuzzle> findBySolverCount(int|array<int> $solver_count) Return ChildPuzzle objects filtered by the solver_count column
 * @method     ChildPuzzle[]|Collection findByCreatedAt(string|array<string> $created_at) Return ChildPuzzle objects filtered by the created_at column
 * @psalm-method Collection&\Traversable<ChildPuzzle> findByCreatedAt(string|array<string> $created_at) Return ChildPuzzle objects filtered by the created_at column
 * @method     ChildPuzzle[]|Collection findByUpdatedAt(string|array<string> $updated_at) Return ChildPuzzle objects filtered by the updated_at column
 * @psalm-method Collection&\Traversable<ChildPuzzle> findByUpdatedAt(string|array<string> $updated_at) Return ChildPuzzle objects filtered by the updated_at column
 *
 * @method     ChildPuzzle[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 * @psalm-method \Propel\Runtime\Util\PropelModelPager&\Traversable<ChildPuzzle> paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 */
abstract class PuzzleQuery extends ModelCriteria
{

    // archivable behavior
    protected $archiveOnDelete = true;
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\PuzzleQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'palindrome', $modelName = '\\Puzzle', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPuzzleQuery object.
     *
     * @param string $modelAlias The alias of a model in the query
     * @param Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPuzzleQuery
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildPuzzleQuery) {
            return $criteria;
        }
        $query = new ChildPuzzleQuery();
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
     * @return ChildPuzzle|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PuzzleTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = PuzzleTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
            // the object is already in the instance pool
            return $obj;
        }

        return $this->findPkSimple($key, $con);
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPuzzle A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, title, url, spreadsheet_id, solution, status, slack_channel, slack_channel_id, wrangler_id, sheet_mod_date, sort_order, note, solver_count, created_at, updated_at FROM puzzle WHERE id = :p0';
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
            /** @var ChildPuzzle $obj */
            $obj = new ChildPuzzle();
            $obj->hydrate($row);
            PuzzleTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con A connection object
     *
     * @return ChildPuzzle|array|mixed the result, formatted by the current formatter
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
     * @param array $keys Primary keys to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return Collection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ?ConnectionInterface $con = null)
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
     * @param mixed $key Primary key to use for the query
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        $this->addUsingAlias(PuzzleTableMap::COL_ID, $key, Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param array|int $keys The list of primary key to use for the query
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        $this->addUsingAlias(PuzzleTableMap::COL_ID, $keys, Criteria::IN);

        return $this;
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
     * @param mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterById($id = null, ?string $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(PuzzleTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(PuzzleTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(PuzzleTableMap::COL_ID, $id, $comparison);

        return $this;
    }

    /**
     * Filter the query on the title column
     *
     * Example usage:
     * <code>
     * $query->filterByTitle('fooValue');   // WHERE title = 'fooValue'
     * $query->filterByTitle('%fooValue%', Criteria::LIKE); // WHERE title LIKE '%fooValue%'
     * $query->filterByTitle(['foo', 'bar']); // WHERE title IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $title The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByTitle($title = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($title)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(PuzzleTableMap::COL_TITLE, $title, $comparison);

        return $this;
    }

    /**
     * Filter the query on the url column
     *
     * Example usage:
     * <code>
     * $query->filterByUrl('fooValue');   // WHERE url = 'fooValue'
     * $query->filterByUrl('%fooValue%', Criteria::LIKE); // WHERE url LIKE '%fooValue%'
     * $query->filterByUrl(['foo', 'bar']); // WHERE url IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $url The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByUrl($url = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($url)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(PuzzleTableMap::COL_URL, $url, $comparison);

        return $this;
    }

    /**
     * Filter the query on the spreadsheet_id column
     *
     * Example usage:
     * <code>
     * $query->filterBySpreadsheetId('fooValue');   // WHERE spreadsheet_id = 'fooValue'
     * $query->filterBySpreadsheetId('%fooValue%', Criteria::LIKE); // WHERE spreadsheet_id LIKE '%fooValue%'
     * $query->filterBySpreadsheetId(['foo', 'bar']); // WHERE spreadsheet_id IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $spreadsheetId The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterBySpreadsheetId($spreadsheetId = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($spreadsheetId)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(PuzzleTableMap::COL_SPREADSHEET_ID, $spreadsheetId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the solution column
     *
     * Example usage:
     * <code>
     * $query->filterBySolution('fooValue');   // WHERE solution = 'fooValue'
     * $query->filterBySolution('%fooValue%', Criteria::LIKE); // WHERE solution LIKE '%fooValue%'
     * $query->filterBySolution(['foo', 'bar']); // WHERE solution IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $solution The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterBySolution($solution = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($solution)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(PuzzleTableMap::COL_SOLUTION, $solution, $comparison);

        return $this;
    }

    /**
     * Filter the query on the status column
     *
     * Example usage:
     * <code>
     * $query->filterByStatus('fooValue');   // WHERE status = 'fooValue'
     * $query->filterByStatus('%fooValue%', Criteria::LIKE); // WHERE status LIKE '%fooValue%'
     * $query->filterByStatus(['foo', 'bar']); // WHERE status IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $status The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByStatus($status = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($status)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(PuzzleTableMap::COL_STATUS, $status, $comparison);

        return $this;
    }

    /**
     * Filter the query on the slack_channel column
     *
     * Example usage:
     * <code>
     * $query->filterBySlackChannel('fooValue');   // WHERE slack_channel = 'fooValue'
     * $query->filterBySlackChannel('%fooValue%', Criteria::LIKE); // WHERE slack_channel LIKE '%fooValue%'
     * $query->filterBySlackChannel(['foo', 'bar']); // WHERE slack_channel IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $slackChannel The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterBySlackChannel($slackChannel = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($slackChannel)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(PuzzleTableMap::COL_SLACK_CHANNEL, $slackChannel, $comparison);

        return $this;
    }

    /**
     * Filter the query on the slack_channel_id column
     *
     * Example usage:
     * <code>
     * $query->filterBySlackChannelId('fooValue');   // WHERE slack_channel_id = 'fooValue'
     * $query->filterBySlackChannelId('%fooValue%', Criteria::LIKE); // WHERE slack_channel_id LIKE '%fooValue%'
     * $query->filterBySlackChannelId(['foo', 'bar']); // WHERE slack_channel_id IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $slackChannelId The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterBySlackChannelId($slackChannelId = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($slackChannelId)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(PuzzleTableMap::COL_SLACK_CHANNEL_ID, $slackChannelId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the wrangler_id column
     *
     * Example usage:
     * <code>
     * $query->filterByWranglerId(1234); // WHERE wrangler_id = 1234
     * $query->filterByWranglerId(array(12, 34)); // WHERE wrangler_id IN (12, 34)
     * $query->filterByWranglerId(array('min' => 12)); // WHERE wrangler_id > 12
     * </code>
     *
     * @see       filterByWrangler()
     *
     * @param mixed $wranglerId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByWranglerId($wranglerId = null, ?string $comparison = null)
    {
        if (is_array($wranglerId)) {
            $useMinMax = false;
            if (isset($wranglerId['min'])) {
                $this->addUsingAlias(PuzzleTableMap::COL_WRANGLER_ID, $wranglerId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($wranglerId['max'])) {
                $this->addUsingAlias(PuzzleTableMap::COL_WRANGLER_ID, $wranglerId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(PuzzleTableMap::COL_WRANGLER_ID, $wranglerId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the sheet_mod_date column
     *
     * Example usage:
     * <code>
     * $query->filterBySheetModDate('2011-03-14'); // WHERE sheet_mod_date = '2011-03-14'
     * $query->filterBySheetModDate('now'); // WHERE sheet_mod_date = '2011-03-14'
     * $query->filterBySheetModDate(array('max' => 'yesterday')); // WHERE sheet_mod_date > '2011-03-13'
     * </code>
     *
     * @param mixed $sheetModDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterBySheetModDate($sheetModDate = null, ?string $comparison = null)
    {
        if (is_array($sheetModDate)) {
            $useMinMax = false;
            if (isset($sheetModDate['min'])) {
                $this->addUsingAlias(PuzzleTableMap::COL_SHEET_MOD_DATE, $sheetModDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sheetModDate['max'])) {
                $this->addUsingAlias(PuzzleTableMap::COL_SHEET_MOD_DATE, $sheetModDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(PuzzleTableMap::COL_SHEET_MOD_DATE, $sheetModDate, $comparison);

        return $this;
    }

    /**
     * Filter the query on the sort_order column
     *
     * Example usage:
     * <code>
     * $query->filterBySortOrder(1234); // WHERE sort_order = 1234
     * $query->filterBySortOrder(array(12, 34)); // WHERE sort_order IN (12, 34)
     * $query->filterBySortOrder(array('min' => 12)); // WHERE sort_order > 12
     * </code>
     *
     * @param mixed $sortOrder The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterBySortOrder($sortOrder = null, ?string $comparison = null)
    {
        if (is_array($sortOrder)) {
            $useMinMax = false;
            if (isset($sortOrder['min'])) {
                $this->addUsingAlias(PuzzleTableMap::COL_SORT_ORDER, $sortOrder['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sortOrder['max'])) {
                $this->addUsingAlias(PuzzleTableMap::COL_SORT_ORDER, $sortOrder['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(PuzzleTableMap::COL_SORT_ORDER, $sortOrder, $comparison);

        return $this;
    }

    /**
     * Filter the query on the note column
     *
     * Example usage:
     * <code>
     * $query->filterByNote('fooValue');   // WHERE note = 'fooValue'
     * $query->filterByNote('%fooValue%', Criteria::LIKE); // WHERE note LIKE '%fooValue%'
     * $query->filterByNote(['foo', 'bar']); // WHERE note IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $note The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByNote($note = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($note)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(PuzzleTableMap::COL_NOTE, $note, $comparison);

        return $this;
    }

    /**
     * Filter the query on the solver_count column
     *
     * Example usage:
     * <code>
     * $query->filterBySolverCount(1234); // WHERE solver_count = 1234
     * $query->filterBySolverCount(array(12, 34)); // WHERE solver_count IN (12, 34)
     * $query->filterBySolverCount(array('min' => 12)); // WHERE solver_count > 12
     * </code>
     *
     * @param mixed $solverCount The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterBySolverCount($solverCount = null, ?string $comparison = null)
    {
        if (is_array($solverCount)) {
            $useMinMax = false;
            if (isset($solverCount['min'])) {
                $this->addUsingAlias(PuzzleTableMap::COL_SOLVER_COUNT, $solverCount['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($solverCount['max'])) {
                $this->addUsingAlias(PuzzleTableMap::COL_SOLVER_COUNT, $solverCount['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(PuzzleTableMap::COL_SOLVER_COUNT, $solverCount, $comparison);

        return $this;
    }

    /**
     * Filter the query on the created_at column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatedAt('2011-03-14'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt('now'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt(array('max' => 'yesterday')); // WHERE created_at > '2011-03-13'
     * </code>
     *
     * @param mixed $createdAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, ?string $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(PuzzleTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(PuzzleTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(PuzzleTableMap::COL_CREATED_AT, $createdAt, $comparison);

        return $this;
    }

    /**
     * Filter the query on the updated_at column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdatedAt('2011-03-14'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt('now'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt(array('max' => 'yesterday')); // WHERE updated_at > '2011-03-13'
     * </code>
     *
     * @param mixed $updatedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, ?string $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(PuzzleTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(PuzzleTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(PuzzleTableMap::COL_UPDATED_AT, $updatedAt, $comparison);

        return $this;
    }

    /**
     * Filter the query by a related \Member object
     *
     * @param \Member|ObjectCollection $member The related object(s) to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByWrangler($member, ?string $comparison = null)
    {
        if ($member instanceof \Member) {
            return $this
                ->addUsingAlias(PuzzleTableMap::COL_WRANGLER_ID, $member->getId(), $comparison);
        } elseif ($member instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingAlias(PuzzleTableMap::COL_WRANGLER_ID, $member->toKeyValue('PrimaryKey', 'Id'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByWrangler() only accepts arguments of type \Member or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Wrangler relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinWrangler(?string $relationAlias = null, ?string $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Wrangler');

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
            $this->addJoinObject($join, 'Wrangler');
        }

        return $this;
    }

    /**
     * Use the Wrangler relation Member object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \MemberQuery A secondary query class using the current class as primary query
     */
    public function useWranglerQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinWrangler($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Wrangler', '\MemberQuery');
    }

    /**
     * Use the Wrangler relation Member object
     *
     * @param callable(\MemberQuery):\MemberQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withWranglerQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::LEFT_JOIN
    ) {
        $relatedQuery = $this->useWranglerQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the Wrangler relation to the Member table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \MemberQuery The inner query object of the EXISTS statement
     */
    public function useWranglerExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \MemberQuery */
        $q = $this->useExistsQuery('Wrangler', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the Wrangler relation to the Member table for a NOT EXISTS query.
     *
     * @see useWranglerExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \MemberQuery The inner query object of the NOT EXISTS statement
     */
    public function useWranglerNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \MemberQuery */
        $q = $this->useExistsQuery('Wrangler', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the Wrangler relation to the Member table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \MemberQuery The inner query object of the IN statement
     */
    public function useInWranglerQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \MemberQuery */
        $q = $this->useInQuery('Wrangler', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the Wrangler relation to the Member table for a NOT IN query.
     *
     * @see useWranglerInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \MemberQuery The inner query object of the NOT IN statement
     */
    public function useNotInWranglerQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \MemberQuery */
        $q = $this->useInQuery('Wrangler', $modelAlias, $queryClass, 'NOT IN');
        return $q;
    }

    /**
     * Filter the query by a related \PuzzleMember object
     *
     * @param \PuzzleMember|ObjectCollection $puzzleMember the related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByPuzzleMember($puzzleMember, ?string $comparison = null)
    {
        if ($puzzleMember instanceof \PuzzleMember) {
            $this
                ->addUsingAlias(PuzzleTableMap::COL_ID, $puzzleMember->getPuzzleId(), $comparison);

            return $this;
        } elseif ($puzzleMember instanceof ObjectCollection) {
            $this
                ->usePuzzleMemberQuery()
                ->filterByPrimaryKeys($puzzleMember->getPrimaryKeys())
                ->endUse();

            return $this;
        } else {
            throw new PropelException('filterByPuzzleMember() only accepts arguments of type \PuzzleMember or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PuzzleMember relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinPuzzleMember(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PuzzleMember');

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
            $this->addJoinObject($join, 'PuzzleMember');
        }

        return $this;
    }

    /**
     * Use the PuzzleMember relation PuzzleMember object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PuzzleMemberQuery A secondary query class using the current class as primary query
     */
    public function usePuzzleMemberQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPuzzleMember($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PuzzleMember', '\PuzzleMemberQuery');
    }

    /**
     * Use the PuzzleMember relation PuzzleMember object
     *
     * @param callable(\PuzzleMemberQuery):\PuzzleMemberQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withPuzzleMemberQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->usePuzzleMemberQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to PuzzleMember table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \PuzzleMemberQuery The inner query object of the EXISTS statement
     */
    public function usePuzzleMemberExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \PuzzleMemberQuery */
        $q = $this->useExistsQuery('PuzzleMember', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the relation to PuzzleMember table for a NOT EXISTS query.
     *
     * @see usePuzzleMemberExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \PuzzleMemberQuery The inner query object of the NOT EXISTS statement
     */
    public function usePuzzleMemberNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \PuzzleMemberQuery */
        $q = $this->useExistsQuery('PuzzleMember', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the relation to PuzzleMember table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \PuzzleMemberQuery The inner query object of the IN statement
     */
    public function useInPuzzleMemberQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \PuzzleMemberQuery */
        $q = $this->useInQuery('PuzzleMember', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the relation to PuzzleMember table for a NOT IN query.
     *
     * @see usePuzzleMemberInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \PuzzleMemberQuery The inner query object of the NOT IN statement
     */
    public function useNotInPuzzleMemberQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \PuzzleMemberQuery */
        $q = $this->useInQuery('PuzzleMember', $modelAlias, $queryClass, 'NOT IN');
        return $q;
    }

    /**
     * Filter the query by a related \PuzzlePuzzle object
     *
     * @param \PuzzlePuzzle|ObjectCollection $puzzlePuzzle the related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByPuzzleParent($puzzlePuzzle, ?string $comparison = null)
    {
        if ($puzzlePuzzle instanceof \PuzzlePuzzle) {
            $this
                ->addUsingAlias(PuzzleTableMap::COL_ID, $puzzlePuzzle->getPuzzleId(), $comparison);

            return $this;
        } elseif ($puzzlePuzzle instanceof ObjectCollection) {
            $this
                ->usePuzzleParentQuery()
                ->filterByPrimaryKeys($puzzlePuzzle->getPrimaryKeys())
                ->endUse();

            return $this;
        } else {
            throw new PropelException('filterByPuzzleParent() only accepts arguments of type \PuzzlePuzzle or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PuzzleParent relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinPuzzleParent(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PuzzleParent');

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
            $this->addJoinObject($join, 'PuzzleParent');
        }

        return $this;
    }

    /**
     * Use the PuzzleParent relation PuzzlePuzzle object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PuzzlePuzzleQuery A secondary query class using the current class as primary query
     */
    public function usePuzzleParentQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPuzzleParent($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PuzzleParent', '\PuzzlePuzzleQuery');
    }

    /**
     * Use the PuzzleParent relation PuzzlePuzzle object
     *
     * @param callable(\PuzzlePuzzleQuery):\PuzzlePuzzleQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withPuzzleParentQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->usePuzzleParentQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the PuzzleParent relation to the PuzzlePuzzle table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \PuzzlePuzzleQuery The inner query object of the EXISTS statement
     */
    public function usePuzzleParentExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \PuzzlePuzzleQuery */
        $q = $this->useExistsQuery('PuzzleParent', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the PuzzleParent relation to the PuzzlePuzzle table for a NOT EXISTS query.
     *
     * @see usePuzzleParentExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \PuzzlePuzzleQuery The inner query object of the NOT EXISTS statement
     */
    public function usePuzzleParentNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \PuzzlePuzzleQuery */
        $q = $this->useExistsQuery('PuzzleParent', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the PuzzleParent relation to the PuzzlePuzzle table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \PuzzlePuzzleQuery The inner query object of the IN statement
     */
    public function useInPuzzleParentQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \PuzzlePuzzleQuery */
        $q = $this->useInQuery('PuzzleParent', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the PuzzleParent relation to the PuzzlePuzzle table for a NOT IN query.
     *
     * @see usePuzzleParentInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \PuzzlePuzzleQuery The inner query object of the NOT IN statement
     */
    public function useNotInPuzzleParentQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \PuzzlePuzzleQuery */
        $q = $this->useInQuery('PuzzleParent', $modelAlias, $queryClass, 'NOT IN');
        return $q;
    }

    /**
     * Filter the query by a related \PuzzlePuzzle object
     *
     * @param \PuzzlePuzzle|ObjectCollection $puzzlePuzzle the related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByPuzzleChild($puzzlePuzzle, ?string $comparison = null)
    {
        if ($puzzlePuzzle instanceof \PuzzlePuzzle) {
            $this
                ->addUsingAlias(PuzzleTableMap::COL_ID, $puzzlePuzzle->getParentId(), $comparison);

            return $this;
        } elseif ($puzzlePuzzle instanceof ObjectCollection) {
            $this
                ->usePuzzleChildQuery()
                ->filterByPrimaryKeys($puzzlePuzzle->getPrimaryKeys())
                ->endUse();

            return $this;
        } else {
            throw new PropelException('filterByPuzzleChild() only accepts arguments of type \PuzzlePuzzle or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PuzzleChild relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinPuzzleChild(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PuzzleChild');

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
            $this->addJoinObject($join, 'PuzzleChild');
        }

        return $this;
    }

    /**
     * Use the PuzzleChild relation PuzzlePuzzle object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PuzzlePuzzleQuery A secondary query class using the current class as primary query
     */
    public function usePuzzleChildQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPuzzleChild($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PuzzleChild', '\PuzzlePuzzleQuery');
    }

    /**
     * Use the PuzzleChild relation PuzzlePuzzle object
     *
     * @param callable(\PuzzlePuzzleQuery):\PuzzlePuzzleQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withPuzzleChildQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->usePuzzleChildQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the PuzzleChild relation to the PuzzlePuzzle table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \PuzzlePuzzleQuery The inner query object of the EXISTS statement
     */
    public function usePuzzleChildExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \PuzzlePuzzleQuery */
        $q = $this->useExistsQuery('PuzzleChild', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the PuzzleChild relation to the PuzzlePuzzle table for a NOT EXISTS query.
     *
     * @see usePuzzleChildExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \PuzzlePuzzleQuery The inner query object of the NOT EXISTS statement
     */
    public function usePuzzleChildNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \PuzzlePuzzleQuery */
        $q = $this->useExistsQuery('PuzzleChild', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the PuzzleChild relation to the PuzzlePuzzle table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \PuzzlePuzzleQuery The inner query object of the IN statement
     */
    public function useInPuzzleChildQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \PuzzlePuzzleQuery */
        $q = $this->useInQuery('PuzzleChild', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the PuzzleChild relation to the PuzzlePuzzle table for a NOT IN query.
     *
     * @see usePuzzleChildInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \PuzzlePuzzleQuery The inner query object of the NOT IN statement
     */
    public function useNotInPuzzleChildQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \PuzzlePuzzleQuery */
        $q = $this->useInQuery('PuzzleChild', $modelAlias, $queryClass, 'NOT IN');
        return $q;
    }

    /**
     * Filter the query by a related Member object
     * using the solver table as cross reference
     *
     * @param Member $member the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL and Criteria::IN for queries
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByMember($member, string $comparison = null)
    {
        $this
            ->usePuzzleMemberQuery()
            ->filterByMember($member, $comparison)
            ->endUse();

        return $this;
    }

    /**
     * Filter the query by a related Puzzle object
     * using the relationship table as cross reference
     *
     * @param Puzzle $puzzle the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL and Criteria::IN for queries
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByParent($puzzle, string $comparison = null)
    {
        $this
            ->usePuzzleParentQuery()
            ->filterByParent($puzzle, $comparison)
            ->endUse();

        return $this;
    }

    /**
     * Filter the query by a related Puzzle object
     * using the relationship table as cross reference
     *
     * @param Puzzle $puzzle the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL and Criteria::IN for queries
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByChild($puzzle, string $comparison = null)
    {
        $this
            ->usePuzzleChildQuery()
            ->filterByChild($puzzle, $comparison)
            ->endUse();

        return $this;
    }

    /**
     * Exclude object from result
     *
     * @param ChildPuzzle $puzzle Object to remove from the list of results
     *
     * @return $this The current query, for fluid interface
     */
    public function prune($puzzle = null)
    {
        if ($puzzle) {
            $this->addUsingAlias(PuzzleTableMap::COL_ID, $puzzle->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Code to execute before every DELETE statement
     *
     * @param ConnectionInterface $con The connection object used by the query
     * @return int|null
     */
    protected function basePreDelete(ConnectionInterface $con): ?int
    {
        // archivable behavior

        if ($this->archiveOnDelete) {
            $this->archive($con);
        } else {
            $this->archiveOnDelete = true;
        }


        return $this->preDelete($con);
    }

    /**
     * Deletes all rows from the puzzle table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PuzzleTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PuzzleTableMap::clearInstancePool();
            PuzzleTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(?ConnectionInterface $con = null): int
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PuzzleTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PuzzleTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PuzzleTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PuzzleTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param int $nbDays Maximum age of the latest update in days
     *
     * @return $this The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        $this->addUsingAlias(PuzzleTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);

        return $this;
    }

    /**
     * Order by update date desc
     *
     * @return $this The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        $this->addDescendingOrderByColumn(PuzzleTableMap::COL_UPDATED_AT);

        return $this;
    }

    /**
     * Order by update date asc
     *
     * @return $this The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        $this->addAscendingOrderByColumn(PuzzleTableMap::COL_UPDATED_AT);

        return $this;
    }

    /**
     * Order by create date desc
     *
     * @return $this The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        $this->addDescendingOrderByColumn(PuzzleTableMap::COL_CREATED_AT);

        return $this;
    }

    /**
     * Filter by the latest created
     *
     * @param int $nbDays Maximum age of in days
     *
     * @return $this The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        $this->addUsingAlias(PuzzleTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);

        return $this;
    }

    /**
     * Order by create date asc
     *
     * @return $this The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        $this->addAscendingOrderByColumn(PuzzleTableMap::COL_CREATED_AT);

        return $this;
    }

    // archivable behavior

    /**
     * Copy the data of the objects satisfying the query into ChildPuzzleArchive archive objects.
     * The archived objects are then saved.
     * If any of the objects has already been archived, the archived object
     * is updated and not duplicated.
     * Warning: This termination methods issues 2n+1 queries.
     *
     * @param ConnectionInterface|null $con    Connection to use.
     * @param bool $useLittleMemory Whether to use OnDemandFormatter to retrieve objects.
     *               Set to false if the identity map matters.
     *               Set to true (default) to use less memory.
     *
     * @return int the number of archived objects
     */
    public function archive($con = null, $useLittleMemory = true)
    {
        $criteria = clone $this;
        // prepare the query
        $criteria->setWith(array());
        if ($useLittleMemory) {
            $criteria->setFormatter(ModelCriteria::FORMAT_ON_DEMAND);
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PuzzleTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con, $criteria) {
            $totalArchivedObjects = 0;

            // archive all results one by one
            foreach ($criteria->find($con) as $object) {
                $object->archive($con);
                $totalArchivedObjects++;
            }

            return $totalArchivedObjects;
        });
    }

    /**
     * Enable/disable auto-archiving on delete for the next query.
     *
     * @param bool True if the query must archive deleted objects, false otherwise.
     */
    public function setArchiveOnDelete(bool $archiveOnDelete)
    {
        $this->archiveOnDelete = $archiveOnDelete;
    }

    /**
     * Delete records matching the current query without archiving them.
     *
     * @param ConnectionInterface|null $con    Connection to use.
     *
     * @return int The number of deleted rows
     */
    public function deleteWithoutArchive($con = null): int
    {
        $this->archiveOnDelete = false;

        return $this->delete($con);
    }

    /**
     * Delete all records without archiving them.
     *
     * @param ConnectionInterface|null $con    Connection to use.
     *
     * @return int The number of deleted rows
     */
    public function deleteAllWithoutArchive($con = null): int
    {
        $this->archiveOnDelete = false;

        return $this->deleteAll($con);
    }

}
