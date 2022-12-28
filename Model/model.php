<?php

require __DIR__ . "/../database.php";
class Model
{
    public $table = false;
    public $modelName = null;
    public $singularName = null;
    protected $_schema = array();
    protected $_attributes = array();
    public $hasMany = array();
    public $belongsTo = array();

    public $db = null;

    public function getTable()
    {
        return $this->table;
    }

    public function getModelName()
    {
        return $this->modelName;
    }

    public function getSingularName()
    {
        return $this->singularName;
    }
    public function getHasMany()
    {
        return $this->hasMany;
    }

    public function getBelongsTo()
    {
        return $this->belongsTo;
    }

    public function getSchema()
    {
        return $this->_schema;
    }
    public function getAttributes()
    {
        return $this->_attributes;
    }

    public function get($whereConditions = null)
    {
        $this->db = new Database();
        $schema = $this->getSchema();
        $query = '';
        $select = 'SELECT ';
        $columns = '';
        $from = '';
        $join = '';
        $where = !empty($whereConditions) ? ' WHERE ' . $whereConditions : null;

        foreach ($schema as $column) {
            if (next($schema)) {
                $columns .= $this->table . "." . $column . " AS " . $this->singularName . "_" . $column . ", ";
            } else {
                $columns .= $this->table . "." . $column . " AS " . $this->singularName . "_" . $column . " ";
            }
        }

        $from .= " FROM " . $this->table;

        if (!empty($this->hasMany)) {
            foreach ($this->hasMany as $item => $value) {
                $className = $value['className'];
                $model = new $className();
                $modelTable = $model->getTable();
                $modelSchema = $model->getSchema();
                $modelSingularName = $model->getSingularName();
                $columns = rtrim($columns, " ");
                $columns .= ", ";
                foreach ($modelSchema as $column) {
                    if (next($modelSchema)) {
                        $columns .= $modelTable . "." . $column . " AS " . $modelSingularName . "_" . $column . ", ";
                    } else {
                        $columns .= $modelTable . "." . $column . " AS " . $modelSingularName . "_" . $column . " ";
                    }
                }

                $join .= " LEFT JOIN " . $modelTable . " ON " . $this->table . ".id= " . $modelTable . "." . $value['foreignKey'];
            }
        }

        if (!empty($this->belongsTo)) {
            foreach ($this->belongsTo as $item => $value) {
                $className = $value['className'];
                $model = new $className();
                $modelTable = $model->getTable();
                $modelSchema = $model->getSchema();
                $modelSingularName = $model->getSingularName();
                $columns = rtrim($columns, " ");
                $columns .= ", ";
                foreach ($modelSchema as $column) {
                    if (next($modelSchema)) {
                        $columns .= $modelTable . "." . $column . " AS " . $modelSingularName . "_" . $column . ", ";
                    } else {
                        $columns .= $modelTable . "." . $column . " AS " . $modelSingularName . "_" . $column . " ";
                    }
                }

                $join .= " INNER JOIN " . $modelTable . " ON " . $this->table . "." . $value['foreignKey'] . " = " . $modelTable . ".id";
            }
        }

        $order = " ORDER BY " . $this->table . ".id";
        $query = $select . $columns . $from . $join . $where . $order;

        $result = $this->db->read($query);
        return $result;
    }

    public function addSingle($data)
    {
        $this->db = new Database();
        $newData = array();
        $schema = $this->getSchema();
        foreach ($schema as $column) {
            if (!empty($data[$column])) {
                $newData[$column] =  $data[$column];
            }
        }

        $query = "INSERT INTO " . $this->table . " SET ";
        foreach ($newData as $item => $value) {
            $query .= "$item='$value', ";
        }
        $query = rtrim($query, ', ');
        $result = $this->db->write($query);
        return $result;
    }

    public function add($data)
    {
        $whereConditions = null;

        if (!empty($data)) {
            $recordId = $this->addSingle($data);

            if (!empty($this->belongsTo)) {
                foreach ($this->belongsTo as $item => $value) {
                    if (array_key_exists($value['foreignKey'], $data)) {
                        $className = $value['className'];
                        $model = new $className();
                        $modelTable = $model->getTable();

                        $whereConditions = $modelTable . ".id = " . $data[$value['foreignKey']];
                        $assocRecord = $model->get($whereConditions);

                        foreach ($assocRecord[0] as $assoc) {
                            if (array_key_exists($assoc, $this->hasMany)) {
                                $assocClassName = $assoc;
                                $assocModel = new $assocClassName();
                                $data[$this->hasMany[$assoc]['foreignKey']] = $recordId;
                                $assocModel->addSingle($data);
                            }
                        }
                    }
                }
            }
        }
    }

    public function delete($data)
    {
        $this->db = new Database();
        if (is_array($data)) {
            foreach ($data as $item => $value) {
                $query = "DELETE FROM " . $this->table . " WHERE id=" . $value;
                $this->db->write($query);
            }
        }
        return true;
    }

    public function displayAttributes()
    {
        foreach ($this->_attributes as $attribute => $property) {
            echo '<div class="col-12 col-xl-12">
                    <div class="mb-4">
                        <h4 class="card-title mb-4">' . ucwords($attribute) . ' (' . $property['unit'] . ')</h4>
                            <input class="form-control" type="' . $property['type'] . '" step="any" placeholder="Write ' . $attribute . ' here..." id="' . $attribute . '" name="product[' . $attribute . ']" required>
                            <div id="' . $attribute . 'Help" class="form-text">Please provide ' . $attribute . ' in ' . $property['unit'] . '.</div>
                            <small class=" mb-5" id="' . $attribute . 'Error"></small>
                    </div>
                </div>';
        }
    }
}
