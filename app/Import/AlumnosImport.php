<?php
    namespace App\Import;
    use Illuminate\Support\Collection;
    use Maatwebsite\Excel\Concerns\ToCollection;

    class AlumnosImport implements ToCollection
    {
       public function collection(Collection $rows)
       {
       }
    }