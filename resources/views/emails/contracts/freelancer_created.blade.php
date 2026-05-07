<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Contract Created</title>
</head>
<body>
<h2>Contract Created</h2>

<p>Hello {{ $contract->freelancer->name }},</p>

<p>Your contract for the project
    <strong>{{ $contract->project->title }}</strong>
    has been created successfully.
</p>

<p>
    Rate: {{ $contract->rate }} / {{ $contract->rate_type }}
</p>

<p>Status: {{ $contract->status }}</p>

<br>

<p>Thank you.</p>
</body>
</html>
