<?php

namespace Base;

use \Member as ChildMember;
use \MemberQuery as ChildMemberQuery;
use \Exception;
use \PDO;
use Map\MemberTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the `member` table.
 *
 * @method     ChildMemberQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildMemberQuery orderByFullName($order = Criteria::ASC) Order by the full_name column
 * @method     ChildMemberQuery orderByGoogleId($order = Criteria::ASC) Order by the google_id column
 * @method     ChildMemberQuery orderByGoogleRefresh($order = Criteria::ASC) Order by the google_refresh column
 * @method     ChildMemberQuery orderBySlackId($order = Criteria::ASC) Order by the slack_id column
 * @method     ChildMemberQuery orderBySlackHandle($order = Criteria::ASC) Order by the slack_handle column
 * @method     ChildMemberQuery orderByStrengths($order = Criteria::ASC) Order by the strengths column
 * @method     ChildMemberQuery orderByAvatar($order = Criteria::ASC) Order by the avatar column
 * @method     ChildMemberQuery orderByPhoneNumber($order = Criteria::ASC) Order by the phone_number column
 * @method     ChildMemberQuery orderByLocation($order = Criteria::ASC) Order by the location column
 *
 * @method     ChildMemberQuery groupById() Group by the id column
 * @method     ChildMemberQuery groupByFullName() Group by the full_name column
 * @method     ChildMemberQuery groupByGoogleId() Group by the google_id column
 * @method     ChildMemberQuery groupByGoogleRefresh() Group by the google_refresh column
 * @method     ChildMemberQuery groupBySlackId() Group by the slack_id column
 * @method     ChildMemberQuery groupBySlackHandle() Group by the slack_handle column
 * @method     ChildMemberQuery groupByStrengths() Group by the strengths column
 * @method     ChildMemberQuery groupByAvatar() Group by the avatar column
 * @method     ChildMemberQuery groupByPhoneNumber() Group by the phone_number column
 * @method     ChildMemberQuery groupByLocation() Group by the location column
 *
 * @method     ChildMemberQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildMemberQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildMemberQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildMemberQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildMemberQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildMemberQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildMemberQuery leftJoinWrangledPuzzle($relationAlias = null) Adds a LEFT JOIN clause to the query using the WrangledPuzzle relation
 * @method     ChildMemberQuery rightJoinWrangledPuzzle($relationAlias = null) Adds a RIGHT JOIN clause to the query using the WrangledPuzzle relation
 * @method     ChildMemberQuery innerJoinWrangledPuzzle($relationAlias = null) Adds a INNER JOIN clause to the query using the WrangledPuzzle relation
 *
 * @method     ChildMemberQuery joinWithWrangledPuzzle($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the WrangledPuzzle relation
 *
 * @method     ChildMemberQuery leftJoinWithWrangledPuzzle() Adds a LEFT JOIN clause and with to the query using the WrangledPuzzle relation
 * @method     ChildMemberQuery rightJoinWithWrangledPuzzle() Adds a RIGHT JOIN clause and with to the query using the WrangledPuzzle relation
 * @method     ChildMemberQuery innerJoinWithWrangledPuzzle() Adds a INNER JOIN clause and with to the query using the WrangledPuzzle relation
 *
 * @method     ChildMemberQuery leftJoinPuzzleMember($relationAlias = null) Adds a LEFT JOIN clause to the query using the PuzzleMember relation
 * @method     ChildMemberQuery rightJoinPuzzleMember($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PuzzleMember relation
 * @method     ChildMemberQuery innerJoinPuzzleMember($relationAlias = null) Adds a INNER JOIN clause to the query using the PuzzleMember relation
 *
 * @method     ChildMemberQuery joinWithPuzzleMember($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the PuzzleMember relation
 *
 * @method     ChildMemberQuery leftJoinWithPuzzleMember() Adds a LEFT JOIN clause and with to the query using the PuzzleMember relation
 * @method     ChildMemberQuery rightJoinWithPuzzleMember() Adds a RIGHT JOIN clause and with to the query using the PuzzleMember relation
 * @method     ChildMemberQuery innerJoinWithPuzzleMember() Adds a INNER JOIN clause and with to the query using the PuzzleMember relation
 *
 * @method     \PuzzleQuery|\PuzzleMemberQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildMember|null findOne(?ConnectionInterface $con = null) Return the first ChildMember matching the query
 * @method     ChildMember findOneOrCreate(?ConnectionInterface $con = null) Return the first ChildMember matching the query, or a new ChildMember object populated from the query conditions when no match is found
 *
 * @method     ChildMember|null findOneById(int $id) Return the first ChildMember filtered by the id column
 * @method     ChildMember|null findOneByFullName(string $full_name) Return the first ChildMember filtered by the full_name column
 * @method     ChildMember|null findOneByGoogleId(string $google_id) Return the first ChildMember filtered by the google_id column
 * @method     ChildMember|null findOneByGoogleRefresh(string $google_refresh) Return the first ChildMember filtered by the google_refresh column
 * @method     ChildMember|null findOneBySlackId(string $slack_id) Return the first ChildMember filtered by the slack_id column
 * @method     ChildMember|null findOneBySlackHandle(string $slack_handle) Return the first ChildMember filtered by the slack_handle column
 * @method     ChildMember|null findOneByStrengths(string $strengths) Return the first ChildMember filtered by the strengths column
 * @method     ChildMember|null findOneByAvatar(string $avatar) Return the first ChildMember filtered by the avatar column
 * @method     ChildMember|null findOneByPhoneNumber(string $phone_number) Return the first ChildMember filtered by the phone_number column
 * @method     ChildMember|null findOneByLocation(string $location) Return the first ChildMember filtered by the location column
 *
 * @method     ChildMember requirePk($key, ?ConnectionInterface $con = null) Return the ChildMember by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMember requireOne(?ConnectionInterface $con = null) Return the first ChildMember matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildMember requireOneById(int $id) Return the first ChildMember filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMember requireOneByFullName(string $full_name) Return the first ChildMember filtered by the full_name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMember requireOneByGoogleId(string $google_id) Return the first ChildMember filtered by the google_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMember requireOneByGoogleRefresh(string $google_refresh) Return the first ChildMember filtered by the google_refresh column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMember requireOneBySlackId(string $slack_id) Return the first ChildMember filtered by the slack_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMember requireOneBySlackHandle(string $slack_handle) Return the first ChildMember filtered by the slack_handle column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMember requireOneByStrengths(string $strengths) Return the first ChildMember filtered by the strengths column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMember requireOneByAvatar(string $avatar) Return the first ChildMember filtered by the avatar column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMember requireOneByPhoneNumber(string $phone_number) Return the first ChildMember filtered by the phone_number column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMember requireOneByLocation(string $location) Return the first ChildMember filtered by the location column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildMember[]|Collection find(?ConnectionInterface $con = null) Return ChildMember objects based on current ModelCriteria
 * @psalm-method Collection&\Traversable<ChildMember> find(?ConnectionInterface $con = null) Return ChildMember objects based on current ModelCriteria
 *
 * @method     ChildMember[]|Collection findById(int|array<int> $id) Return ChildMember objects filtered by the id column
 * @psalm-method Collection&\Traversable<ChildMember> findById(int|array<int> $id) Return ChildMember objects filtered by the id column
 * @method     ChildMember[]|Collection findByFullName(string|array<string> $full_name) Return ChildMember objects filtered by the full_name column
 * @psalm-method Collection&\Traversable<ChildMember> findByFullName(string|array<string> $full_name) Return ChildMember objects filtered by the full_name column
 * @method     ChildMember[]|Collection findByGoogleId(string|array<string> $google_id) Return ChildMember objects filtered by the google_id column
 * @psalm-method Collection&\Traversable<ChildMember> findByGoogleId(string|array<string> $google_id) Return ChildMember objects filtered by the google_id column
 * @method     ChildMember[]|Collection findByGoogleRefresh(string|array<string> $google_refresh) Return ChildMember objects filtered by the google_refresh column
 * @psalm-method Collection&\Traversable<ChildMember> findByGoogleRefresh(string|array<string> $google_refresh) Return ChildMember objects filtered by the google_refresh column
 * @method     ChildMember[]|Collection findBySlackId(string|array<string> $slack_id) Return ChildMember objects filtered by the slack_id column
 * @psalm-method Collection&\Traversable<ChildMember> findBySlackId(string|array<string> $slack_id) Return ChildMember objects filtered by the slack_id column
 * @method     ChildMember[]|Collection findBySlackHandle(string|array<string> $slack_handle) Return ChildMember objects filtered by the slack_handle column
 * @psalm-method Collection&\Traversable<ChildMember> findBySlackHandle(string|array<string> $slack_handle) Return ChildMember objects filtered by the slack_handle column
 * @method     ChildMember[]|Collection findByStrengths(string|array<string> $strengths) Return ChildMember objects filtered by the strengths column
 * @psalm-method Collection&\Traversable<ChildMember> findByStrengths(string|array<string> $strengths) Return ChildMember objects filtered by the strengths column
 * @method     ChildMember[]|Collection findByAvatar(string|array<string> $avatar) Return ChildMember objects filtered by the avatar column
 * @psalm-method Collection&\Traversable<ChildMember> findByAvatar(string|array<string> $avatar) Return ChildMember objects filtered by the avatar column
 * @method     ChildMember[]|Collection findByPhoneNumber(string|array<string> $phone_number) Return ChildMember objects filtered by the phone_number column
 * @psalm-method Collection&\Traversable<ChildMember> findByPhoneNumber(string|array<string> $phone_number) Return ChildMember objects filtered by the phone_number column
 * @method     ChildMember[]|Collection findByLocation(string|array<string> $location) Return ChildMember objects filtered by the location column
 * @psalm-method Collection&\Traversable<ChildMember> findByLocation(string|array<string> $location) Return ChildMember objects filtered by the location column
 *
 * @method     ChildMember[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 * @psalm-method \Propel\Runtime\Util\PropelModelPager&\Traversable<ChildMember> paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 */
abstract class MemberQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\MemberQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'palindrome', $modelName = '\\Member', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildMemberQuery object.
     *
     * @param string $modelAlias The alias of a model in the query
     * @param Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildMemberQuery
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildMemberQuery) {
            return $criteria;
        }
        $query = new ChildMemberQuery();
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
     * @return ChildMember|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(MemberTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = MemberTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildMember A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, full_name, google_id, google_refresh, slack_id, slack_handle, strengths, avatar, phone_number, location FROM member WHERE id = :p0';
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
            /** @var ChildMember $obj */
            $obj = new ChildMember();
            $obj->hydrate($row);
            MemberTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildMember|array|mixed the result, formatted by the current formatter
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

        $this->addUsingAlias(MemberTableMap::COL_ID, $key, Criteria::EQUAL);

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

        $this->addUsingAlias(MemberTableMap::COL_ID, $keys, Criteria::IN);

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
                $this->addUsingAlias(MemberTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(MemberTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(MemberTableMap::COL_ID, $id, $comparison);

        return $this;
    }

    /**
     * Filter the query on the full_name column
     *
     * Example usage:
     * <code>
     * $query->filterByFullName('fooValue');   // WHERE full_name = 'fooValue'
     * $query->filterByFullName('%fooValue%', Criteria::LIKE); // WHERE full_name LIKE '%fooValue%'
     * $query->filterByFullName(['foo', 'bar']); // WHERE full_name IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $fullName The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByFullName($fullName = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($fullName)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(MemberTableMap::COL_FULL_NAME, $fullName, $comparison);

        return $this;
    }

    /**
     * Filter the query on the google_id column
     *
     * Example usage:
     * <code>
     * $query->filterByGoogleId('fooValue');   // WHERE google_id = 'fooValue'
     * $query->filterByGoogleId('%fooValue%', Criteria::LIKE); // WHERE google_id LIKE '%fooValue%'
     * $query->filterByGoogleId(['foo', 'bar']); // WHERE google_id IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $googleId The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByGoogleId($googleId = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($googleId)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(MemberTableMap::COL_GOOGLE_ID, $googleId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the google_refresh column
     *
     * Example usage:
     * <code>
     * $query->filterByGoogleRefresh('fooValue');   // WHERE google_refresh = 'fooValue'
     * $query->filterByGoogleRefresh('%fooValue%', Criteria::LIKE); // WHERE google_refresh LIKE '%fooValue%'
     * $query->filterByGoogleRefresh(['foo', 'bar']); // WHERE google_refresh IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $googleRefresh The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByGoogleRefresh($googleRefresh = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($googleRefresh)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(MemberTableMap::COL_GOOGLE_REFRESH, $googleRefresh, $comparison);

        return $this;
    }

    /**
     * Filter the query on the slack_id column
     *
     * Example usage:
     * <code>
     * $query->filterBySlackId('fooValue');   // WHERE slack_id = 'fooValue'
     * $query->filterBySlackId('%fooValue%', Criteria::LIKE); // WHERE slack_id LIKE '%fooValue%'
     * $query->filterBySlackId(['foo', 'bar']); // WHERE slack_id IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $slackId The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterBySlackId($slackId = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($slackId)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(MemberTableMap::COL_SLACK_ID, $slackId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the slack_handle column
     *
     * Example usage:
     * <code>
     * $query->filterBySlackHandle('fooValue');   // WHERE slack_handle = 'fooValue'
     * $query->filterBySlackHandle('%fooValue%', Criteria::LIKE); // WHERE slack_handle LIKE '%fooValue%'
     * $query->filterBySlackHandle(['foo', 'bar']); // WHERE slack_handle IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $slackHandle The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterBySlackHandle($slackHandle = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($slackHandle)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(MemberTableMap::COL_SLACK_HANDLE, $slackHandle, $comparison);

        return $this;
    }

    /**
     * Filter the query on the strengths column
     *
     * Example usage:
     * <code>
     * $query->filterByStrengths('fooValue');   // WHERE strengths = 'fooValue'
     * $query->filterByStrengths('%fooValue%', Criteria::LIKE); // WHERE strengths LIKE '%fooValue%'
     * $query->filterByStrengths(['foo', 'bar']); // WHERE strengths IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $strengths The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByStrengths($strengths = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($strengths)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(MemberTableMap::COL_STRENGTHS, $strengths, $comparison);

        return $this;
    }

    /**
     * Filter the query on the avatar column
     *
     * Example usage:
     * <code>
     * $query->filterByAvatar('fooValue');   // WHERE avatar = 'fooValue'
     * $query->filterByAvatar('%fooValue%', Criteria::LIKE); // WHERE avatar LIKE '%fooValue%'
     * $query->filterByAvatar(['foo', 'bar']); // WHERE avatar IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $avatar The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByAvatar($avatar = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($avatar)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(MemberTableMap::COL_AVATAR, $avatar, $comparison);

        return $this;
    }

    /**
     * Filter the query on the phone_number column
     *
     * Example usage:
     * <code>
     * $query->filterByPhoneNumber('fooValue');   // WHERE phone_number = 'fooValue'
     * $query->filterByPhoneNumber('%fooValue%', Criteria::LIKE); // WHERE phone_number LIKE '%fooValue%'
     * $query->filterByPhoneNumber(['foo', 'bar']); // WHERE phone_number IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $phoneNumber The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByPhoneNumber($phoneNumber = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($phoneNumber)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(MemberTableMap::COL_PHONE_NUMBER, $phoneNumber, $comparison);

        return $this;
    }

    /**
     * Filter the query on the location column
     *
     * Example usage:
     * <code>
     * $query->filterByLocation('fooValue');   // WHERE location = 'fooValue'
     * $query->filterByLocation('%fooValue%', Criteria::LIKE); // WHERE location LIKE '%fooValue%'
     * $query->filterByLocation(['foo', 'bar']); // WHERE location IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $location The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByLocation($location = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($location)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(MemberTableMap::COL_LOCATION, $location, $comparison);

        return $this;
    }

    /**
     * Filter the query by a related \Puzzle object
     *
     * @param \Puzzle|ObjectCollection $puzzle the related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByWrangledPuzzle($puzzle, ?string $comparison = null)
    {
        if ($puzzle instanceof \Puzzle) {
            $this
                ->addUsingAlias(MemberTableMap::COL_ID, $puzzle->getWranglerId(), $comparison);

            return $this;
        } elseif ($puzzle instanceof ObjectCollection) {
            $this
                ->useWrangledPuzzleQuery()
                ->filterByPrimaryKeys($puzzle->getPrimaryKeys())
                ->endUse();

            return $this;
        } else {
            throw new PropelException('filterByWrangledPuzzle() only accepts arguments of type \Puzzle or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the WrangledPuzzle relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinWrangledPuzzle(?string $relationAlias = null, ?string $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('WrangledPuzzle');

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
            $this->addJoinObject($join, 'WrangledPuzzle');
        }

        return $this;
    }

    /**
     * Use the WrangledPuzzle relation Puzzle object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PuzzleQuery A secondary query class using the current class as primary query
     */
    public function useWrangledPuzzleQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinWrangledPuzzle($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'WrangledPuzzle', '\PuzzleQuery');
    }

    /**
     * Use the WrangledPuzzle relation Puzzle object
     *
     * @param callable(\PuzzleQuery):\PuzzleQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withWrangledPuzzleQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::LEFT_JOIN
    ) {
        $relatedQuery = $this->useWrangledPuzzleQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the WrangledPuzzle relation to the Puzzle table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \PuzzleQuery The inner query object of the EXISTS statement
     */
    public function useWrangledPuzzleExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \PuzzleQuery */
        $q = $this->useExistsQuery('WrangledPuzzle', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the WrangledPuzzle relation to the Puzzle table for a NOT EXISTS query.
     *
     * @see useWrangledPuzzleExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \PuzzleQuery The inner query object of the NOT EXISTS statement
     */
    public function useWrangledPuzzleNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \PuzzleQuery */
        $q = $this->useExistsQuery('WrangledPuzzle', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the WrangledPuzzle relation to the Puzzle table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \PuzzleQuery The inner query object of the IN statement
     */
    public function useInWrangledPuzzleQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \PuzzleQuery */
        $q = $this->useInQuery('WrangledPuzzle', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the WrangledPuzzle relation to the Puzzle table for a NOT IN query.
     *
     * @see useWrangledPuzzleInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \PuzzleQuery The inner query object of the NOT IN statement
     */
    public function useNotInWrangledPuzzleQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \PuzzleQuery */
        $q = $this->useInQuery('WrangledPuzzle', $modelAlias, $queryClass, 'NOT IN');
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
                ->addUsingAlias(MemberTableMap::COL_ID, $puzzleMember->getMemberId(), $comparison);

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
     * Filter the query by a related Puzzle object
     * using the solver table as cross reference
     *
     * @param Puzzle $puzzle the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL and Criteria::IN for queries
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByPuzzle($puzzle, string $comparison = null)
    {
        $this
            ->usePuzzleMemberQuery()
            ->filterByPuzzle($puzzle, $comparison)
            ->endUse();

        return $this;
    }

    /**
     * Exclude object from result
     *
     * @param ChildMember $member Object to remove from the list of results
     *
     * @return $this The current query, for fluid interface
     */
    public function prune($member = null)
    {
        if ($member) {
            $this->addUsingAlias(MemberTableMap::COL_ID, $member->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the member table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MemberTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            MemberTableMap::clearInstancePool();
            MemberTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(MemberTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(MemberTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            MemberTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            MemberTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

}
