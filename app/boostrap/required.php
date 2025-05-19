<?php

require_once ROOT_PATH . "/services/session.service.php";
startSession();
require_once ROOT_PATH . "/config/db.php";
require_once ROOT_PATH . "/helpers/helpers.php";
require_once ROOT_PATH . "/helpers/auth.helpers.php";
require_once ROOT_PATH . "/helpers/url.helpers.php";
require_once ROOT_PATH . "/helpers/pagination.helpers.php";
require_once ROOT_PATH . "/helpers/file_upload.helpers.php";
require_once ROOT_PATH . "/services/validator.service.php";
require_once ROOT_PATH . "/routes/route.web.php";
