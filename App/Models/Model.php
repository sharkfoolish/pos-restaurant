<?php

namespace App\Models;

include 'env.php';

use \PDO;
use \PDOException;
use \Environment\Database as DB;

class Model
{
    protected static function connect() : object | null
    {
        try {
            $connection = new PDO(
                DB::$TYPE . ":host=" . DB::$HOST . ";dbname=" . DB::$NAME,
                DB::$USER,
                DB::$PASS
            );
            $connection->query("set names utf8");
            return $connection;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    // for where()
    static function __callStatic($function, $arguments)
    {
        $name = static::$name;
        $count = count($arguments);
        $sql = match ($count) {
            1 => "SELECT * FROM {$name} WHERE 1",
            2 => "SELECT * FROM {$name} WHERE {$arguments[0]} = '$arguments[1]'",
            4 => "SELECT * FROM {$name} WHERE {$arguments[0]} = '$arguments[1]' AND {$arguments[2]} = '$arguments[3]'",
            6 => "SELECT * FROM {$name} WHERE {$arguments[0]} = '$arguments[1]' AND {$arguments[2]} = '$arguments[3]' 
                      AND {$arguments[4]} = '$arguments[5]'"
        };
        $connection = Model::connect();
        $state = $connection->prepare($sql);
        if (!$state->execute()) {
            return null;
        } else {
            return $state->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public static function save($data) : bool
    {
        $name = static::$name;
        $sql = "INSERT INTO {$name} (" . implode(', ', array_keys($data)) . ") VALUES (:" . implode(', :', array_keys($data)) . ")";
        $connection = Model::connect();
        return $connection->prepare($sql)->execute($data);
    }

    public static function update($data, $condition) : bool
    {
        $name = static::$name;
        $sql = "UPDATE {$name} SET ";
        foreach ($data as $key => $value) {
            $sql .= "`" . $key . "` = '" . $value . "'";
        }
        $sql .= " WHERE ";
        foreach ($condition as $key => $value) {
            $sql .= "`" . $key . "` = '" . $value . "'";
        }
        $connection = Model::connect();
        return $connection->prepare($sql)->execute();
    }
    public static  function delete($key, $value) : bool
    {
        $name = static::$name;
        $sql = "DELETE FROM {$name} WHERE {$key} = {$value}";
        $connection = Model::connect();
        return $connection->prepare($sql)->execute();
    }
}
