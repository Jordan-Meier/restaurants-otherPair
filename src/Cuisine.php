<?php

class Cuisine
{
    private $name;
    private $id;

    function __construct($name, $id = null)
    {
        $this->name = $name;
        $this->id = $id;
    }

    function getName()
    {
        return $this->name;
    }

    function setName($new_name)
    {
        return $this->name = (string) $new_name;
    }

    function getCuisineID()
    {
        return $this->id;
    }

    function save()
    {
      $GLOBALS['DB']->exec("INSERT INTO cuisines (name) VALUES ('{$this->getName()}')");
      $this->id = $GLOBALS['DB']->lastInsertId();
    }

    static function getAll()
    {
        $result_cuisines = $GLOBALS['DB']->query("SELECT * FROM cuisines;");
        $cuisines = array();
        foreach ($result_cuisines as $cuisine) {
          $cuisine_name = $cuisine['name'];
          $cuisine_id = $cuisine['id'];
          $new_cuisine = new Cuisine($cuisine_name, $cuisine_id);
          array_push($cuisines, $new_cuisine);
        }
        return $cuisines;
    }

    static function deleteAll()
    {
        $GLOBALS['DB']->exec("DELETE FROM cuisines;");
    }

    static function find($search_id)
    {
      $found_cuisine = null;
      $all_cuisines = Cuisine::getAll();
      foreach($all_cuisines as $cuisine) {
          $cuisine_id = $cuisine->getCuisineID();
          if ($cuisine_id == $search_id) {
            $found_cuisine = $cuisine;
          }
        }
        return $found_cuisine;
    }

    //to get all restaurants that are associated with a specific cuisine.
    function findRestaurant_InCuisine()//finding all restaurants in a cuisine
    {
        $restaurant_in_cuisine = array();
        $get_restaurants = $GLOBALS['DB']->query("SELECT * FROM restaurants WHERE cuisine_id = {$this->getCuisineID()}");
        foreach($get_restaurants as $restaurant) {
            $name = $restaurant['name'];
            $id = $restaurant['id'];
            $cuisine_id = $restaurant['cuisine_id'];
            $description = $restaurant['description'];
            $new_restaurant = new Restaurant($name, $id, $cuisine_id, $description);
            array_push($restaurant_in_cuisine, $new_restaurant);
        }
        return $restaurant_in_cuisine;

    }

    function update($new_name)
    {
        $GLOBALS['DB']->exec("UPDATE cuisines SET name = '{$new_name}' WHERE id = {$this->getCuisineId()};");
        $this->setName($new_name);
    }

    function delete()
    {
        $GLOBALS['DB']->exec("DELETE FROM cuisines WHERE id = {$this->getCuisineId()};");
        $GLOBALS['DB']->exec("DELETE FROM restaurants WHERE cuisine_id = {$this->getCuisineId()};");
    }
}
?>
