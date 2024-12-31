<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="main">
        <h2>TO DO List</h2>
        <form action="" method="POST">
            <input type="text" name="Task" placeholder = "Enter a task">
            <button type="submit" name="Add_task"> Add Task</button>
        </form>
    </div>
   
    <?php
        include 'Db.php';
            
        if(isset($_POST['Add_task'])){
            $task = $_POST['Task'];
            
            insert($connection, $dbname,$tableName,$task);
            
        }
        function insert($connection, $dbname,$tableName,$task)
        {
            $connection->select_db($dbname);
            $insetsql = $connection->prepare("INSERT INTO $tableName (Task) VALUES (?)");
            $insetsql->bind_param("s", $task);
            if($insetsql->execute()){
                echo "New task Added";
                select($connection, $dbname, $tableName);
            }
            else{
                echo "fail to add the task";
            }
            $insetsql->close();
            
        }
        
        function select($connection, $dbname, $tableName) {
            $connection->select_db($dbname);
            $selectSql = "SELECT * FROM $tableName";   
            $result = $connection->query($selectSql);

            echo "<table>";
            echo "<thead>
                    <tr>
                        <th>Task</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>";

            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['Task']) . "</td>";
                    echo "<td class='task-buttons'>
                            <form method='POST' style='display:inline;'>
                                <button type='submit' name='Complete' id='Complete' value='" . $row['id'] . "'>Complete</button>
                            </form>
                            <form method='POST' style='display:inline;'>
                                <button type='submit' name='Delete' id='Delete' value='" . $row['id'] . "'>Delete</button>
                            </form>
                            </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='2'>No tasks added.</td></tr>";
            }

            echo "</tbody></table>";
            
        }
        function Delete($connection, $dbname,$tableName){
            $taskId = $_POST['Delete'];
                $connection->select_db($dbname);
                $deletesql = $connection->prepare("DELETE  FROM $tableName WHERE id = ?");
                $deletesql->bind_param("i",$taskId);
                $deletesql->execute();
                select($connection, $dbname, $tableName);
            
        }
        if(isset($_POST['Delete'])){
            Delete($connection, $dbname,$tableName);
        }
        function compelete($connection, $dbname,$tableName){
            $taskId = $_POST['Complete'];
            $connection->select_db($dbname);
            $updatesql = $connection->prepare("UPDATE $tableName SET Task = CONCAT(Task, ' (Completed)') WHERE id = ?");
            $updatesql->bind_param("i",$taskId);
            $updatesql->execute();
            $updatesql->close();
            select($connection, $dbname, $tableName);
        }
        if(isset($_POST['Complete'])){
            compelete($connection, $dbname,$tableName);
        }
        
    ?>
</body>
</html>