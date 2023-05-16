<?php

namespace Base;

use \Member as ChildMember;
use \MemberQuery as ChildMemberQuery;
use \Puzzle as ChildPuzzle;
use \PuzzleArchive as ChildPuzzleArchive;
use \PuzzleArchiveQuery as ChildPuzzleArchiveQuery;
use \PuzzleMember as ChildPuzzleMember;
use \PuzzleMemberQuery as ChildPuzzleMemberQuery;
use \PuzzlePuzzle as ChildPuzzlePuzzle;
use \PuzzlePuzzleQuery as ChildPuzzlePuzzleQuery;
use \PuzzleQuery as ChildPuzzleQuery;
use \DateTime;
use \Exception;
use \PDO;
use Map\PuzzleMemberTableMap;
use Map\PuzzlePuzzleTableMap;
use Map\PuzzleTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'puzzle' table.
 *
 *
 *
 * @package    propel.generator..Base
 */
abstract class Puzzle implements ActiveRecordInterface
{
    /**
     * TableMap class name
     *
     * @var string
     */
    public const TABLE_MAP = '\\Map\\PuzzleTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var bool
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var bool
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = [];

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = [];

    /**
     * The value for the id field.
     *
     * @var        int
     */
    protected $id;

    /**
     * The value for the title field.
     *
     * @var        string|null
     */
    protected $title;

    /**
     * The value for the url field.
     *
     * @var        string|null
     */
    protected $url;

    /**
     * The value for the spreadsheet_id field.
     *
     * @var        string|null
     */
    protected $spreadsheet_id;

    /**
     * The value for the solution field.
     *
     * @var        string|null
     */
    protected $solution;

    /**
     * The value for the status field.
     *
     * @var        string|null
     */
    protected $status;

    /**
     * The value for the slack_channel field.
     *
     * @var        string|null
     */
    protected $slack_channel;

    /**
     * The value for the slack_channel_id field.
     *
     * @var        string|null
     */
    protected $slack_channel_id;

    /**
     * The value for the wrangler_id field.
     *
     * @var        int|null
     */
    protected $wrangler_id;

    /**
     * The value for the sheet_mod_date field.
     *
     * @var        DateTime|null
     */
    protected $sheet_mod_date;

    /**
     * The value for the solver_count field.
     *
     * @var        int|null
     */
    protected $solver_count;

    /**
     * The value for the created_at field.
     *
     * @var        DateTime|null
     */
    protected $created_at;

    /**
     * The value for the updated_at field.
     *
     * @var        DateTime|null
     */
    protected $updated_at;

    /**
     * @var        ChildMember
     */
    protected $aWrangler;

    /**
     * @var        ObjectCollection|ChildPuzzleMember[] Collection to store aggregation of ChildPuzzleMember objects.
     * @phpstan-var ObjectCollection&\Traversable<ChildPuzzleMember> Collection to store aggregation of ChildPuzzleMember objects.
     */
    protected $collPuzzleMembers;
    protected $collPuzzleMembersPartial;

    /**
     * @var        ObjectCollection|ChildPuzzlePuzzle[] Collection to store aggregation of ChildPuzzlePuzzle objects.
     * @phpstan-var ObjectCollection&\Traversable<ChildPuzzlePuzzle> Collection to store aggregation of ChildPuzzlePuzzle objects.
     */
    protected $collPuzzleParents;
    protected $collPuzzleParentsPartial;

    /**
     * @var        ObjectCollection|ChildPuzzlePuzzle[] Collection to store aggregation of ChildPuzzlePuzzle objects.
     * @phpstan-var ObjectCollection&\Traversable<ChildPuzzlePuzzle> Collection to store aggregation of ChildPuzzlePuzzle objects.
     */
    protected $collPuzzlechildren;
    protected $collPuzzlechildrenPartial;

    /**
     * @var        ObjectCollection|ChildMember[] Cross Collection to store aggregation of ChildMember objects.
     * @phpstan-var ObjectCollection&\Traversable<ChildMember> Cross Collection to store aggregation of ChildMember objects.
     */
    protected $collMembers;

    /**
     * @var bool
     */
    protected $collMembersPartial;

    /**
     * @var        ObjectCollection|ChildPuzzle[] Cross Collection to store aggregation of ChildPuzzle objects.
     * @phpstan-var ObjectCollection&\Traversable<ChildPuzzle> Cross Collection to store aggregation of ChildPuzzle objects.
     */
    protected $collParents;

    /**
     * @var bool
     */
    protected $collParentsPartial;

    /**
     * @var        ObjectCollection|ChildPuzzle[] Cross Collection to store aggregation of ChildPuzzle objects.
     * @phpstan-var ObjectCollection&\Traversable<ChildPuzzle> Cross Collection to store aggregation of ChildPuzzle objects.
     */
    protected $collChildren;

    /**
     * @var bool
     */
    protected $collChildrenPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var bool
     */
    protected $alreadyInSave = false;

    // archivable behavior
    protected $archiveOnDelete = true;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildMember[]
     * @phpstan-var ObjectCollection&\Traversable<ChildMember>
     */
    protected $membersScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPuzzle[]
     * @phpstan-var ObjectCollection&\Traversable<ChildPuzzle>
     */
    protected $parentsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPuzzle[]
     * @phpstan-var ObjectCollection&\Traversable<ChildPuzzle>
     */
    protected $childrenScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPuzzleMember[]
     * @phpstan-var ObjectCollection&\Traversable<ChildPuzzleMember>
     */
    protected $puzzleMembersScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPuzzlePuzzle[]
     * @phpstan-var ObjectCollection&\Traversable<ChildPuzzlePuzzle>
     */
    protected $puzzleParentsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPuzzlePuzzle[]
     * @phpstan-var ObjectCollection&\Traversable<ChildPuzzlePuzzle>
     */
    protected $puzzlechildrenScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Puzzle object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return bool True if the object has been modified.
     */
    public function isModified(): bool
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param string $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return bool True if $col has been modified.
     */
    public function isColumnModified(string $col): bool
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns(): array
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return bool True, if the object has never been persisted.
     */
    public function isNew(): bool
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param bool $b the state of the object.
     */
    public function setNew(bool $b): void
    {
        $this->new = $b;
    }

    /**
     * Whether this object has been deleted.
     * @return bool The deleted state of this object.
     */
    public function isDeleted(): bool
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param bool $b The deleted state of this object.
     * @return void
     */
    public function setDeleted(bool $b): void
    {
        $this->deleted = $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified(?string $col = null): void
    {
        if (null !== $col) {
            unset($this->modifiedColumns[$col]);
        } else {
            $this->modifiedColumns = [];
        }
    }

    /**
     * Compares this with another <code>Puzzle</code> instance.  If
     * <code>obj</code> is an instance of <code>Puzzle</code>, delegates to
     * <code>equals(Puzzle)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param mixed $obj The object to compare to.
     * @return bool Whether equal to the object specified.
     */
    public function equals($obj): bool
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns(): array
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param string $name The virtual column name
     * @return bool
     */
    public function hasVirtualColumn(string $name): bool
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param string $name The virtual column name
     * @return mixed
     *
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getVirtualColumn(string $name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of nonexistent virtual column `%s`.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name The virtual column name
     * @param mixed $value The value to give to the virtual column
     *
     * @return $this The current object, for fluid interface
     */
    public function setVirtualColumn(string $name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param string $msg
     * @param int $priority One of the Propel::LOG_* logging levels
     * @return void
     */
    protected function log(string $msg, int $priority = Propel::LOG_INFO): void
    {
        Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param \Propel\Runtime\Parser\AbstractParser|string $parser An AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param bool $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @param string $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME, TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM. Defaults to TableMap::TYPE_PHPNAME.
     * @return string The exported data
     */
    public function exportTo($parser, bool $includeLazyLoadColumns = true, string $keyType = TableMap::TYPE_PHPNAME): string
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray($keyType, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     *
     * @return array<string>
     */
    public function __sleep(): array
    {
        $this->clearAllReferences();

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        $serializableProperties = array_diff($cls->getProperties(), $cls->getProperties(\ReflectionProperty::IS_STATIC));

        foreach($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }

        return $propertyNames;
    }

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [title] column value.
     *
     * @return string|null
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get the [url] column value.
     *
     * @return string|null
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Get the [spreadsheet_id] column value.
     *
     * @return string|null
     */
    public function getSpreadsheetId()
    {
        return $this->spreadsheet_id;
    }

    /**
     * Get the [solution] column value.
     *
     * @return string|null
     */
    public function getSolution()
    {
        return $this->solution;
    }

    /**
     * Get the [status] column value.
     *
     * @return string|null
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get the [slack_channel] column value.
     *
     * @return string|null
     */
    public function getSlackChannel()
    {
        return $this->slack_channel;
    }

    /**
     * Get the [slack_channel_id] column value.
     *
     * @return string|null
     */
    public function getSlackChannelId()
    {
        return $this->slack_channel_id;
    }

    /**
     * Get the [wrangler_id] column value.
     *
     * @return int|null
     */
    public function getWranglerId()
    {
        return $this->wrangler_id;
    }

    /**
     * Get the [optionally formatted] temporal [sheet_mod_date] column value.
     *
     *
     * @param string|null $format The date/time format string (either date()-style or strftime()-style).
     *   If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime|null Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00.
     *
     * @throws \Propel\Runtime\Exception\PropelException - if unable to parse/validate the date/time value.
     *
     * @psalm-return ($format is null ? DateTime|null : string|null)
     */
    public function getSheetModDate($format = null)
    {
        if ($format === null) {
            return $this->sheet_mod_date;
        } else {
            return $this->sheet_mod_date instanceof \DateTimeInterface ? $this->sheet_mod_date->format($format) : null;
        }
    }

    /**
     * Get the [solver_count] column value.
     *
     * @return int|null
     */
    public function getSolverCount()
    {
        return $this->solver_count;
    }

    /**
     * Get the [optionally formatted] temporal [created_at] column value.
     *
     *
     * @param string|null $format The date/time format string (either date()-style or strftime()-style).
     *   If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime|null Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00.
     *
     * @throws \Propel\Runtime\Exception\PropelException - if unable to parse/validate the date/time value.
     *
     * @psalm-return ($format is null ? DateTime|null : string|null)
     */
    public function getCreatedAt($format = null)
    {
        if ($format === null) {
            return $this->created_at;
        } else {
            return $this->created_at instanceof \DateTimeInterface ? $this->created_at->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [updated_at] column value.
     *
     *
     * @param string|null $format The date/time format string (either date()-style or strftime()-style).
     *   If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime|null Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00.
     *
     * @throws \Propel\Runtime\Exception\PropelException - if unable to parse/validate the date/time value.
     *
     * @psalm-return ($format is null ? DateTime|null : string|null)
     */
    public function getUpdatedAt($format = null)
    {
        if ($format === null) {
            return $this->updated_at;
        } else {
            return $this->updated_at instanceof \DateTimeInterface ? $this->updated_at->format($format) : null;
        }
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[PuzzleTableMap::COL_ID] = true;
        }

        return $this;
    }

    /**
     * Set the value of [title] column.
     *
     * @param string|null $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setTitle($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->title !== $v) {
            $this->title = $v;
            $this->modifiedColumns[PuzzleTableMap::COL_TITLE] = true;
        }

        return $this;
    }

    /**
     * Set the value of [url] column.
     *
     * @param string|null $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setUrl($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->url !== $v) {
            $this->url = $v;
            $this->modifiedColumns[PuzzleTableMap::COL_URL] = true;
        }

        return $this;
    }

    /**
     * Set the value of [spreadsheet_id] column.
     *
     * @param string|null $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setSpreadsheetId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->spreadsheet_id !== $v) {
            $this->spreadsheet_id = $v;
            $this->modifiedColumns[PuzzleTableMap::COL_SPREADSHEET_ID] = true;
        }

        return $this;
    }

    /**
     * Set the value of [solution] column.
     *
     * @param string|null $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setSolution($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->solution !== $v) {
            $this->solution = $v;
            $this->modifiedColumns[PuzzleTableMap::COL_SOLUTION] = true;
        }

        return $this;
    }

    /**
     * Set the value of [status] column.
     *
     * @param string|null $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setStatus($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->status !== $v) {
            $this->status = $v;
            $this->modifiedColumns[PuzzleTableMap::COL_STATUS] = true;
        }

        return $this;
    }

    /**
     * Set the value of [slack_channel] column.
     *
     * @param string|null $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setSlackChannel($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->slack_channel !== $v) {
            $this->slack_channel = $v;
            $this->modifiedColumns[PuzzleTableMap::COL_SLACK_CHANNEL] = true;
        }

        return $this;
    }

    /**
     * Set the value of [slack_channel_id] column.
     *
     * @param string|null $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setSlackChannelId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->slack_channel_id !== $v) {
            $this->slack_channel_id = $v;
            $this->modifiedColumns[PuzzleTableMap::COL_SLACK_CHANNEL_ID] = true;
        }

        return $this;
    }

    /**
     * Set the value of [wrangler_id] column.
     *
     * @param int|null $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setWranglerId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->wrangler_id !== $v) {
            $this->wrangler_id = $v;
            $this->modifiedColumns[PuzzleTableMap::COL_WRANGLER_ID] = true;
        }

        if ($this->aWrangler !== null && $this->aWrangler->getId() !== $v) {
            $this->aWrangler = null;
        }

        return $this;
    }

    /**
     * Sets the value of [sheet_mod_date] column to a normalized version of the date/time value specified.
     *
     * @param string|integer|\DateTimeInterface|null $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this The current object (for fluent API support)
     */
    public function setSheetModDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->sheet_mod_date !== null || $dt !== null) {
            if ($this->sheet_mod_date === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->sheet_mod_date->format("Y-m-d H:i:s.u")) {
                $this->sheet_mod_date = $dt === null ? null : clone $dt;
                $this->modifiedColumns[PuzzleTableMap::COL_SHEET_MOD_DATE] = true;
            }
        } // if either are not null

        return $this;
    }

    /**
     * Set the value of [solver_count] column.
     *
     * @param int|null $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setSolverCount($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->solver_count !== $v) {
            $this->solver_count = $v;
            $this->modifiedColumns[PuzzleTableMap::COL_SOLVER_COUNT] = true;
        }

        return $this;
    }

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param string|integer|\DateTimeInterface|null $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($this->created_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->created_at->format("Y-m-d H:i:s.u")) {
                $this->created_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[PuzzleTableMap::COL_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    }

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param string|integer|\DateTimeInterface|null $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($this->updated_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->updated_at->format("Y-m-d H:i:s.u")) {
                $this->updated_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[PuzzleTableMap::COL_UPDATED_AT] = true;
            }
        } // if either are not null

        return $this;
    }

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return bool Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues(): bool
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    }

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array $row The row returned by DataFetcher->fetch().
     * @param int $startcol 0-based offset column which indicates which resultset column to start with.
     * @param bool $rehydrate Whether this object is being re-hydrated from the database.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int next starting column
     * @throws \Propel\Runtime\Exception\PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate(array $row, int $startcol = 0, bool $rehydrate = false, string $indexType = TableMap::TYPE_NUM): int
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : PuzzleTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : PuzzleTableMap::translateFieldName('Title', TableMap::TYPE_PHPNAME, $indexType)];
            $this->title = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : PuzzleTableMap::translateFieldName('Url', TableMap::TYPE_PHPNAME, $indexType)];
            $this->url = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : PuzzleTableMap::translateFieldName('SpreadsheetId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->spreadsheet_id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : PuzzleTableMap::translateFieldName('Solution', TableMap::TYPE_PHPNAME, $indexType)];
            $this->solution = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : PuzzleTableMap::translateFieldName('Status', TableMap::TYPE_PHPNAME, $indexType)];
            $this->status = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : PuzzleTableMap::translateFieldName('SlackChannel', TableMap::TYPE_PHPNAME, $indexType)];
            $this->slack_channel = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : PuzzleTableMap::translateFieldName('SlackChannelId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->slack_channel_id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : PuzzleTableMap::translateFieldName('WranglerId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->wrangler_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : PuzzleTableMap::translateFieldName('SheetModDate', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->sheet_mod_date = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : PuzzleTableMap::translateFieldName('SolverCount', TableMap::TYPE_PHPNAME, $indexType)];
            $this->solver_count = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : PuzzleTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : PuzzleTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $this->resetModified();
            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 13; // 13 = PuzzleTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Puzzle'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws \Propel\Runtime\Exception\PropelException
     * @return void
     */
    public function ensureConsistency(): void
    {
        if ($this->aWrangler !== null && $this->wrangler_id !== $this->aWrangler->getId()) {
            $this->aWrangler = null;
        }
    }

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param bool $deep (optional) Whether to also de-associated any related objects.
     * @param ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws \Propel\Runtime\Exception\PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload(bool $deep = false, ?ConnectionInterface $con = null): void
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PuzzleTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildPuzzleQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aWrangler = null;
            $this->collPuzzleMembers = null;

            $this->collPuzzleParents = null;

            $this->collPuzzlechildren = null;

            $this->collMembers = null;
            $this->collParents = null;
            $this->collChildren = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param ConnectionInterface $con
     * @return void
     * @throws \Propel\Runtime\Exception\PropelException
     * @see Puzzle::setDeleted()
     * @see Puzzle::isDeleted()
     */
    public function delete(?ConnectionInterface $con = null): void
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PuzzleTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildPuzzleQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            // archivable behavior
            if ($ret) {
                if ($this->archiveOnDelete) {
                    // do nothing yet. The object will be archived later when calling ChildPuzzleQuery::delete().
                } else {
                    $deleteQuery->setArchiveOnDelete(false);
                    $this->archiveOnDelete = true;
                }
            }

            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param ConnectionInterface $con
     * @return int The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws \Propel\Runtime\Exception\PropelException
     * @see doSave()
     */
    public function save(?ConnectionInterface $con = null): int
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($this->alreadyInSave) {
            return 0;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PuzzleTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior
                $time = time();
                $highPrecision = \Propel\Runtime\Util\PropelDateTime::createHighPrecision();
                if (!$this->isColumnModified(PuzzleTableMap::COL_CREATED_AT)) {
                    $this->setCreatedAt($highPrecision);
                }
                if (!$this->isColumnModified(PuzzleTableMap::COL_UPDATED_AT)) {
                    $this->setUpdatedAt($highPrecision);
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(PuzzleTableMap::COL_UPDATED_AT)) {
                    $this->setUpdatedAt(\Propel\Runtime\Util\PropelDateTime::createHighPrecision());
                }
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                PuzzleTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param ConnectionInterface $con
     * @return int The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws \Propel\Runtime\Exception\PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con): int
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aWrangler !== null) {
                if ($this->aWrangler->isModified() || $this->aWrangler->isNew()) {
                    $affectedRows += $this->aWrangler->save($con);
                }
                $this->setWrangler($this->aWrangler);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->membersScheduledForDeletion !== null) {
                if (!$this->membersScheduledForDeletion->isEmpty()) {
                    $pks = [];
                    foreach ($this->membersScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[0] = $this->getId();
                        $entryPk[1] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \PuzzleMemberQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->membersScheduledForDeletion = null;
                }

            }

            if ($this->collMembers) {
                foreach ($this->collMembers as $member) {
                    if (!$member->isDeleted() && ($member->isNew() || $member->isModified())) {
                        $member->save($con);
                    }
                }
            }


            if ($this->parentsScheduledForDeletion !== null) {
                if (!$this->parentsScheduledForDeletion->isEmpty()) {
                    $pks = [];
                    foreach ($this->parentsScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[0] = $this->getId();
                        $entryPk[1] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \PuzzlePuzzleQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->parentsScheduledForDeletion = null;
                }

            }

            if ($this->collParents) {
                foreach ($this->collParents as $parent) {
                    if (!$parent->isDeleted() && ($parent->isNew() || $parent->isModified())) {
                        $parent->save($con);
                    }
                }
            }


            if ($this->childrenScheduledForDeletion !== null) {
                if (!$this->childrenScheduledForDeletion->isEmpty()) {
                    $pks = [];
                    foreach ($this->childrenScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[1] = $this->getId();
                        $entryPk[0] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \PuzzlePuzzleQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->childrenScheduledForDeletion = null;
                }

            }

            if ($this->collChildren) {
                foreach ($this->collChildren as $child) {
                    if (!$child->isDeleted() && ($child->isNew() || $child->isModified())) {
                        $child->save($con);
                    }
                }
            }


            if ($this->puzzleMembersScheduledForDeletion !== null) {
                if (!$this->puzzleMembersScheduledForDeletion->isEmpty()) {
                    \PuzzleMemberQuery::create()
                        ->filterByPrimaryKeys($this->puzzleMembersScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->puzzleMembersScheduledForDeletion = null;
                }
            }

            if ($this->collPuzzleMembers !== null) {
                foreach ($this->collPuzzleMembers as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->puzzleParentsScheduledForDeletion !== null) {
                if (!$this->puzzleParentsScheduledForDeletion->isEmpty()) {
                    \PuzzlePuzzleQuery::create()
                        ->filterByPrimaryKeys($this->puzzleParentsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->puzzleParentsScheduledForDeletion = null;
                }
            }

            if ($this->collPuzzleParents !== null) {
                foreach ($this->collPuzzleParents as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->puzzlechildrenScheduledForDeletion !== null) {
                if (!$this->puzzlechildrenScheduledForDeletion->isEmpty()) {
                    \PuzzlePuzzleQuery::create()
                        ->filterByPrimaryKeys($this->puzzlechildrenScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->puzzlechildrenScheduledForDeletion = null;
                }
            }

            if ($this->collPuzzlechildren !== null) {
                foreach ($this->collPuzzlechildren as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    }

    /**
     * Insert the row in the database.
     *
     * @param ConnectionInterface $con
     *
     * @throws \Propel\Runtime\Exception\PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con): void
    {
        $modifiedColumns = [];
        $index = 0;

        $this->modifiedColumns[PuzzleTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . PuzzleTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(PuzzleTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(PuzzleTableMap::COL_TITLE)) {
            $modifiedColumns[':p' . $index++]  = 'title';
        }
        if ($this->isColumnModified(PuzzleTableMap::COL_URL)) {
            $modifiedColumns[':p' . $index++]  = 'url';
        }
        if ($this->isColumnModified(PuzzleTableMap::COL_SPREADSHEET_ID)) {
            $modifiedColumns[':p' . $index++]  = 'spreadsheet_id';
        }
        if ($this->isColumnModified(PuzzleTableMap::COL_SOLUTION)) {
            $modifiedColumns[':p' . $index++]  = 'solution';
        }
        if ($this->isColumnModified(PuzzleTableMap::COL_STATUS)) {
            $modifiedColumns[':p' . $index++]  = 'status';
        }
        if ($this->isColumnModified(PuzzleTableMap::COL_SLACK_CHANNEL)) {
            $modifiedColumns[':p' . $index++]  = 'slack_channel';
        }
        if ($this->isColumnModified(PuzzleTableMap::COL_SLACK_CHANNEL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'slack_channel_id';
        }
        if ($this->isColumnModified(PuzzleTableMap::COL_WRANGLER_ID)) {
            $modifiedColumns[':p' . $index++]  = 'wrangler_id';
        }
        if ($this->isColumnModified(PuzzleTableMap::COL_SHEET_MOD_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'sheet_mod_date';
        }
        if ($this->isColumnModified(PuzzleTableMap::COL_SOLVER_COUNT)) {
            $modifiedColumns[':p' . $index++]  = 'solver_count';
        }
        if ($this->isColumnModified(PuzzleTableMap::COL_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'created_at';
        }
        if ($this->isColumnModified(PuzzleTableMap::COL_UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'updated_at';
        }

        $sql = sprintf(
            'INSERT INTO puzzle (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);

                        break;
                    case 'title':
                        $stmt->bindValue($identifier, $this->title, PDO::PARAM_STR);

                        break;
                    case 'url':
                        $stmt->bindValue($identifier, $this->url, PDO::PARAM_STR);

                        break;
                    case 'spreadsheet_id':
                        $stmt->bindValue($identifier, $this->spreadsheet_id, PDO::PARAM_STR);

                        break;
                    case 'solution':
                        $stmt->bindValue($identifier, $this->solution, PDO::PARAM_STR);

                        break;
                    case 'status':
                        $stmt->bindValue($identifier, $this->status, PDO::PARAM_STR);

                        break;
                    case 'slack_channel':
                        $stmt->bindValue($identifier, $this->slack_channel, PDO::PARAM_STR);

                        break;
                    case 'slack_channel_id':
                        $stmt->bindValue($identifier, $this->slack_channel_id, PDO::PARAM_STR);

                        break;
                    case 'wrangler_id':
                        $stmt->bindValue($identifier, $this->wrangler_id, PDO::PARAM_INT);

                        break;
                    case 'sheet_mod_date':
                        $stmt->bindValue($identifier, $this->sheet_mod_date ? $this->sheet_mod_date->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);

                        break;
                    case 'solver_count':
                        $stmt->bindValue($identifier, $this->solver_count, PDO::PARAM_INT);

                        break;
                    case 'created_at':
                        $stmt->bindValue($identifier, $this->created_at ? $this->created_at->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);

                        break;
                    case 'updated_at':
                        $stmt->bindValue($identifier, $this->updated_at ? $this->updated_at->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);

                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param ConnectionInterface $con
     *
     * @return int Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con): int
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param string $name name
     * @param string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName(string $name, string $type = TableMap::TYPE_PHPNAME)
    {
        $pos = PuzzleTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos Position in XML schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition(int $pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();

            case 1:
                return $this->getTitle();

            case 2:
                return $this->getUrl();

            case 3:
                return $this->getSpreadsheetId();

            case 4:
                return $this->getSolution();

            case 5:
                return $this->getStatus();

            case 6:
                return $this->getSlackChannel();

            case 7:
                return $this->getSlackChannelId();

            case 8:
                return $this->getWranglerId();

            case 9:
                return $this->getSheetModDate();

            case 10:
                return $this->getSolverCount();

            case 11:
                return $this->getCreatedAt();

            case 12:
                return $this->getUpdatedAt();

            default:
                return null;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param string $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param bool $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param bool $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array An associative array containing the field names (as keys) and field values
     */
    public function toArray(string $keyType = TableMap::TYPE_PHPNAME, bool $includeLazyLoadColumns = true, array $alreadyDumpedObjects = [], bool $includeForeignObjects = false): array
    {
        if (isset($alreadyDumpedObjects['Puzzle'][$this->hashCode()])) {
            return ['*RECURSION*'];
        }
        $alreadyDumpedObjects['Puzzle'][$this->hashCode()] = true;
        $keys = PuzzleTableMap::getFieldNames($keyType);
        $result = [
            $keys[0] => $this->getId(),
            $keys[1] => $this->getTitle(),
            $keys[2] => $this->getUrl(),
            $keys[3] => $this->getSpreadsheetId(),
            $keys[4] => $this->getSolution(),
            $keys[5] => $this->getStatus(),
            $keys[6] => $this->getSlackChannel(),
            $keys[7] => $this->getSlackChannelId(),
            $keys[8] => $this->getWranglerId(),
            $keys[9] => $this->getSheetModDate(),
            $keys[10] => $this->getSolverCount(),
            $keys[11] => $this->getCreatedAt(),
            $keys[12] => $this->getUpdatedAt(),
        ];
        if ($result[$keys[9]] instanceof \DateTimeInterface) {
            $result[$keys[9]] = $result[$keys[9]]->format('Y-m-d H:i:s.u');
        }

        if ($result[$keys[11]] instanceof \DateTimeInterface) {
            $result[$keys[11]] = $result[$keys[11]]->format('Y-m-d H:i:s.u');
        }

        if ($result[$keys[12]] instanceof \DateTimeInterface) {
            $result[$keys[12]] = $result[$keys[12]]->format('Y-m-d H:i:s.u');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aWrangler) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'member';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'member';
                        break;
                    default:
                        $key = 'Wrangler';
                }

                $result[$key] = $this->aWrangler->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collPuzzleMembers) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'puzzleMembers';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'solvers';
                        break;
                    default:
                        $key = 'PuzzleMembers';
                }

                $result[$key] = $this->collPuzzleMembers->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPuzzleParents) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'puzzlePuzzles';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'relationships';
                        break;
                    default:
                        $key = 'PuzzleParents';
                }

                $result[$key] = $this->collPuzzleParents->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPuzzlechildren) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'puzzlePuzzles';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'relationships';
                        break;
                    default:
                        $key = 'Puzzlechildren';
                }

                $result[$key] = $this->collPuzzlechildren->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param string $name
     * @param mixed $value field value
     * @param string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this
     */
    public function setByName(string $name, $value, string $type = TableMap::TYPE_PHPNAME)
    {
        $pos = PuzzleTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        $this->setByPosition($pos, $value);

        return $this;
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @param mixed $value field value
     * @return $this
     */
    public function setByPosition(int $pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setTitle($value);
                break;
            case 2:
                $this->setUrl($value);
                break;
            case 3:
                $this->setSpreadsheetId($value);
                break;
            case 4:
                $this->setSolution($value);
                break;
            case 5:
                $this->setStatus($value);
                break;
            case 6:
                $this->setSlackChannel($value);
                break;
            case 7:
                $this->setSlackChannelId($value);
                break;
            case 8:
                $this->setWranglerId($value);
                break;
            case 9:
                $this->setSheetModDate($value);
                break;
            case 10:
                $this->setSolverCount($value);
                break;
            case 11:
                $this->setCreatedAt($value);
                break;
            case 12:
                $this->setUpdatedAt($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param array $arr An array to populate the object from.
     * @param string $keyType The type of keys the array uses.
     * @return $this
     */
    public function fromArray(array $arr, string $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = PuzzleTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setTitle($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setUrl($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setSpreadsheetId($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setSolution($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setStatus($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setSlackChannel($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setSlackChannelId($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setWranglerId($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setSheetModDate($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setSolverCount($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setCreatedAt($arr[$keys[11]]);
        }
        if (array_key_exists($keys[12], $arr)) {
            $this->setUpdatedAt($arr[$keys[12]]);
        }

        return $this;
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this The current object, for fluid interface
     */
    public function importFrom($parser, string $data, string $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return \Propel\Runtime\ActiveQuery\Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria(): Criteria
    {
        $criteria = new Criteria(PuzzleTableMap::DATABASE_NAME);

        if ($this->isColumnModified(PuzzleTableMap::COL_ID)) {
            $criteria->add(PuzzleTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(PuzzleTableMap::COL_TITLE)) {
            $criteria->add(PuzzleTableMap::COL_TITLE, $this->title);
        }
        if ($this->isColumnModified(PuzzleTableMap::COL_URL)) {
            $criteria->add(PuzzleTableMap::COL_URL, $this->url);
        }
        if ($this->isColumnModified(PuzzleTableMap::COL_SPREADSHEET_ID)) {
            $criteria->add(PuzzleTableMap::COL_SPREADSHEET_ID, $this->spreadsheet_id);
        }
        if ($this->isColumnModified(PuzzleTableMap::COL_SOLUTION)) {
            $criteria->add(PuzzleTableMap::COL_SOLUTION, $this->solution);
        }
        if ($this->isColumnModified(PuzzleTableMap::COL_STATUS)) {
            $criteria->add(PuzzleTableMap::COL_STATUS, $this->status);
        }
        if ($this->isColumnModified(PuzzleTableMap::COL_SLACK_CHANNEL)) {
            $criteria->add(PuzzleTableMap::COL_SLACK_CHANNEL, $this->slack_channel);
        }
        if ($this->isColumnModified(PuzzleTableMap::COL_SLACK_CHANNEL_ID)) {
            $criteria->add(PuzzleTableMap::COL_SLACK_CHANNEL_ID, $this->slack_channel_id);
        }
        if ($this->isColumnModified(PuzzleTableMap::COL_WRANGLER_ID)) {
            $criteria->add(PuzzleTableMap::COL_WRANGLER_ID, $this->wrangler_id);
        }
        if ($this->isColumnModified(PuzzleTableMap::COL_SHEET_MOD_DATE)) {
            $criteria->add(PuzzleTableMap::COL_SHEET_MOD_DATE, $this->sheet_mod_date);
        }
        if ($this->isColumnModified(PuzzleTableMap::COL_SOLVER_COUNT)) {
            $criteria->add(PuzzleTableMap::COL_SOLVER_COUNT, $this->solver_count);
        }
        if ($this->isColumnModified(PuzzleTableMap::COL_CREATED_AT)) {
            $criteria->add(PuzzleTableMap::COL_CREATED_AT, $this->created_at);
        }
        if ($this->isColumnModified(PuzzleTableMap::COL_UPDATED_AT)) {
            $criteria->add(PuzzleTableMap::COL_UPDATED_AT, $this->updated_at);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return \Propel\Runtime\ActiveQuery\Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria(): Criteria
    {
        $criteria = ChildPuzzleQuery::create();
        $criteria->add(PuzzleTableMap::COL_ID, $this->id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int|string Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param int|null $key Primary key.
     * @return void
     */
    public function setPrimaryKey(?int $key = null): void
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     *
     * @return bool
     */
    public function isPrimaryKeyNull(): bool
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of \Puzzle (or compatible) type.
     * @param bool $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param bool $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws \Propel\Runtime\Exception\PropelException
     * @return void
     */
    public function copyInto(object $copyObj, bool $deepCopy = false, bool $makeNew = true): void
    {
        $copyObj->setTitle($this->getTitle());
        $copyObj->setUrl($this->getUrl());
        $copyObj->setSpreadsheetId($this->getSpreadsheetId());
        $copyObj->setSolution($this->getSolution());
        $copyObj->setStatus($this->getStatus());
        $copyObj->setSlackChannel($this->getSlackChannel());
        $copyObj->setSlackChannelId($this->getSlackChannelId());
        $copyObj->setWranglerId($this->getWranglerId());
        $copyObj->setSheetModDate($this->getSheetModDate());
        $copyObj->setSolverCount($this->getSolverCount());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getPuzzleMembers() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPuzzleMember($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPuzzleParents() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPuzzleParent($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPuzzlechildren() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPuzzleChild($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param bool $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \Puzzle Clone of current object.
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function copy(bool $deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Declares an association between this object and a ChildMember object.
     *
     * @param ChildMember|null $v
     * @return $this The current object (for fluent API support)
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function setWrangler(ChildMember $v = null)
    {
        if ($v === null) {
            $this->setWranglerId(NULL);
        } else {
            $this->setWranglerId($v->getId());
        }

        $this->aWrangler = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildMember object, it will not be re-added.
        if ($v !== null) {
            $v->addWrangledPuzzle($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildMember object
     *
     * @param ConnectionInterface $con Optional Connection object.
     * @return ChildMember|null The associated ChildMember object.
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getWrangler(?ConnectionInterface $con = null)
    {
        if ($this->aWrangler === null && ($this->wrangler_id != 0)) {
            $this->aWrangler = ChildMemberQuery::create()->findPk($this->wrangler_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aWrangler->addWrangledPuzzles($this);
             */
        }

        return $this->aWrangler;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName): void
    {
        if ('PuzzleMember' === $relationName) {
            $this->initPuzzleMembers();
            return;
        }
        if ('PuzzleParent' === $relationName) {
            $this->initPuzzleParents();
            return;
        }
        if ('PuzzleChild' === $relationName) {
            $this->initPuzzlechildren();
            return;
        }
    }

    /**
     * Clears out the collPuzzleMembers collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return $this
     * @see addPuzzleMembers()
     */
    public function clearPuzzleMembers()
    {
        $this->collPuzzleMembers = null; // important to set this to NULL since that means it is uninitialized

        return $this;
    }

    /**
     * Reset is the collPuzzleMembers collection loaded partially.
     *
     * @return void
     */
    public function resetPartialPuzzleMembers($v = true): void
    {
        $this->collPuzzleMembersPartial = $v;
    }

    /**
     * Initializes the collPuzzleMembers collection.
     *
     * By default this just sets the collPuzzleMembers collection to an empty array (like clearcollPuzzleMembers());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param bool $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPuzzleMembers(bool $overrideExisting = true): void
    {
        if (null !== $this->collPuzzleMembers && !$overrideExisting) {
            return;
        }

        $collectionClassName = PuzzleMemberTableMap::getTableMap()->getCollectionClassName();

        $this->collPuzzleMembers = new $collectionClassName;
        $this->collPuzzleMembers->setModel('\PuzzleMember');
    }

    /**
     * Gets an array of ChildPuzzleMember objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPuzzle is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPuzzleMember[] List of ChildPuzzleMember objects
     * @phpstan-return ObjectCollection&\Traversable<ChildPuzzleMember> List of ChildPuzzleMember objects
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getPuzzleMembers(?Criteria $criteria = null, ?ConnectionInterface $con = null)
    {
        $partial = $this->collPuzzleMembersPartial && !$this->isNew();
        if (null === $this->collPuzzleMembers || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collPuzzleMembers) {
                    $this->initPuzzleMembers();
                } else {
                    $collectionClassName = PuzzleMemberTableMap::getTableMap()->getCollectionClassName();

                    $collPuzzleMembers = new $collectionClassName;
                    $collPuzzleMembers->setModel('\PuzzleMember');

                    return $collPuzzleMembers;
                }
            } else {
                $collPuzzleMembers = ChildPuzzleMemberQuery::create(null, $criteria)
                    ->filterByPuzzle($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPuzzleMembersPartial && count($collPuzzleMembers)) {
                        $this->initPuzzleMembers(false);

                        foreach ($collPuzzleMembers as $obj) {
                            if (false == $this->collPuzzleMembers->contains($obj)) {
                                $this->collPuzzleMembers->append($obj);
                            }
                        }

                        $this->collPuzzleMembersPartial = true;
                    }

                    return $collPuzzleMembers;
                }

                if ($partial && $this->collPuzzleMembers) {
                    foreach ($this->collPuzzleMembers as $obj) {
                        if ($obj->isNew()) {
                            $collPuzzleMembers[] = $obj;
                        }
                    }
                }

                $this->collPuzzleMembers = $collPuzzleMembers;
                $this->collPuzzleMembersPartial = false;
            }
        }

        return $this->collPuzzleMembers;
    }

    /**
     * Sets a collection of ChildPuzzleMember objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param Collection $puzzleMembers A Propel collection.
     * @param ConnectionInterface $con Optional connection object
     * @return $this The current object (for fluent API support)
     */
    public function setPuzzleMembers(Collection $puzzleMembers, ?ConnectionInterface $con = null)
    {
        /** @var ChildPuzzleMember[] $puzzleMembersToDelete */
        $puzzleMembersToDelete = $this->getPuzzleMembers(new Criteria(), $con)->diff($puzzleMembers);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->puzzleMembersScheduledForDeletion = clone $puzzleMembersToDelete;

        foreach ($puzzleMembersToDelete as $puzzleMemberRemoved) {
            $puzzleMemberRemoved->setPuzzle(null);
        }

        $this->collPuzzleMembers = null;
        foreach ($puzzleMembers as $puzzleMember) {
            $this->addPuzzleMember($puzzleMember);
        }

        $this->collPuzzleMembers = $puzzleMembers;
        $this->collPuzzleMembersPartial = false;

        return $this;
    }

    /**
     * Returns the number of related PuzzleMember objects.
     *
     * @param Criteria $criteria
     * @param bool $distinct
     * @param ConnectionInterface $con
     * @return int Count of related PuzzleMember objects.
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function countPuzzleMembers(?Criteria $criteria = null, bool $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collPuzzleMembersPartial && !$this->isNew();
        if (null === $this->collPuzzleMembers || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPuzzleMembers) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPuzzleMembers());
            }

            $query = ChildPuzzleMemberQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPuzzle($this)
                ->count($con);
        }

        return count($this->collPuzzleMembers);
    }

    /**
     * Method called to associate a ChildPuzzleMember object to this object
     * through the ChildPuzzleMember foreign key attribute.
     *
     * @param ChildPuzzleMember $l ChildPuzzleMember
     * @return $this The current object (for fluent API support)
     */
    public function addPuzzleMember(ChildPuzzleMember $l)
    {
        if ($this->collPuzzleMembers === null) {
            $this->initPuzzleMembers();
            $this->collPuzzleMembersPartial = true;
        }

        if (!$this->collPuzzleMembers->contains($l)) {
            $this->doAddPuzzleMember($l);

            if ($this->puzzleMembersScheduledForDeletion and $this->puzzleMembersScheduledForDeletion->contains($l)) {
                $this->puzzleMembersScheduledForDeletion->remove($this->puzzleMembersScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildPuzzleMember $puzzleMember The ChildPuzzleMember object to add.
     */
    protected function doAddPuzzleMember(ChildPuzzleMember $puzzleMember): void
    {
        $this->collPuzzleMembers[]= $puzzleMember;
        $puzzleMember->setPuzzle($this);
    }

    /**
     * @param ChildPuzzleMember $puzzleMember The ChildPuzzleMember object to remove.
     * @return $this The current object (for fluent API support)
     */
    public function removePuzzleMember(ChildPuzzleMember $puzzleMember)
    {
        if ($this->getPuzzleMembers()->contains($puzzleMember)) {
            $pos = $this->collPuzzleMembers->search($puzzleMember);
            $this->collPuzzleMembers->remove($pos);
            if (null === $this->puzzleMembersScheduledForDeletion) {
                $this->puzzleMembersScheduledForDeletion = clone $this->collPuzzleMembers;
                $this->puzzleMembersScheduledForDeletion->clear();
            }
            $this->puzzleMembersScheduledForDeletion[]= clone $puzzleMember;
            $puzzleMember->setPuzzle(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Puzzle is new, it will return
     * an empty collection; or if this Puzzle has previously
     * been saved, it will retrieve related PuzzleMembers from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Puzzle.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPuzzleMember[] List of ChildPuzzleMember objects
     * @phpstan-return ObjectCollection&\Traversable<ChildPuzzleMember}> List of ChildPuzzleMember objects
     */
    public function getPuzzleMembersJoinMember(?Criteria $criteria = null, ?ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPuzzleMemberQuery::create(null, $criteria);
        $query->joinWith('Member', $joinBehavior);

        return $this->getPuzzleMembers($query, $con);
    }

    /**
     * Clears out the collPuzzleParents collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return $this
     * @see addPuzzleParents()
     */
    public function clearPuzzleParents()
    {
        $this->collPuzzleParents = null; // important to set this to NULL since that means it is uninitialized

        return $this;
    }

    /**
     * Reset is the collPuzzleParents collection loaded partially.
     *
     * @return void
     */
    public function resetPartialPuzzleParents($v = true): void
    {
        $this->collPuzzleParentsPartial = $v;
    }

    /**
     * Initializes the collPuzzleParents collection.
     *
     * By default this just sets the collPuzzleParents collection to an empty array (like clearcollPuzzleParents());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param bool $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPuzzleParents(bool $overrideExisting = true): void
    {
        if (null !== $this->collPuzzleParents && !$overrideExisting) {
            return;
        }

        $collectionClassName = PuzzlePuzzleTableMap::getTableMap()->getCollectionClassName();

        $this->collPuzzleParents = new $collectionClassName;
        $this->collPuzzleParents->setModel('\PuzzlePuzzle');
    }

    /**
     * Gets an array of ChildPuzzlePuzzle objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPuzzle is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPuzzlePuzzle[] List of ChildPuzzlePuzzle objects
     * @phpstan-return ObjectCollection&\Traversable<ChildPuzzlePuzzle> List of ChildPuzzlePuzzle objects
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getPuzzleParents(?Criteria $criteria = null, ?ConnectionInterface $con = null)
    {
        $partial = $this->collPuzzleParentsPartial && !$this->isNew();
        if (null === $this->collPuzzleParents || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collPuzzleParents) {
                    $this->initPuzzleParents();
                } else {
                    $collectionClassName = PuzzlePuzzleTableMap::getTableMap()->getCollectionClassName();

                    $collPuzzleParents = new $collectionClassName;
                    $collPuzzleParents->setModel('\PuzzlePuzzle');

                    return $collPuzzleParents;
                }
            } else {
                $collPuzzleParents = ChildPuzzlePuzzleQuery::create(null, $criteria)
                    ->filterByChild($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPuzzleParentsPartial && count($collPuzzleParents)) {
                        $this->initPuzzleParents(false);

                        foreach ($collPuzzleParents as $obj) {
                            if (false == $this->collPuzzleParents->contains($obj)) {
                                $this->collPuzzleParents->append($obj);
                            }
                        }

                        $this->collPuzzleParentsPartial = true;
                    }

                    return $collPuzzleParents;
                }

                if ($partial && $this->collPuzzleParents) {
                    foreach ($this->collPuzzleParents as $obj) {
                        if ($obj->isNew()) {
                            $collPuzzleParents[] = $obj;
                        }
                    }
                }

                $this->collPuzzleParents = $collPuzzleParents;
                $this->collPuzzleParentsPartial = false;
            }
        }

        return $this->collPuzzleParents;
    }

    /**
     * Sets a collection of ChildPuzzlePuzzle objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param Collection $puzzleParents A Propel collection.
     * @param ConnectionInterface $con Optional connection object
     * @return $this The current object (for fluent API support)
     */
    public function setPuzzleParents(Collection $puzzleParents, ?ConnectionInterface $con = null)
    {
        /** @var ChildPuzzlePuzzle[] $puzzleParentsToDelete */
        $puzzleParentsToDelete = $this->getPuzzleParents(new Criteria(), $con)->diff($puzzleParents);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->puzzleParentsScheduledForDeletion = clone $puzzleParentsToDelete;

        foreach ($puzzleParentsToDelete as $puzzleParentRemoved) {
            $puzzleParentRemoved->setChild(null);
        }

        $this->collPuzzleParents = null;
        foreach ($puzzleParents as $puzzleParent) {
            $this->addPuzzleParent($puzzleParent);
        }

        $this->collPuzzleParents = $puzzleParents;
        $this->collPuzzleParentsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related PuzzlePuzzle objects.
     *
     * @param Criteria $criteria
     * @param bool $distinct
     * @param ConnectionInterface $con
     * @return int Count of related PuzzlePuzzle objects.
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function countPuzzleParents(?Criteria $criteria = null, bool $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collPuzzleParentsPartial && !$this->isNew();
        if (null === $this->collPuzzleParents || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPuzzleParents) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPuzzleParents());
            }

            $query = ChildPuzzlePuzzleQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByChild($this)
                ->count($con);
        }

        return count($this->collPuzzleParents);
    }

    /**
     * Method called to associate a ChildPuzzlePuzzle object to this object
     * through the ChildPuzzlePuzzle foreign key attribute.
     *
     * @param ChildPuzzlePuzzle $l ChildPuzzlePuzzle
     * @return $this The current object (for fluent API support)
     */
    public function addPuzzleParent(ChildPuzzlePuzzle $l)
    {
        if ($this->collPuzzleParents === null) {
            $this->initPuzzleParents();
            $this->collPuzzleParentsPartial = true;
        }

        if (!$this->collPuzzleParents->contains($l)) {
            $this->doAddPuzzleParent($l);

            if ($this->puzzleParentsScheduledForDeletion and $this->puzzleParentsScheduledForDeletion->contains($l)) {
                $this->puzzleParentsScheduledForDeletion->remove($this->puzzleParentsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildPuzzlePuzzle $puzzleParent The ChildPuzzlePuzzle object to add.
     */
    protected function doAddPuzzleParent(ChildPuzzlePuzzle $puzzleParent): void
    {
        $this->collPuzzleParents[]= $puzzleParent;
        $puzzleParent->setChild($this);
    }

    /**
     * @param ChildPuzzlePuzzle $puzzleParent The ChildPuzzlePuzzle object to remove.
     * @return $this The current object (for fluent API support)
     */
    public function removePuzzleParent(ChildPuzzlePuzzle $puzzleParent)
    {
        if ($this->getPuzzleParents()->contains($puzzleParent)) {
            $pos = $this->collPuzzleParents->search($puzzleParent);
            $this->collPuzzleParents->remove($pos);
            if (null === $this->puzzleParentsScheduledForDeletion) {
                $this->puzzleParentsScheduledForDeletion = clone $this->collPuzzleParents;
                $this->puzzleParentsScheduledForDeletion->clear();
            }
            $this->puzzleParentsScheduledForDeletion[]= clone $puzzleParent;
            $puzzleParent->setChild(null);
        }

        return $this;
    }

    /**
     * Clears out the collPuzzlechildren collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return $this
     * @see addPuzzlechildren()
     */
    public function clearPuzzlechildren()
    {
        $this->collPuzzlechildren = null; // important to set this to NULL since that means it is uninitialized

        return $this;
    }

    /**
     * Reset is the collPuzzlechildren collection loaded partially.
     *
     * @return void
     */
    public function resetPartialPuzzlechildren($v = true): void
    {
        $this->collPuzzlechildrenPartial = $v;
    }

    /**
     * Initializes the collPuzzlechildren collection.
     *
     * By default this just sets the collPuzzlechildren collection to an empty array (like clearcollPuzzlechildren());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param bool $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPuzzlechildren(bool $overrideExisting = true): void
    {
        if (null !== $this->collPuzzlechildren && !$overrideExisting) {
            return;
        }

        $collectionClassName = PuzzlePuzzleTableMap::getTableMap()->getCollectionClassName();

        $this->collPuzzlechildren = new $collectionClassName;
        $this->collPuzzlechildren->setModel('\PuzzlePuzzle');
    }

    /**
     * Gets an array of ChildPuzzlePuzzle objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPuzzle is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPuzzlePuzzle[] List of ChildPuzzlePuzzle objects
     * @phpstan-return ObjectCollection&\Traversable<ChildPuzzlePuzzle> List of ChildPuzzlePuzzle objects
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getPuzzlechildren(?Criteria $criteria = null, ?ConnectionInterface $con = null)
    {
        $partial = $this->collPuzzlechildrenPartial && !$this->isNew();
        if (null === $this->collPuzzlechildren || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collPuzzlechildren) {
                    $this->initPuzzlechildren();
                } else {
                    $collectionClassName = PuzzlePuzzleTableMap::getTableMap()->getCollectionClassName();

                    $collPuzzlechildren = new $collectionClassName;
                    $collPuzzlechildren->setModel('\PuzzlePuzzle');

                    return $collPuzzlechildren;
                }
            } else {
                $collPuzzlechildren = ChildPuzzlePuzzleQuery::create(null, $criteria)
                    ->filterByParent($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPuzzlechildrenPartial && count($collPuzzlechildren)) {
                        $this->initPuzzlechildren(false);

                        foreach ($collPuzzlechildren as $obj) {
                            if (false == $this->collPuzzlechildren->contains($obj)) {
                                $this->collPuzzlechildren->append($obj);
                            }
                        }

                        $this->collPuzzlechildrenPartial = true;
                    }

                    return $collPuzzlechildren;
                }

                if ($partial && $this->collPuzzlechildren) {
                    foreach ($this->collPuzzlechildren as $obj) {
                        if ($obj->isNew()) {
                            $collPuzzlechildren[] = $obj;
                        }
                    }
                }

                $this->collPuzzlechildren = $collPuzzlechildren;
                $this->collPuzzlechildrenPartial = false;
            }
        }

        return $this->collPuzzlechildren;
    }

    /**
     * Sets a collection of ChildPuzzlePuzzle objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param Collection $puzzlechildren A Propel collection.
     * @param ConnectionInterface $con Optional connection object
     * @return $this The current object (for fluent API support)
     */
    public function setPuzzlechildren(Collection $puzzlechildren, ?ConnectionInterface $con = null)
    {
        /** @var ChildPuzzlePuzzle[] $puzzlechildrenToDelete */
        $puzzlechildrenToDelete = $this->getPuzzlechildren(new Criteria(), $con)->diff($puzzlechildren);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->puzzlechildrenScheduledForDeletion = clone $puzzlechildrenToDelete;

        foreach ($puzzlechildrenToDelete as $puzzleChildRemoved) {
            $puzzleChildRemoved->setParent(null);
        }

        $this->collPuzzlechildren = null;
        foreach ($puzzlechildren as $puzzleChild) {
            $this->addPuzzleChild($puzzleChild);
        }

        $this->collPuzzlechildren = $puzzlechildren;
        $this->collPuzzlechildrenPartial = false;

        return $this;
    }

    /**
     * Returns the number of related PuzzlePuzzle objects.
     *
     * @param Criteria $criteria
     * @param bool $distinct
     * @param ConnectionInterface $con
     * @return int Count of related PuzzlePuzzle objects.
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function countPuzzlechildren(?Criteria $criteria = null, bool $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collPuzzlechildrenPartial && !$this->isNew();
        if (null === $this->collPuzzlechildren || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPuzzlechildren) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPuzzlechildren());
            }

            $query = ChildPuzzlePuzzleQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByParent($this)
                ->count($con);
        }

        return count($this->collPuzzlechildren);
    }

    /**
     * Method called to associate a ChildPuzzlePuzzle object to this object
     * through the ChildPuzzlePuzzle foreign key attribute.
     *
     * @param ChildPuzzlePuzzle $l ChildPuzzlePuzzle
     * @return $this The current object (for fluent API support)
     */
    public function addPuzzleChild(ChildPuzzlePuzzle $l)
    {
        if ($this->collPuzzlechildren === null) {
            $this->initPuzzlechildren();
            $this->collPuzzlechildrenPartial = true;
        }

        if (!$this->collPuzzlechildren->contains($l)) {
            $this->doAddPuzzleChild($l);

            if ($this->puzzlechildrenScheduledForDeletion and $this->puzzlechildrenScheduledForDeletion->contains($l)) {
                $this->puzzlechildrenScheduledForDeletion->remove($this->puzzlechildrenScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildPuzzlePuzzle $puzzleChild The ChildPuzzlePuzzle object to add.
     */
    protected function doAddPuzzleChild(ChildPuzzlePuzzle $puzzleChild): void
    {
        $this->collPuzzlechildren[]= $puzzleChild;
        $puzzleChild->setParent($this);
    }

    /**
     * @param ChildPuzzlePuzzle $puzzleChild The ChildPuzzlePuzzle object to remove.
     * @return $this The current object (for fluent API support)
     */
    public function removePuzzleChild(ChildPuzzlePuzzle $puzzleChild)
    {
        if ($this->getPuzzlechildren()->contains($puzzleChild)) {
            $pos = $this->collPuzzlechildren->search($puzzleChild);
            $this->collPuzzlechildren->remove($pos);
            if (null === $this->puzzlechildrenScheduledForDeletion) {
                $this->puzzlechildrenScheduledForDeletion = clone $this->collPuzzlechildren;
                $this->puzzlechildrenScheduledForDeletion->clear();
            }
            $this->puzzlechildrenScheduledForDeletion[]= clone $puzzleChild;
            $puzzleChild->setParent(null);
        }

        return $this;
    }

    /**
     * Clears out the collMembers collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addMembers()
     */
    public function clearMembers()
    {
        $this->collMembers = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collMembers crossRef collection.
     *
     * By default this just sets the collMembers collection to an empty collection (like clearMembers());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initMembers()
    {
        $collectionClassName = PuzzleMemberTableMap::getTableMap()->getCollectionClassName();

        $this->collMembers = new $collectionClassName;
        $this->collMembersPartial = true;
        $this->collMembers->setModel('\Member');
    }

    /**
     * Checks if the collMembers collection is loaded.
     *
     * @return bool
     */
    public function isMembersLoaded(): bool
    {
        return null !== $this->collMembers;
    }

    /**
     * Gets a collection of ChildMember objects related by a many-to-many relationship
     * to the current object by way of the solver cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPuzzle is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria Optional query object to filter the query
     * @param ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildMember[] List of ChildMember objects
     * @phpstan-return ObjectCollection&\Traversable<ChildMember> List of ChildMember objects
     */
    public function getMembers(?Criteria $criteria = null, ?ConnectionInterface $con = null)
    {
        $partial = $this->collMembersPartial && !$this->isNew();
        if (null === $this->collMembers || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collMembers) {
                    $this->initMembers();
                }
            } else {

                $query = ChildMemberQuery::create(null, $criteria)
                    ->filterByPuzzle($this);
                $collMembers = $query->find($con);
                if (null !== $criteria) {
                    return $collMembers;
                }

                if ($partial && $this->collMembers) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collMembers as $obj) {
                        if (!$collMembers->contains($obj)) {
                            $collMembers[] = $obj;
                        }
                    }
                }

                $this->collMembers = $collMembers;
                $this->collMembersPartial = false;
            }
        }

        return $this->collMembers;
    }

    /**
     * Sets a collection of Member objects related by a many-to-many relationship
     * to the current object by way of the solver cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param Collection $members A Propel collection.
     * @param ConnectionInterface $con Optional connection object
     * @return $this The current object (for fluent API support)
     */
    public function setMembers(Collection $members, ?ConnectionInterface $con = null)
    {
        $this->clearMembers();
        $currentMembers = $this->getMembers();

        $membersScheduledForDeletion = $currentMembers->diff($members);

        foreach ($membersScheduledForDeletion as $toDelete) {
            $this->removeMember($toDelete);
        }

        foreach ($members as $member) {
            if (!$currentMembers->contains($member)) {
                $this->doAddMember($member);
            }
        }

        $this->collMembersPartial = false;
        $this->collMembers = $members;

        return $this;
    }

    /**
     * Gets the number of Member objects related by a many-to-many relationship
     * to the current object by way of the solver cross-reference table.
     *
     * @param Criteria $criteria Optional query object to filter the query
     * @param bool $distinct Set to true to force count distinct
     * @param ConnectionInterface $con Optional connection object
     *
     * @return int The number of related Member objects
     */
    public function countMembers(?Criteria $criteria = null, $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collMembersPartial && !$this->isNew();
        if (null === $this->collMembers || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collMembers) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getMembers());
                }

                $query = ChildMemberQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByPuzzle($this)
                    ->count($con);
            }
        } else {
            return count($this->collMembers);
        }
    }

    /**
     * Associate a ChildMember to this object
     * through the solver cross reference table.
     *
     * @param ChildMember $member
     * @return ChildPuzzle The current object (for fluent API support)
     */
    public function addMember(ChildMember $member)
    {
        if ($this->collMembers === null) {
            $this->initMembers();
        }

        if (!$this->getMembers()->contains($member)) {
            // only add it if the **same** object is not already associated
            $this->collMembers->push($member);
            $this->doAddMember($member);
        }

        return $this;
    }

    /**
     *
     * @param ChildMember $member
     */
    protected function doAddMember(ChildMember $member)
    {
        $puzzleMember = new ChildPuzzleMember();

        $puzzleMember->setMember($member);

        $puzzleMember->setPuzzle($this);

        $this->addPuzzleMember($puzzleMember);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$member->isPuzzlesLoaded()) {
            $member->initPuzzles();
            $member->getPuzzles()->push($this);
        } elseif (!$member->getPuzzles()->contains($this)) {
            $member->getPuzzles()->push($this);
        }

    }

    /**
     * Remove member of this object
     * through the solver cross reference table.
     *
     * @param ChildMember $member
     * @return ChildPuzzle The current object (for fluent API support)
     */
    public function removeMember(ChildMember $member)
    {
        if ($this->getMembers()->contains($member)) {
            $puzzleMember = new ChildPuzzleMember();
            $puzzleMember->setMember($member);
            if ($member->isPuzzlesLoaded()) {
                //remove the back reference if available
                $member->getPuzzles()->removeObject($this);
            }

            $puzzleMember->setPuzzle($this);
            $this->removePuzzleMember(clone $puzzleMember);
            $puzzleMember->clear();

            $this->collMembers->remove($this->collMembers->search($member));

            if (null === $this->membersScheduledForDeletion) {
                $this->membersScheduledForDeletion = clone $this->collMembers;
                $this->membersScheduledForDeletion->clear();
            }

            $this->membersScheduledForDeletion->push($member);
        }


        return $this;
    }

    /**
     * Clears out the collParents collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addParents()
     */
    public function clearParents()
    {
        $this->collParents = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collParents crossRef collection.
     *
     * By default this just sets the collParents collection to an empty collection (like clearParents());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initParents()
    {
        $collectionClassName = PuzzlePuzzleTableMap::getTableMap()->getCollectionClassName();

        $this->collParents = new $collectionClassName;
        $this->collParentsPartial = true;
        $this->collParents->setModel('\Puzzle');
    }

    /**
     * Checks if the collParents collection is loaded.
     *
     * @return bool
     */
    public function isParentsLoaded(): bool
    {
        return null !== $this->collParents;
    }

    /**
     * Gets a collection of ChildPuzzle objects related by a many-to-many relationship
     * to the current object by way of the relationship cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPuzzle is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria Optional query object to filter the query
     * @param ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildPuzzle[] List of ChildPuzzle objects
     * @phpstan-return ObjectCollection&\Traversable<ChildPuzzle> List of ChildPuzzle objects
     */
    public function getParents(?Criteria $criteria = null, ?ConnectionInterface $con = null)
    {
        $partial = $this->collParentsPartial && !$this->isNew();
        if (null === $this->collParents || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collParents) {
                    $this->initParents();
                }
            } else {

                $query = ChildPuzzleQuery::create(null, $criteria)
                    ->filterByChild($this);
                $collParents = $query->find($con);
                if (null !== $criteria) {
                    return $collParents;
                }

                if ($partial && $this->collParents) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collParents as $obj) {
                        if (!$collParents->contains($obj)) {
                            $collParents[] = $obj;
                        }
                    }
                }

                $this->collParents = $collParents;
                $this->collParentsPartial = false;
            }
        }

        return $this->collParents;
    }

    /**
     * Sets a collection of Puzzle objects related by a many-to-many relationship
     * to the current object by way of the relationship cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param Collection $parents A Propel collection.
     * @param ConnectionInterface $con Optional connection object
     * @return $this The current object (for fluent API support)
     */
    public function setParents(Collection $parents, ?ConnectionInterface $con = null)
    {
        $this->clearParents();
        $currentParents = $this->getParents();

        $parentsScheduledForDeletion = $currentParents->diff($parents);

        foreach ($parentsScheduledForDeletion as $toDelete) {
            $this->removeParent($toDelete);
        }

        foreach ($parents as $parent) {
            if (!$currentParents->contains($parent)) {
                $this->doAddParent($parent);
            }
        }

        $this->collParentsPartial = false;
        $this->collParents = $parents;

        return $this;
    }

    /**
     * Gets the number of Puzzle objects related by a many-to-many relationship
     * to the current object by way of the relationship cross-reference table.
     *
     * @param Criteria $criteria Optional query object to filter the query
     * @param bool $distinct Set to true to force count distinct
     * @param ConnectionInterface $con Optional connection object
     *
     * @return int The number of related Puzzle objects
     */
    public function countParents(?Criteria $criteria = null, $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collParentsPartial && !$this->isNew();
        if (null === $this->collParents || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collParents) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getParents());
                }

                $query = ChildPuzzleQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByChild($this)
                    ->count($con);
            }
        } else {
            return count($this->collParents);
        }
    }

    /**
     * Associate a ChildPuzzle to this object
     * through the relationship cross reference table.
     *
     * @param ChildPuzzle $parent
     * @return ChildPuzzle The current object (for fluent API support)
     */
    public function addParent(ChildPuzzle $parent)
    {
        if ($this->collParents === null) {
            $this->initParents();
        }

        if (!$this->getParents()->contains($parent)) {
            // only add it if the **same** object is not already associated
            $this->collParents->push($parent);
            $this->doAddParent($parent);
        }

        return $this;
    }

    /**
     *
     * @param ChildPuzzle $parent
     */
    protected function doAddParent(ChildPuzzle $parent)
    {
        $puzzlePuzzle = new ChildPuzzlePuzzle();

        $puzzlePuzzle->setParent($parent);

        $puzzlePuzzle->setChild($this);

        $this->addPuzzleParent($puzzlePuzzle);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$parent->isChildrenLoaded()) {
            $parent->initChildren();
            $parent->getChildren()->push($this);
        } elseif (!$parent->getChildren()->contains($this)) {
            $parent->getChildren()->push($this);
        }

    }

    /**
     * Remove parent of this object
     * through the relationship cross reference table.
     *
     * @param ChildPuzzle $parent
     * @return ChildPuzzle The current object (for fluent API support)
     */
    public function removeParent(ChildPuzzle $parent)
    {
        if ($this->getParents()->contains($parent)) {
            $puzzlePuzzle = new ChildPuzzlePuzzle();
            $puzzlePuzzle->setParent($parent);
            if ($parent->isChildrenLoaded()) {
                //remove the back reference if available
                $parent->getChildren()->removeObject($this);
            }

            $puzzlePuzzle->setChild($this);
            $this->removePuzzleParent(clone $puzzlePuzzle);
            $puzzlePuzzle->clear();

            $this->collParents->remove($this->collParents->search($parent));

            if (null === $this->parentsScheduledForDeletion) {
                $this->parentsScheduledForDeletion = clone $this->collParents;
                $this->parentsScheduledForDeletion->clear();
            }

            $this->parentsScheduledForDeletion->push($parent);
        }


        return $this;
    }

    /**
     * Clears out the collChildren collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addChildren()
     */
    public function clearChildren()
    {
        $this->collChildren = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collChildren crossRef collection.
     *
     * By default this just sets the collChildren collection to an empty collection (like clearChildren());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initChildren()
    {
        $collectionClassName = PuzzlePuzzleTableMap::getTableMap()->getCollectionClassName();

        $this->collChildren = new $collectionClassName;
        $this->collChildrenPartial = true;
        $this->collChildren->setModel('\Puzzle');
    }

    /**
     * Checks if the collChildren collection is loaded.
     *
     * @return bool
     */
    public function isChildrenLoaded(): bool
    {
        return null !== $this->collChildren;
    }

    /**
     * Gets a collection of ChildPuzzle objects related by a many-to-many relationship
     * to the current object by way of the relationship cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPuzzle is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria Optional query object to filter the query
     * @param ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildPuzzle[] List of ChildPuzzle objects
     * @phpstan-return ObjectCollection&\Traversable<ChildPuzzle> List of ChildPuzzle objects
     */
    public function getChildren(?Criteria $criteria = null, ?ConnectionInterface $con = null)
    {
        $partial = $this->collChildrenPartial && !$this->isNew();
        if (null === $this->collChildren || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collChildren) {
                    $this->initChildren();
                }
            } else {

                $query = ChildPuzzleQuery::create(null, $criteria)
                    ->filterByParent($this);
                $collChildren = $query->find($con);
                if (null !== $criteria) {
                    return $collChildren;
                }

                if ($partial && $this->collChildren) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collChildren as $obj) {
                        if (!$collChildren->contains($obj)) {
                            $collChildren[] = $obj;
                        }
                    }
                }

                $this->collChildren = $collChildren;
                $this->collChildrenPartial = false;
            }
        }

        return $this->collChildren;
    }

    /**
     * Sets a collection of Puzzle objects related by a many-to-many relationship
     * to the current object by way of the relationship cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param Collection $children A Propel collection.
     * @param ConnectionInterface $con Optional connection object
     * @return $this The current object (for fluent API support)
     */
    public function setChildren(Collection $children, ?ConnectionInterface $con = null)
    {
        $this->clearChildren();
        $currentChildren = $this->getChildren();

        $childrenScheduledForDeletion = $currentChildren->diff($children);

        foreach ($childrenScheduledForDeletion as $toDelete) {
            $this->removeChild($toDelete);
        }

        foreach ($children as $child) {
            if (!$currentChildren->contains($child)) {
                $this->doAddChild($child);
            }
        }

        $this->collChildrenPartial = false;
        $this->collChildren = $children;

        return $this;
    }

    /**
     * Gets the number of Puzzle objects related by a many-to-many relationship
     * to the current object by way of the relationship cross-reference table.
     *
     * @param Criteria $criteria Optional query object to filter the query
     * @param bool $distinct Set to true to force count distinct
     * @param ConnectionInterface $con Optional connection object
     *
     * @return int The number of related Puzzle objects
     */
    public function countChildren(?Criteria $criteria = null, $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collChildrenPartial && !$this->isNew();
        if (null === $this->collChildren || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collChildren) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getChildren());
                }

                $query = ChildPuzzleQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByParent($this)
                    ->count($con);
            }
        } else {
            return count($this->collChildren);
        }
    }

    /**
     * Associate a ChildPuzzle to this object
     * through the relationship cross reference table.
     *
     * @param ChildPuzzle $child
     * @return ChildPuzzle The current object (for fluent API support)
     */
    public function addChild(ChildPuzzle $child)
    {
        if ($this->collChildren === null) {
            $this->initChildren();
        }

        if (!$this->getChildren()->contains($child)) {
            // only add it if the **same** object is not already associated
            $this->collChildren->push($child);
            $this->doAddChild($child);
        }

        return $this;
    }

    /**
     *
     * @param ChildPuzzle $child
     */
    protected function doAddChild(ChildPuzzle $child)
    {
        $puzzlePuzzle = new ChildPuzzlePuzzle();

        $puzzlePuzzle->setChild($child);

        $puzzlePuzzle->setParent($this);

        $this->addPuzzleChild($puzzlePuzzle);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$child->isParentsLoaded()) {
            $child->initParents();
            $child->getParents()->push($this);
        } elseif (!$child->getParents()->contains($this)) {
            $child->getParents()->push($this);
        }

    }

    /**
     * Remove child of this object
     * through the relationship cross reference table.
     *
     * @param ChildPuzzle $child
     * @return ChildPuzzle The current object (for fluent API support)
     */
    public function removeChild(ChildPuzzle $child)
    {
        if ($this->getChildren()->contains($child)) {
            $puzzlePuzzle = new ChildPuzzlePuzzle();
            $puzzlePuzzle->setChild($child);
            if ($child->isParentsLoaded()) {
                //remove the back reference if available
                $child->getParents()->removeObject($this);
            }

            $puzzlePuzzle->setParent($this);
            $this->removePuzzleChild(clone $puzzlePuzzle);
            $puzzlePuzzle->clear();

            $this->collChildren->remove($this->collChildren->search($child));

            if (null === $this->childrenScheduledForDeletion) {
                $this->childrenScheduledForDeletion = clone $this->collChildren;
                $this->childrenScheduledForDeletion->clear();
            }

            $this->childrenScheduledForDeletion->push($child);
        }


        return $this;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     *
     * @return $this
     */
    public function clear()
    {
        if (null !== $this->aWrangler) {
            $this->aWrangler->removeWrangledPuzzle($this);
        }
        $this->id = null;
        $this->title = null;
        $this->url = null;
        $this->spreadsheet_id = null;
        $this->solution = null;
        $this->status = null;
        $this->slack_channel = null;
        $this->slack_channel_id = null;
        $this->wrangler_id = null;
        $this->sheet_mod_date = null;
        $this->solver_count = null;
        $this->created_at = null;
        $this->updated_at = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);

        return $this;
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param bool $deep Whether to also clear the references on all referrer objects.
     * @return $this
     */
    public function clearAllReferences(bool $deep = false)
    {
        if ($deep) {
            if ($this->collPuzzleMembers) {
                foreach ($this->collPuzzleMembers as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPuzzleParents) {
                foreach ($this->collPuzzleParents as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPuzzlechildren) {
                foreach ($this->collPuzzlechildren as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collMembers) {
                foreach ($this->collMembers as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collParents) {
                foreach ($this->collParents as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collChildren) {
                foreach ($this->collChildren as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collPuzzleMembers = null;
        $this->collPuzzleParents = null;
        $this->collPuzzlechildren = null;
        $this->collMembers = null;
        $this->collParents = null;
        $this->collChildren = null;
        $this->aWrangler = null;
        return $this;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(PuzzleTableMap::DEFAULT_STRING_FORMAT);
    }

    // solver_count behavior

    /**
     * Computes the value of the aggregate column solver_count *
     * @param ConnectionInterface $con A connection object
     *
     * @return mixed The scalar result from the aggregate query
     */
    public function computeSolverCount(ConnectionInterface $con)
    {
        $stmt = $con->prepare('SELECT COUNT(member_id) FROM solver WHERE solver.PUZZLE_ID = :p1');
        $stmt->bindValue(':p1', $this->getId());
        $stmt->execute();

        return $stmt->fetchColumn();
    }

    /**
     * Updates the aggregate column solver_count *
     * @param ConnectionInterface $con A connection object
     */
    public function updateSolverCount(ConnectionInterface $con)
    {
        $this->setSolverCount($this->computeSolverCount($con));
        $this->save($con);
    }

    // timestampable behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return $this The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[PuzzleTableMap::COL_UPDATED_AT] = true;

        return $this;
    }

    // archivable behavior

    /**
     * Get an archived version of the current object.
     *
     * @param ConnectionInterface|null $con Optional connection object
     *
     * @return ChildPuzzleArchive An archive object, or null if the current object was never archived
     */
    public function getArchive(?ConnectionInterface $con = null)
    {
        if ($this->isNew()) {
            return null;
        }
        $archive = ChildPuzzleArchiveQuery::create()
            ->filterByPrimaryKey($this->getPrimaryKey())
            ->findOne($con);

        return $archive;
    }
    /**
     * Copy the data of the current object into a $archiveTablePhpName archive object.
     * The archived object is then saved.
     * If the current object has already been archived, the archived object
     * is updated and not duplicated.
     *
     * @param ConnectionInterface|null $con Optional connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException If the object is new
     *
     * @return ChildPuzzleArchive The archive object based on this object
     */
    public function archive(?ConnectionInterface $con = null)
    {
        if ($this->isNew()) {
            throw new PropelException('New objects cannot be archived. You must save the current object before calling archive().');
        }
        $archive = $this->getArchive($con);
        if (!$archive) {
            $archive = new ChildPuzzleArchive();
            $archive->setPrimaryKey($this->getPrimaryKey());
        }
        $this->copyInto($archive, $deepCopy = false, $makeNew = false);
        $archive->setArchivedAt(time());
        $archive->save($con);

        return $archive;
    }

    /**
     * Revert the the current object to the state it had when it was last archived.
     * The object must be saved afterwards if the changes must persist.
     *
     * @param ConnectionInterface|null $con Optional connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException If the object has no corresponding archive.
     *
     * @return $this The current object (for fluent API support)
     */
    public function restoreFromArchive(?ConnectionInterface $con = null)
    {
        $archive = $this->getArchive($con);
        if (!$archive) {
            throw new PropelException('The current object has never been archived and cannot be restored');
        }
        $this->populateFromArchive($archive);

        return $this;
    }

    /**
     * Populates the the current object based on a $archiveTablePhpName archive object.
     *
     * @param ChildPuzzleArchive $archive An archived object based on the same class
      * @param bool $populateAutoIncrementPrimaryKeys
     *               If true, autoincrement columns are copied from the archive object.
     *               If false, autoincrement columns are left intact.
      *
     * @return ChildPuzzle The current object (for fluent API support)
     */
    public function populateFromArchive($archive, bool $populateAutoIncrementPrimaryKeys = false)
    {
        if ($populateAutoIncrementPrimaryKeys) {
            $this->setId($archive->getId());
        }
        $this->setTitle($archive->getTitle());
        $this->setUrl($archive->getUrl());
        $this->setSpreadsheetId($archive->getSpreadsheetId());
        $this->setSolution($archive->getSolution());
        $this->setStatus($archive->getStatus());
        $this->setSlackChannel($archive->getSlackChannel());
        $this->setSlackChannelId($archive->getSlackChannelId());
        $this->setWranglerId($archive->getWranglerId());
        $this->setSheetModDate($archive->getSheetModDate());
        $this->setSolverCount($archive->getSolverCount());
        $this->setCreatedAt($archive->getCreatedAt());
        $this->setUpdatedAt($archive->getUpdatedAt());

        return $this;
    }

    /**
     * Removes the object from the database without archiving it.
     *
     * @param ConnectionInterface|null $con Optional connection object
     *
     * @return $this|ChildPuzzle The current object (for fluent API support)
     */
    public function deleteWithoutArchive(?ConnectionInterface $con = null)
    {
        $this->archiveOnDelete = false;

        return $this->delete($con);
    }

    /**
     * Code to be run before persisting the object
     * @param ConnectionInterface|null $con
     * @return bool
     */
    public function preSave(?ConnectionInterface $con = null): bool
    {
                return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface|null $con
     * @return void
     */
    public function postSave(?ConnectionInterface $con = null): void
    {
            }

    /**
     * Code to be run before inserting to database
     * @param ConnectionInterface|null $con
     * @return bool
     */
    public function preInsert(?ConnectionInterface $con = null): bool
    {
                return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface|null $con
     * @return void
     */
    public function postInsert(?ConnectionInterface $con = null): void
    {
            }

    /**
     * Code to be run before updating the object in database
     * @param ConnectionInterface|null $con
     * @return bool
     */
    public function preUpdate(?ConnectionInterface $con = null): bool
    {
                return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface|null $con
     * @return void
     */
    public function postUpdate(?ConnectionInterface $con = null): void
    {
            }

    /**
     * Code to be run before deleting the object in database
     * @param ConnectionInterface|null $con
     * @return bool
     */
    public function preDelete(?ConnectionInterface $con = null): bool
    {
                return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface|null $con
     * @return void
     */
    public function postDelete(?ConnectionInterface $con = null): void
    {
            }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);
            $inputData = $params[0];
            $keyType = $params[1] ?? TableMap::TYPE_PHPNAME;

            return $this->importFrom($format, $inputData, $keyType);
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = $params[0] ?? true;
            $keyType = $params[1] ?? TableMap::TYPE_PHPNAME;

            return $this->exportTo($format, $includeLazyLoadColumns, $keyType);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
