<?php

class Restaurant
{
    private $res_name;
    private $id;
    private $cuisine_id;
    private $description;

    function __construct($res_name, $id = null, $cuisine_id, $description)
    {
        $this->res_name = $res_name;
        $this->id = $id;
        $this->cuisine_id = $cuisine_id;
        $this->description;
    }

    function getDescription()
    {
        return $this->description;
    }

    function setDescription($new_description)
    {
        return $this->description = (string) $new_description;
    }

    function getName()
    {
        return $this->res_name;
    }

    function setName($new_res_name)
    {
        return $this->res_name = (string) $new_res_name;
    }

    function getRestaurantID()
    {
        return $this->id;
    }

    function getCuisineID()//link restuarants to specific cuisine
    {
        return $this->cuisine_id;
    }

    function save()//save a restaurant to the database
    {
        $GLOBALS['DB']->exec("INSERT INTO restaurants (name, cuisine_id, description) VALUES ('{$this->getName()}', {$this->getCuisineID()}, '{$this->getDescription()}')");
        $this->id = $GLOBALS['DB']->lastInsertId();
    }

    static function getAll()//literally gets all restaurants
    {
        $returned_restaurants = $GLOBALS['DB']->query("SELECT * FROM restaurants;");
        $all_restaurants = array();
        foreach($returned_restaurants as $restaurant) {
            $restaurant_name = $restaurant['name'];
            $restaurant_id = $restaurant['id'];
            $restaurant_cuisine_id = $restaurant['cuisine_id'];
            $restaurant_description = $restaurant['description'];
            $new_restaurant = new Restaurant($restaurant_name, $restaurant_id, $restaurant_cuisine_id, $restaurant_description);
            array_push($all_restaurants, $new_restaurant);
        }
        return $all_restaurants;
    }

    static function deleteAll()//nuke all restaurants
    {
        $GLOBALS['DB']->exec("DELETE FROM restaurants;");
    }

    static function find($search_id)//finding a specific restaurant
    {
        $all_restaurants = Restaurant::getAll();
        $found_restaurant = array();
        foreach($all_restaurants as $restaurant){
            $restaurant_id = $restaurant->getRestaurantID();
            if ($restaurant_id == $search_id){
                array_push($found_restaurant, $restaurant);
            }
            return $found_restaurant;
        }
    }

    function findReviews()//finding all reviews for a restaurant
    {
        $review_in_restaurant = array();
        $get_reviews = $GLOBALS['DB']->query("SELECT * FROM restaurant_review WHERE res_id = {$this->getRestaurantID()}");
        foreach($get_reviews as $res_review) {
            $review = $res_review['review'];
            $id = $res_review['id'];
            $res_id = $res_review['res_id'];
            $new_restaurant_review = new RestaurantReview($review, $id, $res_id);
            array_push($review_in_restaurant, $new_restaurant_review);

        }
        return $review_in_restaurant;
    }

    function updateRestaurant($new_res_name, $new_description)
    {
        $GLOBALS['DB']->exec("UPDATE restaurants SET (name, description) = '{$new_res_name}', '{$new_description}' WHERE id = {$this->getRestaurantId()};");

        $this->setName($new_res_name);
        $this->setDescription($new_description);
    }

    function delete()
    {
        $GLOBALS['DB']->exec("DELETE FROM restaurants WHERE cuisine_id = {$this->getCuisineID()};");
    }

    function deleteOneRestaurant()
    {
        $GLOBALS['DB']->exec("DELETE FROM restaurants WHERE id = {$this->getRestaurantId()};");
    }
}
?>
