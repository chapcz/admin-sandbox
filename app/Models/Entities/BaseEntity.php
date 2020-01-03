<?php declare(strict_types=1);

namespace Chap\Models\Entities;

use Kdyby\Doctrine\MagicAccessors\MagicAccessors;

/**
 * Class BaseEntity
 */
abstract class BaseEntity
{
     use MagicAccessors;
}
