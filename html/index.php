<?php

$page=isset($_GET['page']) ? $_GET['page']:'index';

include ('../pages/'.$page.'.php');

