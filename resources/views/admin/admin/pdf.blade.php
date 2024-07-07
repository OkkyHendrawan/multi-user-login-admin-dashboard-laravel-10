<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Admin</title>
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
    <h2>Daftar Admin</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Lengkap</th>
                <th>Email</th>
                <th>Tanggal Dibuat</th>
                <th>Tanggal Diperbarui</th>
            </tr>
        </thead>
        <tbody>
            @foreach($getRecord as $record)
            <tr>
                <td>{{ $record->id}}</td>
                <td>{{ $record->name }}</td>
                <td>{{ $record->email }}</td>
                <td>{{ $record->created_at }}</td>
                <td>{{ $record->updated_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
