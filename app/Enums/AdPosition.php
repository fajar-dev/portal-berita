<?php

namespace App\Enums;

enum AdPosition: string
{
    case HEADER = 'header';
    case SIDEBAR = 'sidebar';
    case HOME_MIDDLE = 'home_middle';
    case ARTICLE_INLINE = 'article_inline';
}
