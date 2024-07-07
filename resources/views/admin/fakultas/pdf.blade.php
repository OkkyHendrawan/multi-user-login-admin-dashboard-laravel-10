<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Fakultas</title>
    <style>
        /* Tambahkan gaya kustom Anda untuk PDF di sini */
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Daftar Fakultas</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Kode</th>
                <th>Nama Fakultas</th>
                <th>Status Fakultas</th>
                <th>Di buat oleh</th>
                <th>Tanggal Dibuat</th>
                <th>Di update oleh</th>
                <th>Tanggal Diperbarui</th>
            </tr>
        </thead>
        <tbody>
            @foreach($getRecord as $record)
            <tr>
                <td>{{ $record->fakultas_id }}</td>
                <td>{{ $record->fakultas_kode }}</td>
                <td>{{ $record->fakultas_nama }}</td>
                <td>{{ $record->fakultas_status }}</td>
                <td>{{ $record->created_by }}</td>
                <td>{{ $record->created_at }}</td>
                <td>{{ $record->updated_by }}</td>
                <td>{{ $record->updated_at }}</td>
                <td>{{ $record->deleted_by_name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
