<?php

namespace Kanboard\Plugin\MetaMagik\Schema;

use PDO;

const VERSION = 2;

function version_2(PDO $pdo)
{
    $pdo->exec('ALTER TABLE metadata_types ADD COLUMN options VARCHAR(255)');
}

function version_1(PDO $pdo)
{
    $pdo->exec('
        CREATE TABLE IF NOT EXISTS metadata_types (
          id INT PRIMARY KEY AUTO_INCREMENT,
          human_name VARCHAR(255) NOT NULL,
          machine_name VARCHAR(255) NOT NULL,
          data_type VARCHAR(50) NOT NULL,
          is_required TINYINT(1) DEFAULT 0,
          attached_to VARCHAR(50) NOT NULL,
          UNIQUE(machine_name, attached_to)
        ) ENGINE=InnoDB CHARSET=utf8
    ');

    $pdo->exec('
        CREATE TABLE IF NOT EXISTS metadata_has_type (
          id INT PRIMARY KEY AUTO_INCREMENT,
          type_id INT NOT NULL,
          metadata_id INT NOT NULL,
          FOREIGN KEY(type_id) REFERENCES metadata_types(id) ON DELETE CASCADE
        ) ENGINE=InnoDB CHARSET=utf8
    ');
}
