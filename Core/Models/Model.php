<?php
namespace Core\Models;

use App\App;
use App_Core_Exception;
use Core\Entity\Entity;
use PDO;

/**
 * Class Model
 * @package Core\Models
 */
class Model
{

    /**
     * Name of table
     * @var string
     */
    public $_tableName;

    /**
     * Name of entity
     * @var string
     */
    public $_entityName;

    /**
     * Filter collection
     * @var array
     */
    protected $_filter = [];

    /**
     * @var null
     */
    protected $limit = null;

    /**
     * @var null
     */
    protected $orderBy = null;

    /**
     * Database model
     * @var Database
     */
    protected $_database;

    public function __construct()
    {
        $this->_database = new Database();
    }

    /**
     * Load an object
     *
     * @param $id
     * @param $field
     * @return Entity|false
     */
    public function load($id, $field = null)
    {
        $sql = "SELECT * FROM $this->_tableName WHERE id = ?";
        if ($field) $sql = "SELECT * FROM $this->_tableName WHERE $field = ?";
        $req = $this->_database->pdo->prepare($sql);
        $req->execute([$id]);
        return $this->_database->isSuccess($req) ?
            $this->getEntity($this->_entityName, $req->fetch()) : false;
    }

    /**
     * Get collection
     *
     * @return Entity[]
     */
    public function getCollection(): array
    {
        $result = [];
        $where = $this->_getWhereClause();
        $sql = "SELECT * FROM $this->_tableName $where";
        if ($this->orderBy) $sql .= "ORDER BY " . $this->orderBy['column'] . ' ' . $this->orderBy['sort'];
        if ($this->limit) $sql .= " LIMIT " . $this->limit;
        $req = $this->_database->pdo->prepare($sql);
        $req->execute();
        if ($this->_database->isSuccess($req)) {
            foreach ($req->fetchAll() as $datas) {
                $result[] = $this->getEntity($this->_entityName, $datas);
            }
            return $result;
        }
        return [];
    }


    /**
     * Add attribut to filter
     *
     * @param $attribut
     * @param $value
     * @return $this
     */
    public function addAttributToFilter($attribut, $value): Model
    {
        $this->_filter[$attribut] = $value;
        return $this;
    }

    /**
     * Set limit
     *
     * @param $limit
     * @return $this
     */
    public function setLimit($limit): Model
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * Set order by
     *
     * @param $column
     * @param string $sort
     * @return $this
     */
    public function setOrderBy($column, string $sort = "ASC"): Model
    {
        $this->orderBy = [
            'column'    => $column,
            'sort'      => $sort
        ];
        return $this;
    }

    /**
     * Get where clause from filter
     *
     * @return string
     */
    private function _getWhereClause(): string
    {
        $sql = "";
        $i = 0;
        foreach ($this->_filter as $attribut => $value) {
            if ($i === 0) $sql .= "WHERE ";
            if ($i >= 1) $sql .= " AND ";
            $sql .= is_array($value) ?
                "$attribut $value[0] '$value[1]'" :
                "$attribut = '$value'";
            $i++;
        }
        return $sql;
    }

    /**
     * Save an object datas
     *
     * @param $object
     * @param $tableName
     * @return bool
     */
    public function save($object, $tableName): bool
    {
        return $this->_database->updateMultiple($tableName, $this->getAllAttributesFromEntity($object));
    }


    /**
     * Create new entity in database
     *
     * @param $object
     * @param $tableName
     * @return bool
     */
    public function create($object, $tableName): bool
    {
        return $this->_database->create($tableName, $this->getAllAttributesFromEntity($object));
    }

    /**
     * Get all attributes from entity
     *
     * @param $object
     * @return array
     */
    public function getAllAttributesFromEntity($object): array
    {
        $attributes = $object->getAttributes();
        $array = [];
        if ($attributes) {
            foreach ($attributes as $attribut) {
                $method = 'get' . str_replace(' ', '', ucwords(str_replace('_', ' ', $attribut)));
                if (is_callable([$object, $method])) {
                    $array[$attribut] = $object->$method();
                }
            }
        }
        return $array;
    }

    /**
     * Delete an object from database
     *
     * @param $object
     * @param $tableName
     * @return bool
     * @throws App_Core_Exception
     */
    public function delete($object, $tableName): bool
    {
        if (is_callable([$object, 'getId'])) {
            $objectId = $object->getId();
            $req = $this->_database->pdo->prepare("DELETE FROM $tableName WHERE id = ?");
            $req->execute([$objectId]);
            return $this->_database->isSuccess($req);
        }
        App::throwException("Erreur lors de la suppression, pas d'id trouvé");
    }

    /**
     * Get entity
     *
     * @param $entityName
     * @param $datas
     * @return false|Entity
     */
    public function getEntity($entityName, $datas)
    {
        $entityName = ucfirst($entityName) . "Entity";
        $className = "App\\Entity\\" . $entityName;
        if (class_exists($className)) {
            return new $className($datas);
        }
        return false;
    }
}