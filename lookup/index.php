<?php
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST');

    //deny access to the script if it's not a post request
    if($_SERVER['REQUEST_METHOD'] != 'POST') {
        $data = array(
            'status' => 'error',
            'message' => 'Method not allowed',
            'code' => 405,
            "data" => array(
                'method' => $_SERVER['REQUEST_METHOD'],
                'uri' => $_SERVER['REQUEST_URI'],
                'ip' => $_SERVER['REMOTE_ADDR'],
            ),
        );
        echo json_encode($data);
        exit();
    }

    //deny access to the script if the request doesn't have the correct headers
    if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
        $data = array(
            'status' => 'error',
            'message' => 'Forbidden',
            'code' => 403,
            "data" => array(
                'method' => $_SERVER['REQUEST_METHOD'],
                'uri' => $_SERVER['REQUEST_URI'],
                'ip' => $_SERVER['REMOTE_ADDR'],
            ),
        );
        echo json_encode($data);
        exit();
    }
    
    $api_version = 'v10';
    $url_base = "https://discord.com/api/";
    $endpoint = '/users/';

    $discord_id = $_POST['discord_id'];
    $discord_token = "<Discord Bot Token>"; // Hardcoded for security reasons.

    $url = $url_base . $api_version . $endpoint . $discord_id;
    //url is built now we can make the request.
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bot ' . $discord_token));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    $response = json_decode($response, true);

    if((isset($response['message']))) {
        $data = array(
            'status' => 'error',
            'message' => 'User not found',
            'code' => 404,
            "data" => array(
                $response
            ),
        );
        echo json_encode($data);
        exit();
    }
    else{
        $flags = $response['public_flags'];

        $list = array(
            "1" => "Discord Employee",
            "2" => "Discord Partner",
            "4" => "HypeSquad Events",
            "8" => "Bug Hunter Level 1",
            "64" => "HypeSquad Bravery",
            "128" => "HypeSquad Brilliance",
            "256" => "HypeSquad Balance",
            "512" => "Early Supporter",
            "1024" => "Team User",
            "4096" => "System",
            "16384" => "Bug Hunter Level 2",
            "65536" => "Verified Bot",
            "131072" => "Early Verified Bot Developer",
            "262144" => "Discord Certified Moderator",
            "4194304" => "Active Developer",
        );

        function decodeFlags($flags, $list) {
            $flags = intval($flags);
            $result = array();
            foreach ($list as $key => $value) {
                if ($flags & $key) {
                    $result[] = $value;
                }
            }
            return $result;
        }

        $decoded = decodeFlags($flags, $list);

        $response['flags_listed'] = $decoded;
        if(empty($response['flags_listed'])){
            $response['flags_listed'] = "No public badges";
        }
        
        $output = array(
            'status' => 'success',
            'message' => 'User found',
            'code' => 200,
            'data' => array(
                $response
            )
        );
    }

    echo json_encode($output);
    exit();
?>