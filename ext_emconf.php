<?php

$EM_CONF[$_EXTKEY] = array(
  'title' => 'Lawyer Gallery',
  'description' => 'An image gallery',
  'category' => 'plugin',
  'version' => '0.0.0',
  'state' => 'beta',
  'author' => 'Sebastian Michaelsen',
  'author_email' => 'sebastian@michaelsen.io',
  'author_company' => 'www.app-zap.de',
  'constraints' =>
    array(
      'depends' =>
        array(
          'php' => '5.4.0-5.6.99',
          'typo3' => '6.2.0-6.2.99',
        ),
    ),
);
