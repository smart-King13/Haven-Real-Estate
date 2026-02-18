<?php
$host = "aws-0-eu-west-2.pooler.supabase.com";
$port = "6543";
$dbname = "postgres";
$user = "postgres.iaptqzvkebjplpadabtx";
$passwords = ["smartking70021", "VjD6Y1D7J0T1kG5E"];

foreach ($passwords as $password) {
    try {
        $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=require";
        echo "Testing $host on port $port with password: " . substr($password, 0, 4) . "...\n";
        $pdo = new PDO($dsn, $user, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_TIMEOUT => 5
        ]);
        echo "SUCCESS: Connected with password: " . substr($password, 0, 4) . "...\n";
        exit(0);
    } catch (PDOException $e) {
        echo "FAILURE: " . $e->getMessage() . "\n";
    }
}
?>
