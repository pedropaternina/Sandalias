<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titulo')</title>
</head>
<body style="margin:0;padding:0;background:#f4efef;font-family:Arial,Helvetica,sans-serif;color:#3b2a2f;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f4efef;padding:24px 12px;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;background:#ffffff;border-radius:12px;overflow:hidden;">
                    <tr>
                        <td style="background:#3b2a2f;padding:24px 32px;color:#f1dede;font-size:22px;font-weight:bold;">
                            Torres Sandals
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:32px;">
                            @yield('contenido')
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:20px 32px;background:#f1dede;font-size:12px;line-height:1.6;color:#3b2a2f;">
                            ¿Dudas con tu pedido? Escríbenos por Instagram:
                            @@torres.sandals · @@torres.sandalswoman
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>