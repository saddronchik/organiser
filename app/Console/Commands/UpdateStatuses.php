<?php

namespace App\Console\Commands;

use App\Models\Assignment;
use App\Repositories\Interfaces\AssignmentQueries;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateStatuses extends Command
{

    protected $signature = 'status:update';


    protected $description = 'Updating assignments statuses';

    private $assignmentQueries;

    public function __construct(AssignmentQueries $assignmentQueries)
    {
        parent::__construct();
        $this->assignmentQueries = $assignmentQueries;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $assignments = $this->assignmentQueries->getByColumns(['id']);

        foreach ($assignments as $assignment) {
            if ($assignment->deadline < Carbon::now()->format('d.m.Y')) {
                $assignment->status_id = 2;
                $assignment->save();
            }
        }
    }
}
