<?php

return [
    'db-host' => '${APP_DB_HOST}',
    'db-user' => '${APP_DB_USER}',
    'db-password' => '${APP_DB_PASS}',
    'db-name' => '${APP_DB2_NAME}',
    'db-prefix' => '',
    'backend-frontname' => 'backend',
    'admin-user' => \Magento\TestFramework\Bootstrap::ADMIN_NAME,
    'admin-password' => \Magento\TestFramework\Bootstrap::ADMIN_PASSWORD,
    'admin-email' => \Magento\TestFramework\Bootstrap::ADMIN_EMAIL,
    'admin-firstname' => \Magento\TestFramework\Bootstrap::ADMIN_FIRSTNAME,
    'admin-lastname' => \Magento\TestFramework\Bootstrap::ADMIN_LASTNAME,
    'elasticsearch-host' => '${ELASTICSEARCH_HOST}',
    'elasticsearch-port' => '${ELASTICSEARCH_PORT}',
];
