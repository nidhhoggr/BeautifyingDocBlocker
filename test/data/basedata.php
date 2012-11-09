<?php
/**
 * PHP version 5
 *
 * @category  PHP
 * @package   BaseData
 * @author    Joseph Persie <persie.joseph@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link      http://pear.php.net/package/BaseData
 */
/**
 * this is a class used to extend all crud based data functionlity
 *
 * Long description (if any) ...
 *
 * @category  PHP
 * @package   BaseData
 * @author    Joseph Persie <persie.joseph@gmail.com>
 * @copyright 2012 Joseph Persie
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License
 * @version   Release: @package_version@
 * @link      http://pear.php.net/package/BaseData
 * @see       References to other sections (if any)...
 */
class BaseData
{
    /**
     * This is the database instance
     * @var object db
     * @access protected
     */
    protected $db;
    /**
     * this is used to desginate what field to perfrom an ation by
     * @var string
     * @access private
     */
    private $identifier = 'id';
    /**
     * this keeps an array of columns of a particular model
     * @var array
     * @access private
     */
    private $columns;
    /**
     * mutator method to set the database table to perform actions on
     *
     * @param String $table the name of the table
     * @return void
     * @access public
     */
    public function setTable($table)
    {
        $this->dbtable = $table;

    }
    /**
     * Sets the columns of the table to work with
     *
     * @param array $columns an array of columns
     * @return void
     * @access public
     */
    public function setColumns($columns)
    {
        $this->columns = $columns;

    }
    /**
     * the mutator of the indetifier field which to execute actions on a record by
     *
     * @param string $id the column name
     * @return void
     * @access public
     */
    public function setIdentifier($id)
    {
        $this->identifier = $id;

    }
    /**
     * return a select sql statement
     *
     * @param array   $fields     an array of fields to select
     * @param array   $conditions an array of sql conditions
     * @param string  $order a string to order the results by
     * @return string Return a sql statment
     * @access public
     */
    public function getSelectSql($fields = array(
        "*"
    ) , $conditions = array() , $order = null)
    {
        $sql = $this->_getFindSql($this->dbtable, $fields, $conditions, $order);
        return $sql;

    }
    /**
     * create an insert statement from the provided arguments to insert
     *
     * @param string $columns sets the columns to insert by ts values
     * @return string Return a sql statement
     * @access public
     */
    public function getInsertSql($columns)
    {
        $this->setColumns($columns);
        $attributes = $this->_insertAttributes();
        extract($attributes);
        $sql = 'INSERT INTO ' . $this->dbtable . '(' . $columns . ') VALUES(' . $values . ')';
        return $sql;

    }
    /**
     * create an update statement from the provided arguments to update
     *
     * @param array $columns set the columns to update by the values
     * @return string  Return a sql update statement
     * @access public
     */
    public function getUpdateSql($columns)
    {
        $this->setColumns($columns);
        $attributes = $this->_updateAttributes();
        $sql = 'UPDATE ' . $this->dbtable . ' ' . $attributes;
        return $sql;

    }
    /**
     * create a delete statement from the provided identifier to delete
     *
     * @param string $id the identifier to delete
     * @return string Return a delete sql statement
     * @access public
     */
    public function getDeleteSql($id)
    {
        $attributes = $this->_getAttributes();
        $sql = "DELETE FROM " . $this->dbtable . " WHERE " . $this->identifier . " = " . $id;
        return $sql;

    }
    /**
     * filter out the array of column arguments by columns the table actually has
     *
     * @return array   Return an array of columns by values
     * @access private
     */
    private function _getAttributes()
    {
        $attributes = array();
        $columns = $this->_getColumnsByTable($this->dbtable);
        foreach ($columns as $col) {
            if (!empty($this->columns[$col])) $attributes[$col] = $this->columns[$col];

        }
        return $attributes;

    }
    /**
     * Build the insert attributes
     *
     * @return array   Return description (if any) ...
     * @access private
     */
    private function _insertAttributes()
    {
        $attributes = $this->_getAttributes();
        $attr['columns'] = '`' . implode('`,`', array_keys($attributes)) . '`';
        $attr['values'] = '"' . implode('","', array_values($attributes)) . '"';
        return $attr;

    }
    /**
     * Build the update attributes
     *
     * @return String a fragment of an update sql statement
     * @access private
     */
    private function _updateAttributes()
    {
        $identifier = $this->identifier;
        $attributes = $this->_getAttributes();
        foreach ($attributes as $k => $v) {
            if ($k != $identifier) $statements[] = '' . $k . ' = "' . $v . '"';

        }
        return ' SET ' . implode(',', $statements) . ' WHERE ' . $identifier . ' = ' . $attributes[$identifier];

    }
    /*
     *  get sql to retrieve columns from the specified table by some condition and order accordingly
     *
     *  @param String $table
     *      the name of the table
     *  @param Array  $fields
     *      an array of fields which will be comma delimited by implosion
     *  @param Array  $conditions
     *      an array of conditions which will be delimited appropriately by implosion
     *  @param String order
     *      as string to designtae the roder in which to retrieve records by
     *  @access private
    */
    private function _getFindSql($table, $fields = null, $conditions = null, $order = null)
    {
        $where = null;
        if ($fields == null) $fields = array(
            "*"
        );
        $sql_fields = implode(', ', $fields);
        if (!empty($conditions)) {
            $conditions = implode(" AND ", $conditions);
            $where = " WHERE " . $conditions . " ";

        }
        $where.= $order;
        $sql = "SELECT " . $sql_fields . " FROM " . $table . " $where";
        return $sql;

    }
    /**
     * a function to get all of the columns of a table
     *
     * @return array   Return an array of the table columns
     * @access private
     */
    private function _getColumnsByTable()
    {
        $result = $this->db->dbQuery('SHOW COLUMNS IN ' . $this->dbtable);
        while ($row = mysql_fetch_assoc($result)) $columns[] = $row['Field'];
        return $columns;

    }

}

