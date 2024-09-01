<?php

namespace App\Imports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ImportStudents implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    private $eventId;
    public function __construct($eventId)
    {
        $this->eventId = $eventId;
    }

    public function collection(Collection $rows)
    {
        $rows->shift();
        foreach ($rows as $row) {
            // Ensure each row has the expected number of columns
            if (isset($row[0]) && isset($row[1]) && isset($row[2])) {
                Attendance::create([
                    'event_id' => $this->eventId,
                    'yearsection' => $row[0],
                    'lastname' => $row[1],
                    'firstname' => $row[2],
                ]);
            }
        }
    }
}
