<?php

return array (
  'b2fba9268194e7dcb0d19f6368b72eeb' => 
  array (
    'query' => 'SELECT * FROM session_storage WHERE session_identifier = :session_identifier AND user_agent = :user_agent  ',
    'bind' => 
    array (
      'session_identifier' => '52b7a47a1a_state-manager',
      'user_agent' => '48a49bc72423076a1c2400df983fd43a',
    ),
  ),
  'f2fe729756a93a45dd67e8926c835a41' => 
  array (
    'query' => 'SELECT * FROM session_storage {where}',
    'bind' => 
    array (
    ),
  ),
  'bd9b0bbcc349d8fbef5e253d9a2cdc2f' => 
  array (
    'query' => 'UPDATE session_storage SET session_value = :session_value  WHERE session_identifier = :session_identifier AND user_agent = :user_agent  ',
    'bind' => 
    array (
      'session_value' => 'czo4MDoiOyJzOjY0OiJhQnUyc0h6dWlvNEVUZHR1V0Vpd1BLOHR3d0d5UkZ2bWZVRVlsN3NVaHB1L0M3S1NTQzhuU1hKZTRvOTNPd1dDIjsiOjI3OnMiOw==',
      'session_identifier' => '52b7a47a1a_state-manager',
      'user_agent' => '48a49bc72423076a1c2400df983fd43a',
    ),
  ),
  '1f627ad6170d6a882e58b48dfbb979b3' => 
  array (
    'query' => 'SELECT * FROM delivery_methods WHERE delivery_methodid = :delivery_methodid ',
    'bind' => 
    array (
      'delivery_methodid' => '2',
    ),
  ),
  'f6bad2077b61ee1edb30df158ffbd6c6' => 
  array (
    'query' => 'SELECT * FROM coupon_codes WHERE coupon_code = :coupon_code and isavaliable = :isavaliable ',
    'bind' => 
    array (
      'coupon_code' => 0,
      'isavaliable' => 1,
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
  '7bc2d5f767bf3a90f299ecfa10aa6aa8' => 
  array (
    'query' => 'SELECT * FROM pickup_requests WHERE customerid = :customerid AND riderid = :riderid AND amount = :amount AND sender_fullname = :sender_fullname AND sender_telephone = :sender_telephone AND reciever_fullname = :reciever_fullname AND reciever_telephone = :reciever_telephone AND delivery_methodid = :delivery_methodid AND pickup_address = :pickup_address AND pickup_coordinates = :pickup_coordinates AND dropoff_address = :dropoff_address AND dropoff_coordinates = :dropoff_coordinates AND package_hint = :package_hint AND coupon_code = :coupon_code AND package_quantity = :package_quantity AND extra_tip = :extra_tip AND reference = :reference AND tracking_number = :tracking_number  ',
    'bind' => 
    array (
      'customerid' => '1',
      'riderid' => '1',
      'amount' => '335',
      'sender_fullname' => 'Amadi Ifeanyi',
      'sender_telephone' => '07017170555',
      'reciever_fullname' => 'frank ogwu',
      'reciever_telephone' => '08018180555',
      'delivery_methodid' => '2',
      'pickup_address' => 'Ayetobi Road, Lagos, Nigeria',
      'pickup_coordinates' => '{\\"latitude\\":6.648493600000002,\\"longitude\\":3.2497105}',
      'dropoff_address' => 'no 3 Kaslat Avenue, Lagos, Nigeria',
      'dropoff_coordinates' => '{\\"latitude\\":6.6551475,\\"longitude\\":3.252895}',
      'package_hint' => 'no hint',
      'coupon_code' => '0',
      'package_quantity' => '1',
      'extra_tip' => '0',
      'reference' => 'vhd2734s2q',
      'tracking_number' => 'DEX89841',
    ),
  ),
  'd0a54cb4b7b2afd8a75f85b27e769449' => 
  array (
    'query' => 'SELECT * FROM pickup_requests WHERE tracking_number = :tracking_number ',
    'bind' => 
    array (
      'tracking_number' => 'DEX89841',
    ),
  ),
  '8391b8638e293fe16729edf2234e865d' => 
  array (
    'query' => 'SELECT * FROM pickup_requests WHERE riderid = :riderid and approved = :approved ',
    'bind' => 
    array (
      'riderid' => '1',
      'approved' => 0,
    ),
  ),
  'bca16003bba282dab4029de590f34015' => 
  array (
    'query' => 'SELECT amount, sender_fullname, dateadded, tracking_number FROM pickup_requests WHERE riderid = :riderid and approved = :approved ',
    'bind' => 
    array (
      'riderid' => '1',
      'approved' => 0,
    ),
  ),
  '163b8601123413f71d84d34498a9ddcf' => 
  array (
    'query' => 'SELECT * FROM pickup_requests WHERE riderid = :riderid and approved = :approved ',
    'bind' => 
    array (
      'riderid' => '1',
      'approved' => 1,
    ),
  ),
  'd1c1aa0c5d25e689bce145fd43a776ca' => 
  array (
    'query' => 'SELECT * FROM pickup_requests WHERE riderid = :riderid AND tracking_number = :tracking_number  ',
    'bind' => 
    array (
      'riderid' => '1',
      'tracking_number' => 'DEX89841',
    ),
  ),
  '94f16ca03732d0a20bc8cbaddbc06191' => 
  array (
    'query' => 'UPDATE pickup_requests SET approved = :approved , dispatch_code = :dispatch_code , time_approved = :time_approved , sender_name = :sender_name  WHERE requestid = :requestid ',
    'bind' => 
    array (
      'approved' => '1',
      'dispatch_code' => '2137',
      'time_approved' => '1595403734',
      'sender_name' => 'Amadi Ifeanyi',
      'requestid' => '1',
    ),
  ),
  '1b78071ea29893e15f61aa1d30b44e4c' => 
  array (
    'query' => 'UPDATE pickup_requests SET approved = :approved , dispatch_code = :dispatch_code , time_approved = :time_approved , sender_name = :sender_name  WHERE requestid = :requestid ',
    'bind' => 
    array (
      'approved' => '1',
      'dispatch_code' => '0713',
      'time_approved' => '1595403759',
      'sender_name' => 'Amadi Ifeanyi',
      'requestid' => '1',
    ),
  ),
  'ff1c58985874f4edea0da118783bb34c' => 
  array (
    'query' => 'UPDATE pickup_requests SET approved = :approved , dispatch_code = :dispatch_code , time_approved = :time_approved , sender_name = :sender_name  WHERE requestid = :requestid ',
    'bind' => 
    array (
      'approved' => '1',
      'dispatch_code' => '8245',
      'time_approved' => '1595403822',
      'sender_name' => 'Amadi Ifeanyi',
      'requestid' => '1',
    ),
  ),
  '3c5b165f3ecad56ca2b2c2c80336e240' => 
  array (
    'query' => 'UPDATE pickup_requests SET approved = :approved , dispatch_code = :dispatch_code , time_approved = :time_approved , sender_name = :sender_name  WHERE requestid = :requestid ',
    'bind' => 
    array (
      'approved' => '1',
      'dispatch_code' => '0153',
      'time_approved' => '1595403832',
      'sender_name' => 'Amadi Ifeanyi',
      'requestid' => '1',
    ),
  ),
  'e7121be04ba4fe2186a8ec0cf8a14736' => 
  array (
    'query' => 'UPDATE pickup_requests SET approved = :approved , dispatch_code = :dispatch_code , time_approved = :time_approved , sender_name = :sender_name  WHERE requestid = :requestid ',
    'bind' => 
    array (
      'approved' => '1',
      'dispatch_code' => '1223',
      'time_approved' => '1595403833',
      'sender_name' => 'Amadi Ifeanyi',
      'requestid' => '1',
    ),
  ),
  '754398d028856a20bcff2e865a752d07' => 
  array (
    'query' => 'UPDATE pickup_requests SET approved = :approved , dispatch_code = :dispatch_code , time_approved = :time_approved  WHERE requestid = :requestid ',
    'bind' => 
    array (
      'approved' => '1',
      'dispatch_code' => '9153',
      'time_approved' => '1595403878',
      'requestid' => '1',
    ),
  ),
  '001a0a8928dbf12f49e39aa20af9122c' => 
  array (
    'query' => 'SELECT * FROM delivery_methods WHERE delivery_methodid = :delivery_methodid ',
    'bind' => 
    array (
      'delivery_methodid' => '2',
    ),
  ),
  '047bdaccf92b53a854e807a6ed3b2927' => 
  array (
    'query' => 'SELECT * FROM pickup_requests WHERE sender_handshake_code = :sender_handshake_code and dispatch_code = :dispatch_code ',
    'bind' => 
    array (
      'sender_handshake_code' => '333839391',
      'dispatch_code' => '7778',
    ),
  ),
  '02dff81e748834f897c9439ad7cd71d5' => 
  array (
    'query' => 'SELECT * FROM pickup_requests WHERE sender_handshake_code = :sender_handshake_code ',
    'bind' => 
    array (
      'sender_handshake_code' => '333839391',
    ),
  ),
  '204f20bd1452550a9bbd84786fa32a2c' => 
  array (
    'query' => 'SELECT * FROM pickup_requests WHERE sender_handshake_code = :sender_handshake_code and dispatch_code = :dispatch_code ',
    'bind' => 
    array (
      'sender_handshake_code' => '333839391',
      'dispatch_code' => '9153',
    ),
  ),
  '4dc72b61aed67b00d451d41c7d4840f8' => 
  array (
    'query' => 'UPDATE pickup_requests SET handshake_made = :handshake_made  WHERE requestid = :requestid ',
    'bind' => 
    array (
      'handshake_made' => '1',
      'requestid' => '1',
    ),
  ),
  'fabb9ce8f318a85ce55d738c0e4311b2' => 
  array (
    'query' => 'SELECT * FROM pickup_requests WHERE customerid = :customerid AND riderid = :riderid AND amount = :amount AND sender_fullname = :sender_fullname AND sender_telephone = :sender_telephone AND reciever_fullname = :reciever_fullname AND reciever_telephone = :reciever_telephone AND delivery_methodid = :delivery_methodid AND pickup_address = :pickup_address AND pickup_coordinates = :pickup_coordinates AND dropoff_address = :dropoff_address AND dropoff_coordinates = :dropoff_coordinates AND package_hint = :package_hint AND coupon_code = :coupon_code AND package_quantity = :package_quantity AND extra_tip = :extra_tip AND reference = :reference AND tracking_number = :tracking_number AND dateadded = :dateadded AND sender_handshake_code = :sender_handshake_code  ',
    'bind' => 
    array (
      'customerid' => '1',
      'riderid' => '1',
      'amount' => '755',
      'sender_fullname' => 'susan micheal',
      'sender_telephone' => '07017170555',
      'reciever_fullname' => 'odu sam',
      'reciever_telephone' => '08144234526',
      'delivery_methodid' => '2',
      'pickup_address' => '22 Kayode St, Abule ijesha 100001, Lagos, Nigeria',
      'pickup_coordinates' => '{\\"latitude\\":6.5241942,\\"longitude\\":3.3793648}',
      'dropoff_address' => 'No. 56 Ogundana Street Ogundana Street, Ikeja, Nigeria',
      'dropoff_coordinates' => '{\\"latitude\\":6.600318100000001,\\"longitude\\":3.358127699999999}',
      'package_hint' => 'no hint',
      'coupon_code' => '0',
      'package_quantity' => '1',
      'extra_tip' => '0',
      'reference' => 'lioa1z0m05',
      'tracking_number' => 'DEX54471',
      'dateadded' => '1595590920',
      'sender_handshake_code' => '89366ac66b',
    ),
  ),
  '3825ee5853a941cf65de7a0c9ac17c50' => 
  array (
    'query' => 'SELECT * FROM pickup_requests WHERE sender_handshake_code = :sender_handshake_code ',
    'bind' => 
    array (
      'sender_handshake_code' => '89366ac66b',
    ),
  ),
  '1354b4a9f891d2ee65363784b307a7b5' => 
  array (
    'query' => 'SELECT * FROM pickup_requests WHERE tracking_number = :tracking_number ',
    'bind' => 
    array (
      'tracking_number' => 'DEX54471',
    ),
  ),
  '164f657b748e2b45425a4a1968552a59' => 
  array (
    'query' => 'SELECT * FROM pickup_requests WHERE riderid = :riderid AND tracking_number = :tracking_number  ',
    'bind' => 
    array (
      'riderid' => '1',
      'tracking_number' => 'DEX54471',
    ),
  ),
  'ac0bc87a0c23aa47fe1eb52851579ccf' => 
  array (
    'query' => 'UPDATE pickup_requests SET approved = :approved , dispatch_code = :dispatch_code , time_approved = :time_approved  WHERE requestid = :requestid ',
    'bind' => 
    array (
      'approved' => '1',
      'dispatch_code' => '0096',
      'time_approved' => '1595590961',
      'requestid' => '4',
    ),
  ),
  '59162d368ac61aeeb47a6f023b619936' => 
  array (
    'query' => 'SELECT * FROM pickup_requests WHERE sender_handshake_code = :sender_handshake_code and dispatch_code = :dispatch_code ',
    'bind' => 
    array (
      'sender_handshake_code' => '89366ac66b',
      'dispatch_code' => '0096',
    ),
  ),
  '7c0d286959f5b86f347b1a313c7f9ed4' => 
  array (
    'query' => 'UPDATE pickup_requests SET handshake_made = :handshake_made  WHERE requestid = :requestid ',
    'bind' => 
    array (
      'handshake_made' => '1',
      'requestid' => '4',
    ),
  ),
  '30abbc971e88ed603abab27ce18ee26f' => 
  array (
    'query' => 'SELECT * FROM pickup_requests WHERE customerid = :customerid AND riderid = :riderid AND amount = :amount AND sender_fullname = :sender_fullname AND sender_telephone = :sender_telephone AND reciever_fullname = :reciever_fullname AND reciever_telephone = :reciever_telephone AND delivery_methodid = :delivery_methodid AND pickup_address = :pickup_address AND pickup_coordinates = :pickup_coordinates AND dropoff_address = :dropoff_address AND dropoff_coordinates = :dropoff_coordinates AND package_hint = :package_hint AND coupon_code = :coupon_code AND package_quantity = :package_quantity AND extra_tip = :extra_tip AND reference = :reference AND tracking_number = :tracking_number AND dateadded = :dateadded AND sender_handshake_code = :sender_handshake_code  ',
    'bind' => 
    array (
      'customerid' => '1',
      'riderid' => '1',
      'amount' => '705',
      'sender_fullname' => 'charles frank',
      'sender_telephone' => '07017170555',
      'reciever_fullname' => 'ugoma',
      'reciever_telephone' => '08144234526',
      'delivery_methodid' => '2',
      'pickup_address' => '21 Kayode St, Abule ijesha 100001, Lagos, Nigeria',
      'pickup_coordinates' => '{\\"latitude\\":6.5243793,\\"longitude\\":3.3792057}',
      'dropoff_address' => 'No. 56 Ogundana Street Ogundana Street, Ikeja, Nigeria',
      'dropoff_coordinates' => '{\\"latitude\\":6.600318100000001,\\"longitude\\":3.358127699999999}',
      'package_hint' => 'A cake',
      'coupon_code' => '0',
      'package_quantity' => '1',
      'extra_tip' => '0',
      'reference' => 'ogfx21738w',
      'tracking_number' => 'DEX41241',
      'dateadded' => '1595620470',
      'sender_handshake_code' => 'e7c6b72cef',
    ),
  ),
  '4a5521ec443c42c4a73dcfae1bb98866' => 
  array (
    'query' => 'SELECT * FROM pickup_requests WHERE sender_handshake_code = :sender_handshake_code ',
    'bind' => 
    array (
      'sender_handshake_code' => 'e7c6b72cef',
    ),
  ),
  '16893612e118ee3fe229cda7a3d7974d' => 
  array (
    'query' => 'SELECT * FROM pickup_requests WHERE tracking_number = :tracking_number ',
    'bind' => 
    array (
      'tracking_number' => 'DEX41241',
    ),
  ),
  'd33f105d6335235eb58e6bcb5f9dc1e0' => 
  array (
    'query' => 'SELECT * FROM pickup_requests WHERE riderid = :riderid AND tracking_number = :tracking_number  ',
    'bind' => 
    array (
      'riderid' => '1',
      'tracking_number' => 'DEX41241',
    ),
  ),
  '281b21a22d30735f32f8958e89669e4e' => 
  array (
    'query' => 'UPDATE pickup_requests SET approved = :approved , dispatch_code = :dispatch_code , time_approved = :time_approved  WHERE requestid = :requestid ',
    'bind' => 
    array (
      'approved' => '1',
      'dispatch_code' => '9184',
      'time_approved' => '1595620536',
      'requestid' => '6',
    ),
  ),
  'ea2dfdddf648b8b453893ea37c8c0ae1' => 
  array (
    'query' => 'SELECT * FROM pickup_requests WHERE sender_handshake_code = :sender_handshake_code and dispatch_code = :dispatch_code ',
    'bind' => 
    array (
      'sender_handshake_code' => 'e7c6b72cef',
      'dispatch_code' => '9184',
    ),
  ),
  '4cd596e172c4b8a32209f0a77c64c33f' => 
  array (
    'query' => 'UPDATE pickup_requests SET handshake_made = :handshake_made  WHERE requestid = :requestid ',
    'bind' => 
    array (
      'handshake_made' => '1',
      'requestid' => '6',
    ),
  ),
  'cfbe02885cfab973a9cdaf70176bdb7c' => 
  array (
    'query' => 'SELECT * FROM pickup_requests WHERE tracking_number = :tracking_number ',
    'bind' => 
    array (
      'tracking_number' => 'DEX96151',
    ),
  ),
  '93b33c57dd91c31e884a69b96cc1cf5d' => 
  array (
    'query' => 'SELECT * FROM pickup_requests WHERE riderid = :riderid AND tracking_number = :tracking_number  ',
    'bind' => 
    array (
      'riderid' => '1',
      'tracking_number' => 'DEX96151',
    ),
  ),
  'b4496f11d30782a259c4d661749f8b9a' => 
  array (
    'query' => 'UPDATE pickup_requests SET approved = :approved , dispatch_code = :dispatch_code , time_approved = :time_approved  WHERE requestid = :requestid ',
    'bind' => 
    array (
      'approved' => '1',
      'dispatch_code' => '0496',
      'time_approved' => '1595722728',
      'requestid' => '8',
    ),
  ),
  '063bc907dfe89712953fb2e52effe125' => 
  array (
    'query' => 'SELECT * FROM pickup_requests WHERE sender_handshake_code = :sender_handshake_code and dispatch_code = :dispatch_code ',
    'bind' => 
    array (
      'sender_handshake_code' => '38f8d9463e',
      'dispatch_code' => '0496',
    ),
  ),
  '5ba00f3689392fa435028ffa7a5d7b51' => 
  array (
    'query' => 'UPDATE pickup_requests SET handshake_made = :handshake_made  WHERE requestid = :requestid ',
    'bind' => 
    array (
      'handshake_made' => '1',
      'requestid' => '8',
    ),
  ),
  '4b365ef612eda08b13a7fff1bcf44c4b' => 
  array (
    'query' => 'SELECT * FROM pickup_requests WHERE customerid = :customerid AND riderid = :riderid AND amount = :amount AND sender_fullname = :sender_fullname AND sender_telephone = :sender_telephone AND reciever_fullname = :reciever_fullname AND reciever_telephone = :reciever_telephone AND delivery_methodid = :delivery_methodid AND pickup_address = :pickup_address AND pickup_coordinates = :pickup_coordinates AND dropoff_address = :dropoff_address AND dropoff_coordinates = :dropoff_coordinates AND package_hint = :package_hint AND coupon_code = :coupon_code AND package_quantity = :package_quantity AND extra_tip = :extra_tip AND reference = :reference AND tracking_number = :tracking_number AND dateadded = :dateadded AND sender_handshake_code = :sender_handshake_code  ',
    'bind' => 
    array (
      'customerid' => '1',
      'riderid' => '1',
      'amount' => '560',
      'sender_fullname' => 'charles frank',
      'sender_telephone' => '07017170555',
      'reciever_fullname' => 'odu sam',
      'reciever_telephone' => '08144234526',
      'delivery_methodid' => '2',
      'pickup_address' => '42 Onitsha Cres, Garki, Abuja, Nigeria',
      'pickup_coordinates' => '{\\"latitude\\":9.040509223937985,\\"longitude\\":7.5070495605468714}',
      'dropoff_address' => 'Vom Banex Plaza, Alexandria Crescent, Abuja, Nigeria',
      'dropoff_coordinates' => '{\\"latitude\\":9.083983299999998,\\"longitude\\":7.468987200000001}',
      'package_hint' => 'no hint',
      'coupon_code' => '0',
      'package_quantity' => '1',
      'extra_tip' => '0',
      'reference' => 'araqcq1e6e',
      'tracking_number' => 'DEX91231',
      'dateadded' => '1597075442',
      'sender_handshake_code' => '3498569ce2',
    ),
  ),
  'e6de34ff3bca5a153fe95fad89eb512f' => 
  array (
    'query' => 'SELECT * FROM pickup_requests WHERE sender_handshake_code = :sender_handshake_code ',
    'bind' => 
    array (
      'sender_handshake_code' => '3498569ce2',
    ),
  ),
  'ff7ca4ed0045437a4092b4167bff7c44' => 
  array (
    'query' => 'SELECT * FROM pickup_requests WHERE tracking_number = :tracking_number ',
    'bind' => 
    array (
      'tracking_number' => 'DEX91231',
    ),
  ),
  'c2056b48e9a293071342ef04d4012ba8' => 
  array (
    'query' => 'SELECT * FROM pickup_requests WHERE riderid = :riderid AND tracking_number = :tracking_number  ',
    'bind' => 
    array (
      'riderid' => '1',
      'tracking_number' => 'DEX91231',
    ),
  ),
  'a5c43167cd871200117402828ab99020' => 
  array (
    'query' => 'UPDATE pickup_requests SET approved = :approved , dispatch_code = :dispatch_code , time_approved = :time_approved  WHERE requestid = :requestid ',
    'bind' => 
    array (
      'approved' => '1',
      'dispatch_code' => '4315',
      'time_approved' => '1597075463',
      'requestid' => '9',
    ),
  ),
  'ea000d36c6b97fe3f418440d2d6e060a' => 
  array (
    'query' => 'SELECT * FROM pickup_requests WHERE sender_handshake_code = :sender_handshake_code and dispatch_code = :dispatch_code ',
    'bind' => 
    array (
      'sender_handshake_code' => '3498569ce2',
      'dispatch_code' => '4315',
    ),
  ),
  '3b44f08b5c04a5446461479c0880511d' => 
  array (
    'query' => 'UPDATE pickup_requests SET handshake_made = :handshake_made  WHERE requestid = :requestid ',
    'bind' => 
    array (
      'handshake_made' => '1',
      'requestid' => '9',
    ),
  ),
  '410a8b3cda2b0064a01870f79451d1ff' => 
  array (
    'query' => 'SELECT * FROM pickup_requests WHERE customerid = :customerid AND riderid = :riderid AND amount = :amount AND sender_fullname = :sender_fullname AND sender_telephone = :sender_telephone AND reciever_fullname = :reciever_fullname AND reciever_telephone = :reciever_telephone AND delivery_methodid = :delivery_methodid AND pickup_address = :pickup_address AND pickup_coordinates = :pickup_coordinates AND dropoff_address = :dropoff_address AND dropoff_coordinates = :dropoff_coordinates AND package_hint = :package_hint AND coupon_code = :coupon_code AND package_quantity = :package_quantity AND extra_tip = :extra_tip AND reference = :reference AND tracking_number = :tracking_number AND dateadded = :dateadded AND sender_handshake_code = :sender_handshake_code  ',
    'bind' => 
    array (
      'customerid' => '1',
      'riderid' => '1',
      'amount' => '490',
      'sender_fullname' => 'charles frank',
      'sender_telephone' => '07017170555',
      'reciever_fullname' => 'Sandra adam',
      'reciever_telephone' => '08144234526',
      'delivery_methodid' => '2',
      'pickup_address' => '274 Ebitu Ukiwe St, Jabi, Abuja, Nigeria',
      'pickup_coordinates' => '{\\"latitude\\":9.066650006392214,\\"longitude\\":7.4310834653296665}',
      'dropoff_address' => 'Wuse 2, Abuja, Nigeria',
      'dropoff_coordinates' => '{\\"latitude\\":9.078749000000002,\\"longitude\\":7.4701862}',
      'package_hint' => 'no hint',
      'coupon_code' => '0',
      'package_quantity' => '1',
      'extra_tip' => '0',
      'reference' => 'tocgwx03rk',
      'tracking_number' => 'DEX66311',
      'dateadded' => '1599744708',
      'sender_handshake_code' => 'd8118c0ebd',
    ),
  ),
  '14866c928570ca2d172851dd88058aa0' => 
  array (
    'query' => 'SELECT * FROM pickup_requests WHERE sender_handshake_code = :sender_handshake_code ',
    'bind' => 
    array (
      'sender_handshake_code' => 'd8118c0ebd',
    ),
  ),
  'a55c4e9e6d831a2c7cc84adf1f71a9f0' => 
  array (
    'query' => 'SELECT * FROM pickup_requests WHERE tracking_number = :tracking_number ',
    'bind' => 
    array (
      'tracking_number' => 'DEX66311',
    ),
  ),
  '4284ad22ef2356cb9038dcc90580fa90' => 
  array (
    'query' => 'SELECT * FROM pickup_requests WHERE riderid = :riderid AND tracking_number = :tracking_number  ',
    'bind' => 
    array (
      'riderid' => '1',
      'tracking_number' => 'DEX66311',
    ),
  ),
  'c2869fce4fdac1fd7923af34bc446d87' => 
  array (
    'query' => 'UPDATE pickup_requests SET approved = :approved , dispatch_code = :dispatch_code , time_approved = :time_approved  WHERE requestid = :requestid ',
    'bind' => 
    array (
      'approved' => '1',
      'dispatch_code' => '5687',
      'time_approved' => '1599744746',
      'requestid' => '11',
    ),
  ),
  'fde627a0e50c89d98b0d87ec7504278a' => 
  array (
    'query' => 'SELECT * FROM pickup_requests WHERE sender_handshake_code = :sender_handshake_code and dispatch_code = :dispatch_code ',
    'bind' => 
    array (
      'sender_handshake_code' => '4b31069207',
      'dispatch_code' => '5687',
    ),
  ),
  '2f547b40283b3714ff3b36e7b3755843' => 
  array (
    'query' => 'SELECT * FROM pickup_requests WHERE sender_handshake_code = :sender_handshake_code and dispatch_code = :dispatch_code ',
    'bind' => 
    array (
      'sender_handshake_code' => 'd8118c0ebd',
      'dispatch_code' => '5687',
    ),
  ),
  '481ae4170d3e96d2d88a270e59b1ac4d' => 
  array (
    'query' => 'UPDATE pickup_requests SET handshake_made = :handshake_made  WHERE requestid = :requestid ',
    'bind' => 
    array (
      'handshake_made' => '1',
      'requestid' => '11',
    ),
  ),
  'e2faed74d128b20f6dcb1804f92badc3' => 
  array (
    'query' => 'SELECT * FROM pickup_requests WHERE customerid = :customerid AND riderid = :riderid AND amount = :amount AND sender_fullname = :sender_fullname AND sender_telephone = :sender_telephone AND reciever_fullname = :reciever_fullname AND reciever_telephone = :reciever_telephone AND delivery_methodid = :delivery_methodid AND pickup_address = :pickup_address AND pickup_coordinates = :pickup_coordinates AND dropoff_address = :dropoff_address AND dropoff_coordinates = :dropoff_coordinates AND package_hint = :package_hint AND coupon_code = :coupon_code AND package_quantity = :package_quantity AND extra_tip = :extra_tip AND reference = :reference AND tracking_number = :tracking_number AND dateadded = :dateadded AND sender_handshake_code = :sender_handshake_code  ',
    'bind' => 
    array (
      'customerid' => '1',
      'riderid' => '1',
      'amount' => '490',
      'sender_fullname' => 'frank ugo',
      'sender_telephone' => '07017170555',
      'reciever_fullname' => 'odu sam',
      'reciever_telephone' => '08144234526',
      'delivery_methodid' => '2',
      'pickup_address' => '282 Ebitu Ukiwe St, Jabi, Abuja, Nigeria',
      'pickup_coordinates' => '{\\"latitude\\":9.06669602314442,\\"longitude\\":7.4311038632852275}',
      'dropoff_address' => 'Wuse 2, Abuja, Nigeria',
      'dropoff_coordinates' => '{\\"latitude\\":9.078749000000002,\\"longitude\\":7.4701862}',
      'package_hint' => 'no hint',
      'coupon_code' => '0',
      'package_quantity' => '1',
      'extra_tip' => '0',
      'reference' => 'ub02rvgmh9',
      'tracking_number' => 'DEX98271',
      'dateadded' => '1601034865',
      'sender_handshake_code' => '02e6a8f810',
    ),
  ),
  '2bad1856a4bda57fdc83a127698b9128' => 
  array (
    'query' => 'SELECT * FROM pickup_requests WHERE sender_handshake_code = :sender_handshake_code ',
    'bind' => 
    array (
      'sender_handshake_code' => '02e6a8f810',
    ),
  ),
  '28d080eb96e84be25595d9fbe626cdd5' => 
  array (
    'query' => 'SELECT * FROM pickup_requests WHERE tracking_number = :tracking_number ',
    'bind' => 
    array (
      'tracking_number' => 'DEX98271',
    ),
  ),
  '7aeaff18427909e05f593af4d3bb3e11' => 
  array (
    'query' => 'SELECT * FROM pickup_requests WHERE riderid = :riderid AND tracking_number = :tracking_number  ',
    'bind' => 
    array (
      'riderid' => '1',
      'tracking_number' => 'DEX98271',
    ),
  ),
  '35242aa8065be8fb2aae022b2f4639f5' => 
  array (
    'query' => 'UPDATE pickup_requests SET approved = :approved , dispatch_code = :dispatch_code , time_approved = :time_approved  WHERE requestid = :requestid ',
    'bind' => 
    array (
      'approved' => '1',
      'dispatch_code' => '8882',
      'time_approved' => '1601034966',
      'requestid' => '12',
    ),
  ),
  '74a4f409d734da1159b956a4d080077c' => 
  array (
    'query' => 'SELECT * FROM pickup_requests WHERE sender_handshake_code = :sender_handshake_code and dispatch_code = :dispatch_code ',
    'bind' => 
    array (
      'sender_handshake_code' => '02e6a8f810',
      'dispatch_code' => '8882',
    ),
  ),
  '55ddd9dab96e6da4d9e6aab7a5901a59' => 
  array (
    'query' => 'UPDATE pickup_requests SET handshake_made = :handshake_made  WHERE requestid = :requestid ',
    'bind' => 
    array (
      'handshake_made' => '1',
      'requestid' => '12',
    ),
  ),
  'f0e559ab80a9abf6fba2247a824d4ec6' => 
  array (
    'query' => 'SELECT * FROM pickup_requests WHERE customerid = :customerid AND riderid = :riderid AND amount = :amount AND sender_fullname = :sender_fullname AND sender_telephone = :sender_telephone AND reciever_fullname = :reciever_fullname AND reciever_telephone = :reciever_telephone AND delivery_methodid = :delivery_methodid AND pickup_address = :pickup_address AND pickup_coordinates = :pickup_coordinates AND dropoff_address = :dropoff_address AND dropoff_coordinates = :dropoff_coordinates AND package_hint = :package_hint AND coupon_code = :coupon_code AND package_quantity = :package_quantity AND extra_tip = :extra_tip AND reference = :reference AND tracking_number = :tracking_number AND dateadded = :dateadded AND sender_handshake_code = :sender_handshake_code  ',
    'bind' => 
    array (
      'customerid' => '1',
      'riderid' => '1',
      'amount' => '505',
      'sender_fullname' => 'ifeanyi amadi',
      'sender_telephone' => '08185624125',
      'reciever_fullname' => 'bola tinibu',
      'reciever_telephone' => '08144234526',
      'delivery_methodid' => '2',
      'pickup_address' => 'L19C Bala Sokoto Way, Jabi, Abuja, Nigeria',
      'pickup_coordinates' => '{\\"latitude\\":9.076536682820358,\\"longitude\\":7.425252532325535}',
      'dropoff_address' => 'Wuse 2, Abuja, Nigeria',
      'dropoff_coordinates' => '{\\"latitude\\":9.078749,\\"longitude\\":7.4701862}',
      'package_hint' => 'an envelope',
      'coupon_code' => '0',
      'package_quantity' => '1',
      'extra_tip' => '0',
      'reference' => 'qsfaetwou0',
      'tracking_number' => 'DEX57161',
      'dateadded' => '1604856603',
      'sender_handshake_code' => '4ab3523774',
    ),
  ),
  '233790460923de7284e856b0734bddc9' => 
  array (
    'query' => 'SELECT * FROM pickup_requests WHERE sender_handshake_code = :sender_handshake_code ',
    'bind' => 
    array (
      'sender_handshake_code' => '4ab3523774',
    ),
  ),
  '3439e3da3ae715c0531a33a976b615f9' => 
  array (
    'query' => 'SELECT * FROM pickup_requests WHERE tracking_number = :tracking_number ',
    'bind' => 
    array (
      'tracking_number' => 'DEX57161',
    ),
  ),
  '89db75e34bb691543c16eb7da9725b6c' => 
  array (
    'query' => 'SELECT * FROM pickup_requests WHERE riderid = :riderid AND tracking_number = :tracking_number  ',
    'bind' => 
    array (
      'riderid' => '1',
      'tracking_number' => 'DEX57161',
    ),
  ),
  '27eb2ac43e9fd2d1a652912b81d8a35b' => 
  array (
    'query' => 'UPDATE pickup_requests SET approved = :approved , dispatch_code = :dispatch_code , time_approved = :time_approved  WHERE requestid = :requestid ',
    'bind' => 
    array (
      'approved' => '1',
      'dispatch_code' => '3772',
      'time_approved' => '1604856661',
      'requestid' => '13',
    ),
  ),
  'd5e315f05060655d2c8691a86ff73678' => 
  array (
    'query' => 'SELECT * FROM pickup_requests WHERE sender_handshake_code = :sender_handshake_code and dispatch_code = :dispatch_code ',
    'bind' => 
    array (
      'sender_handshake_code' => '4ab3523774',
      'dispatch_code' => '2222',
    ),
  ),
  '20408878e7986bce21b31c735322f15c' => 
  array (
    'query' => 'SELECT * FROM pickup_requests WHERE sender_handshake_code = :sender_handshake_code and dispatch_code = :dispatch_code ',
    'bind' => 
    array (
      'sender_handshake_code' => '4ab3523774',
      'dispatch_code' => '3772',
    ),
  ),
  '86d4f0343521bc6bc6e02179fa83b24e' => 
  array (
    'query' => 'UPDATE pickup_requests SET handshake_made = :handshake_made  WHERE requestid = :requestid ',
    'bind' => 
    array (
      'handshake_made' => '1',
      'requestid' => '13',
    ),
  ),
  '21ff842ce4ab9736c719c7f9426b2a83' => 
  array (
    'query' => 'SELECT * FROM pickup_requests WHERE customerid = :customerid AND riderid = :riderid AND amount = :amount AND sender_fullname = :sender_fullname AND sender_telephone = :sender_telephone AND reciever_fullname = :reciever_fullname AND reciever_telephone = :reciever_telephone AND delivery_methodid = :delivery_methodid AND pickup_address = :pickup_address AND pickup_coordinates = :pickup_coordinates AND dropoff_address = :dropoff_address AND dropoff_coordinates = :dropoff_coordinates AND package_hint = :package_hint AND coupon_code = :coupon_code AND package_quantity = :package_quantity AND extra_tip = :extra_tip AND reference = :reference AND tracking_number = :tracking_number AND dateadded = :dateadded AND sender_handshake_code = :sender_handshake_code  ',
    'bind' => 
    array (
      'customerid' => '1',
      'riderid' => '1',
      'amount' => '455',
      'sender_fullname' => 'Frank, Lampard',
      'sender_telephone' => '07066156036',
      'reciever_fullname' => 'Joan micheal',
      'reciever_telephone' => '08144234526',
      'delivery_methodid' => '2',
      'pickup_address' => 'Ameh Ebute St, Utako, Abuja, Nigeria',
      'pickup_coordinates' => '{\\"latitude\\":9.049877312922359,\\"longitude\\":7.435736854206117}',
      'dropoff_address' => '41 Ebitu Ukiwe Street, Abuja, Nigeria',
      'dropoff_coordinates' => '{\\"latitude\\":9.066587199999999,\\"longitude\\":7.4298666}',
      'package_hint' => 'no hint',
      'coupon_code' => '0',
      'package_quantity' => '1',
      'extra_tip' => '0',
      'reference' => 'vycvxfshxk',
      'tracking_number' => 'DEX95041',
      'dateadded' => '1620052425',
      'sender_handshake_code' => '2e4dd3ba98',
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
  'de85f6321e4a01ad79ad09dd5fca32d4' => 
  array (
    'query' => 'SELECT * FROM pickup_requests WHERE tracking_number = :tracking_number ',
    'bind' => 
    array (
      'tracking_number' => 'DEX95041',
    ),
  ),
  'd0c080555eeb307d6aad6d55202aa8bc' => 
  array (
    'query' => 'SELECT * FROM pickup_requests WHERE riderid = :riderid AND tracking_number = :tracking_number  ',
    'bind' => 
    array (
      'riderid' => '1',
      'tracking_number' => 'DEX95041',
    ),
  ),
  'f2dea41864d6232abde10c4b85ca6279' => 
  array (
    'query' => 'UPDATE pickup_requests SET approved = :approved , dispatch_code = :dispatch_code , time_approved = :time_approved  WHERE requestid = :requestid ',
    'bind' => 
    array (
      'approved' => '1',
      'dispatch_code' => '0752',
      'time_approved' => '1620052484',
      'requestid' => '15',
    ),
  ),
  '4973cbc09fdb2a835550a8d36234bc52' => 
  array (
    'query' => 'SELECT * FROM pickup_requests WHERE sender_handshake_code = :sender_handshake_code and dispatch_code = :dispatch_code ',
    'bind' => 
    array (
      'sender_handshake_code' => '2e4dd3ba98',
      'dispatch_code' => '0752',
    ),
  ),
  '64f33b3452b2bd6c40d70f6952730852' => 
  array (
    'query' => 'UPDATE pickup_requests SET handshake_made = :handshake_made  WHERE requestid = :requestid ',
    'bind' => 
    array (
      'handshake_made' => '1',
      'requestid' => '15',
    ),
  ),
);
