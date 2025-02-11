<?php

require '../inc/dbcon.php';

function error422($message){

    $data = [
        'status' => 422,
        'message' => $message,
    ];
    header('HTTP/1.0 422 Unable to process entity');
    echo json_encode($data);
    exit();
}

function storeStudent($studentInput){
    
    global $conn;

    $fullname = mysqli_real_escape_string($conn, $studentInput ['fullname']);
    $studentid = mysqli_real_escape_string($conn, $studentInput ['studentid']);
    $password = mysqli_real_escape_string($conn, $studentInput ['password']);
    $department = mysqli_real_escape_string($conn, $studentInput ['department']);

    if(empty(trim($fullname))){

        return error422('Enter your full name');

    }elseif(empty(trim($studentid))){
        
        return error422('Enter your student id');

    }elseif(empty(trim($password))){

        return error422('Enter your password');

    }elseif(empty(trim($department))){

        return error422('Enter your department');

    }
    else{
        $query = "INSERT INTO students (fullname,studentid,password,department) VALUES ('$fullname', $studentid, '$password', '$department')";
        $result = mysqli_query($conn, $query);

        if($result){

            $data = [
                'status' => 201,
                'message' => 'Student created successful',
            ];
            header('HTTP/1.0 201 Created');
            return json_encode($data);

        }else{

            $data = [
                'status' => 500,
                'message' => 'Server Error',
            ];
            header('HTTP/1.0 500 Server Error');
            return json_encode($data);
        }
    }
}



function getStudentList(){

    global $conn;

    $query = "SELECT * FROM students";
    $query_run = mysqli_query($conn, $query);

    if($query_run){

        if(mysqli_num_rows($query_run) > 0) {

            $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);

            $data = [
                'status' => 200,
                'message' => 'Students list fetch complete',
                'data' => $res
            ];
            header('HTTP/1.0 200 OK');
            return json_encode($data);

        }else{
            $data = [
                'status' => 404,
                'message' => 'No students found',
            ];
            header('HTTP/1.0 404 No students found');
            return json_encode($data);
        }

    }
    else{
        $data = [
            'status' => 500,
            'message' => 'Server Error',
        ];
        header('HTTP/1.0 500 Server Error');
        return json_encode($data);

    }

}

function getStudent($studentParams){

    global $conn;

    if($studentParams['id'] == null){
        return error422('Enter id number');
    }

    $studentId = mysqli_real_escape_string($conn, $studentParams['id']);

    $query = "SELECT * FROM students WHERE id='$studentId' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if($result){

        if(mysqli_num_rows($result) == 1){

            $res = mysqli_fetch_assoc($result);
            
            $data = [
                'status' => 200,
                'message' => 'Student Fetch Successful',
                'data' => $res
            ];
            header('HTTP/1.0 200 OK');
            return json_encode($data);
        }
        else{
            $data = [
                'status' => 404,
                'message' => 'No student found',
            ];
            header('HTTP/1.0 404 Not found');
            return json_encode($data);
        }
        
    }else{
        $data = [
            'status' => 500,
            'message' => 'Server Error',
        ];
        header('HTTP/1.0 500 Server Error');
        return json_encode($data);

    }
}

function updateStudent($studentInput, $studentParams){
    
    global $conn;

    if(!isset($studentParams['id'])){

        return error422('Id not found in the URL');

    }elseif($studentParams['id'] == null){

        return error422('Enter id number');
    }

    $studentId = mysqli_real_escape_string($conn, $studentParams['id']);

    $fullname = mysqli_real_escape_string($conn, $studentInput ['fullname']);
    $studentid = mysqli_real_escape_string($conn, $studentInput ['studentid']);
    $password = mysqli_real_escape_string($conn, $studentInput ['password']);
    $department = mysqli_real_escape_string($conn, $studentInput ['department']);

    if(empty(trim($fullname))){

        return error422('Enter your full name');

    }elseif(empty(trim($studentid))){
        
        return error422('Enter your student id');

    }elseif(empty(trim($password))){

        return error422('Enter your password');

    }elseif(empty(trim($department))){

        return error422('Enter your department');

    }
    else{
        $query = "UPDATE students SET fullname='$fullname', studentid='$studentid', password='$password', department='$department' WHERE id='$studentId' LIMIT 1";
        $result = mysqli_query($conn, $query);

        if($result){

            $data = [
                'status' => 200,
                'message' => 'Student updated successful',
            ];
            header('HTTP/1.0 200 Success');
            return json_encode($data);

        }else{

            $data = [
                'status' => 500,
                'message' => 'Server Error',
            ];
            header('HTTP/1.0 500 Server Error');
            return json_encode($data);
        }
    }
}

function deleteStudent($studentParams){

    global $conn;

    if(!isset($studentParams['id'])){

        return error422('Id not found in the URL');

    }elseif($studentParams['id'] == null){

        return error422('Enter id number');
    }

    $studentId = mysqli_real_escape_string($conn, $studentParams['id']);

    $query = "DELETE FROM students WHERE id ='$studentId' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if($result){

        $data = [
            'status' => 200,
            'message' => 'Student succcessfully deleted',
        ];
        header('HTTP/1.0 200 OK');
        return json_encode($data);

    }
    else{

        $data = [
            'status' => 404,
            'message' => 'Student not found',
        ];
        header('HTTP/1.0 404 Not found');
        return json_encode($data);
    }
}

?>