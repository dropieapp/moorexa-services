<?php

// set the current version
header('x-service-version: 0.0.1');

// maintenance information
header('x-service-maintenance: ' . date('Y-m-d g:i:s', strtotime('+21 days')));
