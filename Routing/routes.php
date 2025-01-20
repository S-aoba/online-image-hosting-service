<?php

use Helpers\DatabaseHelper;
use Helpers\ValidationHelper;
use Response\HTTPRenderer;
use Response\Render\HTMLRenderer;
use Response\Render\JSONRenderer;

return [
    '' => function(): HTTPRenderer {
      return new HTMLRenderer('component/home');
    },
    'upload' => function(): HTTPRenderer {
      return new HTMLRenderer('component/upload');
    }
];