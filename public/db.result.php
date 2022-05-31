<?php
// *************************** connect to database **************** //

$db_server = 'localhost';
$db_user = 'root';
$db_password = '';
$db_name = 'dictionary';

$connect_db = mysqli_connect($db_server, $db_user, $db_password);
$dictionary = "CREATE DATABASE IF NOT EXISTS $db_name";
$db_create = mysqli_query($connect_db, $dictionary);


mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$reconnect = new mysqli($db_server, $db_user, $db_password, $db_name);
$reconnect->set_charset('utf8mb4');

$table_name = 'word_bank';

$word_bank = "CREATE TABLE IF NOT EXISTS $table_name (
	id int(11) not null PRIMARY KEY AUTO_INCREMENT,
    word varchar(128) not null,
    phonetic varchar(128) not null,
    definition varchar(2048) not null,
    sound varchar(512) not null
)";

$result = mysqli_query($reconnect, $word_bank) or die("Error, no cannot create table");

// *************************** fetch API data **************** //

$db_record_count_query = "SELECT COUNT(*) AS num_rows FROM `word_bank`";
$db_record_count_send = mysqli_query($reconnect, $db_record_count_query);
$db_result_count = mysqli_fetch_array($db_record_count_send);
?>

<?php if($db_result_count["num_rows"] < 1) : ?>
    <div>
        <p>No data in database. Go ahead and search API instead!</p>
    </div>
    <? return ?>
<?php endif ?>

<?php    
//end dbq

$sql = "SELECT * FROM $table_name";

$result = $reconnect->query($sql)->fetch_all(MYSQLI_ASSOC);

?>

<? //*** fetches all data from database table  ***/ ?>

<?php foreach ($result as $row) : ?>

<div class = 'mt-6 border-b-2 border-solid border-slate-300 pb-3'>
    <div class = 'mt-3 mb-3'><span class='font-semibold'>Word:</span> <?php echo $row['word'] ?></div>
    <div class = 'mt-3 mb-3'><span class='font-semibold'>Phonetic:</span> <?php echo $row['phonetic'] ?></div>
    <div class = 'mt-3'><span class='font-semibold'>Definitions:</span> <?php echo $row['definition'] ?></div>
    <br>
    <div class = 'mb-3'>
        <?php if($row['sound'] != null) : ?>
        <audio controls>
            <source src="<?php echo $row['sound'] ?>" type="audio/mpeg">
            Your browser does not support the audio tag.
        </audio>
        <?php else : ?>
        <div class='text-red-500'>No audo file to play</div>
        <?php endif ?>
    </div>
</div>

<?php endforeach ?>