<?php

namespace api;
use mysqli;
require __DIR__ . '/SourceQuery/bootstrap.php';

use xPaw\SourceQuery\SourceQuery;

$servername = "";
$username = "";
$password = "";
$database = "";

class db
{
    function get_latest_records()
    {
        global $servername, $username, $password, $database;
        $conn = new mysqli($servername, $username, $password, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT
            RANK() OVER (PARTITION BY t.MapId, t.CategoryId ORDER BY t.`Time`) AS Rank,
            m.id AS MapId,
            m.Name AS MapName,
            c.id AS CategoryId,
            c.Name AS CategoryName,
            u.id AS UserId,
            u.Name AS UserName,
            u.AuthId,
            u.Nationality,
            t.`Time`,
            t.RecordDate,
            t.StartSpeed
        FROM
            Times t
        JOIN
            Categories c ON c.id = t.CategoryId
        JOIN
            Maps m ON m.id = t.MapId
        JOIN
            Users u ON u.id = t.UserId
        ORDER BY
            RecordDate DESC
        LIMIT 50;";

        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $records = array();
            while ($row = $result->fetch_assoc()) {
                array_push($records, array(
                    'userId' => $row["UserId"],
                    'rank' => $row["Rank"],
                    'mapId' => $row["MapId"],
                    'map' => $row["MapName"],
                    'categoryId' => $row["CategoryId"],
                    'category' => $row["CategoryName"],
                    'name' => $row["UserName"],
                    'steamid' => $row["AuthId"],
                    'nationality' => $row["Nationality"],
                    'time' => $this->formatMilliseconds($row["Time"]),
                    'recorddate' => $row["RecordDate"],
                    'startspeed' => $row["StartSpeed"],
                ));
            }
            $conn->close();
            return json_encode($records);
        } else {
            $conn->close();
            return "0";
        }
        
    }

    function get_player($id)
    {
        global $servername, $username, $password, $database;
        $conn = new mysqli($servername, $username, $password, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Define the SQL query with placeholders for the player's ID
        $sql = "
        SELECT
            u.id,
            u.Name,
            u.AuthId,
            u.Nationality,
            pt.time_played AS TimeDr,
            ptb.time_played AS TimeBhop,
            (SELECT COUNT(*) FROM Times WHERE UserId = ?) AS Runs,
            RankedUsers.Rank,
            RankedUsers.Score,
            RankedUsers.Bronze,
            RankedUsers.Silver,
            RankedUsers.Gold
        FROM Users u
        LEFT JOIN played_time pt ON u.Name = pt.name
        LEFT JOIN played_time_bhop ptb ON u.Name = ptb.name
        LEFT JOIN (
            SELECT
            	UserId,
                RANK() OVER (ORDER BY Score DESC) AS Rank,
                Score,
                Bronze,
                Silver,
                Gold
            FROM Ranking
        ) AS RankedUsers ON RankedUsers.UserId = u.id
        WHERE u.id = ?;
         ";

        // Prepare the statement
        $stmt = $conn->prepare($sql);

        // Bind the player's ID to the placeholders
        $stmt->bind_param("ii", $id, $id);

        // Execute the query
        $stmt->execute();

        // Get the result set
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $info = array(
                'id' => $row["id"],
                'name' => $row["Name"],
                'steamid' => $row["AuthId"],
                'nationality' => $row["Nationality"],
                'rank' => $row["Rank"],
                'score' => $row["Score"],
                'bronze' => $row["Bronze"],
                'silver' => $row["Silver"],
                'gold' => $row["Gold"],
                'time' => $this->formatSeconds(intval($row["TimeDr"]) + intval($row["TimeBhop"])),
                'runs' => $row["Runs"],
            );
            // Close the statement and connection
            $stmt->close();
            $conn->close();
            return json_encode($info);
        } else {
            // Return an error message indicating that the user doesn't exist
            $errorInfo = array(
                'error' => 'User not found'
            );
            // Close the statement and connection
            $stmt->close();
            $conn->close();
            return json_encode($errorInfo);
        }

        
    }

    function get_player_records($id)
    {
        global $servername, $username, $password, $database;
        $conn = new mysqli($servername, $username, $password, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Define the SQL query with a placeholder for the player's name
        $sql = "
    SELECT
        (
            SELECT COUNT(*)
            FROM Times t2
            WHERE t2.MapId = t.MapId
            AND t2.CategoryId = t.CategoryId
            AND t2.`Time` < t.`Time`
        ) + 1 AS Rank,
        m.id AS MapId,
        m.Name AS MapName,
        c.Name AS CategoryName,
        c.id AS CategoryId,
        t.`Time`,
        t.RecordDate,
        t.StartSpeed
    FROM
        Times t
    JOIN
        Maps m ON t.MapId = m.id
    JOIN
        Categories c ON t.CategoryId = c.id
    WHERE
        t.UserId = ? 
    ORDER BY
        m.id, c.id
    ";

        // Prepare the statement
        $stmt = $conn->prepare($sql);

        // Bind the player's name to the placeholder
        $stmt->bind_param("i", $id);

        // Execute the query
        $stmt->execute();

        // Get the result set
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $records = array();
            $id = 0;
            while ($row = $result->fetch_assoc()) {
                array_push($records, array(
                    'id' => $id,
                    'rank' => $row["Rank"],
                    'mapId' => $row["MapId"],
                    'map' => $row["MapName"],
                    'category' => $row["CategoryName"],
                    'categoryId' => $row["CategoryId"],
                    'time' => $this->formatMilliseconds($row["Time"]),
                    'recorddate' => $row["RecordDate"],
                    'startspeed' => $row["StartSpeed"],
                ));
                $id++;
            }
            // Close the statement and connection
            $stmt->close();
            $conn->close();
            return json_encode($records);
        } else {
            // Close the statement and connection
            $stmt->close();
            $conn->close();
            return "0";
        }

        
    }

    function get_player_medals($id)
    {
        global $servername, $username, $password, $database;
        $conn = new mysqli($servername, $username, $password, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Define the SQL query with a placeholder for the player's name
        $sql = "SELECT MapId, m.Name as MapName, Bronze, Silver, Gold FROM Player_Medals pm JOIN Maps m ON m.id = pm.MapId WHERE pm.UserId = ?;";

        // Prepare the statement
        $stmt = $conn->prepare($sql);

        // Bind the player's name to the placeholder
        $stmt->bind_param("i", $id);

        // Execute the query
        $stmt->execute();

        // Get the result set
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $records = array();
            $id = 0;
            while ($row = $result->fetch_assoc()) {
                array_push($records, array(
                    'mapId' => $row["MapId"],
                    'map' => $row["MapName"],
                    'bronze' => $row["Bronze"],
                    'silver' => $row["Silver"],
                    'gold' => $row["Gold"],
                ));
                $id++;
            }
            return json_encode($records);
        } else {
            return "0";
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    }

    function get_player_activity($id, $table)
    {
        global $servername, $username, $password, $database;
        $conn = new mysqli($servername, $username, $password, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Define the SQL query with a placeholder for the player's name
        $sql = "SELECT pti.date_join, pti.date_left FROM Users u LEFT JOIN $table pti ON u.Name = pti.name WHERE u.id = ? AND pti.date_join > NOW() - INTERVAL 30 DAY;";

        // Prepare the statement
        $stmt = $conn->prepare($sql);

        // Bind the player's name to the placeholder
        $stmt->bind_param("i", $id);

        // Execute the query
        $stmt->execute();

        // Get the result set
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $activity = array();
            while ($row = $result->fetch_assoc()) {
            	$date_join = new \DateTime( $row["date_join"] );
		        $date_left = new \DateTime( $row["date_left"] );
		
                array_push($activity, array(
                    'date_join' => $row["date_join"],
                    'date_left' => $row["date_left"],
                    'time' => $date_left->getTimestamp() - $date_join->getTimestamp()
                ));
   
            }
            return json_encode($activity);
        } else {
            return "0";
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    }

    function get_records($name, $steamid, $category, $map)
    {
        global $servername, $username, $password, $database;
        $conn = new mysqli($servername, $username, $password, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Define the SQL query with placeholders
        $sql = "SELECT
        m.id AS MapId,
        m.Name AS MapName,
        c.Name AS CategoryName,
        u.id AS UserId,
        u.Name AS UserName,
        u.AuthId,
        u.Nationality,
        t.`Time`,
        t.RecordDate,
        t.StartSpeed
    FROM
        Times t
    JOIN
        Users u ON t.UserId = u.id
    JOIN
        Maps m ON t.MapId = m.id
    JOIN
        Categories c ON t.CategoryId = c.id
    WHERE
        INSTR(u.Name, ?)
    AND
        INSTR(u.AuthId, ?)
    AND 
        INSTR(c.Name, ?)
    AND
        INSTR(m.Name, ?)
    ORDER BY
        t.RecordDate DESC 
    LIMIT 15";

        // Prepare the statement
        $stmt = $conn->prepare($sql);

        // Bind the parameters to the placeholders
        $stmt->bind_param("ssss", $name, $steamid, $category, $map);

        // Execute the query
        $stmt->execute();

        // Get the result set
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $records = array();
            while ($row = $result->fetch_assoc()) {
                array_push($records, array(
                    'mapId' => $row["MapId"],
                    'map' => $row["MapName"],
                    'category' => $row["CategoryName"],
                    'userId' => $row["UserId"],
                    'name' => $row["UserName"],
                    'steamid' => $row["AuthId"],
                    'nationality' => $row["Nationality"],
                    'time' => $this->formatMilliseconds($row["Time"]),
                    'recorddate' => $row["RecordDate"],
                    'startspeed' => $row["StartSpeed"],
                ));
            }
            return json_encode($records);
        } else {
            return "0";
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    }
    function search_player($name)
    {
        global $servername, $username, $password, $database;
        $conn = new mysqli($servername, $username, $password, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "SELECT * FROM Users WHERE INSTR(Name,'" . $name . "') LIMIT 5";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $players = array();
            while ($row = $result->fetch_assoc()) {
                array_push($players, array(
                    'id' => $row["id"],
                    'name' => $row["Name"],
                    'steamid' => $row["AuthId"],
                    'nationality' => $row["Nationality"],
                ));
            }
            echo json_encode($players);
        } else {
            echo "0";
        }
        $conn->close();
    }

    function get_map_records($id)
    {
        global $servername, $username, $password, $database;
        $conn = new mysqli($servername, $username, $password, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Initialize an empty result array
        $resultArray = array();

        // Query to retrieve the top 15 records for each category on the specified map
        $sql = "WITH RankedRecords AS (
    SELECT
        t.id AS Id,
        RANK() OVER(PARTITION BY t.CategoryId ORDER BY t.`Time`) AS Rank,
        c.id AS CategoryId,
        c.Name AS CategoryName,
        u.id AS UserId,
        u.Name AS UserName,
        u.AuthId,
        u.Nationality,
        t.`Time`,
        t.RecordDate,
        t.StartSpeed
    FROM
        Times t
    JOIN
        Users u ON t.UserId = u.id
    JOIN
        Categories c ON t.CategoryId = c.id
    WHERE
        t.MapId = ?
)
SELECT
    Id,
    Rank,
    CategoryId,
    CategoryName,
    UserId,
    UserName,
    AuthId,
    Nationality,
    `Time`,
    RecordDate,
    StartSpeed
FROM
    RankedRecords
WHERE
    Rank <= 15
ORDER BY
    CategoryName ASC, Rank ASC;
    ";

        // Prepare the statement
        $stmt = $conn->prepare($sql);

        // Bind the MapId to the placeholder
        $stmt->bind_param("i", $id);

        // Execute the query
        $stmt->execute();

        // Get the result set
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $categoryName = $row["CategoryName"];

                // Create a new category entry if it doesn't exist in the result array
                if (!isset($resultArray[$categoryName])) {
                    $resultArray[$categoryName] = array();
                }

                // Add the record to the category's top 15 list
                $resultArray[$categoryName][] = array(
                    'id' => $row['Id'],
                    'rank' => $row["Rank"],
                    'userId' => $row["UserId"],
                    'name' => $row["UserName"],
                    'categoryId' => $row["CategoryId"],
                    'steamid' => $row["AuthId"],
                    'nationality' => $row["Nationality"],
                    'time' => $this->formatMilliseconds($row["Time"]),
                    'recorddate' => $row["RecordDate"],
                    'startspeed' => $row["StartSpeed"],
                );
            }
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();

        // Return the result array as JSON
        return json_encode($resultArray);
    }

    function get_map_name($id)
    {
        global $servername, $username, $password, $database;
        $conn = new mysqli($servername, $username, $password, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "SELECT * FROM Maps WHERE id = ?";
        // Prepare the statement
        $stmt = $conn->prepare($sql);

        // Bind the MapId to the placeholder
        $stmt->bind_param("i", $id);

        // Execute the query
        $stmt->execute();

        // Get the result set
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return json_encode($row["Name"]);
        } else {
            return "Invalid Map";
        }
        $conn->close();
    }

    function get_maps()
    {
        global $servername, $username, $password, $database;
        $conn = new mysqli($servername, $username, $password, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "SELECT * FROM Maps";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $maps = array();
            while ($row = $result->fetch_assoc()) {
                array_push($maps, array(
                    'id' => $row["id"],
                    'name' => $row["Name"],
                ));
            }
            return json_encode($maps);
        } else {
            return "0";
        }
        $conn->close();
    }

    function get_category_name($id)
    {
        global $servername, $username, $password, $database;
        $conn = new mysqli($servername, $username, $password, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "SELECT * FROM Categories WHERE id = ?";
        // Prepare the statement
        $stmt = $conn->prepare($sql);

        // Bind the MapId to the placeholder
        $stmt->bind_param("i", $id);

        // Execute the query
        $stmt->execute();

        // Get the result set
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return json_encode($row["Name"]);
        } else {
            return "Invalid Category";
        }
        $conn->close();
    }

    function delete_player($id, $rank1Records)
    {
        global $servername, $username, $password, $database;
        $conn = new mysqli($servername, $username, $password, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Iterate through the rank1Records array
        foreach ($rank1Records as $record) {
            $category = isset($record['category']) ? $record['category'] : 'N/A';
            $map = isset($record['map']) ? $record['map'] : 'N/A';
            unlink('/home/csgfxeu/public_html/uploads/recording/'.$map.'/'.'['.$category.'].rec');
        }

        // Define the SQL query with placeholders
        $sql = "DELETE FROM Times WHERE UserId = ?";
    
        // Prepare the statement
        $stmt = $conn->prepare($sql);

        // Bind the parameters to the placeholders
        $stmt->bind_param("i", $id);

        // Execute the query
        $stmt->execute();

        // Close the statement and connection
        $stmt->close();
        $conn->close();

        return "Succes!";
    }


    function delete_time($id)
    {
        global $servername, $username, $password, $database;
        $conn = new mysqli($servername, $username, $password, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Define the SQL query with placeholders
        $sql = "DELETE FROM Times WHERE id = ?";

        // Prepare the statement
        $stmt = $conn->prepare($sql);

        // Bind the parameters to the placeholders
        $stmt->bind_param("i", $id);

        // Execute the query
        $stmt->execute();
        // Get the result set
        $result = $stmt->get_result();

        // Close the statement and connection
        $stmt->close();
        $conn->close();

        return "Success!";
    }

     // Login Logic
     function login_token($token)
     {
         global $servername, $username, $password, $database;
         $conn = new mysqli($servername, $username, $password, $database);
         if ($conn->connect_error) {
             die("Connection failed: " . $conn->connect_error);
         }
 
         $sql = "SELECT name FROM Users_Panel WHERE token = ?;";
 
         // Prepare the statement
         $stmt = $conn->prepare($sql);
 
         // Bind the player's name to the placeholder
         $stmt->bind_param("s", $token);
 
         // Execute the query
         $stmt->execute();
 
         // Get the result set
         $result = $stmt->get_result();
         if ($result->num_rows > 0) {
             // Close the statement and connection
             $stmt->close();
             $conn->close();
 
             return json_encode("Success!");
         } else {
             // Close the statement and connection
             $stmt->close();
             $conn->close();
 
             return False;
         }
     }
 
     function login($email, $pass)
     {
         global $servername, $username, $password, $database;
         $conn = new mysqli($servername, $username, $password, $database);
         if ($conn->connect_error) {
             die("Connection failed: " . $conn->connect_error);
         }
 
         $sql = "SELECT name FROM Users_Panel WHERE email = ? AND password = ?;";
 
         // Prepare the statement
         $stmt = $conn->prepare($sql);
 
         // Bind the player's name to the placeholder
         $stmt->bind_param("ss", $email, $pass);
 
         // Execute the query
         $stmt->execute();
 
         // Get the result set
         $result = $stmt->get_result();
         if ($result->num_rows > 0) {
             $row = $result->fetch_assoc();
 
             // Close the statement and connection
             $stmt->close();
             $conn->close();
 
             $token = $this->generate_token(32);
             $this->update_token_by_email($email, $token);
             
             return 
                 array(
                     'name' => $row["name"], 
                     'token' => $token
                 );
         } else {
             // Close the statement and connection
             $stmt->close();
             $conn->close();
 
             return -1;
         }
     }
    function generate_token($length)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $token = '';

        for ($i = 0; $i < $length; $i++) {
            $token .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $token;
    }
    
    function update_token_by_email( $email, $token )
    {
        global $servername, $username, $password, $database;
        $conn = new mysqli($servername, $username, $password, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "UPDATE Users_Panel SET token = ? WHERE email = ?";

        // Prepare the statement
        $stmt = $conn->prepare($sql);

        // Bind the player's name to the placeholder
        $stmt->bind_param("ss", $token, $email);

        // Execute the query
        $stmt->execute();
    }
     

    function get_servers_info()
    {
        $servers[] = $this->get_server_info("193.84.64.85", 27015);
        $servers[] = $this->get_server_info("190.115.197.245", 27015);
        $servers[] = $this->get_server_info("93.114.82.74", 27015);

        return $servers;
    }

    function get_server_info($ip, $port)
    {
        $Query = new SourceQuery( );

        try
        {
            $Query->Connect( $ip, $port, 1, SourceQuery::GOLDSOURCE );

            return $Query->GetInfo( );
        }
        catch( Exception $e )
        {
            echo $e->getMessage( );
        }
        finally
        {
            $Query->Disconnect( );
        }
    }

    function get_top()
    {
        global $servername, $username, $password, $database;
        $conn = new mysqli($servername, $username, $password, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "
        SELECT r.UserId, u.Name, u.Nationality, r.Score, r.Bronze, r.Silver, r.Gold 
            FROM Ranking r 
            JOIN Users u ON u.id = r.UserId 
            ORDER BY Score DESC 
            LIMIT 50;";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $maps = array();
            while ($row = $result->fetch_assoc()) {
                array_push($maps, array(
                    'id' => $row["UserId"],
                    'name' => $row["Name"],
                    'nationality' => $row["Nationality"],
                    'score' => $row["Score"],
                    'bronze' => $row["Bronze"],
                    'silver' => $row["Silver"],
                    'gold' => $row["Gold"],
                ));
            }
            return json_encode($maps);
        } else {
            return "0";
        }
        $conn->close();
    }

    function formatMilliseconds($milliseconds) {
        // Calculate minutes and seconds
        $seconds = floor($milliseconds / 1000);
        $minutes = floor($seconds / 60);
        $seconds %= 60;

        // Calculate milliseconds
        $milliseconds %= 1000;

        // Format the time as "m:s.ms"
        return sprintf("%d:%02d.%03d", $minutes, $seconds, $milliseconds);
    }

    function formatSeconds($seconds) {
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);

        return sprintf("%02d:%02d", $hours, $minutes);
    }


}

function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}