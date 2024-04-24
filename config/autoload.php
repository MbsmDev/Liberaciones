<?php
function autoload ($classname)
{
    include CONTROLLERS . $classname .'.php';
}
spl_autoload_register('autoload');