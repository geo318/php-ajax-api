<?php

$keyword = addslashes($_REQUEST['data'])
;

// *************************** connect to database **************** //

$db_server = 'localhost';
$db_user = 'root';
$db_password = '';
$db_name = 'dictionary';

$dictionary = "CREATE DATABASE IF NOT EXISTS $db_name";

// connect to check if database exists
$connect = mysqli_connect($db_server, $db_user, $db_password);
$db_create = mysqli_query($connect, $dictionary);

$reconnect = mysqli_connect($db_server, $db_user, $db_password, $db_name);
$table_name = 'word_bank';

$word_bank = "CREATE TABLE IF NOT EXISTS $table_name (
	id int(11) not null PRIMARY KEY AUTO_INCREMENT,
    word varchar(128) not null,
    phonetic varchar(128) not null,
    definition varchar(2048) not null,
    sound varchar(512) not null
)";

//checks if exists and creates - if not -> connects to database table
$result = mysqli_query($reconnect, $word_bank) or die("error");

// *************************** fetch API data **************** //

$db_record_count_query = "SELECT COUNT(*) AS num_rows FROM `word_bank` WHERE word ='{$keyword}' LIMIT 1";
$db_record_count_send = mysqli_query($reconnect, $db_record_count_query);
$db_result_count = mysqli_fetch_array($db_record_count_send);

// if there is no existing keyword entry in database , then calls api and writes data into database table
?>

<?php if($db_result_count["num_rows"] < 1) {


$url = "https://api.dictionaryapi.dev/api/v2/entries/en/$keyword";
$curl = curl_init($url);
$headers = array(
    "User-Agent: ReqBin Curl Client/1.0",
);

curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

$response = curl_exec($curl);

$status =  curl_getinfo($curl, CURLINFO_HTTP_CODE); // returns status code

curl_close($curl);

$data = json_decode($response, true);

// *********** end of data fetch using curl **************** //
?>

<?php if(!isset($data[0]['word'])) : ?> 
    <p class='m-8'>Keyword not found in database. Please, check your spelling.</p>
    <?php return ?>
<?php endif ?>

<?php
//addslashes enable to escape certain characters that might cause errors
$keyword = addslashes($data[0]['word']);
$phonetic = addslashes($data[0]['phonetic'] ?? $phonetic = null);
$definition = addslashes($data[0]['meanings'][0]['definitions'][0]['definition']);
isset($data[0]['phonetics'][0]['audio']) ? $sound = $data[0]['phonetics'][0]['audio'] : (isset($data[0]['phonetics'][1]['audio']) ? $sound = $data[0]['phonetics'][1]['audio'] : $sound = null);

$sound_dir = null;

if($sound) {
    //saves sound files into sounds folder and saves its directory into database
    $file_arr = explode('/', $sound); 
    $file_name = end($file_arr);
    $create_file = fopen($file_name, "w");

    $dir = 'sounds/';

    if(!is_dir($dir)) {
        mkdir($dir,'0777',true);
    }

    $sound_dir = $dir . $file_name;

    $sound_file = file_put_contents($file_name, file_get_contents($sound));

    rename($file_name,$sound_dir);
}

$new_row = "INSERT into $table_name (word, phonetic, definition, sound) values (
    '$keyword',
    '$phonetic',
    '$definition',
    '$sound_dir'
)";

$insert_row = mysqli_query($reconnect, $new_row);
}

//**** db ****//


// then program executes query to select data from the database table
$lookup = "SELECT * FROM $table_name WHERE word = '$keyword' LIMIT 1";
$result_lookup = mysqli_query($reconnect, $lookup);
$result_array = mysqli_fetch_array($result_lookup);

?>

<?php //********** the result entry from database table is retruned to front and fetched with AJAX request/response  ***********/ ?>

<div class = 'mt-6 mb-4'>
    <div class = 'mt-3 mb-3'><span class='font-semibold'>Word:</span> <?php echo $result_array['word'] ?></div>
    <div class = 'mt-3 mb-3'><span class='font-semibold'>Phonetic:</span> <?php echo $result_array['phonetic'] ?></div>
    <div class = 'mt-3'><span class='font-semibold'>Definitions:</span> <?php echo $result_array['definition'] ?></div>
    <br>
    <div class = ''>
        <?php if($result_array['sound'] != null) : ?>
        <audio controls>
            <source src="<?php echo $result_array['sound'] ?>" type="audio/mpeg">
            Your browser does not support the audio tag.
        </audio>
        <?php else : ?>
        <div class='text-red-500'>No audo file to play</div>
        <?php endif ?>
    </div>
</div>