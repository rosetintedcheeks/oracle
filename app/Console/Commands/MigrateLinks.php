<?php

namespace App\Console\Commands;

use App\Models\Link;
use App\Models\LinkRoot;
use App\Models\Series;
use Illuminate\Console\Command;

class MigrateLinks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:migrate-links {file} {root}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $linkRoot = $this->argument('root');

        switch ($linkRoot) {
            case 'Anime':
                $linkRoot = LinkRoot::where('name', '=', 'Anime')->first();

                break;
        }
        $file = fopen($this->argument('file'), 'r');

        $bar = $this->output->createProgressBar(system('wc '.escapeshellarg($this->argument('file'))."| awk '{print $1}'"));
        while (($line = fgets($file)) !== false) {
            $fileArray = explode('/', $line);
            $seriesName = $fileArray[0];

            $series = Series::where('name', '=', $seriesName)->firstOr(function () use ($linkRoot, $seriesName) {
                return $linkRoot->series()->create([
                    'name' => $seriesName,
                    'path' => $seriesName,
                ]);
            });

            $fileArray = explode(':', $line);

            // remove the series name
            $linkNameArray = explode('/', $fileArray[0]);
            unset($linkNameArray[0]);
            $linkName = implode('/', $linkNameArray);

            $target = $fileArray[1];

            Link::where('name', '=', $linkName)->where('path', '=', $target)
                ->firstOr(function () use ($target, $linkName, $series) {
                    return $series->links()->create([
                        'file_name' => $linkName,
                        'path' => $target,
                    ]);
                })
            ;
            $bar->advance();
        }
    }
}
