<?php
require_once 'db/config.php';

function getPDO()
{
    return db();
}
