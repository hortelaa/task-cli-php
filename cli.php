<?php
$arguments = $argv;
$arguments = array_slice($argv, 1);

$filePath = 'tasks.txt';
$lines = count(file($filePath));

function addTask($desc,$lines){
    $id = 0;
    if ($lines>0){
        $arrayAntigo = json_decode(file_get_contents('tasks.txt'),true);
        foreach($arrayAntigo as $key => $value){
            $arrayAntigo[$key]['id'] = $id;
            $id++;
        }
        $arrayNovo = array("id" => $id, "description" => $desc, "status" => "todo", "createdAt" => time(), "updatedAt" => time());
        $arrayAntigo[] = $arrayNovo;
        $jsonFinal = json_encode($arrayAntigo,true);
        file_put_contents("tasks.txt", $jsonFinal.PHP_EOL);
    }else{
        $line[] = ["id" => $id, "description" => $desc, "status" => "todo", "createdAt" => time(), "updatedAt" => time()];
        $line = json_encode($line,true);
        file_put_contents("tasks.txt", $line.PHP_EOL, FILE_APPEND | LOCK_EX);
    }
    return "Task added successfully (ID: $id) \n";
}

function updateTask($id, $desc){
    $arrays = json_decode(file_get_contents('tasks.txt'),true);
    $arrays[$id]['description'] = $desc;
    $arrays[$id]['updatedAt'] = time();
    $jsonFinal = json_encode($arrays,true);
    file_put_contents("tasks.txt", $jsonFinal.PHP_EOL);
    return "Task updated successfully (ID: $id) \n";
}

function deleteTask($id){
    $arrays = json_decode(file_get_contents('tasks.txt'),true);
    if (array_key_exists($id, $arrays)){
        unset($arrays[$id]);
        $jsonFinal = json_encode($arrays,true);
        file_put_contents("tasks.txt", $jsonFinal.PHP_EOL);
        return "Task deleted successfully (ID: $id) \n";
    }else{
        return "Failed to delete task (ID: $id) \n";
    }
}

function markInProgress($id){
    $arrays = json_decode(file_get_contents('tasks.txt'),true);
    if (array_key_exists($id, $arrays)){
        $arrays[$id]['status'] = 'in-progress';
        $jsonFinal = json_encode($arrays,true);
        file_put_contents("tasks.txt", $jsonFinal.PHP_EOL);
        return "Status changed successfully (ID: $id) \n";
    }else{
        return "Failed to find task (ID: $id) \n";
    }
}

function markDone($id){
    $arrays = json_decode(file_get_contents('tasks.txt'),true);
    if (array_key_exists($id, $arrays)){
        $arrays[$id]['status'] = 'done';
        $jsonFinal = json_encode($arrays,true);
        file_put_contents("tasks.txt", $jsonFinal.PHP_EOL);
        return "Status changed successfully (ID: $id) \n";
    }else{
        return "Failed to find task (ID: $id) \n";
    }
}

function listTasks($command1,$command2 = ""){
    $arrays = json_decode(file_get_contents('tasks.txt'),true);
    if(!empty($command1) & (!empty($command2)) & $command1 == "list" & $command2 == "done"){
        foreach ($arrays as $array){
            if($array['status'] == 'done'){
                print_r($array);
            }
        }
    }elseif (!empty($command1) & (!empty($command2)) & $command1 == "list" & $command2 == "todo"){
        foreach ($arrays as $array){
            if($array['status'] == 'todo'){
                print_r($array);
            }
        }
    }elseif(!empty($command1) & (!empty($command2)) & $command1 == "list" & $command2 == "in-progress"){
        foreach ($arrays as $array){
            if($array['status'] == 'in-progress'){
                print_r($array);
            }
        }
    }elseif(!empty($command1) & $command1 == "list"){
        print_r(json_decode(file_get_contents('tasks.txt'),true));
    }elseif(empty($arrays)){
        return "List is empty, consider adding a new task! \n";
    }
    else{
        return "Not a valid command, try (list todo, list done, list in-progress). \n";
    }
}

switch ($arguments[0]) {
    case 'add':
        echo addTask($arguments[1], $lines);
        break;
    case 'update':
        echo updateTask($arguments[1], $arguments[2]);
        break;
    case 'delete':
        echo deleteTask($arguments[1]);
        break;
    case 'list':
        if(isset($arguments[1]) == null){
            $arguments[1] = "Sem Parametro 2";
        }
        echo listTasks($arguments[0],$arguments[1]);
        break;
    case 'mark-in-progress':
        echo markInProgress($arguments[1]);
        break;
    case 'mark-done':
        echo markDone($arguments[1]);
        break;
}