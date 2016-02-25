<!-- testing with php unit, use this template for guidance -->
<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once __DIR__ . '/../src/Restaurant.php';
    require_once __DIR__ . '/../src/Cuisine.php';
    require_once __DIR__ . '/../src/RestaurantReview.php';

    $server = 'mysql:host=localhost;dbname=cuisine_test';
        $username = 'root';
        $password = 'root';
        $DB = new PDO($server, $username, $password);

    class TestRestaurant extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
          {
              Restaurant::deleteAll();
              Cuisine::deleteAll();
              RestaurantReview::deleteAll();
          }

          function test_setName()
          {
              //Arrange
              $name = "Russian Cuisine";
              $id = null;
              $test_myCuisine = new Cuisine($name, $id);
              $test_myCuisine->save();

              $res_name = 'Kachka';
              $description = 'Yum yum!';
              $cuisine_id = $test_myCuisine->getCuisineID();
              $test_myRestaurant = new Restaurant($res_name, $id, $cuisine_id, $description);
              $test_myRestaurant->save();

              //Act
              $result = $test_myRestaurant->setName($res_name);

              //Assert
              $this->assertEquals($res_name, $result);
          }

        function test_getName()
        {
            //Arrange
            $name = "Russian Cuisine";
            $id = null;
            $test_myCuisine = new Cuisine($name, $id);
            $test_myCuisine->save();

            $res_name = 'Kachka';
            $cuisine_id = $test_myCuisine->getCuisineID();
            $description = 'Yum yum!';
            $test_myRestaurant = new Restaurant($res_name, $id, $cuisine_id, $description);
            $test_myRestaurant->save();

            //Act
            $result = $test_myRestaurant->getName($res_name);

            //Assert
            $this->assertEquals($res_name, $result);
        }

        function test_getID_ofRestaurant()
        {
            // Arrange
            $name = "Russian Cuisine";
            $id = null;
            $test_myCuisine = new Cuisine($name, $id);
            $test_myCuisine->save();

            $res_name = 'Kachka';
            $cuisine_id = $test_myCuisine->getCuisineID();
            $description = 'Yum yum!';
            $test_myRestaurant = new Restaurant($res_name, $id, $cuisine_id, $description);
            $test_myRestaurant->save();

            // Act
            $result = $test_myRestaurant->getRestaurantID();

            // Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_getCuisineID()
        {
            // Arrange
            $name = "Russian Cuisine";
            $id = null;
            $test_myCuisine = new Cuisine($name, $id);
            $test_myCuisine->save();

            $res_name = 'Kachka';
            $cuisine_id = $test_myCuisine->getCuisineID();
            $description = 'Yum yum!';
            $test_myRestaurant = new Restaurant($res_name, $id, $cuisine_id, $description);
            $test_myRestaurant->save();

            // Act
            $result = $test_myRestaurant->getRestaurantID();

            // Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_save()
        {
            //Arrange
            $name = "Russian Cuisine";
            $id = null;
            $test_myCuisine = new Cuisine($name, $id);
            $test_myCuisine->save();

            $res_name = 'Kachka';
            $cuisine_id = $test_myCuisine->getCuisineID();
            $description = 'Yum yum!';
            $test_myRestaurant = new Restaurant($res_name, $id, $cuisine_id, $description);
            $test_myRestaurant->save();

            //Act
            $result = Restaurant::getAll();

            //Assert
            $this->assertEquals([$test_myRestaurant], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $name = "Russian Cuisine";
            $id = null;
            $test_myCuisine = new Cuisine($name, $id);
            $test_myCuisine->save();

            $res_name = 'Kachka';
            $cuisine_id = $test_myCuisine->getCuisineID();
            $description = 'Yum yum!';
            $test_myRestaurant = new Restaurant($res_name, $id, $cuisine_id, $description);
            $test_myRestaurant->save();

            $res_name2 = 'Vladimir';
            $cuisine_id2 = $test_myCuisine->getCuisineID();
            $description = 'Yum yum!';
            $test_myRestaurant2 = new Restaurant($res_name2, $id, $cuisine_id2, $description);
            $test_myRestaurant2->save();

            //Act
            Restaurant::deleteAll();
            $result = Restaurant::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function test_find()//find just one restaurant in all cuisines
        {
            //Arrange
            $name = "Russian Cuisine";
            $id = null;
            $test_myCuisine = new Cuisine($name, $id);
            $test_myCuisine->save();

            $res_name = 'Kachka';
            $cuisine_id = $test_myCuisine->getCuisineID();
            $description = 'Yum yum!';
            $test_myRestaurant = new Restaurant($res_name, $id, $cuisine_id, $description);
            $test_myRestaurant->save();

            $res_name2 = 'Vladimir';
            $cuisine_id2 = $test_myCuisine->getCuisineID();
            $description = 'Yum yum!';
            $test_myRestaurant2 = new Restaurant($res_name2, $id, $cuisine_id2, $description);
            $test_myRestaurant2->save();

            //Act
            $result = Restaurant::find($test_myRestaurant->getRestaurantID());

            //Assert
            $this->assertEquals([$test_myRestaurant], $result);

        }

        function test_findReviews_inRestaurant()
        {
            //Arrange
            $name = 'Russian Cuisine';
            $test_myCuisine = new Cuisine($name);
            $test_myCuisine->save();

            $res_name = 'Kachka';
            $description = 'Yum yum!';
            $id = null;
            $cuisine_id = $test_myCuisine->getCuisineID();
            $test_myRestaurant = new Restaurant($res_name, $id, $cuisine_id, $description);
            $test_myRestaurant->save();

            $review = 'yum tastic';//this is a Review
            $res_id = $test_myRestaurant->getRestaurantID();
            $test_myReview = new RestaurantReview($review, null, $res_id);
            $test_myReview->save();

            $review2 = 'It was ok';//this is a Review
            $res_id = $test_myRestaurant->getRestaurantID();
            $test_myReview2 = new RestaurantReview($review2, null, $res_id);
            $test_myReview2->save();


            //Act
            $result = $test_myRestaurant->findReviews();

            //Assert
            $this->assertEquals([$test_myReview, $test_myReview2], $result);

        }

        function testUpdateRestaurant()
        {
            //Arrange
            $name = 'Mexican';
            $test_Cuisine = new Cuisine($name);
            $test_Cuisine->save();

            $res_name = "Por Que No";
            $id = null;
            $description = "very yummy tacos";
            $cuisine_id = $test_Cuisine->getCuisineID();
            $test_restaurant = new Restaurant($res_name, $id, $cuisine_id, $description);
            $test_restaurant->save();

            $new_res_name = "Por Que";
            $new_description = "yikes";

            //Act
            $test_restaurant->updateRestaurant($new_res_name, $new_description);
            // $result = Restaurant::getAll();

            //Assert
            $this->assertEquals(["Por Que", "yikes"], [$test_restaurant->getName(), $test_restaurant->getDescription()]);
        }


        function testDeleteRestaurants()
        {
            //Arrange
            $name = "Mexican";
            $id = null;
            $test_cuisine = new Cuisine($name, $id);
            $test_cuisine->save();

            $res_name = "Por Que No";
            $description = "yummy tacos";
            $cuisine_id = $test_cuisine->getCuisineID();
            $test_restaurant = new Restaurant($res_name, $id, $cuisine_id, $description);
            $test_restaurant->save();


            //Act
            $test_restaurant->delete();

            //Assert
            $this->assertEquals([], Restaurant::getAll());
        }

        function testDeleteOneRestaurant()
        {
            //Arrange
            $name = "Mexican";
            $id = null;
            $test_cuisine = new Cuisine($name, $id);
            $test_cuisine->save();

            $res_name = "Por Que No";
            $description = "yummy tacos";
            $cuisine_id = $test_cuisine->getCuisineID();
            $test_restaurant = new Restaurant($res_name, $id, $cuisine_id, $description);
            $test_restaurant->save();

            $res_name2 = "Javiers";
            $description2 = "quick food";
            $cuisine_id2 = $test_cuisine->getCuisineID();
            $test_restaurant2 = new Restaurant($res_name, $id, $cuisine_id, $description);
            $test_restaurant2->save();

            //Act
            $test_restaurant->deleteOneRestaurant();
            //Assert
            $this->assertEquals([$test_restaurant2], Restaurant::getAll());
        }

    }
?>
