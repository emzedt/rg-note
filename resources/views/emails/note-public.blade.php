<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Note Made Public</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #121212; color: #ffffff; margin: 0; padding: 0;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; background-color: #1a1a1a; border-radius: 8px;">
        <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
            <tr>
                <td style="text-align: center;">
                    <h1 style="color: #ffffff; margin: 0 0 20px 0;">Note Made Public</h1>
                </td>
            </tr>
            <tr>
                <td style="background-color: #2c2c2c; padding: 20px; border-radius: 8px;">
                    <p style="color: #ffffff; margin: 0 0 16px 0; line-height: 1.6;">
                        The note titled <strong style="color: #4a90e2;">"{{ $note->title }}"</strong> has just been
                        made public by {{ $author->name }}.
                    </p>

                    <div style="text-align: center; margin: 20px 0;">
                        <a href="{{ route('notes.show', $note) }}"
                            style="display: inline-block; padding: 12px 24px; border-radius: 6px; background-color: #4F46E5; color: #ffffff; text-decoration: none; font-weight: bold;">
                            View Note
                        </a>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="text-align: center; font-size: 12px; color: #888888; padding-top: 40px;">
                    <p style="margin: 0 0 4px 0;">Thanks,<br>Raja Gadai Note Team</p>
                    <p style="margin: 0;">&copy; {{ date('Y') }} Raja Gadai Note. All rights reserved.</p>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
