<?php
$regions = [
    "aws-0-us-east-1", "aws-0-us-east-2", "aws-0-us-west-1", "aws-0-us-west-2",
    "aws-0-ap-northeast-1", "aws-0-ap-northeast-2", "aws-0-ap-northeast-3",
    "aws-0-ap-southeast-1", "aws-0-ap-southeast-2", "aws-0-ap-south-1",
    "aws-0-eu-west-1", "aws-0-eu-west-2", "aws-0-eu-west-3", "aws-0-eu-central-1", "aws-0-eu-central-2",
    "aws-0-eu-north-1", "aws-0-eu-south-1", "aws-0-eu-south-2",
    "aws-0-me-central-1", "aws-0-me-south-1", "aws-0-sa-east-1", "aws-0-af-south-1"
];

$dbname = "postgres";
$user = "postgres.iaptqzvkebjplpadabtx";
$password = "VjD6Y1D7J0T1kG5E";

foreach ($regions as $region) {
    $host = "$region.pooler.supabase.com";
    echo "Testing $host (port 5432)...\n";
    try {
        $dsn = "pgsql:host=$host;port=5432;dbname=$dbname;sslmode=require";
        $pdo = new PDO($dsn, $user, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_TIMEOUT => 5
        ]);
        echo "SUCCESS: Connected to $host!\n";
        exit(0);
    } catch (PDOException $e) {
        $msg = $e->getMessage();
        if (strpos($msg, "Password authentication failed") !== false) {
             echo "FOUND REGION: $host (but password failed)\n";
        } elseif (strpos($msg, "Tenant or user not found") === false && strpos($msg, "timeout") === false) {
            echo "RESPONSE from $host: $msg\n";
        }
    }
}

foreach ($regions as $region) {
    $host = "$region.pooler.supabase.com";
    echo "Testing $host (port 6543)...\n";
    try {
        $dsn = "pgsql:host=$host;port=6543;dbname=$dbname;sslmode=require";
        $pdo = new PDO($dsn, $user, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_TIMEOUT => 5
        ]);
        echo "SUCCESS: Connected to $host on 6543!\n";
        exit(0);
    } catch (PDOException $e) {
        $msg = $e->getMessage();
        if (strpos($msg, "Password authentication failed") !== false) {
             echo "FOUND REGION: $host (but password failed)\n";
        } elseif (strpos($msg, "Tenant or user not found") === false && strpos($msg, "timeout") === false) {
            echo "RESPONSE from $host: $msg\n";
        }
    }
}
echo "All regional poolers failed.\n";
?>
