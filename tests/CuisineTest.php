<!-- testing with php unit, use this template for guidance -->
<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once __DIR__ . '/../src/Cuisine.php';

    $server = 'mysql:host=localhost;dbname=cuisine_test';
        $username = 'root';
        $password = 'root';
        $DB = new PDO($server, $username, $password);

    class TestCuisine extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
          {
              Cuisine::deleteAll();
              Restaurant::deleteAll();
              RestaurantReview::deleteAll();
          }

        function test_getName_ofCuisine()
        {
            // Arrange
            $name = 'Mexican Food';
            $test_myCuisine = new Cuisine($name);

            // Act
            $result = $test_myCuisine->getName($name);

            // Assert
            $this->assertEquals($name, $result);
        }

        function test_setName_ofCuisine()
        {
            //Arrange
            $name = 'Mexican Food';
            $test_myCuisine = new Cuisine($name);

            //Act
            $result = $test_myCuisine->setName($name);

            //Assert
            $this->assertEquals($name, $result);
        }

        function test_getCuisineID_ofCuisine()
        {
            //Arrange
            $name = 'Mexican Food';
            $id = 1;
            $test_myCuisine = new Cuisine($name, $id);

            //Act
            $result = $test_myCuisine->getCuisineID();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_save()
        {
            //Arrange
            $name = 'Mexican Food';
            $test_myCuisine = new Cuisine($name);
            $test_myCuisine->save();

            //Act
            $result = Cuisine::getAll();

            //Assert
            $this->assertEquals($test_myCuisine, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $name = 'Mexican Food';
            $test_myCuisine = new Cuisine($name);
            $test_myCuisine->save();
            $name2 = 'Russian Food';
            $test_myCuisine2 = new Cuisine($name2);
            $test_myCuisine2->save();

            //Act
            $result = Cuisine::getAll();

            //Assert
            $this->assertEquals([$test_myCuisine, $test_myCuisine2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $name = 'Mexican Food';
            $test_myCuisine = new Cuisine($name);
            $test_myCuisine->save();
            $name2 = 'Russian Food';
            $test_myCuisine2 = new Cuisine($name2);
            $test_myCuisine2->save();

            //Act
            Cuisine::deleteAll();
            $result = Cuisine::getAll();

            //Assert
            $this->assertEquals([], $result);

        }

        function test_find()//finds all cuisines
        {
            //Arrange
            $name = 'Mexican Food';
            $test_myCuisine = new Cuisine($name);
            $test_myCuisine->save();
            $name2 = 'Russian Food';
            $test_myCuisine2 = new Cuisine($name2);
            $test_myCuisine2->save();

            //Act
            $result = Cuisine::find($test_myCuisine->getCuisineID());

            //Assert
            $this->assertEquals($test_myCuisine, $result);

        }

        function test_findRestaurant_InCuisine()
        {
            //Arrange
            $name = 'Russian Food'; //Cuisine Type
            $test_myCuisine = new Cuisine($name);
            $test_myCuisine->save();

            $res_name = 'Kachka';
            $description = 'Yum yum!';
            $id = null;
            $cuisine_id = $test_myCuisine->getCuisineID();
            $test_myRestaurant = new Restaurant($res_name, $id, $cuisine_id, $description);
            $test_myRestaurant->save();

            $res_name2 = 'Vladimirs';
            $description2 = 'You get nothing else!';
            $id = null;
            $cuisine_id = $test_myCuisine->getCuisineID();
            $test_myRestaurant2 = new Restaurant($res_name2, $id, $cuisine_id, $description2);
            $test_myRestaurant2->save();

            //Act
            $result = $test_myCuisine->findRestaurant_InCuisine();

            //Assert
            $this->assertEquals([$test_myRestaurant, $test_myRestaurant2], $result);
        }

        function testUpdate()
        {
            //Arrange
            $name = "Mexican";
            $id = null;
            $test_cuisine = new Cuisine($name, $id);
            $test_cuisine->save();

            $new_name = "German";

            //Act
            $test_cuisine->update($new_name);

            //Assert
            $this->assertEquals("German", $test_cuisine->getName());
        }

        function testDelete()
        {
            //Arrange
            $name = "Mexican";
            $id = null;
            $test_cuisine = new Cuisine($name, $id);
            $test_cuisine->save();

            $name2 = "Thai";
            $test_cuisine2 = new Cuisine($name2, $id);
            $test_cuisine2->save();


            //Act
            $test_cuisine->delete();

            //Assert
            $this->assertEquals([$test_cuisine2], Cuisine::getAll());
        }

        function testDelete_CuisineRestaurants()
        {
            //Arrange
            $name = "Mexican";
            $id = null;
            $test_cuisine = new Cuisine($name, $id);
            $test_cuisine->save();

            $res_name = "Javiers";
            $description = "A fast dining experience, open ";
            $cuisine_id = $test_cuisine->getCuisineId();
            $test_restaurant = new Restaurant($res_name, $id = null, $cuisine_id, $description);
            $test_restaurant->save();


            //Act
            $test_cuisine->delete();

            //Assert
            $this->assertEquals([], Restaurant::getAll());
        }
    }
?>
