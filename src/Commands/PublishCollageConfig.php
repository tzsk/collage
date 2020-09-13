<?php

namespace Tzsk\Collage\Commands;

use Illuminate\Console\Command;

class PublishCollageConfig extends Command
{
    public $signature = 'collage:publish';

    public $description = 'Publish collage config';

    public function handle()
    {
        $this->call('vendor:publish', ['--tag' => "collage-config"]);
    }
}
