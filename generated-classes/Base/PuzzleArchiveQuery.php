<?php

namespace Base;

use \PuzzleArchive as ChildPuzzleArchive;
use \PuzzleArchiveQuery as ChildPuzzleArchiveQuery;
use \Exception;
use \PDO;
use Map\PuzzleArchiveTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the `puzzle_archive` table.
 *
 * @method     ChildPuzzleArchiveQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildPuzzleArchiveQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method     ChildPuzzleArchiveQuery orderByUrl($order = Criteria::ASC) Order by the url column
 * @method     ChildPuzzleArchiveQuery orderBySpreadsheetId($order = Criteria::ASC) Order by the spreadsheet_id column
 * @method     ChildPuzzleArchiveQuery orderBySolution($order = Criteria::ASC) Order by the solution column
 * @method     ChildPuzzleArchiveQuery orderByStatus($order = Criteria::ASC) Order by the status column
 * @method     ChildPuzzleArchiveQuery orderBySlackChannel($order = Criteria::ASC) Order by the slack_channel column
 * @method     ChildPuzzleArchiveQuery orderBySlackChannelId($order = Criteria::ASC) Order by the slack_channel_id column
 * @method     ChildPuzzleArchiveQuery orderByWranglerId($order = Criteria::ASC) Order by the wrangler_id column
 * @method     ChildPuzzleArchiveQuery orderBySheetModDate($order = Criteria::ASC) Order by the sheet_mod_date column
 * @method     ChildPuzzleArchiveQuery orderBySortOrder($order = Criteria::ASC) Order by the sort_order column
 * @method     ChildPuzzleArchiveQuery orderByNote($order = Criteria::ASC) Order by the note column
 * @method     ChildPuzzleArchiveQuery orderBySolverCount($order = Criteria::ASC) Order by the solver_count column
 * @method     ChildPuzzleArchiveQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildPuzzleArchiveQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 * @method     ChildPuzzleArchiveQuery orderByArchivedAt($order = Criteria::ASC) Order by the archived_at column
 *
 * @method     ChildPuzzleArchiveQuery groupById() Group by the id column
 * @method     ChildPuzzleArchiveQuery groupByTitle() Group by the title column
 * @method     ChildPuzzleArchiveQuery groupByUrl() Group by the url column
 * @method     ChildPuzzleArchiveQuery groupBySpreadsheetId() Group by the spreadsheet_id column
 * @method     ChildPuzzleArchiveQuery groupBySolution() Group by the solution column
 * @method     ChildPuzzleArchiveQuery groupByStatus() Group by the status column
 * @method     ChildPuzzleArchiveQuery groupBySlackChannel() Group by the slack_channel column
 * @method     ChildPuzzleArchiveQuery groupBySlackChannelId() Group by the slack_channel_id column
 * @method     ChildPuzzleArchiveQuery groupByWranglerId() Group by the wrangler_id column
 * @method     ChildPuzzleArchiveQuery groupBySheetModDate() Group by the sheet_mod_date column
 * @method     ChildPuzzleArchiveQuery groupBySortOrder() Group by the sort_order column
 * @method     ChildPuzzleArchiveQuery groupByNote() Group by the note column
 * @method     ChildPuzzleArchiveQuery groupBySolverCount() Group by the solver_count column
 * @method     ChildPuzzleArchiveQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildPuzzleArchiveQuery groupByUpdatedAt() Group by the updated_at column
 * @method     ChildPuzzleArchiveQuery groupByArchivedAt() Group by the archived_at column
 *
 * @method     ChildPuzzleArchiveQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPuzzleArchiveQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPuzzleArchiveQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPuzzleArchiveQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildPuzzleArchiveQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildPuzzleArchiveQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildPuzzleArchive|null findOne(?ConnectionInterface $con = null) Return the first ChildPuzzleArchive matching the query
 * @method     ChildPuzzleArchive findOneOrCreate(?ConnectionInterface $con = null) Return the first ChildPuzzleArchive matching the query, or a new ChildPuzzleArchive object populated from the query conditions when no match is found
 *
 * @method     ChildPuzzleArchive|null findOneById(int $id) Return the first ChildPuzzleArchive filtered by the id column
 * @method     ChildPuzzleArchive|null findOneByTitle(string $title) Return the first ChildPuzzleArchive filtered by the title column
 * @method     ChildPuzzleArchive|null findOneByUrl(string $url) Return the first ChildPuzzleArchive filtered by the url column
 * @method     ChildPuzzleArchive|null findOneBySpreadsheetId(string $spreadsheet_id) Return the first ChildPuzzleArchive filtered by the spreadsheet_id column
 * @method     ChildPuzzleArchive|null findOneBySolution(string $solution) Return the first ChildPuzzleArchive filtered by the solution column
 * @method     ChildPuzzleArchive|null findOneByStatus(string $status) Return the first ChildPuzzleArchive filtered by the status column
 * @method     ChildPuzzleArchive|null findOneBySlackChannel(string $slack_channel) Return the first ChildPuzzleArchive filtered by the slack_channel column
 * @method     ChildPuzzleArchive|null findOneBySlackChannelId(string $slack_channel_id) Return the first ChildPuzzleArchive filtered by the slack_channel_id column
 * @method     ChildPuzzleArchive|null findOneByWranglerId(int $wrangler_id) Return the first ChildPuzzleArchive filtered by the wrangler_id column
 * @method     ChildPuzzleArchive|null findOneBySheetModDate(string $sheet_mod_date) Return the first ChildPuzzleArchive filtered by the sheet_mod_date column
 * @method     ChildPuzzleArchive|null findOneBySortOrder(int $sort_order) Return the first ChildPuzzleArchive filtered by the sort_order column
 * @method     ChildPuzzleArchive|null findOneByNote(string $note) Return the first ChildPuzzleArchive filtered by the note column
 * @method     ChildPuzzleArchive|null findOneBySolverCount(int $solver_count) Return the first ChildPuzzleArchive filtered by the solver_count column
 * @method     ChildPuzzleArchive|null findOneByCreatedAt(string $created_at) Return the first ChildPuzzleArchive filtered by the created_at column
 * @method     ChildPuzzleArchive|null findOneByUpdatedAt(string $updated_at) Return the first ChildPuzzleArchive filtered by the updated_at column
 * @method     ChildPuzzleArchive|null findOneByArchivedAt(string $archived_at) Return the first ChildPuzzleArchive filtered by the archived_at column
 *
 * @method     ChildPuzzleArchive requirePk($key, ?ConnectionInterface $con = null) Return the ChildPuzzleArchive by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPuzzleArchive requireOne(?ConnectionInterface $con = null) Return the first ChildPuzzleArchive matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPuzzleArchive requireOneById(int $id) Return the first ChildPuzzleArchive filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPuzzleArchive requireOneByTitle(string $title) Return the first ChildPuzzleArchive filtered by the title column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPuzzleArchive requireOneByUrl(string $url) Return the first ChildPuzzleArchive filtered by the url column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPuzzleArchive requireOneBySpreadsheetId(string $spreadsheet_id) Return the first ChildPuzzleArchive filtered by the spreadsheet_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPuzzleArchive requireOneBySolution(string $solution) Return the first ChildPuzzleArchive filtered by the solution column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPuzzleArchive requireOneByStatus(string $status) Return the first ChildPuzzleArchive filtered by the status column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPuzzleArchive requireOneBySlackChannel(string $slack_channel) Return the first ChildPuzzleArchive filtered by the slack_channel column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPuzzleArchive requireOneBySlackChannelId(string $slack_channel_id) Return the first ChildPuzzleArchive filtered by the slack_channel_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPuzzleArchive requireOneByWranglerId(int $wrangler_id) Return the first ChildPuzzleArchive filtered by the wrangler_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPuzzleArchive requireOneBySheetModDate(string $sheet_mod_date) Return the first ChildPuzzleArchive filtered by the sheet_mod_date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPuzzleArchive requireOneBySortOrder(int $sort_order) Return the first ChildPuzzleArchive filtered by the sort_order column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPuzzleArchive requireOneByNote(string $note) Return the first ChildPuzzleArchive filtered by the note column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPuzzleArchive requireOneBySolverCount(int $solver_count) Return the first ChildPuzzleArchive filtered by the solver_count column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPuzzleArchive requireOneByCreatedAt(string $created_at) Return the first ChildPuzzleArchive filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPuzzleArchive requireOneByUpdatedAt(string $updated_at) Return the first ChildPuzzleArchive filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPuzzleArchive requireOneByArchivedAt(string $archived_at) Return the first ChildPuzzleArchive filtered by the archived_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPuzzleArchive[]|Collection find(?ConnectionInterface $con = null) Return ChildPuzzleArchive objects based on current ModelCriteria
 * @psalm-method Collection&\Traversable<ChildPuzzleArchive> find(?ConnectionInterface $con = null) Return ChildPuzzleArchive objects based on current ModelCriteria
 *
 * @method     ChildPuzzleArchive[]|Collection findById(int|array<int> $id) Return ChildPuzzleArchive objects filtered by the id column
 * @psalm-method Collection&\Traversable<ChildPuzzleArchive> findById(int|array<int> $id) Return ChildPuzzleArchive objects filtered by the id column
 * @method     ChildPuzzleArchive[]|Collection findByTitle(string|array<string> $title) Return ChildPuzzleArchive objects filtered by the title column
 * @psalm-method Collection&\Traversable<ChildPuzzleArchive> findByTitle(string|array<string> $title) Return ChildPuzzleArchive objects filtered by the title column
 * @method     ChildPuzzleArchive[]|Collection findByUrl(string|array<string> $url) Return ChildPuzzleArchive objects filtered by the url column
 * @psalm-method Collection&\Traversable<ChildPuzzleArchive> findByUrl(string|array<string> $url) Return ChildPuzzleArchive objects filtered by the url column
 * @method     ChildPuzzleArchive[]|Collection findBySpreadsheetId(string|array<string> $spreadsheet_id) Return ChildPuzzleArchive objects filtered by the spreadsheet_id column
 * @psalm-method Collection&\Traversable<ChildPuzzleArchive> findBySpreadsheetId(string|array<string> $spreadsheet_id) Return ChildPuzzleArchive objects filtered by the spreadsheet_id column
 * @method     ChildPuzzleArchive[]|Collection findBySolution(string|array<string> $solution) Return ChildPuzzleArchive objects filtered by the solution column
 * @psalm-method Collection&\Traversable<ChildPuzzleArchive> findBySolution(string|array<string> $solution) Return ChildPuzzleArchive objects filtered by the solution column
 * @method     ChildPuzzleArchive[]|Collection findByStatus(string|array<string> $status) Return ChildPuzzleArchive objects filtered by the status column
 * @psalm-method Collection&\Traversable<ChildPuzzleArchive> findByStatus(string|array<string> $status) Return ChildPuzzleArchive objects filtered by the status column
 * @method     ChildPuzzleArchive[]|Collection findBySlackChannel(string|array<string> $slack_channel) Return ChildPuzzleArchive objects filtered by the slack_channel column
 * @psalm-method Collection&\Traversable<ChildPuzzleArchive> findBySlackChannel(string|array<string> $slack_channel) Return ChildPuzzleArchive objects filtered by the slack_channel column
 * @method     ChildPuzzleArchive[]|Collection findBySlackChannelId(string|array<string> $slack_channel_id) Return ChildPuzzleArchive objects filtered by the slack_channel_id column
 * @psalm-method Collection&\Traversable<ChildPuzzleArchive> findBySlackChannelId(string|array<string> $slack_channel_id) Return ChildPuzzleArchive objects filtered by the slack_channel_id column
 * @method     ChildPuzzleArchive[]|Collection findByWranglerId(int|array<int> $wrangler_id) Return ChildPuzzleArchive objects filtered by the wrangler_id column
 * @psalm-method Collection&\Traversable<ChildPuzzleArchive> findByWranglerId(int|array<int> $wrangler_id) Return ChildPuzzleArchive objects filtered by the wrangler_id column
 * @method     ChildPuzzleArchive[]|Collection findBySheetModDate(string|array<string> $sheet_mod_date) Return ChildPuzzleArchive objects filtered by the sheet_mod_date column
 * @psalm-method Collection&\Traversable<ChildPuzzleArchive> findBySheetModDate(string|array<string> $sheet_mod_date) Return ChildPuzzleArchive objects filtered by the sheet_mod_date column
 * @method     ChildPuzzleArchive[]|Collection findBySortOrder(int|array<int> $sort_order) Return ChildPuzzleArchive objects filtered by the sort_order column
 * @psalm-method Collection&\Traversable<ChildPuzzleArchive> findBySortOrder(int|array<int> $sort_order) Return ChildPuzzleArchive objects filtered by the sort_order column
 * @method     ChildPuzzleArchive[]|Collection findByNote(string|array<string> $note) Return ChildPuzzleArchive objects filtered by the note column
 * @psalm-method Collection&\Traversable<ChildPuzzleArchive> findByNote(string|array<string> $note) Return ChildPuzzleArchive objects filtered by the note column
 * @method     ChildPuzzleArchive[]|Collection findBySolverCount(int|array<int> $solver_count) Return ChildPuzzleArchive objects filtered by the solver_count column
 * @psalm-method Collection&\Traversable<ChildPuzzleArchive> findBySolverCount(int|array<int> $solver_count) Return ChildPuzzleArchive objects filtered by the solver_count column
 * @method     ChildPuzzleArchive[]|Collection findByCreatedAt(string|array<string> $created_at) Return ChildPuzzleArchive objects filtered by the created_at column
 * @psalm-method Collection&\Traversable<ChildPuzzleArchive> findByCreatedAt(string|array<string> $created_at) Return ChildPuzzleArchive objects filtered by the created_at column
 * @method     ChildPuzzleArchive[]|Collection findByUpdatedAt(string|array<string> $updated_at) Return ChildPuzzleArchive objects filtered by the updated_at column
 * @psalm-method Collection&\Traversable<ChildPuzzleArchive> findByUpdatedAt(string|array<string> $updated_at) Return ChildPuzzleArchive objects filtered by the updated_at column
 * @method     ChildPuzzleArchive[]|Collection findByArchivedAt(string|array<string> $archived_at) Return ChildPuzzleArchive objects filtered by the archived_at column
 * @psalm-method Collection&\Traversable<ChildPuzzleArchive> findByArchivedAt(string|array<string> $archived_at) Return ChildPuzzleArchive objects filtered by the archived_at column
 *
 * @method     ChildPuzzleArchive[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 * @psalm-method \Propel\Runtime\Util\PropelModelPager&\Traversable<ChildPuzzleArchive> paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 */
abstract class PuzzleArchiveQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\PuzzleArchiveQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'palindrome', $modelName = '\\PuzzleArchive', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPuzzleArchiveQuery object.
     *
     * @param string $modelAlias The alias of a model in the query
     * @param Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPuzzleArchiveQuery
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildPuzzleArchiveQuery) {
            return $criteria;
        }
        $query = new ChildPuzzleArchiveQuery();
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
     * @return ChildPuzzleArchive|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PuzzleArchiveTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = PuzzleArchiveTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildPuzzleArchive A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, title, url, spreadsheet_id, solution, status, slack_channel, slack_channel_id, wrangler_id, sheet_mod_date, sort_order, note, solver_count, created_at, updated_at, archived_at FROM puzzle_archive WHERE id = :p0';
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
            /** @var ChildPuzzleArchive $obj */
            $obj = new ChildPuzzleArchive();
            $obj->hydrate($row);
            PuzzleArchiveTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildPuzzleArchive|array|mixed the result, formatted by the current formatter
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

        $this->addUsingAlias(PuzzleArchiveTableMap::COL_ID, $key, Criteria::EQUAL);

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

        $this->addUsingAlias(PuzzleArchiveTableMap::COL_ID, $keys, Criteria::IN);

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
                $this->addUsingAlias(PuzzleArchiveTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(PuzzleArchiveTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(PuzzleArchiveTableMap::COL_ID, $id, $comparison);

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

        $this->addUsingAlias(PuzzleArchiveTableMap::COL_TITLE, $title, $comparison);

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

        $this->addUsingAlias(PuzzleArchiveTableMap::COL_URL, $url, $comparison);

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

        $this->addUsingAlias(PuzzleArchiveTableMap::COL_SPREADSHEET_ID, $spreadsheetId, $comparison);

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

        $this->addUsingAlias(PuzzleArchiveTableMap::COL_SOLUTION, $solution, $comparison);

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

        $this->addUsingAlias(PuzzleArchiveTableMap::COL_STATUS, $status, $comparison);

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

        $this->addUsingAlias(PuzzleArchiveTableMap::COL_SLACK_CHANNEL, $slackChannel, $comparison);

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

        $this->addUsingAlias(PuzzleArchiveTableMap::COL_SLACK_CHANNEL_ID, $slackChannelId, $comparison);

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
                $this->addUsingAlias(PuzzleArchiveTableMap::COL_WRANGLER_ID, $wranglerId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($wranglerId['max'])) {
                $this->addUsingAlias(PuzzleArchiveTableMap::COL_WRANGLER_ID, $wranglerId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(PuzzleArchiveTableMap::COL_WRANGLER_ID, $wranglerId, $comparison);

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
                $this->addUsingAlias(PuzzleArchiveTableMap::COL_SHEET_MOD_DATE, $sheetModDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sheetModDate['max'])) {
                $this->addUsingAlias(PuzzleArchiveTableMap::COL_SHEET_MOD_DATE, $sheetModDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(PuzzleArchiveTableMap::COL_SHEET_MOD_DATE, $sheetModDate, $comparison);

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
                $this->addUsingAlias(PuzzleArchiveTableMap::COL_SORT_ORDER, $sortOrder['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sortOrder['max'])) {
                $this->addUsingAlias(PuzzleArchiveTableMap::COL_SORT_ORDER, $sortOrder['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(PuzzleArchiveTableMap::COL_SORT_ORDER, $sortOrder, $comparison);

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

        $this->addUsingAlias(PuzzleArchiveTableMap::COL_NOTE, $note, $comparison);

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
                $this->addUsingAlias(PuzzleArchiveTableMap::COL_SOLVER_COUNT, $solverCount['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($solverCount['max'])) {
                $this->addUsingAlias(PuzzleArchiveTableMap::COL_SOLVER_COUNT, $solverCount['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(PuzzleArchiveTableMap::COL_SOLVER_COUNT, $solverCount, $comparison);

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
                $this->addUsingAlias(PuzzleArchiveTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(PuzzleArchiveTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(PuzzleArchiveTableMap::COL_CREATED_AT, $createdAt, $comparison);

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
                $this->addUsingAlias(PuzzleArchiveTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(PuzzleArchiveTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(PuzzleArchiveTableMap::COL_UPDATED_AT, $updatedAt, $comparison);

        return $this;
    }

    /**
     * Filter the query on the archived_at column
     *
     * Example usage:
     * <code>
     * $query->filterByArchivedAt('2011-03-14'); // WHERE archived_at = '2011-03-14'
     * $query->filterByArchivedAt('now'); // WHERE archived_at = '2011-03-14'
     * $query->filterByArchivedAt(array('max' => 'yesterday')); // WHERE archived_at > '2011-03-13'
     * </code>
     *
     * @param mixed $archivedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByArchivedAt($archivedAt = null, ?string $comparison = null)
    {
        if (is_array($archivedAt)) {
            $useMinMax = false;
            if (isset($archivedAt['min'])) {
                $this->addUsingAlias(PuzzleArchiveTableMap::COL_ARCHIVED_AT, $archivedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($archivedAt['max'])) {
                $this->addUsingAlias(PuzzleArchiveTableMap::COL_ARCHIVED_AT, $archivedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(PuzzleArchiveTableMap::COL_ARCHIVED_AT, $archivedAt, $comparison);

        return $this;
    }

    /**
     * Exclude object from result
     *
     * @param ChildPuzzleArchive $puzzleArchive Object to remove from the list of results
     *
     * @return $this The current query, for fluid interface
     */
    public function prune($puzzleArchive = null)
    {
        if ($puzzleArchive) {
            $this->addUsingAlias(PuzzleArchiveTableMap::COL_ID, $puzzleArchive->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the puzzle_archive table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PuzzleArchiveTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PuzzleArchiveTableMap::clearInstancePool();
            PuzzleArchiveTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PuzzleArchiveTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PuzzleArchiveTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PuzzleArchiveTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PuzzleArchiveTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

}
