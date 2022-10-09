<?php

declare(strict_types=1);

namespace App\Tests\Mocks;

use App\Database\Connectors\PdoConnector as RealPdoConnector;

final class PdoConnector extends RealPdoConnector {}