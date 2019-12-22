<?php declare(strict_types=1);

namespace Chap\Models\Entities;

use Kdyby\Doctrine\MagicAccessors\MagicAccessors;
use Nette\SmartObject;

/**
 * Class BaseEntity
 */
abstract class BaseEntity
{
     use MagicAccessors;
}
