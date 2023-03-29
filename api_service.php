<?php
include_once "/config/database.php";
include_once "class_users.php";
include_once "class_user_rights.php";


$method = $_SERVER['REQUEST_METHOD'];


if (in_array($method, array('PUT','DELETE','POST')))   {   $data = json_decode(file_get_contents("php://input"));  $object = $data->object;    }
if ($method == 'GET')                                  {   $data = $_GET;                                          $object = $_GET['object'];  }

$database = new Database();
$db = $database->getConnection();


if (!isset($object))
{
    header('HTTP/1.1 400');
    echo json_encode(array("message" => "Object is not defined."));
    exit();
}
else
{
    if ($object == 'user')
    {
        $obj_user = new Users($db);
    }
    if ($object == 'user_rights')
    {
        $obj_rights = new userRights($db);
    }
    
    switch ($method)
    {
        case "GET":
                if ($object == 'user')          showUser($obj_user, $data);
                if ($object == 'user_rights')   showRights($obj_rights, $data);
            break;
        case "POST":
                if ($object == 'user')          updateUser($obj_user, $data);
                if ($object == 'user_rights')   updateRights($obj_rights, $data);
            break;
        case "PUT":
                if ($object == 'user')          insertUser($obj_user, $data);
                if ($object == 'user_rights')   insertRights($obj_rights, $data);
            break;
        case "DELETE":
                if ($object == 'user')          deleteUser($obj_user, $data);
                if ($object == 'user_rights')   deleteRights($obj_rights, $data);
            break;
    }
}

function showRights($obj_rights, $data)
{
    $rights_arr = array();

    if (isset($data['user_id']))
    {
        $obj_rights->user_id = $data['user_id'];
        
        $res = $obj_rights->read();
        
        while ($row = $res->fetch_array())
        {
            $rights_item = array(
                'id' => $row['id'],
                'message' => $row['message'],
                'path' => $row['path'],
                'user_id' => $row['user_id'],
                'created' => $row['created'],
                'modified' => $row['modified']
            );
            //var_error_log($row);
            array_push($rights_arr, $rights_item);
        }

        if (count($rights_arr) > 0)
        {
            header('HTTP/1.1 200');
            echo json_encode($rights_arr);
        }
        else
        {
            header('HTTP/1.1 404');                    
            echo json_encode(array('message' => 'There are no rights in DB.'));
        }
    }
    else
    {
        header('HTTP/1.1 400');                    
        echo json_encode(array('message' => 'Incorrect request.'));
    }
}


function deleteUser($obj_user, $data)
{
    //var_error_log($data);
    
    if (isset($data->id))
    {
        $obj_user->id = $data->id;
        $count = $obj_user->delete();
        if ($count > 0)
        {
            header('HTTP/1.1 200');
            echo json_encode(array('message' => 'User deleted.'));
        }
        else
        {
            header('HTTP/1.1 409');                    
            echo json_encode(array('message' => 'Can`t delete user.'));
        }
    }
    else
    {
        header('HTTP/1.1 404');                    
        echo json_encode(array('message' => 'User not defined.'));
    }
}

function showUser($obj_user, $data)
{
    $users_arr = array();                

    if (isset($data['id']))
    {
        $obj_user->id = $data['id'];
        $res = $obj_user->readOne();
    }
    else
    {
        $res = $obj_user->read();
    }

    while ($row = $res->fetch_array())
    {
        $user_item = array(
            'id' => $row['id'],
            'name' => $row['name'],
            'login' => $row['login'],
            'pass' => $row['pass'],
            'created' => $row['created'],
            'modified' => $row['modified']
        );
        //var_error_log($row);
        array_push($users_arr, $user_item);
    }
    
    if (count($users_arr) > 0)
    {
        header('HTTP/1.1 200');
        echo json_encode($users_arr);
    }
    else
    {
        header('HTTP/1.1 404');                    
        echo json_encode(array('message' => 'There are no users in DB.'));
    }
}

function updateUser($obj_user, $data)
{
    $obj_user->id = $data->id;
    $obj_user->name = $data->name;
    $obj_user->login = $data->login;
    $obj_user->pass = $data->pass;
    $obj_user->modified = date('Y-m-d H:i:s');
    
    //var_error_log($data);
    
    if ($obj_user->id > 0  &&  $obj_user->name != '')
    {
        if ($obj_user->update())
        {
            header('HTTP/1.1 200');
            echo json_encode(array('message' => 'User updated. Оperation completed.'));
        }
        else
        {
            header('HTTP/1.1 409');                    
            echo json_encode(array('message' => 'Can`t update user. Operation failed.'));
        }
    }
}
function insertUser($obj_user, $data)
{
    if ($id = $obj_user->create())
    {
        header('HTTP/1.1 201');                    
        echo json_encode(array('message' => 'User added.', 'id' => $id));
    }
    else
    {
        header('HTTP/1.1 409');                    
        echo json_encode(array('message' => 'Can`t add user. Operation failed.'));
    }
}






function var_error_log( $object=null )
{
    ob_start();                    // start buffer capture
    var_dump( $object );           // dump the values
    $contents = ob_get_contents(); // put the buffer into a variable
    ob_end_clean();                // end capture
    error_log( $contents );        // log contents of the result of var_dump( $object )
}
    

    
    
    
    
    