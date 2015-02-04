<?php

namespace Hackerspace\Map;

use Hackerspace\User;
use Hackerspace\UserQuery;
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
 * This class defines the structure of the 'users' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class UserTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Hackerspace.Map.UserTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'users';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Hackerspace\\User';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Hackerspace.User';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 13;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 13;

    /**
     * the column name for the id field
     */
    const COL_ID = 'users.id';

    /**
     * the column name for the email_address field
     */
    const COL_EMAIL_ADDRESS = 'users.email_address';

    /**
     * the column name for the real_email_address field
     */
    const COL_REAL_EMAIL_ADDRESS = 'users.real_email_address';

    /**
     * the column name for the password_hash field
     */
    const COL_PASSWORD_HASH = 'users.password_hash';

    /**
     * the column name for the first_name field
     */
    const COL_FIRST_NAME = 'users.first_name';

    /**
     * the column name for the last_name field
     */
    const COL_LAST_NAME = 'users.last_name';

    /**
     * the column name for the alias field
     */
    const COL_ALIAS = 'users.alias';

    /**
     * the column name for the terms_agree field
     */
    const COL_TERMS_AGREE = 'users.terms_agree';

    /**
     * the column name for the newsletter_subscribe field
     */
    const COL_NEWSLETTER_SUBSCRIBE = 'users.newsletter_subscribe';

    /**
     * the column name for the failed_login_attempts field
     */
    const COL_FAILED_LOGIN_ATTEMPTS = 'users.failed_login_attempts';

    /**
     * the column name for the last_login_attempt field
     */
    const COL_LAST_LOGIN_ATTEMPT = 'users.last_login_attempt';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'users.created_at';

    /**
     * the column name for the updated_at field
     */
    const COL_UPDATED_AT = 'users.updated_at';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'EmailAddress', 'RealEmailAddress', 'PasswordHash', 'FirstName', 'LastName', 'Alias', 'TermsAgree', 'NewsletterSubscribe', 'FailedLoginAttempts', 'LastLoginAttempt', 'CreatedAt', 'UpdatedAt', ),
        self::TYPE_CAMELNAME     => array('id', 'emailAddress', 'realEmailAddress', 'passwordHash', 'firstName', 'lastName', 'alias', 'termsAgree', 'newsletterSubscribe', 'failedLoginAttempts', 'lastLoginAttempt', 'createdAt', 'updatedAt', ),
        self::TYPE_COLNAME       => array(UserTableMap::COL_ID, UserTableMap::COL_EMAIL_ADDRESS, UserTableMap::COL_REAL_EMAIL_ADDRESS, UserTableMap::COL_PASSWORD_HASH, UserTableMap::COL_FIRST_NAME, UserTableMap::COL_LAST_NAME, UserTableMap::COL_ALIAS, UserTableMap::COL_TERMS_AGREE, UserTableMap::COL_NEWSLETTER_SUBSCRIBE, UserTableMap::COL_FAILED_LOGIN_ATTEMPTS, UserTableMap::COL_LAST_LOGIN_ATTEMPT, UserTableMap::COL_CREATED_AT, UserTableMap::COL_UPDATED_AT, ),
        self::TYPE_FIELDNAME     => array('id', 'email_address', 'real_email_address', 'password_hash', 'first_name', 'last_name', 'alias', 'terms_agree', 'newsletter_subscribe', 'failed_login_attempts', 'last_login_attempt', 'created_at', 'updated_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'EmailAddress' => 1, 'RealEmailAddress' => 2, 'PasswordHash' => 3, 'FirstName' => 4, 'LastName' => 5, 'Alias' => 6, 'TermsAgree' => 7, 'NewsletterSubscribe' => 8, 'FailedLoginAttempts' => 9, 'LastLoginAttempt' => 10, 'CreatedAt' => 11, 'UpdatedAt' => 12, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'emailAddress' => 1, 'realEmailAddress' => 2, 'passwordHash' => 3, 'firstName' => 4, 'lastName' => 5, 'alias' => 6, 'termsAgree' => 7, 'newsletterSubscribe' => 8, 'failedLoginAttempts' => 9, 'lastLoginAttempt' => 10, 'createdAt' => 11, 'updatedAt' => 12, ),
        self::TYPE_COLNAME       => array(UserTableMap::COL_ID => 0, UserTableMap::COL_EMAIL_ADDRESS => 1, UserTableMap::COL_REAL_EMAIL_ADDRESS => 2, UserTableMap::COL_PASSWORD_HASH => 3, UserTableMap::COL_FIRST_NAME => 4, UserTableMap::COL_LAST_NAME => 5, UserTableMap::COL_ALIAS => 6, UserTableMap::COL_TERMS_AGREE => 7, UserTableMap::COL_NEWSLETTER_SUBSCRIBE => 8, UserTableMap::COL_FAILED_LOGIN_ATTEMPTS => 9, UserTableMap::COL_LAST_LOGIN_ATTEMPT => 10, UserTableMap::COL_CREATED_AT => 11, UserTableMap::COL_UPDATED_AT => 12, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'email_address' => 1, 'real_email_address' => 2, 'password_hash' => 3, 'first_name' => 4, 'last_name' => 5, 'alias' => 6, 'terms_agree' => 7, 'newsletter_subscribe' => 8, 'failed_login_attempts' => 9, 'last_login_attempt' => 10, 'created_at' => 11, 'updated_at' => 12, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('users');
        $this->setPhpName('User');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Hackerspace\\User');
        $this->setPackage('Hackerspace');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('email_address', 'EmailAddress', 'VARCHAR', true, 255, null);
        $this->addColumn('real_email_address', 'RealEmailAddress', 'VARCHAR', true, 255, null);
        $this->addColumn('password_hash', 'PasswordHash', 'VARCHAR', true, 255, null);
        $this->addColumn('first_name', 'FirstName', 'VARCHAR', true, 255, null);
        $this->addColumn('last_name', 'LastName', 'VARCHAR', true, 255, null);
        $this->addColumn('alias', 'Alias', 'VARCHAR', true, 255, null);
        $this->addColumn('terms_agree', 'TermsAgree', 'BOOLEAN', true, 1, null);
        $this->addColumn('newsletter_subscribe', 'NewsletterSubscribe', 'BOOLEAN', true, 1, null);
        $this->addColumn('failed_login_attempts', 'FailedLoginAttempts', 'INTEGER', true, null, 0);
        $this->addColumn('last_login_attempt', 'LastLoginAttempt', 'TIMESTAMP', false, null, null);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('updated_at', 'UpdatedAt', 'TIMESTAMP', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
    } // buildRelations()

    /**
     *
     * Gets the list of behaviors registered for this table
     *
     * @return array Associative array (name => parameters) of behaviors
     */
    public function getBehaviors()
    {
        return array(
            'timestampable' => array('create_column' => 'created_at', 'update_column' => 'updated_at', 'disable_created_at' => 'false', 'disable_updated_at' => 'false', ),
        );
    } // getBehaviors()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
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
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? UserTableMap::CLASS_DEFAULT : UserTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (User object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = UserTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = UserTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + UserTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = UserTableMap::OM_CLASS;
            /** @var User $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            UserTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = UserTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = UserTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var User $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                UserTableMap::addInstanceToPool($obj, $key);
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
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(UserTableMap::COL_ID);
            $criteria->addSelectColumn(UserTableMap::COL_EMAIL_ADDRESS);
            $criteria->addSelectColumn(UserTableMap::COL_REAL_EMAIL_ADDRESS);
            $criteria->addSelectColumn(UserTableMap::COL_PASSWORD_HASH);
            $criteria->addSelectColumn(UserTableMap::COL_FIRST_NAME);
            $criteria->addSelectColumn(UserTableMap::COL_LAST_NAME);
            $criteria->addSelectColumn(UserTableMap::COL_ALIAS);
            $criteria->addSelectColumn(UserTableMap::COL_TERMS_AGREE);
            $criteria->addSelectColumn(UserTableMap::COL_NEWSLETTER_SUBSCRIBE);
            $criteria->addSelectColumn(UserTableMap::COL_FAILED_LOGIN_ATTEMPTS);
            $criteria->addSelectColumn(UserTableMap::COL_LAST_LOGIN_ATTEMPT);
            $criteria->addSelectColumn(UserTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(UserTableMap::COL_UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.email_address');
            $criteria->addSelectColumn($alias . '.real_email_address');
            $criteria->addSelectColumn($alias . '.password_hash');
            $criteria->addSelectColumn($alias . '.first_name');
            $criteria->addSelectColumn($alias . '.last_name');
            $criteria->addSelectColumn($alias . '.alias');
            $criteria->addSelectColumn($alias . '.terms_agree');
            $criteria->addSelectColumn($alias . '.newsletter_subscribe');
            $criteria->addSelectColumn($alias . '.failed_login_attempts');
            $criteria->addSelectColumn($alias . '.last_login_attempt');
            $criteria->addSelectColumn($alias . '.created_at');
            $criteria->addSelectColumn($alias . '.updated_at');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(UserTableMap::DATABASE_NAME)->getTable(UserTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(UserTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(UserTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new UserTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a User or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or User object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Hackerspace\User) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(UserTableMap::DATABASE_NAME);
            $criteria->add(UserTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = UserQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            UserTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                UserTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the users table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return UserQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a User or Criteria object.
     *
     * @param mixed               $criteria Criteria or User object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from User object
        }

        if ($criteria->containsKey(UserTableMap::COL_ID) && $criteria->keyContainsValue(UserTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.UserTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = UserQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // UserTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
UserTableMap::buildTableMap();
