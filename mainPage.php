
 <!DOCTYPE html>



<html lang="en">
<head>
	<title>Login V1</title>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->

	<link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->


    <?php
                 
    $servername = "localhost";
    $username = "root";
    $dbname = "social_db";
    $conn = new mysqli($servername, $username,"",$dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    else
    {
        session_start();

        $_SESSION['removeFriendCount'] = 0;
        $friends = explode(',', $_SESSION['friendList']);
        $friendArray = array();

        foreach($friends AS $word)
        {
            array_push($friendArray,$word);
        }

        $friendNameArray = array();
        $k = 0;

        if(isset($_SESSION['friendList']))
        {
            foreach($friendArray AS $friendID)
            {
                $friendNameArray[$k] = array();
                //Get first name
    
                $sql = "SELECT first_name FROM accounts WHERE ID LIKE '$friendID';";
                
                $result = mysqli_query($conn, $sql);
                
                $row = mysqli_fetch_row($result);
    
                $friendFirstName = $row[0];
    
                //Get last name
    
                $sql = "SELECT last_name FROM accounts WHERE ID LIKE '$friendID';";
                
                $result = mysqli_query($conn, $sql);
                
                $row = mysqli_fetch_row($result);
    
                $friendLastName = $row[0];
    
                //Store data
    
                array_push($friendNameArray[$k],$friendFirstName);
                array_push($friendNameArray[$k],$friendLastName);
    
                $k = $k + 1;
            }

            //Load timeline data
            
            $sql = "SELECT * FROM timeline;";
                
            $result = mysqli_query($conn, $sql);

            $timelineData = array();
            $timelineCount = 0;

            $friends = explode(',', $_SESSION['friendList']);
            $friendArray = array();
    
            foreach($friends AS $word)
            {
                array_push($friendArray,$word);
            }

            while ($row = mysqli_fetch_row($result))
            {   
                foreach($friendArray as $temp)
                {
                    $timelineData[$timelineCount] = array();
                    if($temp == $row[1])
                    {
                        $sql = "SELECT first_name,last_name FROM accounts WHERE ID LIKE '$row[1]';";
                        $nameResult = mysqli_query($conn, $sql);
                        
                        $names = mysqli_fetch_row($nameResult);
                        
                        $timelineData[$timelineCount][0] = $names[0];
                        $timelineData[$timelineCount][1] = $names[1];
                        $timelineData[$timelineCount][2] = $row[2];
        
                        $timelineCount++;  

                    }
                }

                if($row[1] == $_SESSION['userID'])
                {
                    $timelineData[$timelineCount][0] = $_SESSION['firstName'];
                    $timelineData[$timelineCount][1] = $_SESSION['lastName'];
                    $timelineData[$timelineCount][2] = $row[2];

                    $timelineCount++;  
                }
            }
        }
        else
        {
           
        }
    }

    ?>

<?php

    if(array_key_exists('searchButton', $_POST)) { 
        searchButton();
    } 
    if(array_key_exists('postButton', $_POST)) { 
        postButton();
    } 


    function postButton()
    {
        $servername = "localhost";
        $username = "root";
        $dbname = "social_db";
        $conn = new mysqli($servername, $username,"",$dbname);
    
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        else
        {
            if(isset($_POST["postButton"]))
            {
                $userID = $_SESSION['userID'];
                $timelineText = $_POST['post-text-area'];

                $sql = "INSERT INTO timeline(ID,timeline_text) VALUES ('$userID','$timelineText');";
                
                $result = mysqli_query($conn, $sql);

            }

        }
        header('Location: mainPage.php');

    }
    function searchButton()
    {
        $servername = "localhost";
        $username = "root";
        $dbname = "social_db";
        $conn = new mysqli($servername, $username,"",$dbname);
    
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        else
        {
            if(isset($_POST["searchBar"]))
            {
                $searchBarText = $_POST['searchBar'];

                $searchNameArray = explode(' ',$searchBarText);
                
                if(isset($searchNameArray[1]))
                {
                    $sql = "SELECT ID FROM accounts WHERE first_name LIKE '$searchNameArray[0]' AND last_name LIKE '$searchNameArray[1]';";
                
                    $result = mysqli_query($conn, $sql);
                    
                    if (mysqli_num_rows($result) > 0) 
                    {
                        $row = mysqli_fetch_row($result);
                        $newFriendID = $row[0];

                        echo $newFriendID;

                        if($newFriendID >0)
                        {
                            $_SESSION['friendList'] = $newFriendID  .','. $_SESSION['friendList'];
                        }
                         
                        $sql = "UPDATE accounts SET friendList="." '". $_SESSION['friendList'] . "'" . " WHERE ID =" . $_SESSION['userID'] . ";";
                        
                        $result = mysqli_query($conn, $sql);

                        header('Location: mainPage.php');
                    }
                }
            }
       
        }
    }

?>


</head>
<body>
	
<div class="limiter">
    <div class="container-login100">
        <img src ="images/avatar.png" class="avatar">
        <div class= "avatar-name">
            <?php echo $_SESSION['firstName'] . " " . $_SESSION['lastName'] ?>       
        </div>

        <div class="friends-list">
            <table class="friends-Table">
                <th class="friendHeader">Friends list</th>
                <tr>
                <?php
                if($k>1)
                {
                    for($i=0;$i<$k;$i++)
                    {
                        if($friendNameArray[$i][0] !='')
                        {
                            echo "<td class = 'friend-cell'>" . $friendNameArray[$i][0];
                            echo "<td class = 'friend-cell'>" . $friendNameArray[$i][1];
                            echo "<tr>";
                        }

                    }
                }
                else
                {
                    echo "<td>You have no friends.";
                }

                ?>
            </table>    

        </div>

        <div class="wrap">
            <div class="search">
                <form  action="" method = "post">
                    <input type="text"  name="searchBar" class="searchTerm" placeholder="Who are you looking for?">
                    
                    <button type="submit" value ="searchButton" name="searchButton" class="searchButton">
                        <img src = "images/searchIcon.png" class ="searchIcon">
                        <i class="fa fa-search"></i>
                    </button>
                </input>
            </div>
        </div>     


        <div class="wrap-timeline">
            <div class = "timeline-title">
                Timeline
            </div>
            <div class="timeline-content">
                <table class="timeline-table">
                    <?php
                        if(isset($timelineCount))
                        {
                            for($i=$timelineCount-1;$i>=0;$i--)
                            {
                                echo "<tr><td class='timeline-name'>" . $timelineData[$i][0] . " " .  $timelineData[$i][1];
                                echo "<tr><td>" . $timelineData[$i][2];
                                echo "<br><br>";
                            }
                        }
                    ?>
                  </table>
            </div>
            
        </div>
        
        <form action="" method="post">
            <button name = "postButton" class="post-button">Post</button>
            <div class ="text-area-info">Post something on your timeline.</div>

            <div class="post-container">
                <textarea maxlength="2000" name="post-text-area" rows="4" cols="50" placeholder="Write here." class ="post-areaText"></textarea>
            </div>
        </form>
        

        
    </div>
</div>
	

</body>
</html>