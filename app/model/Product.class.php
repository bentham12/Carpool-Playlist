<?php

class Product extends DbObject {
    // name of database table
    const DB_TABLE = 'parts';

    // database fields
    protected $ProductID;
    protected $item_name;
    protected $seller_name;
    protected $seller_rep;
    protected $end_date;
    protected $current_price;
    protected $description;
    protected $img_url;

    // constructor
    public function __construct($args = array()) {
        $defaultArgs = array(
            'ProductID' => null,
            'item_name' => '',
            'seller_name' => '',
            'seller_rep' => 0,
            'end_date' => null,
            'current_price' => 0,
            'description' => '',
            'img_url' => ''
            );

        $args += $defaultArgs;

        $this->ProductID = $args['ProductID'];
        $this->item_name = $args['item_name'];
        $this->seller_name = $args['seller_name'];
        $this->seller_rep = $args['seller_rep'];
        $this->end_date = $args['end_date'];
        $this->current_price = $args['current_price'];
        $this->description = $args['description'];
        $this->img_url = $args['img_url'];
    }

    // save changes to object
    public function save() {
        $db = Db::instance();
        // omit id and any timestamps
        $db_properties = array(
            'item_name' => $this->item_name,
            'seller_name' => $this->seller_name,
            'seller_rep' => $this->seller_rep,
            'end_date' => $this->end_date,
            'current_price' => $this->current_price,
            'description' => $this->description,
            'img_url' => $this->img_url
            );
        $db->store($this, __CLASS__, self::DB_TABLE, $db_properties);
    }

    // load object by ID
    public static function loadById($id) {
        $db = Db::instance();
        $obj = $db->fetchById($id, __CLASS__, self::DB_TABLE);
        return $obj;
    }

    // load all products
    public static function getAllProducts($limit=null) {
        $query = sprintf(" SELECT id FROM %s ORDER BY date_created DESC ",
            self::DB_TABLE
            );
        $db = Db::instance();
        $result = $db->lookup($query);
        if(!mysql_num_rows($result))
            return null;
        else {
            $objects = array();
            while($row = mysql_fetch_assoc($result)) {
                $objects[] = self::loadById($row['id']);
            }
            return ($objects);
        }
    }

}
