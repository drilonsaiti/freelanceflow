<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Contract Created</title>
</head>
<body>
<h2>Contract Created</h2>

<p>Hello {{ $contract->client->name }},</p>

<p>
    A contract has been created for your project
    <strong>{{ $contract->project->title }}</strong>.
</p>

<p>
    Freelancer: {{ $contract->freelancer->name }}
</p>

<p>
    Rate: {{ $contract->rate }} / {{ $contract->rate_type }}
</p>

<p>Status: {{ $contract->status }}</p>

<br>

<p>Thank you.</p>
</body>
</html>
