<?php

return array (
  '001a0a8928dbf12f49e39aa20af9122c' => 
  array (
    'query' => 'SELECT * FROM delivery_methods WHERE delivery_methodid = :delivery_methodid ',
    'bind' => 
    array (
      'delivery_methodid' => '2',
    ),
  ),
  '2605d598b47ea055dd94228d10761c80' => 
  array (
    'query' => 'SELECT * FROM pickup_requests WHERE riderid = :riderid and approved = :approved ',
    'bind' => 
    array (
      'riderid' => '1',
      'approved' => 0,
    ),
  ),
  '08630777f1c8f647ab70631dd74e8631' => 
  array (
    'query' => 'SELECT amount, sender_fullname, dateadded, tracking_number FROM pickup_requests WHERE riderid = :riderid and approved = :approved ',
    'bind' => 
    array (
      'riderid' => '1',
      'approved' => 0,
    ),
  ),
  '2aeec6a190c14b286ad9042d549fa235' => 
  array (
    'query' => 'SELECT * FROM pickup_requests WHERE riderid = :riderid and approved = :approved ',
    'bind' => 
    array (
      'riderid' => '1',
      'approved' => 1,
    ),
  ),
  '9a7456cc38e349ab48d113bf9ba89522' => 
  array (
    'query' => 'SELECT * FROM pickup_requests WHERE riderid = :riderid and completed = :completed ',
    'bind' => 
    array (
      'riderid' => 1,
      'completed' => 1,
    ),
  ),
  '5576947697472713665d0cd3c8578a5a' => 
  array (
    'query' => 'SELECT * FROM pickup_requests WHERE sender_handshake_code = :sender_handshake_code ',
    'bind' => 
    array (
      'sender_handshake_code' => '7ceebffdf8',
    ),
  ),
  '7d0d25006d0667260f46092e337e9ebd' => 
  array (
    'query' => 'SELECT * FROM pickup_requests WHERE sender_handshake_code = :sender_handshake_code ',
    'bind' => 
    array (
      'sender_handshake_code' => '2e4dd3ba98',
    ),
  ),
  'f62bbcde73293f86e2e514a7e8e9b4f5' => 
  array (
    'query' => 'SELECT * FROM delivery_rates WHERE current_day = :current_day ',
    'bind' => 
    array (
      'current_day' => '2021-05-03',
    ),
  ),
  '9bc4e18c932146522a65311745c3e92e' => 
  array (
    'query' => 'SELECT * FROM delivery_methods WHERE visible = :visible ',
    'bind' => 
    array (
      'visible' => 1,
    ),
  ),
  'a1753c79b9522e9a958bca45711a450b' => 
  array (
    'query' => 'SELECT * FROM pickup_requests WHERE dispatch_code = :dispatch_code and riderid = :riderid ',
    'bind' => 
    array (
      'dispatch_code' => '9153',
      'riderid' => '1',
    ),
  ),
);
